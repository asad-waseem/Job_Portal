<?php
session_start();
include 'partials/header.php';
$conn = new mysqli("localhost", "root", "", "user");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user by username only (not password)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password against stored hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $user['id'];
            session_regenerate_id(true);
            header("Location: index..I.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='loginuser.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='loginuser.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Login Form Section -->
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
                        <h3 class="fw-bold mb-2">User Login</h3>
                        <p class="text-muted">Sign in to your account to continue</p>
                    </div>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-at me-2 text-primary"></i>Username
                            </label>
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter your username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="forgot_password.php" class="text-decoration-none text-primary">
                            <i class="fas fa-key me-1"></i>Forgot Password?
                        </a>
                    </div>
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">
                            Don't have an account? 
                            <a href="registeruser.php" class="fw-semibold text-primary text-decoration-none">
                                <i class="fas fa-user-plus me-1"></i>Register here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
