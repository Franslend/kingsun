<?php
    $purchase_orders = $_POST['payload'];

    include('connection.php');

    try{

        foreach ($purchase_orders as $po) {
            $delivered = (int) $po['qtyDelivered'];

           // We don't save the data if it's zero received
            if($delivered >= 0){
                $cur_qty_received = (int) $po['qtyReceive'];
                // $status = $po['status'];
                $row_id = $po['id'];
                $qty_ordered = (int) $po['qtyOrdered'];
                $product_id = (int) $po['pid'];
                
            // Calculate the updated quantity received
            $updated_qty_received = $cur_qty_received + $delivered;

            // Check if the delivered quantity exceeds the ordered quantity
            if ($updated_qty_received > $qty_ordered) {
                $response = [
                    'success' => false,
                    'message' => "The input quantity exceeds the number of ordered products for one or more items.",
                ];
                echo json_encode($response);
                exit; // Stop processing if there's an error
            }

            // Calculate the remaining quantity
            $qty_remaining = $qty_ordered - $updated_qty_received;


            // Check if the delivered quantity equals the ordered quantity
            if ($updated_qty_received === $qty_ordered) {
                $status = 'completed';
            } elseif ( $updated_qty_received === 0) {
                $status = 'cancelled'; // Keep it as 'incomplete' if it was manually set
            } else {
                $status = 'pending';
            }
        
                $sql = "UPDATE order_product
                            SET
                                quantity_received=?, status=?, quantity_remaining=?
                            WHERE id=?";
        
                $stmt = $conn->prepare($sql);
                $stmt->execute([$updated_qty_received, $status, $qty_remaining, $row_id]);


                // Insert script adding to the order_product_history
                $delivery_history = [
                    'order_product_id' => $row_id,
                    'qty_received' => $delivered,
                    'date_received' => date('Y-m-d H:i:s'),
                    'date_updated' => date('Y-m-d H:i:s')
                ];

                $sql = "INSERT INTO order_product_history 
                            (order_product_id, qty_received, date_received, date_updated)
                        VALUES
                            (:order_product_id, :qty_received, :date_received, :date_updated)";
                $stmt = $conn->prepare ($sql);
                $stmt->execute($delivery_history);



                // Script for Updating the main product quantity
                // Select statement - to pull the current quantity of product,
                // Update statment - to add the delivered product to the cur quantity


                $stmt = $conn->prepare("
                        SELECT products.stocks FROM products
                            WHERE
                                id = $product_id
                        ");
                $stmt->execute();
                $product = $stmt->fetch();

                $cur_stocks = (int) $product['stocks'];

                // Update statement - to add the delivered product to the cur quantity
                $updated_stocks = $cur_stocks + $delivered;
                $sql = "UPDATE products
                            SET
                                stocks=?
                            WHERE id=?";
                            
                $stmt = $conn->prepare($sql);
                $stmt->execute([$updated_stocks, $product_id]);
                    
            }
        }
   
        $response = [
            'success' => true,
            'message' => "Purchase order successfully updated!"
        ];

        
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => "Error processing your request"
        ];
    }
    
echo json_encode($response);
?>