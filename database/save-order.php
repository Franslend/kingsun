<?php
session_start();

$post_data = $_POST;
//print_r($post_data);
$products = $post_data['products'];

    // Include connection
    include('connection.php');

    // store data.
    $batch = time();

    try {
        function generateNewId($conn)
        {
            $lastIdQuery = "SELECT id FROM order_product ORDER BY id DESC LIMIT 1";
            $stmt = $conn->query($lastIdQuery);
            $lastId = $stmt->fetchColumn();
            $newId = $lastId + 1;
            return $newId;
        }

        $post_data_arr = [];
        foreach ($products as $key => $pid) {
            if (isset($post_data['quantity'][$key])) {
                $supplier_qty = $post_data['quantity'][$key];
                foreach ($supplier_qty as $sid => $qty) {
                    $post_data_arr[$pid][$sid] = $qty;
                }
            }
        }

        if (empty($post_data_arr)) {
            $message = 'No selected product to submit order'; // Error message
            $success = false;
        } else {
            foreach ($post_data_arr as $pid => $supplier_qty) {
                foreach ($supplier_qty as $sid => $qty) {
                    // Insert into the database.

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
                            (id, supplier, product, quantity_ordered, status, batch, created_by, updated_at, created_at) 
                        VALUES 
                            (:id, :supplier, :product, :quantity_ordered, :status, :batch, :created_by, :updated_at, :created_at)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($values);
                }
            }
            $success = true;
            $message = 'The Order is successfully recorded. Redirecting to View Orders...'; // Success message
        }
    } catch (\Exception $e) {
        $message = $e->getMessage();
        $success = false;
    }


// Store success flag in the session
$_SESSION['response'] = [
    'message' => $message,
    'success' => $success
];

// Redirect after displaying the message
if ($success) {
    header("Location: ../view-order.php");
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
?>
