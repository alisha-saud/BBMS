<?php
session_start();
include('../includes/dbconfig.php');
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Count queries
$totalDonors = $conn->query("SELECT COUNT(*) as count FROM donors")->fetch_assoc()['count'];
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$totalMessages = $conn->query("SELECT COUNT(*) as count FROM messages")->fetch_assoc()['count'];
$totalEvents = $conn->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Statistics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container card p-4">
  <h2 class="text-center text-danger mb-4">📊 Admin Dashboard Statistics</h2>
  <div class="row text-center">
    <div class="col-md-3"><div class="alert alert-info"><strong>🧑‍🦰 Donors:</strong><br><?= $totalDonors ?></div></div>
    <div class="col-md-3"><div class="alert alert-primary"><strong>👤 Users:</strong><br><?= $totalUsers ?></div></div>
    <div class="col-md-3"><div class="alert alert-warning"><strong>📧 Messages:</strong><br><?= $totalMessages ?></div></div>
    <div class="col-md-3"><div class="alert alert-success"><strong>📅 Events:</strong><br><?= $totalEvents ?></div></div>
  </div>
  <div class="text-center mt-3">
    <a href="dashboard.php" class="btn btn-secondary">⬅️ Back to Dashboard</a>
  </div>
</div>
</body>
</html>
