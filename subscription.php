<?php
require 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
	header("Location: login.php");
	exit();
}
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
	$_SESSION['message'] = "You don't allowed to access this page.";
	$_SESSION['message_type'] = "error";
	header ("Location: admin_page.php");
	exit ();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_SESSION['email'];
    $full_name = $_POST['full_name'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $allergies = $_POST['allergies'] ?? '';
	$delivery_days_str = isset($_POST['delivery_days']) ? implode(', ',$_POST['delivery_days']) : '';
    $meal_plan = $_POST['meal_plan'] ?? '';
    $meal_type_str = isset($_POST['meal_type']) ? implode(', ',$_POST['meal_type']) : '';
    $gender = $_POST['gender'] ?? '';
	$total_price = $_POST['total_price'] ?? 0;

	$stmt = $conn->prepare("INSERT INTO subscription (full_name, email, phone_number, `address`, allergies, delivery_days, meal_plan, meal_type, gender, total_price, `status`, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())");
	
	$stmt->bind_param("sssssssssi", 
    $full_name, $email, $phone_number, $address, $allergies,
    $delivery_days_str, $meal_plan, $meal_type_str,
    $gender, $total_price );

	if ($stmt->execute()) {
		echo "successed";
	} else {
		echo "failed" . $stmt->error;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Subscription</title>

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />

    <!--icons-->
    <script src="https://unpkg.com/feather-icons"></script>

    <!--my style-->
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>
    <!--Navbar -->
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

  <section class="subscription" id="subscription">
		<div class="form-wrapper">
			<h2 class="subscribe">Subscribe<span> Now!</span></h2>
			<form action="subscription.php" method="POST">
				<div class="user-details">
					<div class="input-box">
						<span class="details">Full Name</span>
						<input type="text" name="full_name" required>
					</div>
					<div class="input-box">
						<span class="details">Active Phone Number</span>
						<input type="num" name="phone_number" required>
					</div>
					<div class="input-box">
						<span class="details">Address</span>
						<input type="text" name="address" required>
					</div>
					<div class="input-box">
						<span class="details">Allergies</span>
						<input type="text" name="allergies" required>
					</div>
					<div class="input-box">
						<span class="details" Required>Delivery Days</span>
						<label><input type="checkbox" name="delivery_days[]" value="Monday">Monday</label><br>
						<label><input type="checkbox" name="delivery_days[]" value="Tuesday">Tuesday</label><br>
						<label><input type="checkbox" name="delivery_days[]" value="Wednesday">Wednesday</label><br>
						<label><input type="checkbox" name="delivery_days[]" value="Thursday">Thursday</label><br>
						<label><input type="checkbox" name="delivery_days[]" value="Friday">Friday</label><br>
						<label><input type="checkbox" name="delivery_days[]" value="Saturday">Saturday</label><br>
						<label><input type="checkbox" name="delivery_days[]" value="Sunday">Sunday	</label><br>
					</div>
					<div class="input-box">
						<span class="details" Required>Meal Plan</span>
						<label><input type="radio" name="meal_plan" value="Protein Plan ">Protein Plan (Rp 40.000)</label><br>
						<label><input type="radio" name="meal_plan" value="Diet Plan">Diet Plan (Rp. 30.000)</label><br>
						<label><input type="radio" name="meal_plan" value="Royal Plan">Royal Plan (Rp 60.000)</label><br>
						<span class="details">Meal Type</span>
						<label><input type="checkbox" name="meal_type[]" value="breakfast">Breakfast</label><br>
						<label><input type="checkbox" name="meal_type[]" value="lunch">Lunch</label><br>
						<label><input type="checkbox" name="meal_type[]" value="dinner">Dinner</label><br>
					</div>
					<div class="input-box full-width">
						<span class="details" Required>Gender</span>
						<label><input type="radio" name="gender" value="Male">Male</label><br>
						<label><input type="radio" name="gender" value="Female">Female</label><br>
					</div>
					<div class="input-box">
						<span class="details">Total Price (Rp)</span>
						<input type="text" id="total_price_display" disabled>
						<input type="hidden" id="total_price" name="total_price" >
					</div>

				</div>
					<button type="submit" class="cta">Subscribe</button>
			</form>
  </section>


	<script>
   feather.replace();
  </script>

</body> 

<!--JavaScript-->
<script src ="js/script.js"></script>

</html>