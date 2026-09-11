<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Fetch recent items
$stmt = $pdo->query("SELECT items.*, users.username 
                    FROM items 
                    JOIN users ON items.user_id = users.id 
                    ORDER BY created_at DESC 
                    LIMIT 6");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<!-- Hero Section - Modern & Clean -->
<div class="hero-section bg-gradient-primary py-5 mb-5 text-white shadow-lg">
    <div class="container py-4 text-center">
        <h2 class="fw-bold mb-3">ARAVALI COLLEGE OF ENGINEERING & MANAGEMENT</h2>
        <h1 class="display-4 fw-bold mb-4">Lost Something?</h1>
        <p class="lead mb-4 fs-4">Find your lost items or help others find theirs</p>
        <div class="d-flex gap-3 justify-content-center">
            <?php if (!isLoggedIn()): ?>
                <a href="register.php" class="btn btn-light btn-lg px-4 fw-bold shadow-sm">
                    <i class="fas fa-user-plus me-2"></i>Get Started
                </a>
            <?php else: ?>
                <a href="report.php" class="btn btn-success btn-lg px-4 fw-bold shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Report Item
                </a>
            <?php endif; ?>
            <a href="items.php" class="btn btn-outline-light btn-lg px-4 fw-bold">
                <i class="fas fa-search me-2"></i>Browse Items
            </a>
        </div>
    </div>
</div>

<!-- Recently Reported Items - Pinterest Style -->
<main class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Recently Reported Items</h2>
        <a href="items.php" class="text-decoration-none">View all <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    
    <!-- Pinterest-style masonry layout -->
    <div class="row" data-masonry='{"percentPosition": true }'>
        <?php foreach ($items as $item): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card rounded-4 border-0 shadow-sm h-100 item-card pinterest-card">
                    <?php if ($item['image']): ?>
                        <div class="card-img-container">
                            <img src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?>" class="card-img-top rounded-top-4" alt="<?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8') ?>">
                            <span class="badge position-absolute top-0 end-0 m-3 rounded-pill bg-<?= $item['status'] === 'lost' ? 'danger' : 'success' ?> shadow-sm px-3 py-2 fs-6">
                                <?= htmlspecialchars(ucfirst($item['status']), ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <div class="hover-overlay d-flex justify-content-center align-items-center">
                                <a href="item-details.php?id=<?= $item['id'] ?>" class="btn btn-light rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card-img-placeholder d-flex justify-content-center align-items-center rounded-top-4 text-muted">
                            <i class="fas fa-image fa-3x"></i>
                            <span class="badge position-absolute top-0 end-0 m-3 rounded-pill bg-<?= $item['status'] === 'lost' ? 'danger' : 'success' ?> shadow-sm px-3 py-2 fs-6">
                                <?= htmlspecialchars(ucfirst($item['status']), ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><?= htmlspecialchars($item['title']) ?></h5>
                        <p class="card-text text-muted mb-3"><?= htmlspecialchars(substr($item['description'], 0, 100)) . (strlen($item['description']) > 100 ? '...' : '') ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="location-info">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                <small class="text-muted"><?= htmlspecialchars($item['location']) ?></small>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i> <?= htmlspecialchars($item['username']) ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="item-details.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm w-100 rounded-pill fw-bold py-2">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<!-- Add Bootstrap 5 Masonry -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elem = document.querySelector('.row[data-masonry]');
    var masonry = new Masonry(elem, {
        itemSelector: '.col-md-6.col-lg-4',
        percentPosition: true
    });
    
    // Re-layout masonry after each image loads without requiring another library.
    elem.querySelectorAll('img').forEach(function(image) {
        image.addEventListener('load', function() { masonry.layout(); });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
