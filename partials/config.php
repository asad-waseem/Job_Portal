<?php
/**
 * Database Configuration File
 * 
 * This file contains the database connection settings and creates
 * a single database connection that can be included in all other files.
 * 
 * Usage: require_once 'partials/config.php'; (from root)
 *        require_once '../partials/config.php'; (from admin folder)
 */

// Database Configuration Constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'user');

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection and display error if failed
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set character encoding (recommended for proper UTF-8 support)
$conn->set_charset("utf8mb4");
?>
