<?php

session_start();
include 'config.php';


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];

$query = "SELECT * FROM subscription WHERE email = '$email' AND status = 'active' LIMIT 1 ";
$result = mysqli_query ($conn, $query);

$subscription = null;
if ($result && mysqli_num_rows($result) > 0) {
    $subscription = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet" />

    <!--icons-->
    <script src="https://unpkg.com/feather-icons"></script>

    <!--my style-->
    <link rel="stylesheet" href="CSS/style.css" />
</head>
<body class="user_page">
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
        <p>This is an <span>User Page </span> </p>
    </div>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    <div class="row">
      <?php if ($subscription): ?>
      <div class="subscription-box">
        <p>Viewing Your Subscription: </p>  
        <h2><?=htmlspecialchars($subscription['meal_plan']) ?></h2>
        <h3><strong>Meal Types: </strong> <?=htmlspecialchars($subscription['meal_type']) ?></h3>
        <h3><strong>Delivery Days: </strong> <?=htmlspecialchars($subscription['delivery_days']) ?></h3> 
        <h3><strong>Total Price (/day): Rp</strong> <?=htmlspecialchars($subscription['total_price']) ?></h3> 
        <h3><strong>Status: </strong> <span class="active-status"><?=htmlspecialchars($subscription['status']) ?></span></h3>
        <?php else: ?>
          <p>You have no active subscription yet</p>
        <?php endif; ?>
      </div>
      <div class="pause-box">
        <form action="pause_subscription.php" method="POST">
          <h3><strong>Pause Subscription: </strong></h3><br><br>
          <input type="date" name="pause_start" required>
          <input type="date" name="pause_end" required>
          <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>" >
          <button type="submit" class="pause-btn">Pause</button>
          <br><br>
          
        </form>
      </div>
      <div class="cancel-box">
        <form action="cancel_subscription.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel your subscription permanently');">
          <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
          <button type="submit" class="cancel-btn">Cancel Subscription</button>
        </form> 
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