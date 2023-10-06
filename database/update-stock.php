<?php
// database/update-stock.php

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the product ID and new stock count from the request
$productId = $_POST['id'];
$stockCount = $_POST['stocks'];

// Prepare the update statement with placeholders
$sql = "UPDATE products SET stocks = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $stockCount, $productId);

// Execute the update statement
if ($stmt->execute()) {
  $response = array('status' => 'success', 'message' => 'Stock count updated successfully');
  echo json_encode($response);
} else {
  $response = array('status' => 'error', 'message' => 'Failed to update stock count');
  echo json_encode($response);
}

// Close the database connection
$stmt->close();
$conn->close();
?>



