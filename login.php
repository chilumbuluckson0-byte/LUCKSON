<?php
session_start();
include 'db_connect.php'; // Database connection file

$error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Basic validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
  } elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters.";
  } else {
    // Prepare query to find user by email
    $sql = "SELECT id, first_name, last_name, email, password, role FROM user_table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Verify password
      if (password_verify($password, $user['password'])) {
        // Store user data in session (excluding password)
       $_SESSION['id'] = $user['id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name'] = $user['last_name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] === 'admin') {
          header("Location: admindash.php");
          exit();
        } elseif ($user['role'] === 'user') {
          header("Location: dashboard.php");
          exit();
        } else {
          $error = "Invalid role assigned to this account.";
        }
      } else {
        $error = "Incorrect password.";
      }
    } else {
      $error = "No account found with that email.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - RedWheel Rentals</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    header {
      background: #222;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      color: #ff3b3b;
      font-weight: bold;
      font-size: 20px;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
    }
    nav a {
      color: white;
      text-decoration: none;
    }
    nav a:hover {
      color: #ff3b3b;
    }
    .form-container {
      max-width: 400px;
      margin: 80px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #f30514;
      margin-bottom: 20px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .error {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-bottom: 10px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #f30514;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #c20410;
    }
    p {
      text-align: center;
      margin-top: 15px;
    }
    p a {
      color: #f30514;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">RedWheel Rentals</div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container"> 
    <h2>Login to RedWheel Rentals</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password (min 6 chars)" minlength="6" required>
      <button type="submit">Login</button>
      <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </form>
  </div>
</body>
</html>
