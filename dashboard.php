<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

// Get user's items
$stmt = $pdo->prepare("SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$userItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
$lostCount = count(array_filter($userItems, fn($item) => $item['status'] === 'lost'));
$foundCount = count($userItems) - $lostCount;
?>

<?php include 'includes/header.php'; ?>
<main class="app-page dashboard-page">
<div class="container py-5">
    <section class="dashboard-hero mb-5">
        <div>
            <p class="eyebrow mb-2">YOUR DASHBOARD</p>
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['username']) ?>.</h1>
            <p>Keep your reports organised and help reunite items with their owners.</p>
        </div>
        <a href="report.php" class="btn btn-light btn-lg"><i class="fas fa-plus me-2"></i>Report an item</a>
    </section>

    <section class="row g-3 mb-5" aria-label="Your report summary">
        <div class="col-md-4"><div class="metric-card"><i class="fas fa-layer-group metric-icon icon-blue"></i><div><small>Total reports</small><strong><?= count($userItems) ?></strong></div></div></div>
        <div class="col-md-4"><div class="metric-card"><i class="fas fa-search metric-icon icon-coral"></i><div><small>Marked lost</small><strong><?= $lostCount ?></strong></div></div></div>
        <div class="col-md-4"><div class="metric-card"><i class="fas fa-hand-holding-heart metric-icon icon-green"></i><div><small>Marked found</small><strong><?= $foundCount ?></strong></div></div></div>
    </section>

    <div class="section-heading">
        <div><p class="eyebrow mb-1">MANAGE REPORTS</p><h2>Your reported items</h2></div>
        <a href="report.php" class="text-link">New report <i class="fas fa-arrow-right ms-1"></i></a>
    </div>

    <div class="row g-4">
        <?php if (empty($userItems)): ?>
            <div class="col-12">
                <div class="empty-state"><i class="fas fa-box-open"></i><h3>No reports yet</h3><p>Start by sharing the details of an item you lost or found.</p><a href="report.php" class="btn btn-primary">Create your first report</a></div>
            </div>
        <?php else: ?>
            <?php foreach ($userItems as $item): ?>
                <div class="col-md-6 col-xl-4">
                    <article class="dashboard-item-card">
                        <div class="dashboard-item-media">
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                            <?php else: ?>
                                <i class="fas fa-image"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <span class="status-pill status-<?= $item['status'] === 'lost' ? 'lost' : 'found' ?>"><i class="fas fa-circle"></i><?= htmlspecialchars(ucfirst($item['status']), ENT_QUOTES, 'UTF-8') ?></span>
                            <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                            <p class="card-text line-clamp-2"><?= htmlspecialchars($item['description']) ?></p>
                            <p class="item-meta"><i class="fas fa-location-dot"></i><?= htmlspecialchars($item['location']) ?></p>
                            <div class="card-actions"><a href="edit_item.php?id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                            <form method="POST" action="delete_item.php" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                                <button type="submit" class="btn btn-link-danger btn-sm">Delete</button>
                            </form>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</main>
<?php include 'includes/footer.php'; ?>
