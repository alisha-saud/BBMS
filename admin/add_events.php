<?php
session_start(); // Start session for admin authentication

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin'])) {
  header("Location: ../login.php");
  exit();
}

include('../includes/dbconfig.php'); // DB connection

$msg = ""; // Message for success/failure

// Handle form submission
if (isset($_POST['submit'])) {
  // Collect and sanitize form inputs
  $title = $_POST['title'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $location = $_POST['location'];
  $description = $_POST['description'];

  // Insert into database using prepared statement
  $sql = "INSERT INTO events (title, date, time, location, description) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $title, $date, $time, $location, $description);

  if ($stmt->execute()) {
    $msg = "✅ Event added successfully!";
  } else {
    $msg = "❌ Error: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Event - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* pink to blue */
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
    }
    .card {
      background: white;
      border-radius: 15px;
      padding: 30px;
      max-width: 700px;
      margin: auto;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      color: #dc3545;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="card">
  <h2 class="text-center mb-4">➕ Add New Event</h2>

  <!-- Display message -->
  <?php if (!empty($msg)): ?>
    <div class="alert alert-info"><?= $msg ?></div>
  <?php endif; ?>

  <!-- Event Form -->
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Event Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Date</label>
      <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Time</label>
      <input type="time" name="time" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Location</label>
      <input type="text" name="location" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>

    <!-- Submit & Back -->
    <div class="d-flex justify-content-between">
      <a href="dashboard.php" class="btn btn-secondary">⬅️ Back</a>
      <button type="submit" name="submit" class="btn btn-danger">Add Event</button>
    </div>
  </form>
</div>

</body>
</html>
