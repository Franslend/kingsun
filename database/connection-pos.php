<?php
$servername = 'localhost'; // Replace with your server name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$dbname = 'client02'; // Replace with your database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the desired columns from the products table
    $query = "SELECT id, product_name, img, category, price, stocks FROM products";// Add the "id" column to the SELECT statement
    $statement = $conn->query($query);
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Convert the data to JSON and send it as the response
    header('Content-Type: application/json');
    echo json_encode($products);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

