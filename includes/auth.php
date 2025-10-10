<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Get full user record by roll number
function getUserByRollNo($pdo, $roll_no) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE roll_no = ?");
    $stmt->execute([$roll_no]);
    return $stmt->fetch();
}

// Get currently logged-in user record (if any)
function currentUser($pdo) {
    if (!isLoggedIn()) return null;
    if (!empty($_SESSION['roll_no'])) {
        return getUserByRollNo($pdo, $_SESSION['roll_no']);
    }
    // Fallback by user_id
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}
?>