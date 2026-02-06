<?php


// Connect to DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$jobId = intval($_GET['id']);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['jobTitle'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $type = $_POST['jobType'];
    $description = $_POST['description'];

    $updateSQL = "UPDATE jobs SET 
                    title = '$title', 
                    company = '$company', 
                    location = '$location', 
                    category = '$category', 
                    type = '$type', 
                    description = '$description'
                  WHERE id = $jobId";

    if (mysqli_query($conn, $updateSQL)) {
        header("Location: dashboard.php?updated=1");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error updating job: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch job data to pre-fill form
$query = "SELECT * FROM jobs WHERE id = $jobId";
$result = mysqli_query($conn, $query);
$job = mysqli_fetch_assoc($result);

if (!$job) {
    echo "<div class='alert alert-warning'>Job not found.</div>";
    exit();
}
include 'adminheader.php';
?>

<!-- Bootstrap + Animate CSS -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        h3 {
            color: #183153;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-pen me-2"></i>Edit Job - ID #<?= $jobId ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="jobTitle" class="form-label fw-semibold">Job Title</label>
                                <input type="text" name="jobTitle" class="form-control" value="<?= htmlspecialchars($job['title']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company" class="form-label fw-semibold">Company Name</label>
                                <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($job['company']) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="location" class="form-label fw-semibold">Location</label>
                                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($job['location']) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="development" <?= $job['category'] == 'development' ? 'selected' : '' ?>>Development</option>
                                    <option value="design" <?= $job['category'] == 'design' ? 'selected' : '' ?>>Design</option>
                                    <option value="marketing" <?= $job['category'] == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                                    <option value="sales" <?= $job['category'] == 'sales' ? 'selected' : '' ?>>Sales</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="jobType" class="form-label fw-semibold">Job Type</label>
                                <select name="jobType" class="form-select" required>
                                    <option value="full-time" <?= $job['type'] == 'full-time' ? 'selected' : '' ?>>Full-time</option>
                                    <option value="part-time" <?= $job['type'] == 'part-time' ? 'selected' : '' ?>>Part-time</option>
                                    <option value="remote" <?= $job['type'] == 'remote' ? 'selected' : '' ?>>Remote</option>
                                    <option value="contract" <?= $job['type'] == 'contract' ? 'selected' : '' ?>>Contract</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Job Description</label>
                                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($job['description']) ?></textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS + Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
