<?php
// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the job ID from URL
if (isset($_GET['id'])) {
    $jobId = intval($_GET['id']);

    // Delete query
    $sql = "DELETE FROM jobs WHERE id = $jobId";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to dashboard with success message
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        echo "Error deleting job: " . mysqli_error($conn);
    }
} else {
    // If no ID was passed
    header("Location: dashboard.php");
    exit();
}
?>
