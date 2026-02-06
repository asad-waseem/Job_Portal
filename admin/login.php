<?php
session_start();
require_once '../partials/config.php';
include '../partials/header.php';

// When form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch admin by username only (not password)
    $stmt = $conn->prepare("SELECT * FROM admins WHERE usernames = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin exists
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Verify password against stored hash
        if (password_verify($password, $admin['passwords'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Login Form HTML (same as you provided, but use POST method and real submit button) -->
<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-2xl border-0">
                    <div class="card-body p-5">
                        <div class="mb-3">
                            <a href="../index..I.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Home
                            </a>
                        </div>
                        <div class="text-center mb-4">
                            <div class="admin-icon mb-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3 class="fw-bold mb-2">Admin Login</h3>
                            <p class="text-muted">Enter your credentials to access the admin panel</p>
                        </div>
                        
                        <form method="POST" action="">
                            <div class="mb-4">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control border-start-0 ps-0" id="username" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" id="password" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label text-muted" for="remember">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
                                </button>
                            </div>
                            
                           
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
