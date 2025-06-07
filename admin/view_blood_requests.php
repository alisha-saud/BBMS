<?php
session_start();
include('../includes/dbconfig.php');

// Redirect if not admin
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit();
}

// Fetch blood requests
$result = $conn->query("SELECT * FROM blood_request ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Requests - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee);
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
      min-height: 100vh;
    }

    .card {
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      max-width: 1000px;
      margin: auto;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease-out;
    }

    h2 {
      color: #dc3545;
      font-weight: bold;
      text-align: center;
      margin-bottom: 25px;
    }

    .table th {
      background-color: #dc3545;
      color: #fff;
    }

    .alert {
      text-align: center;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .back-btn {
      text-align: end;
      margin-top: 20px;
    }

    .btn-back {
      background-color: #6c757d;
      color: #fff;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .btn-back:hover {
      background-color: #495057;
    }
  </style>
</head>
<body>

<div class="card">
  <h2>📩 Blood Requests</h2>

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Blood Group</th>
          <th>Location</th>
          <th>Requested At</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['blood_group']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= $row['created_at'] ?? 'N/A' ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning">❌ No blood requests found.</div>
  <?php endif; ?>

  <div class="back-btn">
    <a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>
  </div>
</div>

</body>
</html>
