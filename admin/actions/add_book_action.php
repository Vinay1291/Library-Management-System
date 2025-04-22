<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../../includes/db.php';
require_once '../../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $category = $_POST['category'] ?? '';
    $language = $_POST['language'] ?? '';
    $available_copies = intval($_POST['available_copies'] ?? 0);
    $total_copies = intval($_POST['total_copies'] ?? 0);
    $shelf_code = $_POST['shelf_code'] ?? '';
    $status = $_POST['status'] ?? 'available';
    $total_pages = intval($_POST['total_pages'] ?? 0);
    $cover_image = $_POST['cover_image'] ?? ''; // ✅ match column name
    $features = $_POST['features'] ?? '';
    $volume = $_POST['volume'] ?? '';
    $publisher_name = $_POST['publisher_name'] ?? '';
    $published_date = $_POST['published_date'] ?? '';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO books 
        (title, author, isbn, category, language, available_copies, copies, shelf_code, status, total_pages, cover_image, features, volume, publisher_name, published_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssiissssisss", 
        $title, $author, $isbn, $category, $language, 
        $available_copies, $total_copies, $shelf_code, $status, 
        $total_pages, $cover_image, $features, $volume, 
        $publisher_name, $published_date);

    if ($stmt->execute()) {
        header("Location: ../admin/manage-books.php");


        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../add_books.php");
    exit();
}
?>