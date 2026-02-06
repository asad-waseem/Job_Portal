<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include 'partials/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white mb-4">Find Your Dream Job Today</h1>
                <p class="lead text-white-50 mb-4">Discover thousands of job opportunities from top companies. Start your career journey with us.</p>
                <a href="jobs.php" class="btn btn-primary btn-lg me-3">Browse Jobs</a>
                <a href="loginuser.php" class="btn btn-outline-light btn-lg"> Login</a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-briefcase hero-icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Job Listings Section -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="fw-bold mb-3">Latest Job Opportunities</h2>
            <p class="text-muted">Explore our featured job listings from top employers</p>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Job Card 1 -->
       <div class="row g-4">
<?php
$sql = "SELECT * FROM jobs ORDER BY created_at DESC LIMIT 6";
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
        </div>
    </div>
</div>
<!-- How It Works Section -->
<section class="py-5">
  <div class="container text-center">
    <h3 class="fw-bold mb-4">How It Works</h3>
    <div class="row g-4">
      <div class="col-md-4">
        <i class="fas fa-user-plus fa-2x text-primary mb-3"></i>
        <h5 class="fw-semibold">1. Create an Account</h5>
        <p class="text-muted">Register yourself in seconds for free.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-search fa-2x text-success mb-3"></i>
        <h5 class="fw-semibold">2. Browse Jobs</h5>
        <p class="text-muted">Find the perfect job that fits your skills.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-paper-plane fa-2x text-info mb-3"></i>
        <h5 class="fw-semibold">3. Apply Online</h5>
        <p class="text-muted">Submit your application with a click.</p>
      </div>
    </div>
  </div>
</section>

<!-- Statistics Section -->
<?php
// Get statistics
$stats_query = "SELECT COUNT(*) as total_jobs FROM jobs";
$stats_result = mysqli_query($conn, $stats_query);
$total_jobs = 0;
if ($stats_result) {
    $row = mysqli_fetch_assoc($stats_result);
    $total_jobs = $row['total_jobs'];
}

$user_query = "SELECT COUNT(*) as total_users FROM users";
$user_result = mysqli_query($conn, $user_query);
$total_users = 0;
if ($user_result) {
    $row = mysqli_fetch_assoc($user_result);
    $total_users = $row['total_users'];
}

$app_query = "SELECT COUNT(*) as total_applications FROM job_applications";
$app_result = mysqli_query($conn, $app_query);
$total_applications = 0;
if ($app_result) {
    $row = mysqli_fetch_assoc($app_result);
    $total_applications = $row['total_applications'];
}
?>
<section class="py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
  <div class="container">
    <div class="row text-center text-white g-4">
      <div class="col-md-4">
        <div class="p-4">
          <i class="fas fa-briefcase fa-3x mb-3 opacity-75"></i>
          <h2 class="fw-bold mb-2"><?php echo $total_jobs; ?>+</h2>
          <p class="lead mb-0">Active Jobs</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4">
          <i class="fas fa-users fa-3x mb-3 opacity-75"></i>
          <h2 class="fw-bold mb-2"><?php echo $total_users; ?>+</h2>
          <p class="lead mb-0">Registered Users</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4">
          <i class="fas fa-file-alt fa-3x mb-3 opacity-75"></i>
          <h2 class="fw-bold mb-2"><?php echo $total_applications; ?>+</h2>
          <p class="lead mb-0">Applications</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h3 class="fw-bold mb-3">Why Choose Us</h3>
        <p class="text-muted">Discover what makes our platform the best choice for job seekers</p>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4 text-center">
            <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
            <h5 class="fw-bold mb-3">Fast & Easy</h5>
            <p class="text-muted mb-0">Quick registration and application process. Get started in minutes, not hours.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4 text-center">
            <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
            <h5 class="fw-bold mb-3">Secure Platform</h5>
            <p class="text-muted mb-0">Your data is protected with advanced security measures. Safe and reliable.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4 text-center">
            <i class="fas fa-star fa-3x text-warning mb-3"></i>
            <h5 class="fw-bold mb-3">Top Companies</h5>
            <p class="text-muted mb-0">Connect with leading employers and discover premium job opportunities.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4 text-center">
            <i class="fas fa-headset fa-3x text-info mb-3"></i>
            <h5 class="fw-bold mb-3">24/7 Support</h5>
            <p class="text-muted mb-0">Get help whenever you need it. Our support team is always ready to assist.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4 text-center">
            <i class="fas fa-filter fa-3x text-danger mb-3"></i>
            <h5 class="fw-bold mb-3">Smart Filters</h5>
            <p class="text-muted mb-0">Find exactly what you're looking for with our advanced search and filter options.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4 text-center">
            <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
            <h5 class="fw-bold mb-3">Mobile Friendly</h5>
            <p class="text-muted mb-0">Access job opportunities on any device. Fully responsive and optimized.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
  <div class="container">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h3 class="fw-bold mb-3">What Our Users Say</h3>
        <p class="text-muted">Real testimonials from job seekers who found their dream jobs</p>
      </div>
    </div>
    <div class="row g-4">
      <?php
      // Fetch active testimonials from database
      $testimonial_query = "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY created_at DESC LIMIT 6";
      $testimonial_result = mysqli_query($conn, $testimonial_query);
      
      if ($testimonial_result && mysqli_num_rows($testimonial_result) > 0):
          while ($testimonial = mysqli_fetch_assoc($testimonial_result)):
              // Generate initials from name
              $initials = '';
              $names = explode(' ', $testimonial['name']);
              foreach ($names as $n) {
                  $initials .= strtoupper(substr($n, 0, 1));
              }
              $initials = substr($initials, 0, 2);
      ?>
      <div class="col-md-6 col-lg-4">
        <div class="job-card h-100">
          <div class="card-body p-4">
            <div class="mb-3">
              <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
              <i class="fas fa-star text-warning"></i>
              <?php endfor; ?>
              <?php for ($i = $testimonial['rating']; $i < 5; $i++): ?>
              <i class="far fa-star text-warning"></i>
              <?php endfor; ?>
            </div>
            <p class="text-muted mb-4">"<?php echo htmlspecialchars($testimonial['review']); ?>"</p>
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="rounded-circle bg-<?php echo htmlspecialchars($testimonial['avatar_color']); ?> d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                  <span class="text-white fw-bold"><?php echo $initials; ?></span>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($testimonial['name']); ?></h6>
                <small class="text-muted"><?php echo htmlspecialchars($testimonial['profession']); ?></small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php 
          endwhile;
      else:
      ?>
      <!-- Fallback if no testimonials in database -->
      <div class="col-12 text-center">
        <p class="text-muted">No testimonials available yet.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>



<?php include 'partials/footer.php'; ?>