<?php
session_start(); // Start a new or resume existing session

include('includes/dbconfig.php'); // Include the database connection file

$message = ""; // Variable to store error/success messages

// Check if the login form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form inputs
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role']; // Either 'admin' or 'user'

    // Handle hardcoded Admin login
    if ($role == "admin" && $username == "admin" && $password == "admin123") {
        $_SESSION['admin'] = $username; // Store admin session
        header("Location: admin/dashboard.php"); // Redirect to admin dashboard
        exit(); // Stop further script execution
    }

    // Handle normal User login
    elseif ($role == "user") {
        $sql = "SELECT * FROM users WHERE username = ?"; // SQL query to find user by username
        $stmt = $conn->prepare($sql); // Prepare the SQL statement
        $stmt->bind_param("s", $username); // Bind the username to the SQL statement
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get result set
        $user = $result->fetch_assoc(); // Fetch user row as associative array

        // If user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username; // Store user session
            header("Location: index.php"); // Redirect to homepage
            exit(); // Stop further script execution
        } else {
            $message = "❌ Invalid username or password!"; // Error message
        }
    } else {
        $message = "❌ Invalid role or credentials!"; // General fallback error
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - BBMS</title> <!-- Page Title -->

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    /* Full screen gradient background */
    body {
      background: linear-gradient(to right, rgb(228, 165, 190), rgb(149, 172, 206));
      height: 100vh; /* Full screen height */
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Login form container */
    .login-box {
      background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
      width: 100%;
      max-width: 400px; /* Maximum width */
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #dc3545; /* Bootstrap red */
    }

    .btn-primary {
      width: 100%; /* Make login button full width */
    }

    .login-footer {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>

  <!-- Login Box Container -->
  <div class="login-box">
    <h2>Login to BBMS</h2>

    <!-- Display any message (error or success) -->
    <?php if ($message): ?>
      <div class="alert alert-danger text-center"> <?= $message ?> </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST">
      <!-- Username Field -->
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <!-- Password Field -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <!-- Role Selection -->
      <div class="mb-3">
        <label for="role" class="form-label">Login As</label>
        <select name="role" class="form-select" required>
          <option value="">-- Select Role --</option>
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>
      </div>

      <!-- Submit Button -->
      <button type="submit" name="submit" class="btn btn-primary">Login</button>
    </form>

    <!-- Link to Signup Page -->
    <div class="login-footer">
      <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
  </div>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

