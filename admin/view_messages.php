<?php
session_start();
include('../includes/dbconfig.php');
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch messages from database
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Messages - BBMS</title>
  <!-- Bootstrap CSS and Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee);
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
    }
    .card {
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      max-width: 960px;
      margin: auto;
    }
    h2 {
      color: #dc3545;
      font-weight: bold;
    }
    .table thead {
      background-color: #dc3545;
      color: white;
    }
    .alert {
      margin-top: 20px;
      padding: 15px;
    }
    .back-btn {
      margin-top: 30px;
      text-align: right;
    }
    .back-btn a {
      background-color: #6c757d;
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
    }
    .back-btn a:hover {
      background-color: #495057;
    }
  </style>
</head>
<body>
<div class="card">
  <h2 class="text-center mb-4"><i class="bi bi-chat-left-text"></i> Contact Messages</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
          <td><?= isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A' ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning text-center">
      <i class="bi bi-x-circle"></i> No messages found.
    </div>
  <?php endif; ?>

  <div class="back-btn">
    <a href="dashboard.php"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
  </div>
</div>
</body>
</html>
