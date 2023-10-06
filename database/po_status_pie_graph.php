<?php

include('connection.php');
$statuses = ['pending', 'complete', 'incomplete'];

$results = []; 
$date = isset($_GET['date']) ? 'AND YEAR(created_at) = '.$_GET['date'].'' : '';
// Loop through statuses and query AND YEAR(created_at) = '2023'
foreach($statuses as $status){
    $stmt = $conn->prepare("SELECT COUNT(*) as status_count FROM order_product WHERE order_product.status='" . $status . "' $date");
    $stmt->execute();
    $row = $stmt->fetch();

    $count = $row['status_count'];

    $results[] = [
        'name' => strtoupper($status),
        'y' => (int) $count
    ];
}

    $productFetch = [];
    $total = [];
    $best_sale = isset($_GET['best_sale']) ? "AND DATE_FORMAT(c.date_order, '%Y-%m') = '".$_GET['best_sale']."'" : '';
    
    $stmt = $conn->prepare("SELECT *,
    COALESCE((SELECT SUM(a.price * c.qty)
               FROM tbl_cart c
               WHERE c.status = 'completed' AND c.product_id = a.id ".$best_sale." ), 0) AS total
  FROM products a
  ORDER BY total DESC");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    foreach ($rows as $key => $value) {
        $productFetch[] = $value['product_name'];
        $total[] = $value['total'];
    }
//echo json_encode($productFetch);
