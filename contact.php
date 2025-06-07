<?php
// Start a session
include('includes/dbconfig.php'); // Include database configuration file

$msg = ""; // Message variable to display feedback to the user

// Check if the form has been submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];       // Get user's name from form
    $email = $_POST["email"];     // Get user's email from form
    $message = $_POST["message"]; // Get user's message from form

    // SQL query to insert message into the 'messages' table
    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
    
    // Execute the query and store success or error message
    if ($conn->query($sql)) {
        $msg = "✅ Message sent successfully!";
    } else {
        $msg = "❌ Failed to send message: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - BBMS</title>

  <!-- External CSS files -->
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Inline styles for layout and design -->
  <style>
    body {
      background: linear-gradient(to right, rgb(228, 165, 190), rgb(149, 172, 206)); /* pink to blue gradient */
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .overlay {
      width: 100%;
      flex: 1;
      padding: 60px 20px;
    }

    footer {
      background-color: #212529;
      color: #fff;
    }

    .back-btn-top-left {
      position: absolute;
      top: 65px;
      left: 20px;
      z-index: 1000;
    }
  </style>
</head>
<body>

<!-- Top contact information bar -->
<div class="top-bar bg-primary text-white py-1 px-3 d-flex justify-content-between">
  <div>📧 BBMS25@gmail.com | 📞 +01-567547</div>
  <div>
    <a href="#" class="text-white px-2">FB</a>
    <a href="#" class="text-white px-2">TW</a>
    <a href="#" class="text-white px-2">IG</a>
  </div>
</div>

<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark position-relative">
  <div class="container-fluid">
    <!-- Logo/brand -->
    <a class="navbar-brand fw-bold text-danger" href="index.php">BB<span class="text-white">DMS</span></a>

    <!-- Collapse button for mobile view -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation links -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="donor/register.php">Register Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Search Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
      </ul>
    </div>

    <!-- Back to Home button -->
    <div class="back-btn-top-left">
      <a href="index.php" class="btn btn-outline-light btn-sm">&larr; Back</a>
    </div>
  </div>
</nav>

<!-- Main content area: Contact form -->
<div class="overlay">
  <div class="container">
    <h2 class="mb-4 text-danger">Contact Us</h2>
    <p class="lead">Have questions or suggestions? Reach out to us below.</p>

    <!-- Display message if any (success or error) -->
    <?php if (!empty($msg)): ?>
      <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Contact form -->
    <form method="POST">
      <!-- Name input field -->
      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <!-- Email input field -->
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <!-- Message textarea field -->
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
      </div>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
  </div>
</div>

<!-- Footer -->
<footer class="text-center py-3">
  &copy; <?php echo date("Y"); ?> BBMS | Blood Bank & Donor Management System
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
