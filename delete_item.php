<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

if (isset($_GET['id'])) {
    try {
        // Verify ownership before deletion
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
        $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
        
        $_SESSION['success'] = "Item deleted successfully";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error deleting item: " . $e->getMessage();
    }
}

header("Location: dashboard.php");
exit();
?>