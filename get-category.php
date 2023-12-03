<?php
    // get-category.php

    require_once('database/category-conn.php');

    if(isset($_GET['id'])) {
        $categoryId = $_GET['id'];
        
        $query = "SELECT * FROM categories WHERE cat_id = $categoryId";
        $result = mysqli_query($con, $query);

        if($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        } else {
            echo "Category not found";
        }
    }
?>
