<?php
session_start();
include 'db_connect.php';

// Debug: see session
// print_r($_SESSION);

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

$message = ""; // To store success/error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_email = $_SESSION['email']; // Use session email (logged in user)
  $car_name = $_POST['car_name'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $total_price = $_POST['total_price'];

  if (!empty($user_email) && !empty($car_name) && !empty($start_date) && !empty($end_date) && !empty($total_price)) {
    $sql = "INSERT INTO booking_table (user_email, car_name, start_date, end_date, total_price)
            VALUES ('$user_email', '$car_name', '$start_date', '$end_date', '$total_price')";

    if ($conn->query($sql) === TRUE) {
      $message = "<p style='color:green; font-weight:bold; text-align:center;'>✅ Booking successful! You can view it on your dashboard.</p>";
    } else {
      $message = "<p style='color:red; font-weight:bold; text-align:center;'>❌ Error: " . $redwheel->error . "</p>";
    }
  } else {
    $message = "<p style='color:red; font-weight:bold; text-align:center;'>⚠️ Please fill in all fields.</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book a Car - RedWheel Rentals</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #343232;
      color: white;
      display: flex;
      justify-content: space-between;
      padding: 20px 40px;
      align-items: center;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
    }

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #f30514;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #f30514;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background-color: #c10410;
    }

    .message {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">RedWheel Rentals</div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="cars.php">Cars</a></li>
        <li><a href="bookings.php" class="active">Bookings</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container">
    <h2>Book Your Car</h2>
    <?php echo $message; ?>

    <form method="POST" action="">
      <label for="car_name">Select a Car:</label>
      <select name="car_name" required>
        <option value="">-- Select a Car --</option>
        <option value="Toyota Corolla">Toyota Corolla</option>
        <option value="Honda Civic">Honda Civic</option>
        <option value="Mazda CX-5">Mazda CX-5</option>
        <option value="Range Rover Evoque">Range Rover Evoque</option>
      </select>

      <label>Start Date:</label>
      <input type="date" name="start_date" required>

      <label>End Date:</label>
      <input type="date" name="end_date" required>

      <label>Total Price (ZMW):</label>
      <input type="number" name="total_price" placeholder="Enter total price" required>

      <button type="submit">Confirm Booking</button>
    </form>
  </div>
</body>
</html>
