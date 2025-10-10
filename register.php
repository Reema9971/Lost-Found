<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $error = "Registration failed: " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post">
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
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>