<?php
session_start();
include('includes/dbconfig.php');

$userData = ['username' => 'Guest'];

if (isset($_SESSION['user'])) {
  $username = $_SESSION['user'];
  $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BBMS - Home</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .carousel-item {
      height: 80vh;
      background-size: cover;
      background-position: center;
    }
    .carousel-caption {
      background-color: rgba(255, 255, 255, 0.85);
      padding: 30px;
      border-radius: 15px;
      color: #000;
    }
    .carousel-caption h1 {
      font-weight: bold;
      color: #b30000;
    }
    .carousel-caption p {
      color: #222;
      font-size: 1.2rem;
    }
    .highlight {
      color: #b30000;
    }
    .cta-buttons a {
      font-size: 1.1rem;
    }
    .announcement {
      background: #f8d7da;
      color: #721c24;
      font-weight: 500;
      text-align: center;
      padding: 15px;
    }
  </style>
</head>
<body>
  <div class="top-bar bg-primary text-white py-1 px-3 d-flex justify-content-between">
    <div>📧 BBMS25@gmail.com  | 📞 +01-567547</div>
    <div>
      <a href="#" class="text-white px-2"><i class="bi bi-facebook"></i></a>
      <a href="#" class="text-white px-2"><i class="bi bi-twitter-x"></i></a>
      <a href="#" class="text-white px-2"><i class="bi bi-instagram"></i></a>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-danger" href="index.php">BB<span class="text-white">DMS</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="about.php"><i class="bi bi-info-circle"></i> About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php"><i class="bi bi-envelope"></i> Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= isset($_SESSION['user']) ? 'donor/register.php' : 'login.php'; ?>"><i class="bi bi-person-plus"></i> Register Donor</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= isset($_SESSION['user']) ? 'search.php' : 'login.php'; ?>"><i class="bi bi-search"></i> Search Donor</a></li>
          <li class="nav-item"><a class="nav-link" href="events.php"><i class="bi bi-calendar-event"></i> Events</a></li>
          <li class="nav-item"><a class="nav-link fw-bold text-warning" href="<?= isset($_SESSION['user']) ? 'blood_request.php' : 'login.php'; ?>"><i class="bi bi-exclamation-circle"></i> Blood Request</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person"></i></a>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php if (isset($_SESSION['admin'])): ?>
                <li><a class="dropdown-item" href="admin/dashboard.php">Admin Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              <?php elseif (isset($_SESSION['user'])): ?>
                <li><a class="dropdown-item" href="donor/dashboard.php">User Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="login.php">Login</a></li>
              <?php endif; ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" style="background-image: url('images/image3.jpg');">
        <div class="carousel-caption text-center">
          <h1>Blood bank services you <span class="highlight">can trust</span></h1>
          <?php if (isset($_SESSION['user'])): ?>
            <p class="mt-2">Welcome, <strong><?= htmlspecialchars($userData['username']) ?></strong> ❤️</p>
          <?php elseif (isset($_SESSION['admin'])): ?>
            <p class="mt-2">Welcome back, <strong>Admin</strong> 🛠️</p>
          <?php endif; ?>
          <div class="cta-buttons d-flex justify-content-center gap-3 mt-3">
            <a href="<?= isset($_SESSION['user']) ? 'donor/register.php' : 'login.php'; ?>" class="btn btn-danger btn-lg"><i class="bi bi-plus-circle"></i> Register</a>
            <a href="<?= isset($_SESSION['user']) ? 'search.php' : 'login.php'; ?>" class="btn btn-outline-dark btn-lg"><i class="bi bi-search"></i> Search</a>
            <a href="events.php" class="btn btn-primary btn-lg"><i class="bi bi-calendar-event"></i> Events</a>
          </div>
        </div>
      </div>
      <div class="carousel-item" style="background-image: url('images/image4.png');">
        <div class="carousel-caption text-center">
          <h1>Your blood can save <span class="highlight">lives</span></h1>
          <div class="cta-buttons mt-3">
            <a href="events.php" class="btn btn-outline-danger btn-lg"><i class="bi bi-bandaid"></i> Apply for Blood Camp</a>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="announcement">
    📢 Blood Donation Camp every Sunday at City Hospital! Join and Save Lives ❤️
  </div>

  <footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; <?= date("Y"); ?> BBMS | Blood Bank & Donor Management System
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
