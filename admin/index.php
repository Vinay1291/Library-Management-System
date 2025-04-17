
<?php
session_start();
require_once '../includes/auth.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
echo '<a href="../logout.php">Logout</a>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color: #f3f6fc;
    }

    .sidebar {
      width: 220px;
      background-color: white;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
    }

    .sidebar h2 {
      margin-bottom: 30px;
      color: #5b21b6;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      padding: 10px;
      margin: 5px 0;
      color: #333;
      cursor: pointer;
    }

    .sidebar ul li:hover {
      background-color: #f0f0f0;
    }

    .main {
      flex: 1;
      padding: 20px;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .cards {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .card {
      background-color: white;
      flex: 1;
      padding: 20px;
      border-left: 5px solid #5b21b6;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card h3 {
      margin-bottom: 10px;
    }

    .charts {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .chart-box {
      background-color: white;
      flex: 1;
      min-width: 300px;
      padding: 20px;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>ASPIR LMS</h2>
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
</body>

</html>
