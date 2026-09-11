<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken();
    // Accept roll number for login
    $roll_no = trim($_POST['roll_no']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE roll_no = ?");
    $stmt->execute([$roll_no]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['roll_no'] = $user['roll_no'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid roll number or password";
    }
}
?>

<?php include 'includes/header.php'; ?>
<main class="auth-page"><div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="auth-card">
                <div class="auth-card-header"><div class="auth-icon"><i class="fas fa-arrow-right-to-bracket"></i></div><p class="eyebrow">WELCOME BACK</p><h1>Sign in to continue</h1><p>Access your item reports and messages.</p></div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="mb-3">
                            <label>Roll Number</label>
                            <input type="text" name="roll_no" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Sign in <i class="fas fa-arrow-right ms-2"></i></button>
                        <p class="auth-switch">New here? <a href="register.php">Create an account</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div></main>
<?php include 'includes/footer.php'; ?>
