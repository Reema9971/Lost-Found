<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$stmt = $pdo->query("SELECT items.*, users.username FROM items JOIN users ON items.user_id = users.id ORDER BY created_at DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>
<main class="app-page"><div class="container py-5">
    <div class="page-intro"><p class="eyebrow">COMMUNITY BOARD</p><h1>Browse reported items</h1><p>See what the community has recently lost and found.</p></div>
    <div class="row g-4">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4 mb-4">
                <article class="browse-card">
                    <?php if ($item['image']): ?>
                        <img src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="status-pill status-<?= $item['status'] === 'lost' ? 'lost' : 'found' ?>">
                            <?= htmlspecialchars(ucfirst($item['status']), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="item-details-meta"><span><i class="fas fa-location-dot"></i><?= htmlspecialchars($item['location']) ?></span><span><i class="fas fa-calendar"></i><?= date('M j, Y', strtotime($item['lost_date'])) ?></span></div>
                        <a href="item-details.php?id=<?= (int) $item['id'] ?>" class="text-link">View details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</div></main>
<?php include 'includes/footer.php'; ?>
