<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include 'partials/header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="fw-bold mb-3">All Job Listings</h2>
            <p class="text-muted">Browse all available job opportunities</p>
        </div>
    </div>

    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM jobs ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0):
            while ($job = mysqli_fetch_assoc($result)):
        ?>
            <div class="col-lg-4 col-md-6">
                <div class="job-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-primary"><?= htmlspecialchars(ucwords($job['type'])) ?></span>
                            <small class="text-muted"><?= date("d M Y", strtotime($job['created_at'])) ?></small>
                        </div>
                        <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($job['title']) ?></h5>
                        <p class="text-muted mb-2"><i class="fas fa-building me-2"></i><?= htmlspecialchars($job['company']) ?></p>
                        <p class="text-muted mb-3"><i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($job['location']) ?></p>
                        <p class="card-text text-muted mb-4"><?= htmlspecialchars(substr($job['description'], 0, 150)) ?>...</p>
                        <a href="apply.php?job=<?= $job['id'] ?>" class="btn btn-outline-primary w-100">Apply Now</a>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else:
            echo "<p class='text-muted text-center'>No jobs posted yet.</p>";
        endif;
        ?>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
