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

<main class="app-page"><div class="container py-5">
<div class="row justify-content-center">
    <div class="col-md-8 offset-md-2">
        <article class="item-detail-card">
            <div class="card-body">
                <span class="status-pill status-<?= $item['status'] === 'lost' ? 'lost' : 'found' ?>"><i class="fas fa-circle"></i><?= htmlspecialchars(ucfirst($item['status'])) ?></span>
                <h1 class="card-title"><?= htmlspecialchars($item['title']) ?></h1>
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
                <div class="reporter-card"><i class="fas fa-user-circle"></i><div><small>REPORTED BY</small><strong><?= htmlspecialchars($item['username']) ?></strong><a href="mailto:<?= htmlspecialchars($item['email']) ?>"><?= htmlspecialchars($item['email']) ?></a></div></div>

                <a href="index.php" class="btn btn-secondary mt-3">Back to Home</a>
            </div>
        </article>
    </div>
</div>
</div></main>
<?php include 'includes/footer.php'; ?>
