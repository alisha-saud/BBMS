<?php
session_start(); // Start the session to check logged-in status
include('includes/dbconfig.php'); // Include database connection

$msg = ""; // Message placeholder (success/error feedback)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form values
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $blood_group = $_POST['blood_group'];
    $location = $_POST['location'];

    // ✅ IMPORTANT: Table name must match your database (your screenshot shows 'blood_request')
    $sql = "INSERT INTO blood_request (name, phone, blood_group, location) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql); // Prepare the insert statement

    if ($stmt) {
        // Bind input values to SQL statement
        $stmt->bind_param("ssss", $name, $phone, $blood_group, $location);

        if ($stmt->execute()) {
            $msg = "✅ Blood request submitted successfully!";

            // Find donors who match blood group and are nearby
            $donor_sql = "SELECT name, email FROM donors WHERE blood_group = ? AND location LIKE ?";
            $donor_stmt = $conn->prepare($donor_sql); // Prepare donor query

            if ($donor_stmt) {
                $searchLocation = "%" . $location . "%"; // Wildcard for partial match
                $donor_stmt->bind_param("ss", $blood_group, $searchLocation);
                $donor_stmt->execute();
                $result = $donor_stmt->get_result();

                // Send emails to matching donors
                while ($donor = $result->fetch_assoc()) {
                    if (!empty($donor['email'])) {
                        $to = $donor['email'];
                        $subject = "🩸 Urgent Blood Request in $location";
                        $message = "Dear {$donor['name']},\n\n"
                                 . "We received a blood request for group $blood_group in your area ($location).\n"
                                 . "If you're available, please consider donating.\n\n"
                                 . "Thank you,\nBBMS Team";
                        $headers = "From: BBMS <noreply@bbms.com>";

                        // @ used to suppress error if mail() fails
                        @mail($to, $subject, $message, $headers);
                    }
                }
            } else {
                $msg = "⚠️ Donor query failed: " . $conn->error;
            }
        } else {
            $msg = "❌ Failed to submit request: " . $stmt->error;
        }
    } else {
        $msg = "❌ Database error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Request Blood - BBMS</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* gradient bg */
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      background: white;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      max-width: 520px;
      width: 100%;
      animation: fadeIn 0.7s ease-out;
    }

    h2 {
      color: #dc3545; /* red text */
      font-weight: bold;
      text-align: center;
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
      border-color: #dc3545;
    }

    .btn-danger {
      background-color: #dc3545;
      border: none;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }
  </style>
</head>

<body>
<!-- Main Form Card -->
<div class="card">
  <h2 class="mb-4">🩸 Request for Blood</h2>

  <!-- Message Display -->
  <?php if (!empty($msg)): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <!-- Blood Request Form -->
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Contact Number</label>
      <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Blood Group Needed</label>
      <select name="blood_group" class="form-control" required>
        <option value="">-- Select --</option>
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>O+</option><option>O-</option>
        <option>AB+</option><option>AB-</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Location</label>
      <input type="text" name="location" class="form-control" required>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between">
      <a href="index.php" class="btn btn-secondary">⬅ Back</a>
      <button type="submit" class="btn btn-danger">Submit Request</button>
    </div>
  </form>
</div>
</body>
</html>
