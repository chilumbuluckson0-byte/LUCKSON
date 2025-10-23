<?php
include 'db_connect.php';

$id = $_POST['id'];
$car_name = $_POST['car_name'];
$model = $_POST['model'];
$fuel_type = $_POST['fuel_type'];
$transmission = $_POST['transmission'];
$total_price = $_POST['tatol_price'];
$new_status = $_POST['status'];

$stmt = $conn->prepare("UPDATE cars SET car_name=?, model=?, fuel_type=?, transmission=?, price_per_day=?, availability=? WHERE id=?");
$stmt->bind_param("ssssdsi", $car_name, $model, $fuel_type, $transmission, $price_per_day, $availability, $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
