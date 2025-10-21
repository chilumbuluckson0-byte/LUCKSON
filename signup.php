<?php
// ✅ Include your database connection file
include('db_connect.php');

// Initialize message variable
$message = "";

// ✅ Only process the form when it’s submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect and sanitize form data
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $license = mysqli_real_escape_string($conn, $_POST['license']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $role = mysqli_real_escape_string($conn, $_POST['role']);

  // ✅ Password validation
  if ($password !== $confirm_password) {
    $message = "<p style='color:red;'>❌ Passwords do not match!</p>";
  } elseif (strlen($password) < 6) {
    $message = "<p style='color:red;'>⚠️ Password must be at least 6 characters long.</p>";
  } else {
    // ✅ Check if email already exists
    $check_email = "SELECT * FROM user_table WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
      $message = "<p style='color:red;'>⚠️ Email already exists. Please use another one.</p>";
    } else {
      // ✅ Encrypt password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // ✅ Insert into database
      $sql = "INSERT INTO user_table (first_name, last_name, email, phone, license_no, password, role)
              VALUES ('$first_name', '$last_name', '$email', '$phone', '$license', '$hashedPassword', '$role')";

      if ($conn->query($sql) === TRUE) {
        $message = "<p style='color:green;'>✅ Account created successfully! You can now <a href='login.php'>login</a>.</p>";
      } else {
        $message = "<p style='color:red;'>❌ Database Error: " . $conn->error . "</p>";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - RedWheel Rentals</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
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
      max-width: 500px;
      margin: 50px auto;
      background: #fff;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #f30514;
      margin-bottom: 20px;
    }
    input, select {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #f30514;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #c10410;
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
    <div class="logo">RedWheel Rentals</div>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container">
    <h2>Create Your Account</h2>
    <?= $message ?>
    <form method="POST" action="">
      <input type="text" name="first_name" placeholder="First Name" required>
      <input type="text" name="last_name" placeholder="Last Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="tel" name="phone" placeholder="Phone Number" required>
      <input type="text" name="license" placeholder="License Number" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>

      <label for="role">Register As:</label>
      <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit">Sign Up</button>
      <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
  </div>

  <footer>
    <p>&copy; 2025 RedWheel Rental. All rights reserved.</p>
  </footer>
</body>
</html>
