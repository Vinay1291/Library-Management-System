<?php
session_start();
require_once '../../includes/db.php';
require_once '../../includes/auth.php';

// Allow only logged-in admin
if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

    echo 'hii';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'done';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $isbn = $_POST['isbn'] ?? '';
        $category = $_POST['category'] ?? '';
        $language = $_POST['language'] ?? '';
        $available_copies = $_POST['available_copies'] ?? 0;
        $total_copies = $_POST['total_copies'] ?? 0;
        $shelf_code = $_POST['shelf_code'] ?? '';
        $status = $_POST['status'] ?? 'available';
        $total_pages = $_POST['total_pages'] ?? 0;
        $cover_img = $_POST['cover_img'] ?? '';
        $features = $_POST['features'] ?? '';
        $volume = $_POST['volume'] ?? '';
        $published_year = $_POST['publisher_name'] ?? '';
        $published_date = $_POST['published_date'] ?? '';
        echo $title;

        // Add validation if needed


        
        $stmt = $conn->prepare("INSERT INTO books 
            (title, author, isbn, category, language, available_copies, copies, shelf_code, status, total_pages, features, volume, published_year, published_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssssiisssissssss", $title, $author, $isbn, $category, $language, $available_copies, $total_copies, $shelf_code, $status, $total_pages, $features, $volume, $published_year, $published_date,);
        
        if ($stmt->execute()) {
            header("Location: ../admin/manage-books.php?msg=Book+added+successfully");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }

} else {
    echo 'not done';
    header("Location: ../add_books.php");
    exit();
    }

?>