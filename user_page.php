<?php

session_start();
include 'config.php';


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];

$query = "SELECT * FROM subscription WHERE email = ? ORDER BY CASE
  WHEN status = 'active' THEN 1
  WHEN status = 'paused' THEN 2
  WHEN status = 'cancelled' THEN 3
  ELSE 4
  END,
  created_at DESC LIMIT 1";
$stmt_subscription = $conn->prepare($query);
if ($stmt_subscription === false) {
    echo "\n";
    die("Error preparing statement: " . $conn->error);
}
$stmt_subscription->bind_param("s", $email);
$stmt_subscription->execute();
$result = $stmt_subscription->get_result();

$subscription = null;
if ($result && $result->num_rows > 0) {
    $subscription = $result->fetch_assoc();
}
$stmt_subscription->close();
if (isset($_SESSION['message'])) {
   $message_type = $_SESSION['message_type'] ?? 'info';
   echo '<div class="alert alert-' . $message_type . '">';
   echo htmlspecialchars($_SESSION['message']);
   echo '</div>';
   unset($_SESSION['message']);
   unset($_SESSION['message_type']);
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
      <a href="index.php#contact">Contact Us</a>
      <a href="subscription.php">Subscription</a>
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
          <?php if ($subscription['status'] === 'cancelled'): ?>
            <p> You have no active subscription yet </p>
            <?php else: ?> 
            <p> Viewing Your Subscription: </p> 
            <h2><?= htmlspecialchars($subscription['meal_plan']) ?></h2>
            <div class=subscription-line><h3><strong>Meal Types: </strong></h3> <p><?=htmlspecialchars($subscription['meal_type']) ?></p></div>
            <div class=subscription-line><h3><strong>Delivery Days: </strong></h3> <p><?=htmlspecialchars($subscription['delivery_days']) ?></p></div> 
            <div class=subscription-line><h3><strong>Total Price (/day):</strong></h3><p> Rp <?=htmlspecialchars($subscription['total_price']) ?></p></div> 
            <div class=subscription-line><h3><strong>Status: </strong></h3> <p> <span class="active-status"><?=htmlspecialchars($subscription['status']) ?></span></p></div>
            
            <?php if ($subscription['status'] === 'paused'): ?>
              <div class=subscription-line><h3><strong>Pause Start: </strong></h3> <p><?=htmlspecialchars($subscription['pause_start_date']) ?></p></div>
              <div class=subscription-line><h3><strong>Pause End: </strong></h3> <p><?=htmlspecialchars($subscription['pause_end_date']) ?></p></div>
              <form action="resume_subscription.php" method="POST">
                <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                <button type="submit" class="resume-btn cta">Resume Subscription</button>
              </form>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <?php if ($subscription['status'] === 'active'): ?>  
          <div class="pause-box">
            <form action="pause_subscription.php" method="POST">
              <h3><strong>Pause Subscription: </strong></h3>
              <div class= "date">
              <p>Select the date that you want to start your pause:</p>
              <input type="date" name="pause_start" required>
              <p>Select the date that you want to end your pause:</p>
              <input type="date" name="pause_end" required>
              <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>" >
              <button type="submit" class="pause-btn">Pause</button>
              </div>          
            </form>
          </div> 
          <div class="cancel-box">
            <form action="cancel_subscription.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel your subscription permanently');">
              <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
              <button type="submit" class="cancel-btn">Cancel Subscription</button>
            </form> 
          </div>
        <?php elseif ($subscription['status'] === 'paused'): ?>
          <div class="cancel-box">
            <form action="cancel_subscription.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel your paused subscription permanently?');">
              <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
              <button type="submit" class="cancel-btn">Cancel Subscription</button>
            </form>
          </div>
        <?php endif; ?>

      <?php else: ?>
        <div class="subscription-box">
          <p>You have no active subscription yet. <br> Please go to the <a href="subscription.php">Subscription</a> page to start one!</p>
        </div>
      <?php endif; ?>
    </div>

  <!--icons-->
  <script>
   feather.replace();
  </script>
</body>

<!--JavaScript-->
<script src ="js/script.js"></script>

</html>