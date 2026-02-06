<?php
session_start();
require_once 'partials/config.php';
include 'partials/header.php';

// Check if user is in reset process
if (!isset($_SESSION['reset_user']) || !isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_SESSION['reset_user'];
    
    // Password validation
    if (strlen($new_password) < 6) {
        $error_message = 'Password must be at least 6 characters long.';
    } elseif ($new_password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } else {
        // Hash the new password before updating
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password with hashed version
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ? AND email = ?");
        $stmt->bind_param("sss", $hashed_password, $username, $_SESSION['reset_email']);
        
        if ($stmt->execute()) {
            // Clear reset session
            unset($_SESSION['reset_user']);
            unset($_SESSION['reset_email']);
            
            echo "<script>alert('Password reset successfully! Please login with your new password.'); window.location.href='loginuser.php';</script>";
            exit();
        } else {
            $error_message = 'Error updating password. Please try again.';
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- Reset Password Form Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="job-card">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-3">
                        <a href="forgot_password.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-lock fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-2">Reset Password</h3>
                        <p class="text-muted">Enter your new password</p>
                    </div>
                    
                    <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" id="resetForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>New Password
                            </label>
                            <input type="password" name="new_password" id="new_password" class="form-control form-control-lg" placeholder="Enter new password (min. 6 characters)" required minlength="6">
                            <small class="text-muted">Password must be at least 6 characters long</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Confirm New Password
                            </label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirm new password" required>
                            <small class="text-danger" id="password_match_error" style="display: none;">Passwords do not match</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password match validation
document.getElementById('confirm_password').addEventListener('input', function() {
    var password = document.getElementById('new_password').value;
    var confirmPassword = this.value;
    var errorMsg = document.getElementById('password_match_error');
    
    if (confirmPassword && password !== confirmPassword) {
        errorMsg.style.display = 'block';
        this.setCustomValidity('Passwords do not match');
    } else {
        errorMsg.style.display = 'none';
        this.setCustomValidity('');
    }
});

document.getElementById('new_password').addEventListener('input', function() {
    var confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});

// Form submission validation
document.getElementById('resetForm').addEventListener('submit', function(e) {
    var password = document.getElementById('new_password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
});
</script>

<?php include 'partials/footer.php'; ?>
