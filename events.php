<?php
session_start(); // Start session to access user data if needed
include('includes/dbconfig.php'); // Include database connection

// Hardcoded array of upcoming events
$events = [
  [
    'title' => 'चौथो वार्षिकोत्सवको अवसरमा - बृहत रक्तदान कार्यक्रम',
    'date' => '2082-02-24',
    'time' => '7:00 AM',
    'location' => 'तिलाठी कोईलाडी वडा - १, तिलाठी, सप्तरी',
    'description' => 'सहभागी भई रक्तदान गरिदिनुहुन सम्पूर्ण महानुभावहरूमा हार्दिक अनुरोध गरिन्छ।',
    'image' => 'images/image1.jpg'
  ],
  [
    'title' => 'Blood Donation and Group Check-up Program',
    'date' => '2082-02-22',
    'time' => '1:00 PM',
    'location' => 'Shree Guhyeshwory Secondary School, Sinamangal',
    'description' => 'Join us for a lifesaving blood donation and group check-up camp organized by Blood for Nepal.',
    'image' => 'images/image2.jpg'
  ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Events - BBMS</title>
  <!-- Bootstrap CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, rgb(228, 165, 190), rgb(149, 172, 206)); /* Background gradient */
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 15px;
      transition: transform 0.3s ease; /* Animation on hover */
    }
    .card:hover {
      transform: translateY(-5px); /* Hover effect */
    }
    .event-img {
      width: 100%;
      max-height: 180px;
      object-fit: contain; /* Resize image while keeping aspect ratio */
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }
  </style>
</head>
<body>

<!-- Main Container -->
<div class="container mt-5">
  <h2 class="text-center text-danger mb-4">📅 Upcoming Blood Donation Events</h2>

  <!-- Events Grid -->
  <div class="row">
    <?php foreach ($events as $event): ?>
      <div class="col-md-6 mb-4">
        <div class="card shadow">
          <!-- Display event image if available -->
          <?php if (!empty($event['image'])): ?>
            <img src="<?= $event['image'] ?>" alt="Event Image" class="event-img">
          <?php endif; ?>

          <div class="card-body">
            <h4 class="card-title text-danger">
              <i class="bi bi-calendar-event"></i> <?= htmlspecialchars($event['title']) ?>
            </h4>
            <p class="mb-1"><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
            <p class="mb-1"><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
            <p class="mb-1"><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
            <p class="mt-2"><?= nl2br(htmlspecialchars($event['description'])) ?></p>

            <!-- Apply Now Button linked to registration page -->
            <a href="events/register_event.php?event=<?= urlencode($event['title']) ?>" class="btn btn-danger mt-3">
              Apply Now
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Back to Home Button -->
  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-dark">⬅️ Back to Home</a>
  </div>
</div>

<!-- Bootstrap JS for functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
