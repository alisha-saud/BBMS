<?php
session_start();
include('../includes/dbconfig.php'); // Include DB config

$success = false;
$error = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_group = $_POST['blood_group'];

    // Use correct column names (case-sensitive!)
    $sql = "INSERT INTO donors (name, Email, contact, blood_group) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $name, $email, $phone, $blood_group);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "❌ Execute failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "❌ Prepare failed: " . $conn->error;
    }
}

$backUrl = isset($_SESSION['admin']) ? "../admin/dashboard.php" : "../index.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register Donor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background: #fff;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 520px;
      animation: slideIn 0.7s ease-out;
    }
    h2 {
      color: #dc3545;
      font-weight: bold;
      text-align: center;
      animation: fadeIn 1s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-100px); }
      to { opacity: 1; transform: translateX(0); }
    }
    .form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
    }
    .btn-danger:hover {
      background-color: #c82333;
    }
    .btn-secondary:hover {
      background-color: #6c757d;
    }

    /* 🎉 Emoji animation */
    .emoji-bounce {
      font-size: 2rem;
      animation: bounce 1s ease infinite;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
  </style>
</head>
<body>
<div class="card">
  <h2 class="mb-4">Register as Donor</h2>

  <?php if ($success): ?>
    <div class="alert alert-success text-center">
      <div class="emoji-bounce">🎉</div>
      <strong>Donor registered successfully!</strong><br>
      <a href="../index.php" class="btn btn-sm btn-outline-success mt-2">Go to Home</a>
    </div>
  <?php elseif (!empty($error)): ?>
    <div class="alert alert-danger text-center"><i class="bi bi-x-circle-fill me-2"></i> <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <!-- Registration Form -->
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name:</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email:</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Phone:</label>
      <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Select Blood Group:</label>
      <select name="blood_group" class="form-control" required>
        <option value="">-- Select --</option>
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>O+</option><option>O-</option>
        <option>AB+</option><option>AB-</option>
      </select>
    </div>

    <div class="d-flex justify-content-between">
      <a href="<?= $backUrl ?>" class="btn btn-secondary">⬅ Back</a>
      <button type="submit" name="submit" class="btn btn-danger">Register</button>
    </div>
  </form>
</div>
</body>
</html>
