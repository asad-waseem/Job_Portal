<?php 

// Include DB connection first
$servername = "localhost";
$username = "root";      // your DB username
$password = "";          // your DB password
$dbname = "user";  // your DB name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

 

// Query to count total job applications
$query = "SELECT COUNT(*) as total_applications FROM job_applications";
$result = mysqli_query($conn, $query);

$applications_count = 0;
if($result){
    $row = mysqli_fetch_assoc($result);
    $applications_count = $row['total_applications'];
}
    // adding job php

    // Insert Job Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['jobTitle'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $type = $_POST['jobType'];
    $description = $_POST['description'];

    $sql = "INSERT INTO jobs (title, company, location, category, type, description)
            VALUES ('$title', '$company', '$location', '$category', '$type', '$description')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to avoid resubmission
        header("Location: dashboard.php?success=1");
        exit(); // Important: stop script execution after redirect
    } else {
        // You can log this error or show it
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center mx-3 my-3">Job added successfully!</div>
    
<?php endif;
include 'adminheader.php';  ?>




           
            
            <!-- Add New Job Form -->
           <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Job</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="jobTitle" class="form-label fw-semibold">Job Title</label>
                    <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="e.g. Senior PHP Developer" required>
                </div>
                <div class="col-md-6">
                    <label for="company" class="form-label fw-semibold">Company Name</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="e.g. TechCorp Solutions" required>
                </div>
                <div class="col-md-4">
                    <label for="location" class="form-label fw-semibold">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g. Karachi, Pakistan" required>
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label fw-semibold">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="development">Development</option>
                        <option value="design">Design</option>
                        <option value="marketing">Marketing</option>
                        <option value="sales">Sales</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="jobType" class="form-label fw-semibold">Job Type</label>
                    <select class="form-select" id="jobType" name="jobType" required>
                        <option value="">Select Type</option>
                        <option value="full-time">Full-time</option>
                        <option value="part-time">Part-time</option>
                        <option value="remote">Remote</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Job Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter detailed job description..." required></textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Add Job 
                </button>
                <button type="reset" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>

            
            <!-- Jobs Table -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Current Jobs</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Posted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
// Fetch jobs from database
$jobQuery = "SELECT * FROM jobs ORDER BY created_at DESC";
$jobResult = mysqli_query($conn, $jobQuery);

if (mysqli_num_rows($jobResult) > 0) {
    while ($job = mysqli_fetch_assoc($jobResult)) {
        echo "<tr>";
        echo "<td>" . $job['id'] . "</td>";
        echo "<td>" . htmlspecialchars($job['title']) . "</td>";
        echo "<td>" . htmlspecialchars($job['company']) . "</td>";
        echo "<td>" . htmlspecialchars($job['location']) . "</td>";

        // Job type badge
        $badgeClass = match ($job['type']) {
            "full-time" => "primary",
            "part-time" => "warning text-dark",
            "remote" => "success",
            "contract" => "info",
            default => "secondary"
        };
        echo "<td><span class='badge bg-$badgeClass'>" . htmlspecialchars(ucwords($job['type'])) . "</span></td>";

        // Date formatting
        $postedDate = date("d M Y", strtotime($job['created_at']));
        echo "<td>$postedDate</td>";

        // Actions (you can make these functional later)
        echo "<td>
        <a href='editjob.php?id=" . $job['id'] . "' class='btn btn-sm btn-outline-primary me-1'>
            <i class='fas fa-edit'></i>
        </a>
        <a href='delete.php?id=" . $job['id'] . "' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this job?\");'>
            <i class='fas fa-trash'></i>
        </a>
      </td>";

    }
} else {
    echo "<tr><td colspan='7' class='text-center text-muted'>No jobs found.</td></tr>";
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
