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

// Total Jobs
$jobResult = mysqli_query($conn, "SELECT COUNT(*) AS total_jobs FROM jobs");
$totalJobs = 0;
if ($jobResult) {
    $row = mysqli_fetch_assoc($jobResult);
    $totalJobs = $row['total_jobs'];
}

// Total Users
$userResult = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$totalUsers = 0;
if ($userResult) {
    $row = mysqli_fetch_assoc($userResult);
    $totalUsers = $row['total_users'];
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CleanEase</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles (optional) -->
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="../index..I.php">
                <i class="fas fa-home me-1"></i>View Website
            </a>
            <a class="nav-link" href="login.php">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>
    </div>
</nav>

<!-- Page Layout -->
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Admin Menu</h5>
                    
                </div>
                
                <div class="list-group list-group-flush">
                    <a href="../index..I.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-link me-2"></i>Visit Website
                    
                        <a href="dashboard.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                    
                    
                    
                    <a href="applications.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i>View Applications
                    </a>
                    
                    <a href="users.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                    
                    <a href="contactmsg.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope me-1"></i> See Contact Us Messages
                    </a>
                    
                    <a href="testimonials.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-star me-2"></i>Manage Testimonials
                    </a>
                    
                </div>
                
            </div>
            
        </div>

        <!-- Main Content Column Starts Here -->
        <div class="col-lg-9 col-md-8">
 <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-primary text-white border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="fw-bold"><?= $totalUsers ?></h4>
<p class="mb-0">Active Users</p>

                                </div>
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-primary text-white border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="fw-bold"><?= $totalJobs ?></h4>
<p class="mb-0">Total Jobs</p>

                                </div>
                                <i class="fas fa-briefcase fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-success text-white border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="fw-bold"><?= $applications_count ?></h4>
                                    <p class="mb-0">Applications</p>
                                </div>
                                <i class="fas fa-users fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>