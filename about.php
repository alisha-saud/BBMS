<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - BBMS</title>

  <!-- Link to custom stylesheet and Bootstrap -->
  <link rel="stylesheet" href="style.css"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Internal CSS styles -->
  <style>
    /* Full-body background with gradient and layout settings */
    body {
      background: linear-gradient(to right, rgb(228, 165, 190), rgb(149, 172, 206)); 
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Main content padding */
    .overlay {
      width: 100%;
      flex: 1;
      padding: 60px 20px;
    }

    /* Footer style */
    footer {
      background-color: #212529;
      color: #fff;
    }

    /* Back button positioning (top-left corner) */
    .back-btn-top-left {
      position: absolute;
      top: 65px;
      left: 20px;
      z-index: 1000;
    }
  </style>
</head>
<body>

<!-- Top contact bar (email & phone) -->
<div class="top-bar bg-primary text-white py-1 px-3 d-flex justify-content-between">
  <div>📧 BBMS25@gmail.com | 📞 +01-567547</div>
  <div>
    <a href="#" class="text-white px-2">FB</a>
    <a href="#" class="text-white px-2">TW</a>
    <a href="#" class="text-white px-2">IG</a>
  </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark position-relative">
  <div class="container-fluid">
    <!-- Site logo -->
    <a class="navbar-brand fw-bold text-danger" href="index.php">BB<span class="text-white">DMS</span></a>

    <!-- Mobile toggle button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation Links -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <!-- Current active page is 'About Us' -->
        <li class="nav-item"><a class="nav-link active" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="donor/register.php">Register Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Search Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
      </ul>
    </div>

    <!-- Back button (top-left under logo) -->
    <div class="back-btn-top-left">
      <a href="index.php" class="btn btn-outline-light btn-sm">&larr; Back</a>
    </div>
  </div>
</nav>

<!-- Main About Content -->
<div class="overlay">
  <div class="container">
    <h2 class="mb-4 text-danger">About Us</h2>

    <!-- Introduction paragraph -->
    <p class="lead">
      The Blood Bank & Donor Management System (BBMS) is an initiative to simplify and streamline the process of blood donation and donor tracking.
      Our system connects blood donors and recipients while helping hospitals and blood banks manage donor data efficiently.
    </p>

    <!-- More description -->
    <p>
      We are committed to saving lives by providing a reliable and user-friendly platform for blood donation. Whether you're a donor or in need of blood, BBMS makes the process simple, fast, and secure.
    </p>

    <!-- Mission Section -->
    <h5 class="mt-4 text-primary">🌟 Our Mission</h5>
    <ul>
      <li>Ensure timely availability of blood to those in need</li>
      <li>Maintain accurate records of donors and recipients</li>
      <li>Promote voluntary blood donation through technology</li>
    </ul>

    <!-- Vision Section -->
    <h5 class="mt-4 text-primary">📍 Our Vision</h5>
    <p>
      To build a nation-wide network of life-savers and make blood donation accessible, transparent, and trusted.
    </p>
  </div>
</div>

<!-- Footer Section -->
<footer class="text-center py-3">
  &copy; <?php echo date("Y"); ?> BBMS | Blood Bank & Donor Management System
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
