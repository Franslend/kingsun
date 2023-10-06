<?php
$servername = 'localhost'; // Replace with your server name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$dbname = 'client02'; // Replace with your database name

// Get the product ID from the query string
$id = $_GET['id'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate the ID parameter to prevent SQL injection
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id === false) {
        throw new Exception('Invalid product ID');
    }

    // Fetch the desired product by ID
    $query = "SELECT id, product_name, img, category, price, stocks FROM products WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    if ($product === false) {
        throw new Exception('Product not found');
    }

    // Convert the data to JSON and send it as the response
    header('Content-Type: application/json');
    echo json_encode(['product' => $product]);
} catch (PDOException $e) {
    // Log the error or handle it appropriately
    echo "Connection failed: " . $e->getMessage();
} catch (Exception $e) {
    // Log the error or handle it appropriately
    echo "Error fetching product: " . $e->getMessage();
}
?>
