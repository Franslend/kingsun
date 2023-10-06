<?php
session_start();

$post_data =$_POST;
print_r($post_data);
$products = $post_data['products'];
$qty = array_values($post_data['quantity']);

$post_data_arr = [];


foreach ($products as $key => $pid) {
    if(isset($qty[$key])) $post_data_arr[$pid] = $qty[$key];
}

// Include connection
    include('connection.php');

// store data.
$batch = time();

$success = false;

try{

    function generateNewId($conn) {
        $lastIdQuery = "SELECT id FROM order_product ORDER BY id DESC LIMIT 1";
        $stmt = $conn->query($lastIdQuery);
        $lastId = $stmt->fetchColumn();
        $newId = $lastId + 1;
        return $newId;
    }

    foreach($post_data_arr as $pid => $supplier_qty){
        foreach($supplier_qty as $sid => $qty){
            // Insert into database.

            $values = [
                'id' => generateNewId($conn),
                'supplier' => $sid,
                'product' => $pid,
                'quantity_ordered' => $qty,
                'status' => 'pending',
                'batch' => $batch,
                'created_by' => $_SESSION['user']['id'],
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];


            $sql = "INSERT INTO order_product			
                        (id,supplier, product, quantity_ordered, status, batch, created_by, updated_at, created_at) 
                    VALUES 
                        (:id,:supplier, :product, :quantity_ordered, :status, :batch, :created_by, :updated_at, :created_at)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($values);
        }
    }
    $success = true;
    $message = 'Completed!';
} catch (\Exception $e) {
    $message = $e->getMessage();
}

$_SESSION['response'] = [
    'message' => $message,
    'success' => $success 
];

header('location: ../product-order.php');