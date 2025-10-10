<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

// Get user's items
$stmt = $pdo->prepare("SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$userItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Your Reported Items</h3>
        <a href="report.php" class="btn btn-primary">Report New Item</a>
    </div>

    <div class="row">
        <?php if (empty($userItems)): ?>
            <div class="col-12">
                <div class="alert alert-info">No items reported yet.</div>
            </div>
        <?php else: ?>
            <?php foreach ($userItems as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            
                            <!-- Show Image if Available -->
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="Item Image" 
                                     style="max-width: 100%; height: 100px; margin-bottom: 10px;">
                            <?php endif; ?>

                            <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                            <p class="text-muted">
                                Status: 
                                <span class="badge bg-<?= $item['status'] === 'lost' ? 'danger' : 'success' ?>">
                                    <?= ucfirst($item['status']) ?>
                                </span>
                            </p>
                            <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_item.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
