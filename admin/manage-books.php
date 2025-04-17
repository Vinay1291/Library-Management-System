<?php
// db.php
$conn = new mysqli("localhost", "root", "admin", "LMS_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$result = $conn->query("SELECT * FROM books");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="sidebar">
    <h3>ASPIRE LMS</h3>
    <p><a href="#">Dashboard</a></p>
    <p><a href="#">Manage Books</a></p>
    <!-- Add other menu links -->
</div>

<div class="content">
    <h2>Manage Books</h2>
    <input type="text" id="searchInput" class="search-bar" placeholder="Search by title..." onkeyup="filterBooks()">
    <table class="table" id="booksTable">
        <thead>
            <tr>
                <th>Book ID</th><th>Title</th><th>Author</th><th>Category</th>
                <th>Language</th><th>Copies</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['book_id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['language'] ?></td>
                <td><?= $row['copies'] ?></td>
                <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
function filterBooks() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#booksTable tbody tr");
    rows.forEach(row => {
        const title = row.cells[1].innerText.toLowerCase();
        row.style.display = title.includes(input) ? "" : "none";
    });
}
</script>
</body>
</html>