<?php
session_start();
include 'config.php';

$is_logged_in = isset($_SESSION['email']);

$testimony = [];
$sql_testimony = "SELECT name, testimony, created_at FROM testimony ORDER BY created_at DESC LIMIT 5";
$result_testimony = $conn->query($sql_testimony);

if ($result_testimony && $result_testimony->num_rows > 0) {
  while ($row = $result_testimony->fetch_assoc()) {
    $testimony[] = $row;
  }
}

$message = '';
$message_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'] ?? 'info';
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
  <!--Navbar -->
  <nav class ="navbar">
    <a href="#" class ="navbar-logo">SEA<span>-Catering</span>.</a>

    <div class="navbar-nav">
      <a href="#home">Home</a>
      <a href="#our-menu">Menu</a>
      <a href="subscription.php">Subscription</a>
      <a href="#contact">Contact Us</a>
    </div>

    <div class="navbar-extra">
      <a href="auth_redirect.php" id="dashboard"><i data-feather="user"></i>></i></a>
      <a href="#" id="menu"><i data-feather="menu"></i>></i></a>
  </nav>

  <!--Hero Section -->
  <section class="hero" id="home">
    <main class="content">
      <h1>Healthy Meal,<br><span>Anytime,Anywhere</span></h1>
      <p>Customize your meals with ease and get them delivered across Indonesia</p>
      <a href="subscription.html" class="cta">Subscribe Now!</a>
    </main>
  </section>
  
  <!--Service List-->
  <section class="service-list" id="service">
    <main class="content">
      <h2> Our <span>Service List </span></h2>
      <div class="video">
        <div class="video-card">
          <video src = "vid/meal-customization-video.mp4" autoplay muted loop style="max-width: 390px;"></video>
          <h3>Meal Customization</h3>
          <p>Customize your own healthy meals</p>
        </div>
        <div class="video-card">
          <video src = "vid/detailed-nutritional-information.mp4" autoplay muted loop style="max-width: 390px;"></video>
          <h3>Detailed Nutritional Information</h3>
          <p>Every meal curated by professional nutritionists</p>
        </div>
        <div class="video-card">
          <video src = "vid/delivery-to-major-cities.mp4" autoplay muted loop style="max-width: 390px;"></video>
          <h3>Delivery to Major Cities</h3>
          <p>Get meals delivered hot and fast to your door</p>
        </div>
      </div>
    </main>
  </section>

  <!--Menu List-->
  <section class="our-menu" id="our-menu">
    <main class="content">
      <h1>Checkout <span> Our Menu</span></h1>
      <div class="menu-list">
        <div class="menu-items">
          <img src="img/protein-plan.jpg" alt="diet-plan" style="max-width:350px">
          <div class="menu-text">
          <h3>Protein Plan</h3>
          <p>The Protein Plan fuels your body with high-protein meals perfect for active lifestyles and muscle growth. Carefully crafted with lean meats, plant-based proteins, and balanced carbs. Great for fitness enthusiasts and anyone looking to stay energized throughout the day.</p>
          <button type="submit" class="see-details" data-popup="pop-up-protein" onclick="openPopup('pop-up-protein')">See Details</button>
          </div>
        </div>
        <div class="menu-items">
          <img src="img/diet-plan.jpg" alt="diet-plan" style="max-width:350px">
          <div class="menu-text">
            <h3>Diet Plan</h3>
            <p>Our Diet Plan is specially designed for those aiming to lose or maintain weight without sacrificing flavor. Each meal is portion-controlled and calorie-conscious, using fresh and nutritious ingredients. Ideal for anyone who wants to eat clean and feel lighter every day</p>
            <button type="submit" class="see-details" data-popup="pop-up-diet" onclick="openPopup('pop-up-diet')">See Details</button>
          </div>
        </div>
        <div class="menu-items">
          <img src="img/royal-plan.jpg" alt="diet-plan" style="max-width:350px">
          <div class="menu-text">
            <h3>Royal Plan</h3>
            <p>The Royal Plan offers a premium dining experience with gourmet healthy meals delivered to your door. It combines luxury ingredients, rich flavors, and optimal nutrition in every bite. Perfect for those who want the best of both health and indulgence.</p>
            <button type="submit" class="see-details" data-popup="pop-up-royal" onclick="openPopup('pop-up-royal')">See Details</button>
          </div>
      </div>
      <div class="pop-up" id="pop-up-protein">
        <div class="pop-up-container">
          <button type="button" class="close-popup" onclick="closePopup()">&times;</button>
          <img src="img/protein-plan.jpg">
          <h3>Protein Plan</h3>
          <p class="product-desc">The Protein Plan fuels your body with high-protein meals perfect for active lifestyles and muscle growth. Carefully crafted with lean meats, plant-based proteins, and balanced carbs. Great for fitness enthusiasts and anyone looking to stay energized throughout the day.</p>
          <p class="product-content"> Calories: approx. 550–650 kcal<br>Protein: 35–50g per serving<br>Rp 40.000,00</p>
          <a href="subscription.php" class="pop-up-btn">Subscribe Now!</a>
        </div>
      </div>
      <div class="pop-up" id="pop-up-diet">
        <div class="pop-up-container">
          <button type="button" class="close-popup" onclick="closePopup()">&times;</button>
          <img src="img/diet-plan.jpg">
          <h3>Diet Plan</h3>
          <p class="product-desc">Our Diet Plan is specially designed for those aiming to lose or maintain weight without sacrificing flavor. Each meal is portion-controlled and calorie-conscious, using fresh and nutritious ingredients. Ideal for anyone who wants to eat clean and feel lighter every day.</p>
          <p class="product-content">Calories: approx. 400–500 kcal <br>High fiber, low sugar & fat <br> Rp 30.000,00</p>
          <a href="subscription.php" class="pop-up-btn">Subscribe Now!</a>
        </div>
      </div>
      <div class="pop-up" id="pop-up-royal">
        <div class="pop-up-container">
          <button type="button" class="close-popup" onclick="closePopup()">&times;</button>
          <img src="img/royal-plan.jpg">
          <h3>Royal Plan</h3>
          <p class="product-desc">The Royal Plan offers a premium dining experience with gourmet healthy meals delivered to your door. It combines luxury ingredients, rich flavors, and optimal nutrition in every bite. Perfect for those who want the best of both health and indulgence.</p>
          <p class="product-content"> Calories: approx. 550–650 kcal<br>Protein: 35–50g per serving<br>Rp 60.000,00</p>
          <a href="subscription.php" class="pop-up-btn">Subscribe Now!</a>
        </div>
      </div>
    </main>
  </section>

  <!--About us section-->
  <section class="about-us" id="about-us">
    <h1>About <span>Us</span></h1>
    <div class="about-us-image">
      <img src="img/about-us-image.jpg">
    </div>
    <p>SEA-Catering (Software Engineering Academy Catering) is an innovative food-tech business that provides customizable healthy meals delivered right to your doorstep,available across cities in Indonesia. Founded by a passionate group of Computer Science students from Indonesia University, also known as the “Pacilian”. SEA-Catering was born from a deep concern over how difficult it is to maintain a healthy diet amidst academic deadlines, work pressure, and a fast-paced lifestyle. From the beginning, SEA-Catering was designed not only as a food delivery service but as a smart platform to help people take control of their diet with flexibility and confidence. Whether you're aiming to build muscle, lose weight, maintain a balanced lifestyle, or enjoy gourmet health dishes, SEA-Catering has something for you. Our three signature plans: Protein Plan, Diet Plan, and Royal Plan, reflect the diverse goals and preferences of our customers. All meals are prepared by certified chefs in collaboration with licensed nutritionists to ensure that every dish is not only delicious but also supports your health goals. With videos showcasing our customization process, nutritional curation, and real-time delivery to major Indonesian cities, SEA-Catering is more than a service—it’s a lifestyle movement.  </p>
  </section>

  <!--Contact us section-->
  <section class="contact" id="contact">
    <h1>Our <span>Contact</span></h1>
    <p>Find Us:</p>
    <div class="row">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.1833125358494!2d106.82447917400924!3d-6.370318362313187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec1ad14fb6cf%3A0xc94e4d829420fa15!2sFakultas%20Ilmu%20Komputer%20(Fasilkom)%20UI!5e0!3m2!1sid!2sid!4v1749869225016!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
      <div class="contact-details">
        <h3>Manager:</h3>
        <p>Brian<br>
        +628123456789</p>
        <button class="btn" type="submit" href="#contact">Message Now!</button>

        </div>
    </div>

   <!--Testimoni-->
   <section class="testimoni" id="testimoni">
    <h1>Leave <span>Your Testimony!</span></h1> 

    <?php if ($message): ?>
        <div class="alert alert-<?= htmlspecialchars($message_type); ?>">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
      
    <form action="submit_testimony.php" method="POST">
      <div class="user-testi">
        <div class="testi-form1">
          <span class="details">Your Name</span>
          <input type="text" name="name">
        </div>
        <div class="testi-form2">
          <span class="details">Testimony</span>
          <textarea type="text" name="testimony"></textarea>
        </div>
      </div>
        <button type="submit" class="submit">Submit</button>
    </form>

    <div class="testimoni-list">
      <?php if (!empty($testimony)): ?>
        <?php foreach ($testimony as $testi): ?>
          <div class="testi-card">
            <h4><?= htmlspecialchars($testi['name']); ?></h4>
            <p>"<?= htmlspecialchars($testi['testimony']); ?>"</p>
            <p class="testi-date"><?= htmlspecialchars(date('d M Y, H:i', strtotime($testi['created_at']))); ?></p>
          </div>
        <?php endforeach; ?>
       <?php else: ?>
        <p>There is no testimony yet</p>
      <?php endif; ?>
    </div>
  </section>

  <!--icons-->
  <script>
   feather.replace();
  </script>
</body>

<!--JavaScript-->
<script src ="js/script.js"></script>


</html>
