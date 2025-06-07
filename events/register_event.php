<?php
session_start(); // Start PHP session to track user info if needed
include('../includes/dbconfig.php'); // Include DB configuration (database connection)

$message = ""; // Initialize a message variable to store success or error messages

// When the form is submitted
if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];       // Get full name from form input
    $email = $_POST['email'];             // Get email from form input
    $event_name = $_POST['event_name'];   // Get event name from form input

    // Prepare SQL insert statement to insert data into event_registrations table
    $sql = "INSERT INTO event_registrations (fullname, email, event_name) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql); // Prepare the SQL statement
    $stmt->bind_param("sss", $fullname, $email, $event_name); // Bind form inputs as string values

    // Execute the SQL statement and set the message accordingly
    if ($stmt->execute()) {
        $message = "✅ Registration successful!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Define character encoding -->
  <title>Register for Event</title> <!-- Page title in browser tab -->

  <!-- Bootstrap CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Internal custom CSS for styling and animations -->
  <style>
    body {
      background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* Soft gradient background */
      min-height: 100vh; /* Full screen height */
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif; /* Font for modern appearance */
    }

    .card {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); /* Smooth shadow */
      width: 100%;
      max-width: 500px; /* Limit max width */
      animation: slideIn 0.7s ease-out; /* Slide animation */
    }

    h2 {
      color: #dc3545; /* Red heading */
      font-weight: bold;
      animation: fadeIn 1s ease-in; /* Fade-in animation */
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .form-control:focus {
      border-color: #dc3545; /* Red border on focus */
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .btn-danger {
      background-color: #dc3545;
      border: none;
    }

    .btn-danger:hover {
      background-color: #c82333; /* Darker red on hover */
    }

    .btn-secondary:hover {
      background-color: #6c757d;
    }
  </style>
</head>

<body>
<div class="card"> <!-- Form container styled as a card -->
  <h2 class="mb-4 text-center">Event Registration</h2>

  <?php if ($message): ?> <!-- If there’s a message (success/error), show it -->
    <div class="alert alert-info text-center"><?= $message ?></div>
  <?php endif; ?>

  <!-- Event Registration Form -->
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name:</label>
      <input type="text" name="fullname" class="form-control" required> <!-- Name input -->
    </div>

    <div class="mb-3">
      <label class="form-label">Email Address:</label>
      <input type="email" name="email" class="form-control" required> <!-- Email input -->
    </div>

    <div class="mb-3">
      <label class="form-label">Event Name:</label>
      <input type="text" name="event_name" class="form-control" required> <!-- Event name input -->
    </div>

    <div class="d-flex justify-content-between">
      <a href="../index.php" class="btn btn-secondary">Back</a> <!-- Back to homepage -->
      <button type="submit" name="submit" class="btn btn-danger">Register</button> <!-- Submit form -->
    </div>
  </form>
</div>
</body>
</html>
