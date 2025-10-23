<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM cars ORDER BY id DESC");
$cars = [];

while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

echo json_encode($cars);
$conn->close();
?>
