<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken();
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $roll_no = trim($_POST['roll_no']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Basic server-side validation
    if (empty($roll_no)) {
        $error = 'Roll number is required';
    } else {
        // Check for existing roll number (must be unique)
        try {
            $check = $pdo->prepare("SELECT id FROM users WHERE roll_no = ?");
            $check->execute([$roll_no]);
            if ($check->fetch()) {
                $error = 'This roll number is already registered. Please use a different roll number or login.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, roll_no, password) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $roll_no, $password]);
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            error_log('Registration failed: ' . $e->getMessage());
            $error = 'Registration failed. Please try again.';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<main class="auth-page"><div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="auth-card">
                <div class="auth-card-header"><div class="auth-icon"><i class="fas fa-user-plus"></i></div><p class="eyebrow">JOIN THE COMMUNITY</p><h1>Create your account</h1><p>Report and track lost or found items in one place.</p></div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>University Roll No</label>
                            <input type="text" name="roll_no" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Create account <i class="fas fa-arrow-right ms-2"></i></button>
                        <p class="auth-switch">Already registered? <a href="login.php">Sign in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div></main>
<?php include 'includes/footer.php'; ?>
