<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No book ID provided.";
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM books WHERE id = $id");

if ($result->num_rows === 0) {
    echo "Book not found.";
    exit;
}

$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $cover_image = $book['cover_image']; // default to existing image
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'assets/uploadsBooks/'; // for book image uploads
        $file_tmp = $_FILES['cover_image']['tmp_name'];
        $file_name = basename($_FILES['cover_image']['name']);
        $cover_image = $file_name;

        // Make sure the folder exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        move_uploaded_file($file_tmp, $upload_dir . $file_name);
    }

    $stmt = $conn->prepare("UPDATE books SET 
        title=?, author=?, isbn=?, category=?, language=?, 
        available_copies=?, copies=?, shelf_code=?, status=?, 
        total_pages=?, cover_image=?, features=?, volume=?, 
        publisher_name=?, published_date=?, moral=? 
        WHERE id=?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // ✅ Cast these string inputs to integers
    $available_copies = (int) $_POST['available_copies'];
    $total_copies = (int) $_POST['total_copies'];
    $total_pages = (int) $_POST['total_pages'];

    // ✅ Handle status safely
    $status = $_POST['status'] ?? 'Available';
    $allowed_statuses = ['Available', 'Lended', 'Damaged'];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status value.");
    }

    // ✅ Handle nullables properly
    $author = $_POST['author'] ?? '';
    $shelf_code = $_POST['shelf_code'] ?? '';
    $features = $_POST['features'] ?? '';
    $volume = $_POST['volume'] ?? '';
    $publisher_name = $_POST['publisher_name'] ?? '';
    $published_date = $_POST['published_date'] ?? '';
    $moral = $_POST['moral'] ?? '';
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;


    $stmt->bind_param(
        "ssssiississsssssi",
        $_POST['title'],
        $author,
        $_POST['isbn'],
        $_POST['category'],
        $_POST['language'],
        $available_copies,
        $total_copies,
        $shelf_code,
        $status, 
        $total_pages,
        $cover_image,
        $features,
        $volume,
        $publisher_name,
        $published_date,
        $moral,
        $id
    );

    var_dump($status); 
    
    $stmt->execute();

    header("Location: book_details.php?id=$id&updated=1");
    exit;

    // if ($stmt->execute()) { // likely here
    //     header("Location: book_details.php?id=$id&updated=1");
    //     exit;
    // } else {
    //     echo "Execute failed: " . $stmt->error;
    // }

    $stmt->close();
}

$activePage = 'manage-books';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Book - <?= htmlspecialchars($book['title']?? '') ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <!-- <link rel="stylesheet" href="assets/css/booksmng.css"> -->
    <link rel="stylesheet" href="assets/css/form.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="body">

        <div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        
        <main class="main">

            <div class="breadcrumbs">
                <a href="manage-books.php">Manage Books</a>
                <span>></span>
                <a href="book_details.php?id=<?= htmlspecialchars($book['id']) ?>"><?= htmlspecialchars($book['title']) ?></a>
                <span>></span>
                <span>Editing</span>
            </div>
            <div class="container">
                    <h3>Book Information</h3>

                    <form method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookTitle">Book title <span>*</span></label>
                                    <input type="text" name="title" placeholder="Book name here" value="<?= htmlspecialchars($book['title']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">Author(s) <span>*</span></label>
                                    <input type="text" name="author" placeholder="Author name here" value="<?= htmlspecialchars($book['author'] ?? '') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN/ISSN</label>
                                    <input type="text" name="isbn" placeholder="ISBN here" value="<?= htmlspecialchars($book['isbn'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="genre">Genre/category</label>
                                    <input type="text" name="category" placeholder="Category here" value="<?= htmlspecialchars($book['category'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="language">Language <span>*</span></label>
                                    <input type="text" name="language" placeholder="language here" value="<?= htmlspecialchars($book['language'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="availableCopies">Available Copies</label>
                                    <input type="number" name="available_copies" placeholder="Available Copies here" value="<?= htmlspecialchars($book['available_copies'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="totalCopies">Total Copies <span>*</span></label>
                                    <input type="number" name="total_copies" value="<?= htmlspecialchars($book['copies'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="shelfCode">Shelf/Location Code</label>
                                    <input type="text" name="shelf_code" placeholder="Shelf/Location Code here" value="<?= htmlspecialchars($book['shelf_code'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span>*</span></label>
                                    <div class="radio-group">
                                        <label>
                                            <input type="radio" name="status" value="Available" <?= $book['status'] === 'Available' ? 'checked' : '' ?>>
                                            Available
                                        </label>

                                        <label>
                                            <input type="radio" name="status" value="Lended" <?= $book['status'] === 'Lended' ? 'checked' : '' ?>>
                                            Lended
                                        </label>

                                        <label>
                                            <input type="radio" name="status" value="Damaged" <?= $book['status'] === 'Damaged' ? 'checked' : '' ?>>
                                            Damaged
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="totalPages">Total no of Pages <span>*</span></label>
                                    <input type="number" name="total_pages" placeholder="10 to 10,000" value="<?= htmlspecialchars($book['total_pages'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="fileAttachment">File Attachment</label>
                                    <div class="form-group ">
                                        <input type="file" name="cover_image" placeholder="Choose a file" value="<?= htmlspecialchars($book['cover_image'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Features Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookFeatures">Book Features <span>*</span></label>
                                    <input type="text" name="features" placeholder="Hard Cover, etc" value="<?= htmlspecialchars($book['features'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookVolume">Book Volume</label>
                                    <input type="text" name="volume" placeholder="None" value="<?= htmlspecialchars($book['volume'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="publisherName">Publisher Name</label>
                                    <input type="text" name="publisher_name" placeholder="Publisher name here" value="<?= htmlspecialchars($book['publisher_name'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookPublishedDate">Book Published Date</label>
                                    <input type="text" name="published_date" placeholder="29-Oct-1950" value="<?= htmlspecialchars($book['published_date'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookmoral">Moral (If any)</label>
                                    <input type="text" name="moral" placeholder="What You think?" value="<?= htmlspecialchars($book['moral'] ?? '') ?>">
                                </div>
                                <div></div> <div></div> </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" onclick="window.location.href='book_details.php?id=<?= $id ?>'">Cancel</button>
                            <button type="submit">Update Book</button>
                        </div>
                    </form>
            </div>
        </main>
    </div>
    <?php include 'includes/footer.php' ?>
</body>

</html>
