<?php
$host = 'localhost';         // or your DB host
$username = 'root';          // your DB username
$password = '';              // your DB password
$database = 'library_db';    // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>