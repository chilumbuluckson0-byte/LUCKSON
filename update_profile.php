<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = $_POST['user_id'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  $sql = "UPDATE user_table 
          SET first_name=?, last_name=?, email=?, phone=?, address=? 
          WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $address, $user_id);

  if ($stmt->execute()) {
    $_SESSION['first_name'] = $first_name;
    $_SESSION['user_email'] = $email;
    header("Location: dashboard.php?success=1");
  } else {
    echo "Error updating profile.";
  }
}
?>
