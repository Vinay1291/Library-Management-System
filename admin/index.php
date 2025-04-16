<?php
require 'includes/db.php';

$fullname = "Admin User";
$phone = "9999999999";
$email = "admin@lms.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";

$stmt = $conn->prepare("INSERT INTO users (fullname, phone, email, password, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $fullname, $phone, $email, $password, $role);

if ($stmt->execute()) {
    echo "Admin user added!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>