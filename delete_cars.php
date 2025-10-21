<?php
include 'db_connect.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "DELETE FROM cars WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    echo "success";
  } else {
    echo "error";
  }
}

$conn->close();
?>
