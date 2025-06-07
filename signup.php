<?php
// Include the database configuration file
include('includes/dbconfig.php');

// Initialize message variable for alerts
$msg = "";

// If the signup form is submitted
if (isset($_POST['signup'])) {
    // Get user inputs from form
    $username = $_POST['username'];
    $email    = $_POST['email'];

    // Securely hash the password using bcrypt
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare SQL query to insert the new user
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql); // Prepare statement
    $stmt->bind_param("sss", $username, $email, $password); // Bind parameters

    // Execute and check if the insertion was successful
    if ($stmt->execute()) {
        header("Location: login.php"); // Redirect to login page
        exit();
    } else {
        $msg = "❌ Email already registered."; // Show error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup - BBMS</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Google Font (Optional) -->
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">

  <!-- Custom Styling -->
  <style>
    /* Gradient background */
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* Pink to light blue */
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      overflow-x: hidden;
    }

    /* Signup Card */
    .card {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 500px;
      animation: slideIn 0.7s ease-out;
    }

    /* Title style */
    h2 {
      color: #28a745; /* Bootstrap green */
      font-weight: bold;
      animation: fadeIn 1.2s ease-in;
    }

    /* Input focus effect */
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
      border-color: #28a745;
    }

    /* Sign up button */
    .btn-success {
      background-color: #28a745;
      border: none;
      transition: background-color 0.3s ease-in-out;
    }

    .btn-success:hover {
      background-color: #218838;
    }

    /* Animations */
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
      0% { opacity: 0; transform: translateX(-100px); }
      100% { opacity: 1; transform: translateX(0); }
    }
  </style>
</head>

<body>
  <!-- Signup Card -->
  <div class="card">
    <h2 class="text-center mb-4">Create Your BBMS Account</h2>

    <!-- Display message if exists -->
    <?php if ($msg): ?>
      <div class="alert alert-warning text-center"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Signup Form -->
    <form method="POST">
      <!-- Username input -->
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <!-- Email input -->
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <!-- Password input -->
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <!-- Submit Button -->
      <div class="d-flex justify-content-between">
        <a href="login.php" class="btn btn-secondary">Back to Login</a>
        <button type="submit" name="signup" class="btn btn-success">Sign Up</button>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
