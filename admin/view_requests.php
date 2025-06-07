<?php
session_start(); // Start the session to access admin session

// Redirect to login page if not logged in as admin
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit();
}

// Include the database configuration file to connect to MySQL
include('../includes/dbconfig.php');

// Fetch all event registration requests from the database, newest first
$sql = "SELECT * FROM event_registrations ORDER BY created_at DESC";
$result = $conn->query($sql); // Execute the query and store result
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Event Requests - BBMS Admin</title>

  <!-- Bootstrap CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons (optional for future buttons/icons) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom styles -->
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* Gradient background */
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
    }

    .card {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Soft shadow */
      max-width: 960px;
      margin: auto;
    }

    .table th {
      background-color: #dc3545; /* Red table headers */
      color: #fff;
    }
  </style>
</head>

<body>

<!-- Main container for the request list -->
<div class="card">
  <!-- Page Title -->
  <h2 class="text-center text-danger mb-4">📋 Donor Registration Requests</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <!-- If records exist, show them in a styled table -->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Event</th>
          <th>Registered On</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop through each row and display it -->
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td> <!-- Serial number -->
            <td><?= htmlspecialchars($row['name']) ?></td> <!-- Donor name -->
            <td><?= htmlspecialchars($row['email']) ?></td> <!-- Donor email -->
            <td><?= htmlspecialchars($row['phone']) ?></td> <!-- Contact number -->
            <td><?= htmlspecialchars($row['event_name']) ?></td> <!-- Registered event -->
            <td>
              <?= isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A' ?>
            </td> <!-- Registration date or fallback -->
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

  <?php else: ?>
    <!-- Show this if no registration requests are found -->
    <div class="alert alert-warning text-center">
      ❌ No registration requests found.
    </div>
  <?php endif; ?>

  <!-- Back to dashboard button -->
  <div class="text-end mt-3">
    <a href="dashboard.php" class="btn btn-secondary">⬅️ Back to Dashboard</a>
  </div>
</div>

</body>
</html>
