<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        verifyCsrfToken();
        // Verify ownership before deletion
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
        $stmt->execute([$_POST['id'], $_SESSION['user_id']]);
        
        $_SESSION['success'] = "Item deleted successfully";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error deleting item: " . $e->getMessage();
    }
}

header("Location: dashboard.php");
exit();
?>
