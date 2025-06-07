<?php
// Start by including DB configuration for MySQL connection
include('includes/dbconfig.php');

// Initialize empty array to store donor results
$results = [];

// Check if form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form inputs
    $blood_group = $_POST['blood_group'];
    $location = $_POST['location'];

    // SQL query to fetch donors by blood group and location (LIKE for partial match)
    $sql = "SELECT * FROM donors WHERE blood_group = ? AND location LIKE ?";
    $stmt = $conn->prepare($sql); // Prepare SQL

    // Format location string with wildcards for LIKE search
    $search_location = "%" . $location . "%";

    // Bind user inputs to SQL query safely
    $stmt->bind_param("ss", $blood_group, $search_location);

    // Execute query and fetch results
    $stmt->execute();
    $results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Donor - BBMS</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Animate.css for animation effects -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <style>
    /* Main body background and layout */
    body {
      background: linear-gradient(to right, rgb(228, 165, 190), rgb(149, 172, 206));
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      padding: 40px 20px;
    }

    /* Card container for the form and results */
    .card {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      max-width: 800px;
      margin: auto;
    }

    /* Table header styling */
    .result-table th {
      background-color: #dc3545;
      color: white;
    }

    /* Optional: Fade out alert smoothly */
    .fade-out {
      animation: fadeOut 1s forwards;
    }

    @keyframes fadeOut {
      to { opacity: 0; transform: translateY(-10px); display: none; }
    }
  </style>
</head>

<body>

  <!-- Main container card -->
  <div class="card">
    <h2 class="mb-4 text-center text-danger">🔍 Search Blood Donor</h2>

    <!-- Search Form -->
    <form method="POST" class="row g-3 mb-4">
      <!-- Blood Group dropdown -->
      <div class="col-md-6">
        <label class="form-label">Blood Group</label>
        <select name="blood_group" class="form-select" required>
          <option value="">--Select--</option>
          <option>A+</option><option>A-</option>
          <option>B+</option><option>B-</option>
          <option>O+</option><option>O-</option>
          <option>AB+</option><option>AB-</option>
        </select>
      </div>

      <!-- Location input -->
      <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" required placeholder="Enter City or Area">
      </div>

      <!-- Search Button -->
      <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

    <!-- Show alert & result table -->
    <?php if (!empty($results) && $results->num_rows > 0): ?>
      <!-- Success message with animation -->
      <div class="alert alert-success animate__animated animate__fadeInDown" id="alertBox">
        ✅ <?= $results->num_rows ?> donor(s) found!
      </div>

      <!-- Results Table -->
      <table class="table table-bordered result-table mt-3">
        <thead>
          <tr>
            <th>Name</th>
            <th>Blood Group</th>
            <th>Contact</th>
            <th>Location</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $results->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['blood_group']) ?></td>
              <td><?= htmlspecialchars($row['contact']) ?></td>
              <td><?= htmlspecialchars($row['location']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
      <!-- Warning alert if no results -->
      <div class="alert alert-warning animate__animated animate__fadeInDown" id="alertBox">
        ❌ No donors found matching your criteria.
      </div>
    <?php endif; ?>

    <!-- Back button -->
    <div class="text-end mt-4">
      <a href="index.php" class="btn btn-secondary">⬅️ Back to Home</a>
    </div>
  </div>

  <!-- Bootstrap & JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS to auto-hide alert after 3 seconds -->
  <script>
    setTimeout(() => {
      const alert = document.getElementById('alertBox');
      if (alert) {
        alert.classList.add('animate__fadeOutUp');
        setTimeout(() => alert.style.display = 'none', 1000);
      }
    }, 3000);
  </script>

</body>
</html>
