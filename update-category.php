<?php
// update-category.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryId = $_POST['category_id'];
    $newCategoryName = $_POST['edit_category_name'];

    // Perform the database update
    require_once('database/category-conn.php'); // Make sure to include your database connection file

    $updateCategoryQuery = "UPDATE categories SET category_name = '$newCategoryName' WHERE cat_id = '$categoryId'";
    $result = mysqli_query($con, $updateCategoryQuery);

    if ($result) {
        $response = array(
            'success' => true,
            'message' => 'Category updated successfully'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error updating category'
        );
    }

    echo json_encode($response);
    exit();
} else {
    // Handle invalid requests
    header('HTTP/1.1 400 Bad Request');
    exit();
}

