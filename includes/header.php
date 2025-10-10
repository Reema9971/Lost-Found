<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/LostFound/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="modern-body">
    <!-- Premium Modern Header -->
    <header class="premium-header">
       

        <!-- Main Navigation - Preserving Original PHP Code -->
        <nav class="navbar navbar-expand-lg navbar-glass">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-search-location brand-icon"></i>
                    <span class="brand-text">Lost & <span class="text-primary fw-bold">Found</span></span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if (isLoggedIn()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">
                                    <i class="fas fa-home nav-icon"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link report-btn" href="report.php">
                                    <i class="fas fa-plus-circle nav-icon"></i>Report Item
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    <i class="fas fa-sign-out-alt nav-icon"></i>Logout
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">
                                    <i class="fas fa-user-plus nav-icon"></i>Register
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link login-btn" href="login.php">
                                    <i class="fas fa-sign-in-alt nav-icon"></i>Login
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
     <!-- Navbar Scroll Effect -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    });
    </script>

   