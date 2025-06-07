<?php
// Start the session and validate admin login
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit();
}

// Include database connection
include('../includes/dbconfig.php');

// Fetch all donors from the database
$sql = "SELECT * FROM donors ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Donors - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee);
      font-family: 'Segoe UI', sans-serif;
      padding: 30px;
    }
    .card {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      max-width: 1000px;
      margin: auto;
    }
    .table thead {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2 class="text-center text-danger mb-4">All Registered Donors</h2>

    <?php if ($result && $result->num_rows > 0): ?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Blood Group</th>
            <th>Contact</th>
            <th>Location</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['blood_group']) ?></td>
              <td><?= htmlspecialchars($row['contact']) ?></td>
              <td><?= htmlspecialchars($row['location']) ?></td>
              <td>
                <a href="edit_donor.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="delete_donor.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-warning text-center">No donors found.</div>
    <?php endif; ?>

    <div class="text-end mt-3">
      <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
  </div>
</body>
</html>