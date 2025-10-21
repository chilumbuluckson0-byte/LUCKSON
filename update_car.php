<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id           = $_POST['id'];
  $car_name     = $_POST['car_name'];
  $model        = $_POST['model'];
  $fuel_type    = $_POST['fuel_type'];
  $transmission = $_POST['transmission'];
  $price        = $_POST['price'];
  $availability = $_POST['availability'];

  $sql = "UPDATE cars SET 
            car_name='$car_name', 
            model='$model', 
            fuel_type='$fuel_type', 
            transmission='$transmission', 
            price_per_day='$price',
            availability='$availability'
          WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "success";
  } else {
    echo "error";
  }
}

$conn->close();
?>
