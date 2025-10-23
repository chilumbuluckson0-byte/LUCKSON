<?php
include 'db_connect.php';

$car_name = $_POST['car_name'];
$model = $_POST['model'];
$fuel_type = $_POST['fuel_type'];
$transmission = $_POST['transmission'];
$price_per_day = $_POST['price_per_day'];
$availability = $_POST['availability'];

$stmt = $conn->prepare("INSERT INTO cars (car_name, model, fuel_type, transmission, price_per_day, availability) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssds", $car_name, $model, $fuel_type, $transmission, $price_per_day, $availability);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
$stmt->close();
$conn->close();
?>
