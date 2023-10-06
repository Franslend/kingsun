<?php
// get-product-image.php

// Assuming you have a MySQL connection established

// Retrieve the product ID from the request
$id = $_GET['id'];

// Prepare and execute the query to fetch the image URL
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();

// Return the image URL as a JSON response
$response = ['image' => $image];
header('Content-Type: application/json');
echo json_encode($response);
?>
