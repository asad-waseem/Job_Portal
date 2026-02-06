<?php 
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once '../partials/config.php';

$success_message = '';
$error_message = '';

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: testimonials.php?deleted=1");
        exit();
    }
    $stmt->close();
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $profession = trim($_POST['profession']);
    $review = trim($_POST['review']);
    $rating = (int)$_POST['rating'];
    $avatar_color = $_POST['avatar_color'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Validation
    if (empty($name) || empty($profession) || empty($review)) {
        $error_message = "All fields are required.";
    } elseif ($rating < 1 || $rating > 5) {
        $error_message = "Rating must be between 1 and 5.";
    } else {
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            // Update existing
            $id = (int)$_POST['edit_id'];
            $stmt = $conn->prepare("UPDATE testimonials SET name = ?, profession = ?, review = ?, rating = ?, avatar_color = ?, is_active = ? WHERE id = ?");
            $stmt->bind_param("sssissi", $name, $profession, $review, $rating, $avatar_color, $is_active, $id);
            $action = "updated";
        } else {
            // Insert new
            $stmt = $conn->prepare("INSERT INTO testimonials (name, profession, review, rating, avatar_color, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssisi", $name, $profession, $review, $rating, $avatar_color, $is_active);
            $action = "added";
        }
        
        if ($stmt->execute()) {
            header("Location: testimonials.php?success=" . $action);
            exit();
        } else {
            $error_message = "Error saving testimonial. Please try again.";
        }
        $stmt->close();
    }
}

// Get testimonial for editing
$edit_testimonial = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_testimonial = $result->fetch_assoc();
    $stmt->close();
}

// Success messages from redirects
if (isset($_GET['success'])) {
    $success_message = "Testimonial " . htmlspecialchars($_GET['success']) . " successfully!";
}
if (isset($_GET['deleted'])) {
    $success_message = "Testimonial deleted successfully!";
}

include 'adminheader.php'; 
?>

<!-- Add/Edit Form -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">
            <i class="fas fa-<?php echo $edit_testimonial ? 'edit' : 'plus-circle'; ?> me-2"></i>
            <?php echo $edit_testimonial ? 'Edit Testimonial' : 'Add New Testimonial'; ?>
        </h5>
    </div>
    <div class="card-body">
        <?php if ($success_message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <?php if ($edit_testimonial): ?>
            <input type="hidden" name="edit_id" value="<?php echo $edit_testimonial['id']; ?>">
            <?php endif; ?>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Full Name *</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['name']) : ''; ?>" 
                           placeholder="e.g. John Doe" required>
                </div>
                <div class="col-md-6">
                    <label for="profession" class="form-label fw-semibold">Profession/Title *</label>
                    <input type="text" class="form-control" id="profession" name="profession" 
                           value="<?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['profession']) : ''; ?>" 
                           placeholder="e.g. Software Developer" required>
                </div>
                <div class="col-md-4">
                    <label for="rating" class="form-label fw-semibold">Rating (1-5 Stars)</label>
                    <select class="form-select" id="rating" name="rating">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo $i; ?>" 
                                <?php echo ($edit_testimonial && $edit_testimonial['rating'] == $i) ? 'selected' : ($i == 5 ? 'selected' : ''); ?>>
                            <?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?> <?php echo str_repeat('⭐', $i); ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="avatar_color" class="form-label fw-semibold">Avatar Color</label>
                    <select class="form-select" id="avatar_color" name="avatar_color">
                        <option value="primary" <?php echo ($edit_testimonial && $edit_testimonial['avatar_color'] == 'primary') ? 'selected' : ''; ?>>Blue (Primary)</option>
                        <option value="success" <?php echo ($edit_testimonial && $edit_testimonial['avatar_color'] == 'success') ? 'selected' : ''; ?>>Green (Success)</option>
                        <option value="info" <?php echo ($edit_testimonial && $edit_testimonial['avatar_color'] == 'info') ? 'selected' : ''; ?>>Cyan (Info)</option>
                        <option value="warning" <?php echo ($edit_testimonial && $edit_testimonial['avatar_color'] == 'warning') ? 'selected' : ''; ?>>Yellow (Warning)</option>
                        <option value="danger" <?php echo ($edit_testimonial && $edit_testimonial['avatar_color'] == 'danger') ? 'selected' : ''; ?>>Red (Danger)</option>
                        <option value="secondary" <?php echo ($edit_testimonial && $edit_testimonial['avatar_color'] == 'secondary') ? 'selected' : ''; ?>>Gray (Secondary)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                               <?php echo ($edit_testimonial && $edit_testimonial['is_active']) || !$edit_testimonial ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">
                            Active (Show on homepage)
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="review" class="form-label fw-semibold">Review Text *</label>
                    <textarea class="form-control" id="review" name="review" rows="4" 
                              placeholder="Enter the testimonial review text..." required><?php echo $edit_testimonial ? htmlspecialchars($edit_testimonial['review']) : ''; ?></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i><?php echo $edit_testimonial ? 'Update Testimonial' : 'Add Testimonial'; ?>
                </button>
                <?php if ($edit_testimonial): ?>
                <a href="testimonials.php" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
                <?php endif; ?>
                <button type="reset" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Testimonials Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>All Testimonials</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Profession</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC");
                    
                    if ($result && $result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-<?php echo $row['avatar_color']; ?> d-flex align-items-center justify-content-center me-2" 
                                     style="width: 35px; height: 35px;">
                                    <span class="text-white fw-bold" style="font-size: 12px;">
                                        <?php 
                                        $initials = '';
                                        $names = explode(' ', $row['name']);
                                        foreach ($names as $n) {
                                            $initials .= strtoupper(substr($n, 0, 1));
                                        }
                                        echo substr($initials, 0, 2);
                                        ?>
                                    </span>
                                </div>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($row['profession']); ?></td>
                        <td>
                            <span title="<?php echo htmlspecialchars($row['review']); ?>">
                                <?php echo htmlspecialchars(substr($row['review'], 0, 50)) . '...'; ?>
                            </span>
                        </td>
                        <td>
                            <?php for ($i = 0; $i < $row['rating']; $i++): ?>
                            <i class="fas fa-star text-warning"></i>
                            <?php endfor; ?>
                        </td>
                        <td>
                            <?php if ($row['is_active']): ?>
                            <span class="badge bg-success">Active</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="testimonials.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="testimonials.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure you want to delete this testimonial?');" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-comments fa-3x mb-3 d-block opacity-50"></i>
                            No testimonials found. Add your first testimonial above!
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div></div></div>

<?php include '../partials/footer.php'; ?>
