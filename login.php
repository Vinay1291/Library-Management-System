<?php
session_start();
require_once 'includes/db.php';  // Include DB connection
require_once 'includes/auth.php'; // Include auth checks

// Redirect to dashboard if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // e.g., 'admin' or 'user'
            
            // Redirect to dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No user found with that email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Signup</title>
  <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>

  <div class="container" id="container">
    
    <!-- Signup Section -->
    <div class="form-container sign-up-container">
      <form action="#">
        <h2>Create Account</h2>
        <input type="text" placeholder="Full Name" />
        <input type="text" placeholder="Phone No.">
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <input type="text" placeholder="Repeat Password" />
        <button>Sign Up</button>
        <p class="mobile-switch">Already have an account? <a href="#login" id="mobileToLogin">Login</a></p>
      </form>
    </div>

    <!-- Login Section -->
    <div class="form-container sign-in-container">
      <form action="#">
        <h2>Sign in</h2>
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <button>Login</button>
        <p class="mobile-switch">Don't have an account? <a href="#signup" id="mobileToSignup">Sign Up</a></p>
      </form>
    </div>

    <!-- Overlay Section -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2>Hello, Friend!</h2>
          <p>Enter your details and start your journey with us</p>
          <button class="ghost" id="signIn">Login</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2>Welcome Back!</h2>
          <p>To keep connected with us, please login with your personal info</p>
          
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>

  </div>

  <script src="assets/js/login.js"></script>
</body>
</html>