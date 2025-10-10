<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

// Fetch item to edit
$item = null;
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $item = $stmt->fetch();
}

if (!$item) {
    $_SESSION['error'] = "Item not found";
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE items SET 
            title = ?, 
            description = ?, 
            category = ?, 
            location = ?, 
            lost_date = ?, 
            status = ? 
            WHERE id = ? AND user_id = ?");

        $stmt->execute([
            $_POST['title'],
            $_POST['description'],
            $_POST['category'],
            $_POST['location'],
            $_POST['lost_date'],
            $_POST['status'],
            $_POST['id'],
            $_SESSION['user_id']
        ]);

        $_SESSION['success'] = "Item updated successfully";
        header("Location: dashboard.php");
        exit();
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error updating item: " . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Item</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Item Title</label>
                            <input type="text" name="title" class="form-control" 
                                   value="<?= htmlspecialchars($item['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required>
                                <?= htmlspecialchars($item['description']) ?>
                            </textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="electronics" <?= $item['category'] === 'electronics' ? 'selected' : '' ?>>Electronics</option>
                                    <option value="documents" <?= $item['category'] === 'documents' ? 'selected' : '' ?>>Documents</option>
                                    <option value="jewelry" <?= $item['category'] === 'jewelry' ? 'selected' : '' ?>>Jewelry</option>
                                    <option value="clothing" <?= $item['category'] === 'clothing' ? 'selected' : '' ?>>Clothing</option>
                                    <option value="other" <?= $item['category'] === 'other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="lost" <?= $item['status'] === 'lost' ? 'selected' : '' ?>>Lost</option>
                                    <option value="found" <?= $item['status'] === 'found' ? 'selected' : '' ?>>Found</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" 
                                       value="<?= htmlspecialchars($item['location']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" name="lost_date" class="form-control" 
                                       value="<?= htmlspecialchars($item['lost_date']) ?>" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>