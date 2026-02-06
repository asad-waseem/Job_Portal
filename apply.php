<?php
session_start();
require_once 'partials/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    echo "<script>alert('Please register first to apply for jobs!'); window.location.href='registeruser.php';</script>";
    exit;
}

// Fetch user data to pre-fill form
$username = $_SESSION['user'];
$user_query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$user_result = $stmt->get_result();
$user_data = $user_result->fetch_assoc();
$stmt->close();

// Split fullname into first and last name
$full_name = $user_data['fullname'] ?? '';
$name_parts = explode(' ', $full_name, 2);
$first_name = $name_parts[0] ?? '';
$last_name = $name_parts[1] ?? '';

// Get job ID from URL parameter
$selected_job_id = isset($_GET['job']) ? intval($_GET['job']) : 0;
$selected_job_title = '';

if ($selected_job_id > 0) {
    $job_query = "SELECT title FROM jobs WHERE id = ?";
    $job_stmt = $conn->prepare($job_query);
    $job_stmt->bind_param("i", $selected_job_id);
    $job_stmt->execute();
    $job_result = $job_stmt->get_result();
    if ($job_result->num_rows > 0) {
        $job_data = $job_result->fetch_assoc();
        $selected_job_title = $job_data['title'];
    }
    $job_stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $position = $conn->real_escape_string($_POST['position']);
    $resume_link = $conn->real_escape_string($_POST['resume_link']);
    $cover_letter = $conn->real_escape_string($_POST['cover_letter']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO job_applications (first_name, last_name, email, phone, position, resume_link, cover_letter, user_id)
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$position', '$resume_link', '$cover_letter', $user_id)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Application submitted successfully!'); window.location.href='index..I.php';</script>";
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<?php include 'partials/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-paper-plane me-3"></i>Job Application Form</h3>
                    <p class="mb-0 mt-2 opacity-75">
                        <?php if ($selected_job_title): ?>
                            Applying for: <strong><?= htmlspecialchars($selected_job_title) ?></strong>
                        <?php else: ?>
                            Fill out the form below to apply for a position
                        <?php endif; ?>
                    </p>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">First Name *</label>
                                <input type="text" class="form-control form-control-lg" name="first_name" 
                                       value="<?php echo htmlspecialchars($first_name); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Last Name *</label>
                                <input type="text" class="form-control form-control-lg" name="last_name" 
                                       value="<?php echo htmlspecialchars($last_name); ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email Address *</label>
                                <input type="email" class="form-control form-control-lg" name="email" 
                                       value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control form-control-lg" name="phone" 
                                       value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>">
                            </div>
                           <div class="col-md-6">
    <label class="form-label fw-semibold">Position Applied For *</label>
    <select class="form-select form-select-lg" name="position" required>
        <option value="">Select Position</option>
        <?php
        $query = "SELECT id, title FROM jobs ORDER BY created_at DESC";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($job = mysqli_fetch_assoc($result)) {
                $selected = ($selected_job_title === $job['title']) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($job['title']) . '" ' . $selected . '>' . htmlspecialchars($job['title']) . '</option>';
            }
        } else {
            echo '<option disabled>No jobs available</option>';
        }
        ?>
    </select>
</div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Resume/CV Link *</label>
                                <input type="url" class="form-control form-control-lg" name="resume_link" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Cover Letter</label>
                                <textarea class="form-control" name="cover_letter" rows="5"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" required>
                                    <label class="form-check-label">
                                        I agree to the Terms and Privacy Policy *
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php" class="btn btn-outline-secondary btn-lg me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to Jobs
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
