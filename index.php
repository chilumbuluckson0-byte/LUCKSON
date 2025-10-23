<?php
// index.php - only minimal PHP added: current page detection and dynamic year
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>RedWheel Rentals</title>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* ===== Reset & Global Styles ===== */
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body {
      background: #f9f9f9;
      color: #333;
      line-height: 1.6;
    }
    header {
      background: #222;
      color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header .logo {
      font-size: 1.5em;
      font-weight: bold;
      color: #ff3b3b;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    nav a {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s;
    }
    nav a:hover, nav .active {
      color: #ff3b3b;
    }

    /* ===== Hero Section ===== */
    .hero {
      color: white;
      text-align: center;
      padding: 100px 20px;
    }
    .hero h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
      text-shadow: 2px 2px 5px black;
    }
    .hero p {
      font-size: 1.2em;
    }

    /* ===== Cars Section ===== */
    .car-section {
      padding: 50px 20px;
      text-align: center;
    }
    .car-section h2 {
      margin-bottom: 30px;
      font-size: 2em;
      color: #222;
    }
    .car-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .car-card {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .car-card:hover {
      transform: translateY(-5px);
    }
    .car-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .car-card h3 {
      margin-bottom: 5px;
      color: #444;
    }
    .car-card button {
      background: #ff3b3b;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
      transition: background 0.3s;
    }
    .car-card button:hover {
      background: #cc2f2f;
    }

    /* ===== Special Offers ===== */
    .special-offer {
      background: #fff3f3;
      padding: 50px 20px;
      text-align: center;
    }
    .special-offer h2 {
      margin-bottom: 20px;
      font-size: 2em;
      color: #cc2f2f;
    }
    .special-offer img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    .thumbnail-gallery {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .thumbnail-gallery img {
      width: 100px;
      height: 70px;
      object-fit: cover;
      border-radius: 5px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .thumbnail-gallery img:hover {
      transform: scale(1.1);
    }

    /* ===== Services Section ===== */
    .services {
      background: #fefefe;
      padding: 60px 20px;
      text-align: center;
    }
    .services h2 {
      font-size: 2em;
      margin-bottom: 20px;
      color: #222;
    }
    .services p {
      font-size: 1.1em;
      margin-bottom: 30px;
      color: #555;
    }
    .service-highlights {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .service-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .service-card h3 {
      margin-bottom: 10px;
      color: #ff3b3b;
    }

    /* ===== Reviews Section ===== */
    .reviews {
      padding: 50px 20px;
      background: #f0f0f0;
    }
    .reviews h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 2em;
      color: #222;
    }
    .review-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .review-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .review-card p {
      font-style: italic;
      margin-bottom: 10px;
    }
    .review-card strong {
      color: #ff3b3b;
    }

    /* ===== Employees Section ===== */
    .employees {
      padding: 50px 20px;
      text-align: center;
    }
    .employees h2 {
      margin-bottom: 30px;
      font-size: 2em;
    }
    .employee-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .employee-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 220px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .employee-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .employee-card h3 {
      color: #444;
    }
    .employee-card p {
      font-size: 0.9em;
      color: #666;
    }

    /* ===== Footer ===== */
    footer {
      background: #222;
      color: #fff;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
    }
  </style>

</head>
<body>
  <header>
    <div class="logo">RedWheel Rentals</div>
    <nav>
      <ul>
        <li><a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="about.php" class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">About</a></li>
        <li><a href="cars.php" class="<?= $currentPage === 'cars.php' ? 'active' : '' ?>">Cars</a></li>
        <li><a href="services.html" class="<?= $currentPage === 'services.html' ? 'active' : '' ?>">Services</a></li>
        <li><a href="contact.html" class="<?= $currentPage === 'contact.html' ? 'active' : '' ?>">Contact</a></li>
        <li><a href="dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">profile</a></li>
        <li><a href="bookings.php" class="<?= $currentPage === 'bookings.php' ? 'active' : '' ?>">Booking</a></li>
        <li><a href="signup.php" class="<?= $currentPage === 'signup.php' ? 'active' : '' ?>">Sign Up</a></li>
        <li><a href="login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- ===== Hero ===== -->
  <section class="hero">
    <h1>Drive Your Dreams with RedWheel Rentals</h1>
    <p>✨ Comfort. Style. Reliability. All in one ride. ✨</p>
  </section>

 <!-- ===== Cars ===== -->
<section class="car-section">
  <h2>Available Cars</h2>
  <div class="car-list">

    <div class="car-card">
      <img src="image/toyota corola.jpg" alt="Toyota Corolla">
      <h3>Toyota Corolla</h3>
      <p>$50/day</p>
      <a href="bookings.php?car=Toyota%20Corolla" class="book-link">
        <button>Book Now</button>
      </a>
    </div>

    <div class="car-card">
      <img src="image/honda civc.jpg" alt="Honda Civic">
      <h3>Honda Civic</h3>
      <p>$60/day</p>
      <a href="bookings.php?car=Honda%20Civic" class="book-link">
        <button>Book Now</button>
      </a>
    </div>

    <div class="car-card">
      <img src="image/x5.jpg" alt="BMW X5">
      <h3>BMW X5</h3>
      <p>$120/day</p>
      <a href="bookings.php?car=BMW%20X5" class="book-link">
        <button>Book Now</button>
      </a>
    </div>

  </div>
</section>

  <!-- ===== Special Offer ===== -->
  <section class="special-offer">
    <h2>🔥 Limited Time Special Offer</h2>
    <img id="mainImage" src="image/1755070977674.jpg" alt="Special Car">
    <div class="thumbnail-gallery">
      <img src="image/1755070981010.jpg" onclick="changeImage(this)">
      <img src="image/1755070996213.jpg" onclick="changeImage(this)">
      <img src="image/1755071003275.jpg" onclick="changeImage(this)">
    </div>
    <p>🚗 Book now and enjoy up to <strong>20% OFF</strong> on selected cars!</p>
    <button class="car-card button">Book Special Offer</button>
  </section>

  <!-- ===== Services ===== -->
  <section class="services">
    <h2>🚖 More Than Just Rentals</h2>
    <p>RedWheel Rentals is here for every occasion – making every ride special.</p>
    <div class="service-highlights">
      <div class="service-card">
        <h3>💍 Weddings</h3>
        <p>Arrive in elegance and style on your big day. Let us make it unforgettable.</p>
      </div>
      <div class="service-card">
        <h3>✈️ Airport Pickups</h3>
        <p>Start your journey stress-free with our reliable airport transfers.</p>
      </div>
      <div class="service-card">
        <h3>🏢 Corporate & Events</h3>
        <p>Professional rides tailored for business meetings, conferences, and VIP guests.</p>
      </div>
      <div class="service-card">
        <h3>🎉 Parties & More</h3>
        <p>From birthdays to special occasions – we’ve got the perfect ride for you.</p>
      </div>
    </div>
  </section>

  <!-- ===== Reviews ===== -->
  <section class="reviews">
    <h2>What Our Happy Customers Say</h2>
    <div class="review-list">
      <div class="review-card">
        <p>"Excellent service, the car was clean and comfortable!"</p>
        <strong>- John D.</strong>
      </div>
      <div class="review-card">
        <p>"Affordable rates and friendly staff, highly recommend."</p>
        <strong>- Sarah M.</strong>
      </div>
      <div class="review-card">
        <p>"Booking was easy and the BMW X5 was amazing!"</p>
        <strong>- Peter K.</strong>
      </div>
    </div>
  </section>

  <!-- ===== Employees ===== -->
  <section class="employees">
    <h2>Meet Our Stars</h2>
    <div class="employee-list">
      <div class="employee-card">
        <img src="image/luck.jpg" alt="Driver of the Month">
        <h3>Luckson Chilumbu</h3>
        <p>🏆 Driver of the Month</p>
      </div>
      <div class="employee-card">
        <img src="image/twaambo.jpg" alt="Employee of the Month">
        <h3>Tessy Hums</h3>
        <p>🌟 Employee of the Month</p>
      </div>
    </div>
  </section>

  <!-- ===== Footer ===== -->
  <footer>
    <p>&copy; <?= date('Y') ?> RedWheel Rentals. All rights reserved. 🚗💨</p>
    <p>✨ "Your journey, our wheels." ✨</p>
  </footer>

  <!-- JS for gallery -->
  <script>
    function changeImage(imgElement) {
      document.getElementById("mainImage").src = imgElement.src;
    }
  </script>
</body>
</html>
