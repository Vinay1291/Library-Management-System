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
    
    
  </div>
</body>
</html>

