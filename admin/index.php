<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
// echo '<a href="../logout.php">Logout</a>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js" />
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>

  <header>
    <div class="header-left">
      <div class="hamburger" id="hamburger">&#9776;</div>
      <div class="logo">📚 MyLMS</div>
    </div>
    <nav id="nav-menu">
      <ul>
        <li><a href="#">Notifications</a></li>
        <li><a href="#">Setting</a></li>
        <li><a href="#">Profile</a></li>
        <li><?php echo '<a class="head-link" href="../logout.php">Logout</a>';?></li> 
      </ul>
    </nav>
  </header>

  <div class="body">
    <div class="sidebar">
      <!-- <h2>My LMS</h2> -->
      <ul>
        <li>Dashboard</li>
        <li>Resources</li>
        <li>Manage Books</li>
        <li>Reports</li>
        <li>Lended Books</li>
        <li>Members</li>
        <li>Settings</li>
        <li>Notifications</li>
        <li>Logout</li>
      </ul>
    </div>

    <div class="main">
      <div class="topbar">
        <h1>Welcome Admin</h1>
        <button>Add New Book</button>
      </div>

      <div class="cards">
        <div class="card">
          <h3>Total Books</h3>
          <p>2000</p>
        </div>
        <div class="card">
          <h3>Lended Books</h3>
          <p>500</p>
        </div>
        <div class="card">
          <h3>Available Books</h3>
          <p>800</p>
        </div>
        <div class="card">
          <h3>Total Users</h3>
          <p>500</p>
        </div>
        <div class="card">
          <h3>Overdue Books</h3>
          <p>300</p>
        </div>
      </div>

      <div class="charts">
        <div class="chart-box">
          <h3>No of Visitors</h3>
          <canvas id="visitorsChart"></canvas>
        </div>

        <div class="chart-box">
          <h3>Books Allocation by Locations</h3>
          <canvas id="locationChart"></canvas>
        </div>

        <div class="chart-box">
          <h3>Book Availability</h3>
          <canvas id="availabilityChart"></canvas>
        </div>

        <div class="chart-box">
          <h3>Book Lending Trends</h3>
          <canvas id="lendingChart"></canvas>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ctx1 = document.getElementById('visitorsChart').getContext('2d');
      new Chart(ctx1, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
          datasets: [
            { label: 'Visitors', data: [80, 100, 95, 130, 150, 140, 120, 100], backgroundColor: '#5b21b6' },
            { label: 'Lenders', data: [40, 60, 50, 70, 80, 70, 60, 50], backgroundColor: '#818cf8' }
          ]
        }
      });

      const ctx2 = document.getElementById('locationChart').getContext('2d');
      new Chart(ctx2, {
        type: 'doughnut',
        data: {
          labels: ['Chennai', 'Coimbatore', 'Hyderabad', 'Bangalore', 'Kerala'],
          datasets: [{
            data: [25, 20, 15, 25, 15],
            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444']
          }]
        }
      });

      const ctx3 = document.getElementById('availabilityChart').getContext('2d');
      new Chart(ctx3, {
        type: 'pie',
        data: {
          labels: ['Lended', 'Available', 'Reserved'],
          datasets: [{
            data: [45, 50, 5],
            backgroundColor: ['#ef4444', '#10b981', '#f59e0b']
          }]
        }
      });

      const ctx4 = document.getElementById('lendingChart').getContext('2d');
      new Chart(ctx4, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
          datasets: [{
            label: 'Books Lent',
            data: [200, 300, 350, 400, 420, 380, 360, 300],
            backgroundColor: '#7c3aed'
          }]
        }
      });
    </script>
  </div>
</body>

</html>