<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$stmt = $pdo->query("SELECT items.*, users.username FROM items JOIN users ON items.user_id = users.id ORDER BY created_at DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Recent Items</h2>
    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if ($item['image']): ?>
                        <img src="<?= $item['image'] ?>" class="card-img-top">
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="badge bg-<?= $item['status'] === 'lost' ? 'danger' : 'success' ?>">
                            <?= ucfirst($item['status']) ?>
                        </span>
                        <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Location:</strong> <?= htmlspecialchars($item['location']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Date:</strong> <?= date('M j, Y', strtotime($item['lost_date'])) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Reported by:</strong> <?= htmlspecialchars($item['username']) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>