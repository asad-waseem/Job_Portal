<?php
session_start();
require_once 'partials/config.php';
include 'partials/header.php';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    if (empty($username) || empty($email)) {
        $error_message = 'Please fill in both username and email.';
    } else {
        // Verify username and email match
        $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            // Set session for password reset
            $_SESSION['reset_user'] = $username;
            $_SESSION['reset_email'] = $email;
            header("Location: reset_password.php");
            exit();
        } else {
            $error_message = 'Username and email do not match. Please check your credentials.';
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- Forgot Password Form Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="job-card">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-3">
                        <a href="loginuser.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Login
                        </a>
                    </div>
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-key fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-2">Forgot Password</h3>
                        <p class="text-muted">Enter your username and email to reset your password</p>
                    </div>
                    
                    <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-at me-2 text-primary"></i>Username
                            </label>
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                            </label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email address" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-key me-2"></i>Reset Password
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">
                            Remember your password? 
                            <a href="loginuser.php" class="fw-semibold text-primary text-decoration-none">
                                <i class="fas fa-sign-in-alt me-1"></i>Login here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
