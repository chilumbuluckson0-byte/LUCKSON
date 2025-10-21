<?php
include 'db_connect.php';

$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

$cars = [];
while ($row = $result->fetch_assoc()) {
  $cars[] = $row;
}

echo json_encode($cars);
$conn->close();
?>
