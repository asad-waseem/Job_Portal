<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Find Your Dream Job</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../assets/style.css' : 'assets/style.css'; ?>">
</head>
<body>
    <?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
    <?php if (strpos($_SERVER['REQUEST_URI'], 'login.php') === false): ?>
    <!-- Navigation -->
<?php if (strpos($_SERVER['REQUEST_URI'], 'loginuser.php') === false && strpos($_SERVER['REQUEST_URI'], 'registeruser.php') === false): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../index..I.php' : 'index..I.php'; ?>">
            <i class="fas fa-briefcase me-2"></i>JobPortal
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../index..I.php' : 'index..I.php'; ?>">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../jobs.php' : 'jobs.php'; ?>">
                        <i class="fas fa-user-tie me-1"></i>All Jobs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../apply.php' : 'apply.php'; ?>">
                        <i class="fas fa-paper-plane me-1"></i>Apply
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../contactus.php' : 'contactus.php'; ?>">
                        <i class="fas fa-envelope me-1"></i>Contact Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? 'login.php' : 'admin/login.php'; ?>">
                        <i class="fas fa-shield-alt me-1"></i>Admin
                    </a>
                </li>

                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                <!-- User Profile Dropdown (when logged in) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['user']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../profile.php' : 'profile.php'; ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../logoutuser.php' : 'logoutuser.php'; ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <!-- Login and Register (when not logged in) -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../loginuser.php' : 'loginuser.php'; ?>">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? '../registeruser.php' : 'registeruser.php'; ?>">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>
<?php endif; ?>
