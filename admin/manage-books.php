<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$activePage = 'manage-books';

$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/booksmng.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="body">

        <div class="sidebar">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        <main>
            <h2>Manage Books</h2>
            <div class="container">
                <div class="toolbar">
                    <div class="search-bar"> 
                        <span class="search-icon">🔍</span> 
                        <input type="text" class="search-input" placeholder="Search books"> </div>
                    <div class="actions"> 
                        <button class="add-button" onclick="window.location.href='add_books.php'">+ Add Books</button> 
                        <button class="actions-button">Actions ▾</button> 
                    </div>
                </div>

                <table class="table" id="booksTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th class="sortable">Book ID <span>↑↓</span></th>
                            <th class="sortable">Book Title <span>↑↓</span></th>
                            <th class="sortable">Author(s) <span>↑↓</span></th>
                            <th class="sortable">Genre/Category <span>↑↓</span></th>
                            <th class="sortable">Language <span>↑↓</span></th>
                            <th class="sortable">Total Copies <span>↑↓</span></th>
                            <th class="sortable">Status <span>↑↓</span></th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- <tr>
                            <td><input type="checkbox"></td>
                            <td>ASP-B0-01</td>
                            <td>The Great Gatsby</td>
                            <td>F. Scott Fitzgerald</td>
                            <td>Fiction</td>
                            <td>English</td>
                            <td>10</td>
                            <td><span class="status-Available">Available</span></td>
                        </tr> -->
                        <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <?= $row['book_id'] ?>
                            </td>
                            <td>
                                <?= $row['title'] ?>
                            </td>
                            <td>
                                <?= $row['author'] ?>
                            </td>
                            <td>
                                <?= $row['category'] ?>
                            </td>
                            <td>
                                <?= $row['language'] ?>
                            </td>
                            <td>
                                <?= $row['copies'] ?>
                            </td>
                            <td><span class="status-<?= $row['status'] ?>">
                                    <?= $row['status'] ?>
                                </span></td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
                <div class="pagination">
                <div>Total Books: 1000</div>
                <div class="pagination-links"> <a href="#" class="pagination-arrow disabled">&lt;&lt;</a> <a href="#"
                        class="pagination-arrow disabled">&lt;</a> <a href="#" class="pagination-link active">1</a> <a
                        href="#" class="pagination-link">2</a> <a href="#" class="pagination-link">3</a> <a href="#"
                        class="pagination-link">4</a> <a href="#" class="pagination-link">5</a> <a href="#"
                        class="pagination-arrow">&gt;</a> <a href="#" class="pagination-arrow">&gt;&gt;</a> </div>
                <div class="show-entries"> Show <select>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select> entries </div>
            </div>
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
        </main>
    </div>
    <?php include 'includes/footer.php' ?>
</body>

</html>