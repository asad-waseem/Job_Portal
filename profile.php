<?php
session_start();
require_once 'partials/config.php';
include 'partials/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: loginuser.php");
    exit();
}

$username = $_SESSION['user'];
$message = '';
$message_type = '';

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $profession = $_POST['profession'] ?? '';
    $description = $_POST['description'] ?? '';
    $address = $_POST['address'] ?? '';
    
    // Update user profile
    $update_stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, phone = ?, profession = ?, description = ?, address = ? WHERE username = ?");
    $update_stmt->bind_param("sssssss", $fullname, $email, $phone, $profession, $description, $address, $username);
    
    if ($update_stmt->execute()) {
        $message = 'Profile updated successfully!';
        $message_type = 'success';
        // Refresh user data
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    } else {
        $message = 'Error updating profile. Please try again!';
        $message_type = 'danger';
    }
    
    $update_stmt->close();
}

$conn->close();
?>

<!-- Profile Page -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="job-card">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-3">
                        <a href="index..I.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Home
                        </a>
                    </div>
                    
                    <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-2">My Profile</h3>
                        <p class="text-muted">Edit your profile information</p>
                    </div>
                    
                    <form method="POST">
                        <div class="row g-3">
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Full Name
                                </label>
                                <input type="text" name="fullname" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                                </label>
                                <input type="email" name="email" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                            </div>
                            
                            <!-- Username (Read-only) -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-at me-2 text-primary"></i>Username
                                </label>
                                <input type="text" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" disabled>
                                <small class="text-muted">Username cannot be changed</small>
                            </div>
                            
                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-phone me-2 text-primary"></i>Phone Number
                                </label>
                                <input type="tel" name="phone" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" 
                                       placeholder="Enter your phone number">
                            </div>
                            
                            <!-- Profession (What they do) -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-briefcase me-2 text-primary"></i>Profession / What You Do
                                </label>
                                <input type="text" name="profession" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($user['profession'] ?? ''); ?>" 
                                       placeholder="e.g., Software Developer, Designer, etc.">
                            </div>
                            
                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Address
                                </label>
                                <input type="text" name="address" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" 
                                       placeholder="Enter your address">
                            </div>
                            
                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>About Me / Description
                                </label>
                                <textarea name="description" class="form-control" rows="5" 
                                          placeholder="Tell us about yourself, your skills, experience, etc."><?php echo htmlspecialchars($user['description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index..I.php" class="btn btn-outline-secondary btn-lg me-md-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
