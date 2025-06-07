<?php
session_start();
include('../includes/dbconfig.php');

if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit();
}

// ✅ Define all required dashboard variables
$total_donors = $conn->query("SELECT COUNT(*) AS count FROM donors")->fetch_assoc()['count'];
$total_messages = $conn->query("SELECT COUNT(*) AS count FROM messages")->fetch_assoc()['count'];
$total_requests = $conn->query("SELECT COUNT(*) AS count FROM blood_request")->fetch_assoc()['count'];
$total_events = $conn->query("SELECT COUNT(*) AS count FROM events")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - BBMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee);
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
      min-height: 100vh;
    }

    .dashboard-box {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      max-width: 1100px;
      margin: auto;
      box-shadow: 0 12px 35px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    h2 {
      color: #dc3545;
      font-weight: bold;
    }

    .stats-card {
      background-color: #f8f9fa;
      border-left: 5px solid #dc3545;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
      transition: 0.3s ease;
    }

    .stats-card:hover {
      transform: scale(1.02);
      background-color: #fff0f3;
    }

    .stats-card h4 {
      margin-bottom: 5px;
      font-weight: 600;
      font-size: 1.2rem;
    }

    .stats-card p {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .quick-links a {
      display: block;
      margin: 10px 0;
      padding: 10px 15px;
      background-color: #f1f1f1;
      border-radius: 8px;
      color: #333;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .quick-links a:hover {
      background-color: #dc3545;
      color: white;
    }

    .logout-btn {
      text-align: end;
    }

    .logout-btn a {
      background-color: #6c757d;
      color: #fff;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
    }

    .logout-btn a:hover {
      background-color: #495057;
    }
  </style>
</head>

<body>

<div class="dashboard-box">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['admin']) ?> 👑</h2>
    <div class="logout-btn">
      <a href="../logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
    </div>
  </div>

  <!-- Stats -->
  <div class="row text-center mb-4">
    <div class="col-md-3">
      <div class="stats-card">
        <h4>🧑‍🤝‍🧑 Total Donors</h4>
        <p><?= $total_donors ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <h4>📥 Messages</h4>
        <p><?= $total_messages ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <h4>🩸 Blood Requests</h4>
        <p><?= $total_requests ?></p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <h4>📅 Events</h4>
        <p><?= $total_events ?></p>
      </div>
    </div>
  </div>

  <!-- Quick Navigation Links -->
  <div class="quick-links">
    <h5 class="text-primary">🔗 Quick Links</h5>
    <a href="view_donors.php"><i class="bi bi-people-fill"></i> Manage Donors</a>
    <a href="view_blood_requests.php"><i class="bi bi-droplet-fill"></i> View Blood Requests</a>
    <a href="view_messages.php"><i class="bi bi-envelope-fill"></i> View Contact Messages</a>
    <a href="view_events.php"><i class="bi bi-calendar-event-fill"></i> View Event Applications</a>
    <a href="add_events.php"><i class="bi bi-calendar-plus"></i> Add New Event</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
