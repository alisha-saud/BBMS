<?php
session_start(); // Start session to validate admin login

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit();
}

include('../includes/dbconfig.php'); // Connect to database

// Fetch all events ordered by date
$sql = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Events - BBMS Admin</title>

  <!-- Bootstrap CSS and Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* Soft gradient background */
      padding: 40px;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 1000px;
      margin: auto;
    }

    .table th {
      background-color: #dc3545;
      color: white;
    }

    .btn-back {
      margin-top: 20px;
    }
  </style>
</head>

<body>

<div class="card">
  <h2 class="text-center text-danger mb-4">📅 All Events Listed</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <!-- Display Events Table -->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Event Title</th>
          <th>Date</th>
          <th>Time</th>
          <th>Location</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['time']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <!-- No events found -->
    <div class="alert alert-warning text-center">❌ No events found in the database.</div>
  <?php endif; ?>

  <!-- Back Button -->
  <div class="text-end btn-back">
    <a href="dashboard.php" class="btn btn-secondary">⬅️ Back to Dashboard</a>
  </div>
</div>

</body>
</html>
