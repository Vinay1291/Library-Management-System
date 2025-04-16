<?php
$host = 'lms.lib';         // or your DB host
$username = 'root';          // your DB username
$password = 'admin';              // your DB password
$database = 'LMS_db';    // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>