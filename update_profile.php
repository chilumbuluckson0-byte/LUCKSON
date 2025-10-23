<?php
include 'db_connect.php';

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM cars WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
