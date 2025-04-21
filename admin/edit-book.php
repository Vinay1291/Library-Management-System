<?php
require_once '../includes/db.php';

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
    $stmt = $conn->prepare("UPDATE books SET 
        title=?, author=?, isbn=?, category=?, language=?, 
        available_copies=?, copies=?, shelf_code=?, status=?, 
        total_pages=?, cover_image=?, features=?, volume=?, 
        publisher_name=?, published_date=?, moral=? 
        WHERE id=?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sssssiississssssi",
        $_POST['title'],
        $_POST['author'],
        $_POST['isbn'],
        $_POST['category'],
        $_POST['language'],
        $_POST['available_copies'],
        $_POST['total_copies'],
        $_POST['shelf_code'],
        $_POST['status'],
        $_POST['total_pages'],
        $_POST['cover_img'],
        $_POST['features'],
        $_POST['volume'],
        $_POST['publisher_name'],
        $_POST['published_date'],
        $_POST['moral'],
        $id
    );


    if ($stmt->execute()) {
        header("Location: book_details.php?id=$id&updated=1");
        exit;
    } else {
        echo "Execute failed: " . $stmt->error;
    }

    $stmt->close();
}

$activePage = 'manage-books';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Book - <?= htmlspecialchars($book['title']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/booksmng.css">
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

                    <form method="post">
                        <div class="form-section">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookTitle">Book title <span>*</span></label>
                                    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">Author(s) <span>*</span></label>
                                    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN/ISSN</label>
                                    <input type="text" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="genre">Genre/category</label>
                                    <select name="category" id="genre" >
                                        <?php
                                            $lists = ['Fiction', 'Non-fiction', 'Biography',
                                                            'Science', 'Technology', 'Fantasy', 
                                                            'History', 'Kids', 'Mystery', 'Romance', 
                                                            'Education', 'Comics'];
                                            foreach ($lists as $list) {
                                                $selected = ($book['category'] === $list) ? 'selected' : '';
                                                echo "<option value=\"$list\" $selected>$list</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="language">Language <span>*</span></label>
                                    <select name="language" id="language">
                                        <?php
                                            $lists = ['English', 'Hindi', 'Bengali',
                                                        'Marathi', 'Telugu', 'Tamil', 
                                                        'Spanish', 'French', 'German'];
                                            foreach ($lists as $list) {
                                                $selected = ($book['language'] === $list) ? 'selected' : '';
                                                echo "<option value=\"$list\" $selected>$list</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="availableCopies">Available Copies</label>
                                    <input type="number" name="available_copies" value="<?= htmlspecialchars($book['available_copies']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="totalCopies">Total Copies <span>*</span></label>
                                    <input type="number" name="total_copies" value="<?= htmlspecialchars($book['copies']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="shelfCode">Shelf/Location Code</label>
                                    <input type="text" name="shelf_code" value="<?= htmlspecialchars($book['shelf_code']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status <span>*</span></label>
                                    <div class="radio-group">
                                        <!-- <label><input type="radio" name="status" value="available" checked> Available</label>
                                        <label><input type="radio" name="status" value="reserved"> Reserved</label>
                                        <label><input type="radio" name="status" value="outOfStock"> Out of Stock</label> -->
                                        <label>
                                            <input type="radio" name="status" value="available" <?= $book['status'] === 'Available' ? 'checked' : '' ?>> Available
                                        </label>
                                        <label>
                                            <input type="radio" name="status" value="reserved" <?= $book['status'] === 'Lended' ? 'checked' : '' ?>> Reserved
                                        </label>
                                        <label>
                                            <input type="radio" name="status" value="outOfStock" <?= $book['status'] === 'Damaged' ? 'checked' : '' ?>> Out of Stock
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="totalPages">Total no of Pages <span>*</span></label>
                                    <input type="number" name="total_pages" value="<?= htmlspecialchars($book['total_pages']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="fileAttachment">File Attachment</label>
                                    <div class="file-upload">
                                        <svg viewBox="0 0 24 24"><path fill="currentColor" d="M9 16h6v-6h4l-7-7l-7 7h4zm-4 2h14v2H5zm12-10v7h-2v-7h-4l6-6l6 6h-4z"/></svg>
                                        <span>Choose a file</span>
                                        <input type="text" name="cover_img" value="<?= htmlspecialchars($book['cover_image']) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Features Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="bookFeatures">Book Features <span>*</span></label>
                                    <input type="text" name="features" value="<?= htmlspecialchars($book['features']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookVolume">Book Volume</label>
                                    <input type="text" name="volume" value="<?= htmlspecialchars($book['volume']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="publisherName">Publisher Name</label>
                                    <input type="text" name="publisher_name" value="<?= htmlspecialchars($book['publisher_name']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookPublishedDate">Book Published Date</label>
                                    <input type="text" name="published_date" value="<?= htmlspecialchars($book['published_date']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bookmoral">Moral (If any)</label>
                                    <input type="text" name="moral" value="<?= htmlspecialchars($book['moral']) ?>">
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
