<?php

session_start(); // 🔥 Must be first!
require_once 'includes/auth.php';

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
redirectIfNotLoggedIn('login.php');// to check logined
// if (!isLoggedIn()) {
//     header ('Location: login.php');  
// }
// redirectIfNotAdmin('dashboard.php');
if (isAdmin()) {
    header('Location: admin/');
    exit();
}

echo "<a href='logout.php' class='logout-btn'>Logout</a>";
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
      <div class="p-6 text-purple-700 font-bold text-xl">ASPIRE LMS</div>
      <nav class="space-y-2 text-gray-700">
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Dashboard</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Resources</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Manage Books</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Reports</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Lended Books</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Members</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Settings</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Notifications</a>
        <a href="#" class="block px-6 py-2 hover:bg-gray-100">Logout</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-semibold">Welcome Admin</h1>
        <button class="bg-purple-600 text-white px-4 py-2 rounded">Add New Book</button>
      </div>

      <!-- Stat Cards -->
      <div class="grid grid-cols-5 gap-4 mb-6">
        <div class="bg-yellow-100 p-4 rounded shadow text-center">
          <h2 class="text-lg font-semibold">Total Books</h2>
          <p class="text-2xl font-bold">2000</p>
          <button class="text-sm text-purple-600">View Details</button>
        </div>
        <div class="bg-purple-100 p-4 rounded shadow text-center">
          <h2 class="text-lg font-semibold">Lended Books</h2>
          <p class="text-2xl font-bold">500</p>
          <button class="text-sm text-purple-600">View Details</button>
        </div>
        <div class="bg-green-100 p-4 rounded shadow text-center">
          <h2 class="text-lg font-semibold">Available Books</h2>
          <p class="text-2xl font-bold">800</p>
          <button class="text-sm text-purple-600">View Details</button>
        </div>
        <div class="bg-teal-100 p-4 rounded shadow text-center">
          <h2 class="text-lg font-semibold">Total Users</h2>
          <p class="text-2xl font-bold">500</p>
          <button class="text-sm text-purple-600">View Details</button>
        </div>
        <div class="bg-pink-100 p-4 rounded shadow text-center">
          <h2 class="text-lg font-semibold">Overdue Books</h2>
          <p class="text-2xl font-bold">300</p>
          <button class="text-sm text-purple-600">View Details</button>
        </div>
      </div>

      <!-- Charts -->
      <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-4 rounded shadow">
          <h3 class="font-semibold mb-2">No of Visitors</h3>
          <canvas id="visitorsChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <h3 class="font-semibold mb-2">Books Allocation by Locations</h3>
          <canvas id="locationChart"></canvas>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded shadow">
          <h3 class="font-semibold mb-2">Book Availability</h3>
          <canvas id="availabilityChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <h3 class="font-semibold mb-2">Book Lending Trends</h3>
          <canvas id="lendingChart"></canvas>
        </div>
      </div>
    </main>
  </div>

  <script>
    const visitorsChart = new Chart(document.getElementById('visitorsChart'), {
      type: 'bar',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          { label: 'Visitors', data: [50,60,70,80,90,100,110,120,100,90,80,70], backgroundColor: '#4F46E5' },
          { label: 'Lenders', data: [30,40,50,60,70,80,90,100,80,70,60,50], backgroundColor: '#38BDF8' }
        ]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'top' } }
      }
    });

    new Chart(document.getElementById('locationChart'), {
      type: 'doughnut',
      data: {
        labels: ["Chennai", "Coimbatore", "Hyderabad", "Bangalore", "Kerala"],
        datasets: [{
          data: [25, 15, 20, 30, 10],
          backgroundColor: ["#3B82F6", "#10B981", "#F59E0B", "#8B5CF6", "#EF4444"]
        }]
      }
    });

    new Chart(document.getElementById('availabilityChart'), {
      type: 'doughnut',
      data: {
        labels: ["Lended", "Available", "Reserved"],
        datasets: [{
          data: [45, 50, 5],
          backgroundColor: ["#F87171", "#34D399", "#60A5FA"]
        }]
      }
    });

    new Chart(document.getElementById('lendingChart'), {
      type: 'bar',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: 'Books Lent',
          data: [300, 250, 350, 400, 420, 410, 390, 430, 370, 360, 200, 100],
          backgroundColor: '#8B5CF6'
        }]
      }
    });
  </script>
</body>
</html>

