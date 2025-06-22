<?php

session_start();
include 'config.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet" />

    <!--icons-->
    <script src="https://unpkg.com/feather-icons"></script>

    <!--my style-->
    <link rel="stylesheet" href="CSS/style.css" />

</head>
<body class="admin_page">
  <nav class ="navbar">
    <a href="#" class ="navbar-logo">SEA<span>-Catering</span>.</a>

    <div class="navbar-nav">
      <a href="index.php">Home</a>
      <a href="index.php#our-menu">Menu</a>
      <a href="subscription.php">Subscription</a>
      <a href="index.php#contact">Contact Us</a>
    </div>

    <div class="navbar-extra">
      <a href="auth_redirect.php" id="dashboard"><i data-feather="user"></i>></i></a>
      <a href="#" id="menu"><i data-feather="menu"></i>></i></a>
  </nav>

    <div class="box">
        <h1>Welcome, <span><?= $_SESSION['name']; ?> </span></h1>
        <p>This is an <span>Admin Page </span> </p>
    </div>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

    <div class="row">
        <div class="date-form">
          <input type="date" name="filter_start" required>
          <input type="date" name="filter_end" required>
        </div>
        <button type="submit" class="filter-btn">Filter</button>
      </div>
    </div>

    <!--icons-->
  <script>
   feather.replace();
  </script>
</body>
<!--JavaScript-->
<script src ="js/script.js"></script>
</html>