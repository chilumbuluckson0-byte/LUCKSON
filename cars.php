<?php
session_start();
 

// Check if user is logged in
$isLoggedIn = isset($_SESSION['email']) && $_SESSION['role'] === 'user';
$userName = $isLoggedIn ? $_SESSION['first_name'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RedWheel Rental - Cars</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5f5f5;
      color: #333;
    }
    header {
      background: #222;
      color: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h1 {
      color: rgb(240, 20, 12);
    }
    nav a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
    }
    nav a.active {
      color:rgb(240, 20, 12);
      font-weight: bold;
    }
    main {
      padding: 2rem;
      text-align: center;
    }
    .car-list {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .car-card {
      background: white;
      border-radius: 12px;
      padding: 1rem;
      width: 250px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      transition: transform 0.2s;
    }
    .car-card:hover {
      transform: scale(1.05);
    }
    .car-card img {
      width: 100%;
      border-radius: 12px;
    }
    button {
      background:rgb(240, 20, 12);
      color: white;
      border: none;
      padding: 10px;
      margin-top: 10px;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background: #ff6600;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      overflow: auto;
    }
    .modal-content {
      background: #fff;
      margin: 5% auto;
      padding: 2rem;
      border-radius: 12px;
      width: 450px;
      text-align: left;
    }
    .close {
      float: right;
      font-size: 20px;
      cursor: pointer;
    }
    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    input, textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    footer {
      text-align: center;
      padding: 20px;
      background-color: #222;
      color: white;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <header>
    <h1>RedWheel Rental</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="cars.php" class="active">Cars</a>
      <a href="bookings.php">Booking</a>
      <a href="about.php">About</a>
      <a href="contact.html">Contact</a>
      <a href="services.html">Services</a>
      <?php if ($isLoggedIn): ?>
        <a href="dashboard.php">Welcome, <?php echo htmlspecialchars($first_name); ?></a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </nav>
    
<?php include 'auth_session.php'; ?>

  </header>

  <main>
    <h2>Choose Your Ride</h2>
    <div class="car-list">
      <div class="car-card">
        <img src="image/corolla1.jpg" alt="Sedan">
        <h3>Toyota Corolla</h3>
        <p>💰 $45/day</p>
        <button onclick="checkLogin('Toyota Corolla')">Book Now</button>
      </div>

      <div class="car-card">
        <img src="image/extrail1.jpg" alt="SUV">
        <h3>Nissan X-Trail</h3>
        <p>💰 $70/day</p>
        <button onclick="checkLogin('Nissan X-Trail')">Book Now</button>
      </div>

      <div class="car-card">
        <img src="image/c-class1.jpg" alt="Luxury Car">
        <h3>Mercedes C-Class</h3>
        <p>💰 $120/day</p>
        <button onclick="checkLogin('Mercedes C-Class')">Book Now</button>
      </div>

      <div class="car-card">
        <img src="image/vw1.jpg" alt="Hatchback">
        <h3>Volkswagen Golf</h3>
        <p>💰 $50/day</p>
        <button onclick="checkLogin('Volkswagen Golf')">Book Now</button>
      </div>

      <div class="car-card">
        <img src="image/hilux1.jpg" alt="Pickup">
        <h3>Toyota Hilux</h3>
        <p>💰 $80/day</p>
        <button onclick="checkLogin('Toyota Hilux')">Book Now</button>
      </div>

      <div class="car-card">
        <img src="image/pourch1.jpg" alt="Sports Car">
        <h3>Porsche 911</h3>
        <p>💰 $250/day</p>
        <button onclick="checkLogin('Porsche 911')">Book Now</button>
      </div>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 RedWheel Rental. All rights reserved.</p>
  </footer>

  <script>
    // JS check for login (uses PHP variable)
    const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

    function checkLogin(carName) {
      if (!isLoggedIn) {
        alert("⚠️ Please log in to book a car.");
        window.location.href = "login.php";
      } else {
        window.location.href = "bookings.php?car=" + encodeURIComponent(carName);
      }
    }
  </script>
</body>
</html>
