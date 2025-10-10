<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Get item ID from URL
$item_id = $_GET['id'] ?? null;

if (!$item_id) {
    header("Location: index.php");
    exit();
}

try {
    // Fetch item details
    $stmt = $pdo->prepare("
        SELECT items.*, users.username, users.email 
        FROM items 
        JOIN users ON items.user_id = users.id 
        WHERE items.id = ?
    ");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();

    if (!$item) {
        throw new Exception("Item not found");
    }

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container my-5">
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
                <p class="card-text"><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($item['category']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($item['location']) ?></p>
                <p><strong>Lost Date:</strong> <?= htmlspecialchars($item['lost_date']) ?></p>
                <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($item['status'])) ?></p>

                <?php if (!empty($item['image']) && file_exists($item['image'])): ?>
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image" style="max-width: 100%; height: auto;" class="mt-3">
                <?php else: ?>
                    <img src="uploads/no-image-available.png" alt="No Image" style="max-width: 100%; height: auto;" class="mt-3">
                <?php endif; ?>

                <hr>
                <h5>Reported By:</h5>
                <p><strong>Username:</strong> <?= htmlspecialchars($item['username']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($item['email']) ?></p>

                <a href="index.php" class="btn btn-secondary mt-3">Back to Home</a>
            </div>
        </div>
    </div>
</div>
