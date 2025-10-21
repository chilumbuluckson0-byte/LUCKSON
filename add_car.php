<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $car_name     = $_POST['car_name'];
  $model        = $_POST['model'];
  $fuel_type    = $_POST['fuel_type'];
  $transmission = $_POST['transmission'];
  $price        = $_POST['price'];
  $availability = $_POST['availability'];

  $sql = "INSERT INTO cars (car_name, model, fuel_type, transmission, price_per_day, availability)
          VALUES ('$car_name', '$model', '$fuel_type', '$transmission', '$price', '$availability')";

  if ($conn->query($sql) === TRUE) {
    echo "success";
  } else {
    echo "error";
  }
}

$conn->close();
?>
