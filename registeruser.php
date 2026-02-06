<?php
include 'partials/header.php';

$conn = new mysqli("localhost", "root", "", "user");
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Password validation
    if (strlen($password) < 6) {
        $error_message = 'Password must be at least 6 characters long.';
    } else {
        // Check for duplicate email
        $email_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $email_check->bind_param("s", $email);
        $email_check->execute();
        $email_result = $email_check->get_result();
        
        // Check for duplicate username
        $username_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $username_check->bind_param("s", $username);
        $username_check->execute();
        $username_result = $username_check->get_result();
        
        if ($email_result->num_rows > 0) {
            $error_message = 'Email already exists. Please use a different email.';
            $email_check->close();
            $username_check->close();
        } elseif ($username_result->num_rows > 0) {
            $error_message = 'Username already exists. Please choose a different username.';
            $email_check->close();
            $username_check->close();
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // All validations passed, insert user
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $email, $username, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href='loginuser.php';</script>";
                exit();
            } else {
                $error_message = 'Something went wrong. Please try again!';
            }
            $stmt->close();
        }
    }
}
?>

<!-- Registration Form Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="job-card">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-3">
                        <a href="index..I.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Home
                        </a>
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">User Registration</h3>
                        <p class="text-muted">Fill in your details to get started</p>
                    </div>
                    
                    <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" id="registerForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Full Name
                            </label>
                            <input type="text" name="fullname" class="form-control form-control-lg" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                            </label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-at me-2 text-primary"></i>Username
                            </label>
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Choose a username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Create a strong password (min. 6 characters)" required minlength="6">
                            <small class="text-muted">Password must be at least 6 characters long</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Confirm Password
                            </label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirm your password" required>
                            <small class="text-danger" id="password_match_error" style="display: none;">Passwords do not match</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Register Now
                            </button>
                        </div>
                    </form>
                    
                    <script>
                    // Password match validation
                    document.getElementById('confirm_password').addEventListener('input', function() {
                        var password = document.getElementById('password').value;
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
                    
                    document.getElementById('password').addEventListener('input', function() {
                        var confirmPassword = document.getElementById('confirm_password');
                        if (confirmPassword.value) {
                            confirmPassword.dispatchEvent(new Event('input'));
                        }
                    });
                    
                    // Form submission validation
                    document.getElementById('registerForm').addEventListener('submit', function(e) {
                        var password = document.getElementById('password').value;
                        var confirmPassword = document.getElementById('confirm_password').value;
                        
                        if (password !== confirmPassword) {
                            e.preventDefault();
                            alert('Passwords do not match!');
                            return false;
                        }
                    });
                    </script>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">
                            Already have an account? 
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
