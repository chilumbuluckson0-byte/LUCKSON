<?php
session_start();
include 'db_connect.php'; // Database connection

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['id'];

// Fetch user info from the database
$query = "SELECT first_name, last_name, email, phone, address FROM user_table WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch user booking history
$bookings_query = "SELECT car_name, start_date, end_date, status FROM bookings WHERE user_id = ?";
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$bookings_result = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard | RedWheel Rentals</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    header {
      background: #222;
      color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      color: #ff3b3b;
      font-size: 1.5em;
      font-weight: bold;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    nav a {
      color: white;
      text-decoration: none;
    }
    nav a:hover {
      color: #ff3b3b;
    }
    .dashboard {
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .dashboard h1 {
      color: #ff3b3b;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background: #ff3b3b;
      color: white;
    }
    input, button {
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%;
      margin-bottom: 10px;
    }
    button {
      background: #ff3b3b;
      color: white;
      cursor: pointer;
      border: none;
    }
    button:hover {
      background: #c20410;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">RedWheel Rentals</div>
    <nav>
      <ul>
        <li><a href="index.php">🏠 Home</a></li>
        <li><a href="cars.php">🚗 Cars</a></li>
        <li><a href="bookings.php">📅 Bookings</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($user['first_name']); ?> 👋</h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <h2>Update Profile</h2>
    <form method="POST" action="update_profile.php">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
      <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
      <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
      <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
      <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
      <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
      <button type="submit">💾 Save Changes</button>
    </form>

    <h2>Booking History</h2>
    <table>
      <tr>
        <th>Car</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
      </tr>
      <?php while($row = $bookings_result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo htmlspecialchars($row['car_name']); ?></td>
        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
