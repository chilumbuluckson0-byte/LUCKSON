<?php
session_start();
include 'db_connect.php';

// Restrict access to admins only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

// Fetch summary stats
$total_users = $conn->query("SELECT COUNT(*) AS total FROM user_table WHERE role='user'")->fetch_assoc()['total'];
$total_cars = $conn->query("SELECT COUNT(*) AS total FROM car_table")->fetch_assoc()['total'];
$total_bookings = $conn->query("SELECT COUNT(*) AS total FROM booking_table")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - RedWheel Rentals</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      background: #f8f9fa;
    }
    .sidebar {
      width: 240px;
      background-color: #1a1a1a;
      color: white;
      height: 100vh;
      padding: 20px;
      box-sizing: border-box;
    }
    .sidebar h2 {
      text-align: center;
      color: #f30514;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      margin: 15px 0;
      padding: 10px;
      border-radius: 6px;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background: #333;
      padding-left: 15px;
    }
    .main-content {
      flex: 1;
      padding: 30px;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logout-btn {
      background: #f30514;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    .logout-btn:hover {
      background: #c20410;
    }
    .cards {
      display: flex;
      justify-content: space-around;
      margin-top: 40px;
      flex-wrap: wrap;
    }
    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 250px;
      text-align: center;
      margin-bottom: 20px;
    }
    .card h3 {
      color: #f30514;
    }
    .recent {
      margin-top: 40px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f30514;
      color: white;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>RedWheel Admin</h2>
    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="manage_cars.php">🚗 Manage Cars</a>
    <a href="manage_users.php">👥 Manage Users</a>
    <a href="manage_bookings.php">📅 Manage Bookings</a>
    <a href="logout.php">🚪 Logout</a>
  </div>

  <div class="main-content">
    <header>
      <h1>Welcome, Admin</h1>
      <form action="logout.php" method="POST">
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </header>

    <div class="cards">
      <div class="card">
        <h3>Total Users</h3>
        <p><?= $total_users ?></p>
      </div>
      <div class="card">
        <h3>Total Cars</h3>
        <p><?= $total_cars ?></p>
      </div>
      <div class="card">
        <h3>Total Bookings</h3>
        <p><?= $total_bookings ?></p>
      </div>
    </div>

    <div class="recent">
      <h2>Recent Bookings</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>User</th>
          <th>Car</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
        <?php
        $recent = $conn->query("
          SELECT b.id, first_name AS first_name, c.name, b.start_date, b.status
          FROM booking_table b
          JOIN user_table u ON b.id = u.id
          JOIN car_table c ON b.id = c.id
          ORDER BY b.id DESC LIMIT 5
        ");
        if ($recent->num_rows > 0) {
          while ($row = $recent->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['user_name']}</td>
              <td>{$row['car_name']}</td>
              <td>{$row['booking_date']}</td>
              <td>{$row['status']}</td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No recent bookings.</td></tr>";
        }
        ?>
      </table>
    </div>
  </div>

</body>
</html>
