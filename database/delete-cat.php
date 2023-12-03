<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

require_once('database/category-conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $categoryId = $_POST['id'];

    // Perform the deletion query
    $deleteCategoryQuery = "DELETE FROM categories WHERE cat_id = '$categoryId'";
    mysqli_query($con, $deleteCategoryQuery);

    // You can also add error handling and response messages here if needed
}
?>
