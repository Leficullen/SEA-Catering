<?php

session_start();
include 'config.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

function executeQuery($conn, $sql, $params = [], $types = '') {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Failed to prepare statement: " . $conn->error);
        return false;
    }
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

$new_subscriptions_sql = "SELECT COUNT(*) AS total_new_subscriptions FROM subscription WHERE created_at BETWEEN ? AND ?";
$new_subscriptions_result = executeQuery($conn, $new_subscriptions_sql, [$start_date . ' 00:00:00', $end_date . ' 23:59:59'], 'ss');
$new_subscriptions = $new_subscriptions_result ? $new_subscriptions_result->fetch_assoc()['total_new_subscriptions'] : 0;

$mrr_sql = "SELECT SUM(total_price) AS total_mrr FROM subscription WHERE status = 'active' AND created_at BETWEEN ? AND ?";
$mrr_result = executeQuery($conn, $mrr_sql, [$start_date . ' 00:00:00', $end_date . ' 23:59:59'], 'ss');
$mrr = $mrr_result ? $mrr_result->fetch_assoc()['total_mrr'] : 0;

$reactivations_sql = "SELECT COUNT(*) AS total_reactivations FROM subscription WHERE status = 'reactivated' AND created_at BETWEEN ? AND ?";
$reactivations_result = executeQuery($conn, $reactivations_sql, [$start_date . ' 00:00:00', $end_date . ' 23:59:59'], 'ss');
$reactivations = $reactivations_result ? $reactivations_result->fetch_assoc()['total_reactivations'] : 0;

$subscription_growth_sql = "SELECT COUNT(*) AS total_active_subscriptions FROM subscription WHERE status = 'active'";
$subscription_growth_result = executeQuery($conn, $subscription_growth_sql);
$subscription_growth = $subscription_growth_result ? $subscription_growth_result->fetch_assoc()['total_active_subscriptions'] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>SEA Catering</title>

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet" />

    <!--icons-->
    <script src="https://unpkg.com/feather-icons"></script>

    <!--my style-->
    <link rel="stylesheet" href="CSS/style.css" />
    
    <!--Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
</head>
<body class="admin_page">
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
        <p>This is an <span>Admin Page </span> </p>
    </div>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

    <div class="row">
      <form action="admin_page.php" method="GET" class="date-form">
        <p>Start Date:</p>
        <input type="date" name="start_date" value= "<?= htmlspecialchars($start_date); ?>">
        <p>End Date:</p>
        <input type="date" name="end_date" value= "<?= htmlspecialchars($end_date); ?>">
        <button type="submit" class="filter-btn" > Apply Filter <i data feather ="filter"></i></button>
      </form> 

      <div class="dashboard-grid">
        <div class="card"> 
          <h3>New Subscriptions</h3>
          <p><?= htmlspecialchars($new_subscriptions); ?></p>
        </div>
        <div class="card"> 
          <h3>Monthly Recurring Revenue (MRR)</h3>
          <p>Rp <?= number_format($mrr, 0, ',', '.'); ?></p>
        </div>
        <div class="card"> 
          <h3>Reactivations</h3>
          <p><?= htmlspecialchars($reactivations); ?></p>
        </div>
        <div class="card"> 
          <h3>Subscription Growth</h3>
          <p><?= htmlspecialchars($subscription_growth); ?></p>
        </div>
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