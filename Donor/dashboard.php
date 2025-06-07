<?php
session_start(); // Start the session to access session variables (e.g., logged-in user)

// Include the database configuration file to connect to the database
include('../includes/dbconfig.php'); // Corrected relative path

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); // Redirect unauthenticated users
    exit(); // Stop script execution
}

$username = $_SESSION['user']; // Get the logged-in username from session

// Fetch full user details from the database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql); // Prepare the SQL statement
$stmt->bind_param("s", $username); // Bind the username as a string
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result set
$user = $result->fetch_assoc(); // Fetch the user data as an associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Set character encoding -->
  <title>User Dashboard - BBMS</title> <!-- Page title in browser tab -->

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom inline CSS styling -->
  <style>
    body {
      background: linear-gradient(to right, rgb(228, 165, 190), rgb(149, 172, 206)); /* Background gradient */
      min-height: 100vh; /* Full height */
      font-family: 'Segoe UI', sans-serif; /* Font */
      padding: 40px 20px; /* Space around the content */
    }

    .dashboard-box {
      background: white; /* White card background */
      padding: 30px; /* Inner space */
      border-radius: 15px; /* Rounded corners */
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
      max-width: 800px; /* Max width */
      margin: auto; /* Center the card */
    }

    .dashboard-box h2 {
      color: #dc3545; /* Red heading */
    }

    .dashboard-links a {
      display: block; /* Block level for full width */
      padding: 10px 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      background: #f8f9fa; /* Light gray background */
      text-decoration: none; /* Remove underline */
      color: #333; /* Dark text */
      transition: all 0.2s ease-in-out; /* Smooth hover transition */
    }

    .dashboard-links a:hover {
      background: #dc3545; /* Red background on hover */
      color: white; /* White text on hover */
    }
  </style>
</head>

<body>
  <div class="dashboard-box"> <!-- Main container card -->
    <h2 class="text-center mb-4">
      Welcome, <?= htmlspecialchars($user['username']) ?> ❤️
      <!-- Safely display user's name -->
    </h2>

    <p class="text-success text-center">
      You're logged in as a <strong>blood donor</strong>.
    </p>

    <!-- User profile information -->
    <div class="mb-4">
      <h5>User Details:</h5>
      <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
      </ul>
    </div>

    <!-- Actionable links for user -->
    <div class="dashboard-links">
      <a href="../donor/register.php">➕ Register as Donor</a>
      <a href="../donor/my_donations.php">📄 View My Donations</a>
      <a href="../edit_profile.php">⚙️ Edit Profile</a>
      <a href="../logout.php">🚪 Logout</a>
    </div>

    <!-- Back to homepage button -->
    <div class="text-end mt-3">
      <a href="../index.php" class="btn btn-secondary">⬅️ Back to Home</a>
    </div>
  </div>
</body>
</html>
