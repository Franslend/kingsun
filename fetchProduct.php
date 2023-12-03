<?php 
session_start();
 extract($_POST);
 function fetchItem($query){
    include('database/connection.php');
    $statement = $conn->prepare($query);
    $statement->execute();
    return [
        'res' => $statement->fetchAll(PDO::FETCH_ASSOC),
        'res_count' => $statement->rowCount()
    ];
   
 }
 function insert_data($table,$data){
    include('database/connection.php');
    $placeholders = array_map(function($key) {
        return ':' . $key;
    }, array_keys($data));
    $keys = array_keys($data);
    $stmt = $conn->prepare("INSERT INTO $table (".implode(', ', $keys).") VALUES (".implode(', ', $placeholders).")");
    $stmt->execute($data);
    return true;
 }
 function delete_data($table,$data){
    include('database/connection.php');
    $column = array_keys($data);
    $sql = "DELETE FROM $table WHERE $column[0] = :value";
    $conn->prepare($sql)->execute([':value' => $data[$column[0]]]);
    return true;
 }
 function update_data($table,$data,$where){
    include('database/connection.php');
    $display = '';
    foreach ($data as $key => $value) {
        $display .= "$key = ";
        if (is_numeric($value)) {
            $display .= $value;
        } else {
            $display .= "'$value'";
        }
        $display .= ", ";
    }
    $display = rtrim($display, ', ');
    $condition = key($where) . ' = ' . current($where);
    $sql = "UPDATE $table SET $display WHERE $condition";
    $res = $conn->prepare($sql)->execute();
    if ($res) {
        return true;
    }
    return false;
 }
 function setUpOnQery($action, $query){
    include('database/connection.php');
    $statement = $conn->prepare($query);
    $statement->execute();
    if ($action != 'insert') {
        return true;
    }else{
        return [
            'res' => $statement->fetchAll(PDO::FETCH_ASSOC),
            'res_count' => $statement->rowCount()
        ];
    }
 }

/* Encrypt pass */ 
 function decryptData($encryptedData) {
    $key = '@DWSsadSdw2';
    $iv = '1234567890123456';
    $cipherMethod = 'AES-256-CBC';
    return openssl_decrypt($encryptedData, $cipherMethod, $key, 0, $iv);
}
 if (isset($fetchProduct)) {
    // echo $where = "WHERE id not in ($ids)";
    $where = "WHERE id not in (0)";
    $numbers = explode(',', $ids);
    $where .= ($cat != 'all') ? "AND category = '$cat'" : "" ;
    $where .= ($search_item != '') ? "AND product_name LIKE '%$search_item%'" : "" ;
    $table = 'SELECT * FROM products '.$where.'';
    $product = fetchItem($table);
    $output = '';
    if ($product['res_count'] > 0) {
        foreach ($product['res'] as $key => $value) {
            $disabled = in_array($value['id'], $numbers) ? 'disabled' : '';
            $img = ($value['img'] != null) ? '<img src="uploads/products/'.$value['img'].'" alt="" width="50">' : '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1200px-No-Image-Placeholder.svg.png" alt="" width="50">';
            $btn_status = $value['stocks'] == 0 ? 'disabled' : '';
            $tr_status = $value['stocks'] == 0 ? 'style="background-color:red !important"' : '';
            $output .= '<tr '.$tr_status.'>';
                $output .= '<td>'.$value['item_code'].'</td>';
                $output .= '<td>'.$value['product_name'].'</td>';
                $output .= '<td class="text-center" style="center !important" data-id="'.$value['id'].'" id="view-img">'.$img.'</td>';
                $output .= '<td>'.$value['category'].'</td>';
                $output .= '<td>₱'.number_format($value['price']).'</td>';
                $output .= '<td>'.$value['stocks'].'</td>';
                $output .= '<td><button type="button" class="btn btn-primary btn-sm" id="add-product" data-product_id="'.$value['id'].'" '.$btn_status.' '.$disabled.'> + Add</button></td>';
            $output .= '</tr>';
        }
    }else{
        $output .= '<tr>';
        $output .= '<td colspan="6" class="text-center">NO PRODUCT FOUND</td>';
        $output .= '</tr>';
    }
    echo $output;
}

//checkout scheme supplier
if (isset($fetchSelectedProduct)) {
    $c_product = fetchItem('SELECT * FROM tbl_cart where product_id = '.$product_id.' and time_order = '.$time_order.'');
    $result = true;
    if ($c_product['res_count'] != 1 && $action == 'add') {
        $data = array(
            'time_order' => $time_order,
            'product_id' => $product_id,
            'qty' => $qty
        );
        $insert_data = insert_data('tbl_cart',$data);
    }
    if ($action == 'delete') {
        $data = array(
            'cart_id' => $cart_id
        );
        $delete_data = delete_data('tbl_cart',$data);
    }
    if ($action == 'update') {
        $c_product = fetchItem('SELECT * FROM products where id = '.$product_id.'');
         if ($c_product['res'][0]['stocks'] >= $qty) {
            $data = array(
                'qty' => $qty
            );
            $where = array(
                'cart_id' => $cart_id
            );
            $result = update_data('tbl_cart',$data,$where);
         }else{
            $result = false;
         }
    }
    $table = 'SELECT * FROM products as a 
    inner join tbl_cart as b on a.id = b.product_id
    WHERE b.time_order = '.$time_order.' and b.status = "rejected"';
    //echo $table;
    $product = fetchItem($table);
    $output = '';
    $total = 0;
    if ($product['res_count'] > 0) {
        foreach ($product['res'] as $key => $value) {
            $retVal = $value['price'] * $value['qty'];
            $total += $retVal;
            $output .= '<tr>';
                $output .= '<td>'.$value['item_code'].'</td>';
                $output .= '<td>'.$value['product_name'].'</td>';
                $output .= '<td>
                <div class="input-group input-group-sm">
                    <button class="btn btn-outline-secondary" type="button" data-id="'.$value['id'].'"" id="button-add" data-cart_id="'.$value['cart_id'].'">+</button>
                    <input type="text" class="form-controls number-input text-center"  data-cart_id = "'.$value['cart_id'].'" data-id = "'.$value['id'].'" id= "product_id_'.$value['id'].'" value="'.$value['qty'].'" style="width:40px">
                    <button class="btn btn-outline-danger" type="button" data-cart_id = "'.$value['cart_id'].'" data-id="'.$value['id'].'" id="button-minus">-</button>
                </div>
                </td>';
                $output .= '<td id="stock_num_'.$value['id'].'">'.$value['stocks'] - $value['qty'].'</td>';
                $output .= '<td>₱'.number_format($value['price']).'</td>';
                $output .= '<td><button type="button" class="btn btn-danger btn-sm" id="remove-product" data-id="'.$value['id'].'" data-cart_id="'.$value['cart_id'].'"> Remove</button></td>';
            $output .= '</tr>';
        }
    }else{
        $output .= '<tr class="excepted">';
        $output .= '<td colspan="6" class="text-center">NO PRODUCT FOUND</td>';
        $output .= '</tr>';
    }
    $response = array(
        'cart'=>$output,
        'subtotal'=>$total,
        'result'=>$result
    );
    echo json_encode($response);
}



/* Modal POS Picture*/
if (isset($view_img)) {
    $table = 'SELECT * FROM products where id =' . $itemId;
    $product = fetchItem($table);
    $output = '';
    $total = 0;
    if ($product['res_count'] > 0) {
        foreach ($product['res'] as $key => $value) {
            $img = ($value['img'] != null) ? '<img src="uploads/products/' . $value['img'] . '" alt="" width="100%" height="400">' : '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1200px-No-Image-Placeholder.svg.png" alt="" width="100%" height="400">';
            $output .= $img;

            // Fetch and include p_location
            $p_location = $value['p_location'];
        }
    }

    $response = array(
        'src' => $output,
        'p_location' => $p_location // Include p_location in the response
    );

    echo json_encode($response);
}





if(isset($fetchSelectedProductDashboard)){
    $output = '';
    $total = 0;
    $x = 1;
    switch ($action) {
        case 'pie':
            $table = 'SELECT 
            order_product.id, order_product.product, products.product_name, order_product.quantity_ordered, users.first_name, order_product.batch, order_product.quantity_received,users.last_name, suppliers.supplier_name, order_product.status, order_product.created_at,products.item_code
            FROM order_product, suppliers, products, users
            WHERE
                order_product.supplier = suppliers.id
                    AND
                order_product.product = products.id
                    AND
                order_product.created_by = users.id
                    AND
                order_product.status = "'.$status.'"
            ORDER BY
                order_product.created_at DESC';
            $product = fetchItem($table);
            if ($product['res_count'] > 0) {
                foreach ($product['res'] as $key => $value) {
                    $output .= '<tr>';
                        $output .= '<td>'.$x++.'</td>';
                        $output .= '<td>'.$value['id'].'</td>';
                        $output .= '<td>'.$value['product_name'].'</td>';
                        $output .= '<td>'.$value['quantity_ordered'].'</td>';
                        $output .= '<td>'.$value['quantity_received'].'</td>';
                        $output .= '<td>'.$value['status'].'</td>';
                        $output .= '<td>'.$value['first_name'].' '.$value['last_name'].'</td>';
                        $output .= '<td>'.$value['created_at'].'</td>';
                        $output .= '<td><button type="button" id="modal-2" data-id = "'.$value['id'].'" class="btn btn-primary btn-sm">Deliveries</button></td>';
                    $output .= '</tr>';
                }
            }else{
                $output .= '<tr>';
                $output .= '<td colspan="9" class="text-center">NO PRODUCT FOUND</td>';
                $output .= '</tr>';
            }
            break;
        case 'single_product':
            $table = "SELECT * FROM order_product_history WHERE order_product_id = $id ORDER BY date_received DESC";
            $product = fetchItem($table);
            if ($product['res_count'] > 0) {
                foreach ($product['res'] as $key => $value) {
                    $output .= '<tr>';
                        $output .= '<td>'.$x++.'</td>';
                        $output .= '<td>'.$value['date_received'].'</td>';
                        $output .= '<td>'.$value['qty_received'].'</td>';
                    $output .= '</tr>';
                }
            }else{
                $output .= '<tr>';
                $output .= '<td colspan="3" class="text-center">NO PRODUCT FOUND</td>';
                $output .= '</tr>';
            }
            break;
        case 'line':
            $table = "SELECT * FROM order_product_history as a 
            INNER JOIN products as b ON a.order_product_id = b.id
            WHERE 
            DATE(a.date_received) = '".$date_received."' ORDER BY a.date_received DESC";
            $product = fetchItem($table);
            if ($product['res_count'] > 0) {
                foreach ($product['res'] as $key => $value) {
                    $total += $value['qty_received'];
                    $output .= '<tr>';
                        $output .= '<td>'.$x++.'</td>';
                        $output .= '<td>'.$value['item_code'].'</td>';
                        $output .= '<td>'.$value['product_name'].'</td>';
                        $output .= '<td>'.$value['qty_received'].'</td>';
                        $output .= '<td>'.$value['date_received'].'</td>';
                    $output .= '</tr>';
                }
                $output .= '<tr>';
                    $output .= '<td colspan="5" class="text-center">Total: '.$total.'</td>';;
                $output .= '</tr>';
            }else{
                $output .= '<tr>';
                $output .= '<td colspan="5" class="text-center">NO PRODUCT FOUND</td>';
                $output .= '</tr>';
            }
            break;
        default:
            $output .= '<tr>';
            $output .= '<td colspan="5" class="text-center">NO PRODUCT FOUND</td>';
            $output .= '</tr>';
            break;
    }
    $response = array(
        'products'=>$output,
    );
    echo json_encode($response);
}

//suppier info in  product view
if (isset($viewAddEditDelete)) {

    $output = '';
    $total = 0;
    $x = 1;

    switch ($action) {
        case 'view':
            $table = "SELECT *,a.email as email_sup ,a.c_number as c_num_sup FROM 
            suppliers a
                left join users b on a.created_by = b.id
            WHERE a.id = $id";
            $product = fetchItem($table);
            if ($product['res_count'] > 0) {
                foreach ($product['res'] as $key => $value) {
                    $output .= '<div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Supplier name</label>
                                        <input type="text" class="form-control" id="validationCustom01" value="'.$value['supplier_name'].'" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" id="validationCustom01" value="'.$value['supplier_location'].'" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Contact Details</label>
                                        <input type="text" class="form-control" id="validationCustom01" value="'.$value['email_sup'].' / '.$value['c_num_sup'].'" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Created by</label>
                                        <input type="text" class="form-control" id="validationCustom01" value="'.$value['first_name'].' '.$value['last_name'].'" readonly>
                                    </div>
                                </div>';
                }
            }else{
                $output .= 'NO DATA';
            }
            break;
        case 'edit':
            $table = "SELECT *,a.id as product_id FROM 
            products a
                left join users b on a.created_by = b.id
            WHERE a.id = $id";
            $product = fetchItem($table);

            $table2 = "SELECT * FROM 
            productsuppliers a
            WHERE a.product = $id";
            $product2 = fetchItem($table2);

            $table3 = "SELECT * FROM suppliers";
            $product3 = fetchItem($table3);


            //POS data fetch
            if ($product['res_count'] > 0) {
                //Fetching data
                require_once('database/category-conn.php');
                $query = "select * from categories";
                $result = mysqli_query($con, $query);
                $categories = array();

                while ($row = mysqli_fetch_assoc($result)) {
                    $categories[] = $row['category_name'];
                }
                foreach ($product['res'] as $key => $value) {
                    $output .= '<div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Item Code</label>
                                        <input type="text" class="form-control" name="item_code" value="'.$value['item_code'].'" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="p_location" value="'.$value['p_location'].'" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Product name</label>
                                        <input type="hidden" class="form-control" name="status" value="'.$value['status'].'" required>
                                        <input type="hidden" class="form-control" name="updateProduct" value="'.$value['product_id'].'" required>
                                        <input type="text" class="form-control" name="product_name" value="'.$value['product_name'].'" required>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <label class="form-label">Category</label>
                                        <select class="appFormInput" id="role" name="category" required="">
                                            <option value="" disabled>Select Category</option>
                                        '; 
                                        foreach ($categories as $key => $category) {
                                            if ($value['category'] == $category) {
                                                $output .= '<option value="'.$category.'" selected>'.$category.'</option>';
                                            }else{
                                                $output .= '<option value="'.$category.'">'.$category.'</option>';
                                            }
                                        }
                    $output .=      '</select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Stocks</label>
                                        <input type="number" class="form-control" name="stocks" value="'.$value['stocks'].'" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price" value="'.$value['price'].'" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Suppliers</label>
                                        <select class="appFormInput" id="role" name="suppliers[]" required="" multiple required>
                                        <option value="" disabled>Select Suppliers</option>';
                                        if ($product3['res_count'] > 0) {
                                            $selectedSuppliers = array_column($product2['res'], 'supplier');
                                            foreach ($product3['res'] as $s_all) {
                                                $selected = in_array($s_all['id'], $selectedSuppliers) ? 'selected' : '';
                                                $output .= '<option value="'.$s_all['id'].'" '.$selected.'>'.$s_all['supplier_name'].'</option>';
                                            }
                                        }
                $output .=          '</select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Image <span class="text-danger">(*Note: Leave this blank if you dont change image)</span></label>
                                        <input type="file" class="form-control" name="img" accept="image/*">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description"  class="form-control" id="" cols="3" rows="2">'.$value['description'].'</textarea>
                                    </div>
                                </div>';
                }
            }else{
                $output .= 'NO DATA';
            }
            break;
        case 'check_out':
            $table = "SELECT * FROM tbl_cart as a 
            LEFT JOIN products as b ON a.product_id = b.id
            WHERE 
            a.time_order = $time_order";
            $product = fetchItem($table);
            $sub_total = 0;
            if ($product['res_count'] > 0) {
                $discountInput = ($discountInput == '') ? 0 : $discountInput ;
                foreach ($product['res'] as $key => $value) {
                    $total = $value['qty'] * $value['price'];
                    $sub_total += $total;
                    $output .= '<tr>';
                        $output .= '<td>'.$x++.'</td>';
                        $output .= '<td>'.$value['product_name'].'</td>';
                        $output .= '<td>'.$value['qty'].'</td>';
                        $output .= '<td>'.number_format($value['price'],2).'</td>';
                        $output .= '<td>'.number_format($total, 2).'</td>';
                    $output .= '</tr>';
                }
                $output .= '<tr>';
                    $output .= '<td scope="row" colspan="4" style="text-align:right">Sub Total:</td>';
                    $output .= '<th scope="row" style="text-align:left">₱'.number_format($cartSubtotal, 2).'</th>';
                $output .= '</tr>';

                $output .= '<tr>';
                    $output .= '<td scope="row" colspan="4" style="text-align:right">Discount:</td>';
                    $output .= '<th scope="row" id="discountedOrder" style="text-align:left">'.$discountInput.'%</th>';
                $output .= '</tr>';

                $output .= '<tr>';
                    $output .= '<td scope="row" colspan="4" style="text-align:right">Grand Total: </td>';
                    $output .= '<th scope="row" style="text-align:left">₱'.number_format($cartTotal, 2).'</th>';
                $output .= '</tr>';
                
            }else{
                $output .= '<tr>';
                $output .= '<td colspan="5" class="text-center">NO PRODUCT FOUND</td>';
                $output .= '</tr>';
            }
            break;
        case 'proceed_to_payment':
            $query = "
                        UPDATE products AS p
                        JOIN (
                            SELECT c.product_id, c.qty
                            FROM tbl_cart AS c
                            WHERE c.time_order = $time_order
                        ) AS cart_items ON p.id = cart_items.product_id
                        SET p.stocks = p.stocks - cart_items.qty
                    ";
            $res = setUpOnQery('edit', $query);
            if ($res) {
                $output = 'Success';   
                // $data = array(
                //     'time_order' => $time_order
                // );
                // $delete_data = delete_data('tbl_cart',$data);
                $data = array(
                    'status' => 'completed',
                    'discounted' => $discountInput,
                    'date_order' => date('Y-m-d H:i:s'),
                );
                $where = array(
                    'time_order' => $time_order
                );
                $result = update_data('tbl_cart',$data,$where);
                if ($result) {
                    $output = 'Success';   
                }else{
                    $output = '';   
                }
            }else{
                $output = '';   
            }        
            break;
        default:
            $output .= 'NO DATA';
            break;
    }
    $response = array(
        'content'=>$output,
    );
    echo json_encode($response);
}


//chat system 
//if (isset($chats)) {
//    $output = '';
//    $total = 0;
//   $x = 1;
//    $chat_with = '';
//    switch ($chats) {
//       case 'contact_list':
//            $table = "SELECT * FROM users where id != ".$_SESSION['user']['id']."";
//            $product = fetchItem($table);
//            if ($product['res_count'] > 0) {
//                foreach ($product['res'] as $key => $value) {
//                    $output .= '<tr style="cursor:pointer" id = "pick-person" data-id="'.$value['id'].'">';
//                        $output .= '<td colspan="4" class="text-center">'.$value['id'].'</td>';
//                        $output .= '<td colspan="4" class="text-center">'.$value['first_name'].' '.$value['last_name'].'</td>';
//                    $output .= '</tr>';
//                }
//            }else{
//                $output .= 'NO DATA';
//           }
//          break;
//        case 'pick_chat':
//            $con1 = $_SESSION['user']['id'] .'|'. $id;
//            $con2 = $id .'|'. $_SESSION['user']['id'];
//            $table = "SELECT * FROM tbl_rooms WHERE users = '".$con1."' OR users = '".$con2."'";
//            $product = fetchItem($table);
//            if ($product['res_count'] > 0) {
//                $table2 = "SELECT * FROM tbl_chats a inner join users b on a.send_by = b.id WHERE room_id = '".$product['res'][0]['room_id']."'";
//                $product2 = fetchItem($table2);
//                $output .= '<input type="hidden" id="room_id" value="'.$product['res'][0]['room_id'].'"/>';
//                $output .= '<input type="hidden" id="ka_talk" value="'.$id.'"/>';
//                $table3 = "SELECT * FROM users where id = $id";
//                $product3 = fetchItem($table3);
//                if ($product2['res_count'] > 0) {
//                    foreach ($product2['res'] as $key => $value) {
//                        $name = ($value['send_by'] == $_SESSION['user']['id']) ? 'YOU' : $value['first_name'].' '.$value['last_name'];
//                       if ($value['send_by'] == $_SESSION['user']['id']) {
//                            $output .= '<div class="row msg_container base_sent">
//                                            <div class="col-md-10 col-xs-10">
//                                                <div class="messages msg_sent">
//                                                <h5>'.$name.'</h5>
//                                                <p>'.$value['msg'].'</p>
//                                                </div>
//                                            </div>
//                                            <div class="col-md-2 col-xs-2 avatar">
//                                                <img src="https://bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
//                                            </div>
//                                        </div>';
//                        } else {
//                        $output .= '<div class="row msg_container base_receive">
//                                        <div class="col-md-2 col-xs-2 avatar">
//                                            <img src="http://bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
//                                        </div>
//                                        <div class="col-md-10 col-xs-10">
//                                            <div class="messages msg_receive">
//                                               <h5>'.$name.'</h5>
//                                                <p>'.$value['msg'].'</p>
//                                                <time style = "display:none" datetime="2009-11-13T20:00">Timothy • 51 min</time>
//                                            </div>
//                                        </div>
//                                   </div>';
//                        }
//                    }
//
//                }else{
//                    $output .= '<h3 style="text-align:center">NO CONVERSATION</h3>';
//                }
//                $chat_with = $product3['res'][0]['first_name'].' '.$product3['res'][0]['last_name'];
//            }else{
//                $data = array(
//                    'users' => $con1,
//                );
//                $insert_data = insert_data('tbl_rooms',$data);
//               $output .= '<h3 style="text-align:center">NO CONVERSATION</h3>';
//            }
//            break;
//        case 'send_msg':
//            $data = array(
//                'room_id' => $room_id,
//                'msg' => $msg,
//                'send_by' => $_SESSION['user']['id'],
//            );
//            $insert_data = insert_data('tbl_chats',$data);
//            $output .= 'msg send';
//            break;
//        default:
//            $output .= 'ERROR 404';
//            break;
//    }
//    $response = array(
//        'content'=>$output,
//        'chat_with'=>$chat_with,
//    );
//    echo json_encode($response);
//}



//view product update
if (isset($updateProduct)) {
    // $new_status = $stocks <= 5 ? 1 : 0; //dari
    // if ($stocks <= 5 && $status == 1) {
    //    $new_status = 0;
    // }else{
       $new_status = 0;
    // }
    if (isset($_FILES['img']) && $_FILES['img']['error'] !== UPLOAD_ERR_NO_FILE) {
        $target_dir = "uploads/products/";
        $file_data = $_FILES['img'];
        $value = NULL;
        $file_data = $_FILES['img'];
        if($file_data['tmp_name'] !== ''){	
            $file_name = $file_data['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = 'product-' . time()  . '.' . $file_ext;


            $check = getimagesize($file_data['tmp_name']);
            // Move the file
            if($check){
                if(move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)){
                    // Save the file_name to the database. 
                    $value = $file_name;
                }
            }
        }
        $data = array(
            'item_code' => $item_code,    
            'product_name' => $product_name,
            'category' => $category,
            'stocks' => $stocks,
            'p_location' => $p_location,
            'price' => $price,
            'img' => $value,
            'description' => $description,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $new_status
        );
    }else{
        $data = array(
            'item_code' => $item_code,    
            'product_name' => $product_name,
            'category' => $category,
            'stocks' => $stocks,
            'p_location' => $p_location,
            'price' => $price,
            'description' => $description,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $new_status
        );
    }
    $where = array(
        'id' => $updateProduct
    );
    $result = update_data('products',$data,$where);

    $data2 = array(
        'product' => $updateProduct
    );
    $delete_data = delete_data('productsuppliers',$data2);

    if ($result && $delete_data) {
        foreach ($suppliers as $key => $value) {
            $data3 = array(
                'supplier' => $value,
                'product' => $updateProduct,
            );
            $insert_data = insert_data('productsuppliers',$data3);
        }
        $_SESSION['response_update_product'] = '<div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong>Success!</strong> Product updated.
                                                </div>';
        header('location: product-view.php');
    }
}


//for emailing
if (isset($phpmailer)) {
    include_once('phpMailer/PHPMailer.php');
    include_once('phpMailer/SMTP.php');
    include_once('phpMailer/Exception.php');
    if ($phpmailer != 'send_email') {
        $code = rand(1000, 9999);
        $response['msg'] = false;
        $eq = ($phpmailer == 'v_code') ? 'AND v_code = '.$v_code.'' : '' ;
        $q = "SELECT id FROM users WHERE email = '".$email."' $eq";
        $r1 = fetchItem($q);
        if ($r1['res_count'] > 0) {
            switch ($phpmailer) {
                case 'send_code':
                    $data = array(
                        'v_code' => $code
                    );
                    $where = array(
                        'id' => $r1['res'][0]['id']
                    );
                    $result = update_data('users',$data,$where);
                    $msj = 'Your verification code is: '. $code;
                    $mail = new PHPMailer\PHPMailer\PHPMailer();
                    $mail->IsSMTP(); // enable SMTP
                    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
                    $mail->Mailer = "smtp";
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 465;
                    $mail->Username = decryptData('Ysggl+aSeIAnPcYWgh/NIoVNfXbIFv45FTmmWbWaAsc=');
                    $mail->Password = decryptData('F6g6dLaLhrMxba83MAdYfwh03EgV/ydykdB5ZX2Sfgw=');
                    $mail->Priority = 1;
                    $mail->SetFrom("admin@msunaawan.edu.ph","Verification Code");
                    $mail->Subject = "Verification Code";
                    $mail->MsgHTML($msj);
                    $mail->addAddress($email, 'reciever_name'); //test@gmail.com
                    if($mail->Send()){
                        $response['msg'] = true;
                    }
                    break;
                case 'v_code':
                    $response['msg'] = true;
                    break;    
                case 'c_pass':
                    $data = array(
                        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
                    );
                    $where = array(
                        'id' => $r1['res'][0]['id']
                    );
                    $result = update_data('users',$data,$where);
                    $response['msg'] = true;
                    break;    
                default:
                    $response['msg'] = false;
                    break;
            }
            
        }else{
            $response['msg'] = true;
        }
    }else{
        $msj = $msg;
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = decryptData('Ysggl+aSeIAnPcYWgh/NIoVNfXbIFv45FTmmWbWaAsc=');
        $mail->Password = decryptData('F6g6dLaLhrMxba83MAdYfwh03EgV/ydykdB5ZX2Sfgw=');
        $mail->Priority = 1;
        $mail->SetFrom($fromEmail,"King Sun - ".$fromEmail);
        $mail->Subject = $subject;
        $mail->MsgHTML($msj);
        $mail->addAddress($toEmail, 'Receiver:'); //test@gmail.com
        if($mail->Send()){
            $response['msg'] = true;
        }
        $response['msg'] = true; 
    }
    echo json_encode($response);
}

//Sales log
if (isset($summarySoldItems)) {
    $where = '';
    if (isset($start) && isset($end)) {
        if (strtotime($start) < strtotime($end)) {
            $where .= "and DATE(date_order) BETWEEN '$start' and '$end'";
        }else{
            if (strtotime($start) == strtotime($end)) {
                $where .= "and DATE(date_order) = '$start'";
            }
        }
    }
    $response['start'] = date('F j, Y',strtotime($start));
    $response['end'] = date('F j, Y',strtotime($end));
    $table = "
    SELECT 
        sub.product_id,
        sub.product_name,
        sub.price_per_item,
        sub.sold_items,
        sub.price_per_item * sub.sold_items_sum AS total_sum
    FROM (
        SELECT 
            a.product_id,
            b.product_name,
            b.price AS price_per_item,
            SUM(a.qty) AS sold_items,
            SUM(b.price) AS price_per_item_sum,
            SUM(a.qty) AS sold_items_sum
        FROM
            tbl_cart a 
        LEFT JOIN
            products b ON a.product_id = b.id
        where a.status = 'completed' $where
        GROUP BY a.product_id, b.product_name, b.price
    ) AS sub
    ";
    $x = 1;
    $output = '';
    $grand_total = 0;
    $product = fetchItem($table);
    if ($product['res_count'] > 0) {
        foreach ($product['res'] as $key => $value) {
            $grand_total += $value['total_sum'];
            $output .= '<tr style="cursor:pointer">';
                $output .= '<td class="text-center">'.$x++.'</td>';
                $output .= '<td class="text-left">'.$value['product_name'].'</td>';
                $output .= '<td class="text-left">₱'.number_format($value['price_per_item'],2).'</td>';
                $output .= '<td class="text-left">'.$value['sold_items'].' pcs</td>';
                $output .= '<td class="text-left">₱'.number_format($value['total_sum'],2).'</td>';
            $output .= '</tr>';
        }
        $output .= '<tr>
                        <th scope="row" colspan="4" class="text-right">TOTAL:</th>
                        <td class="text-left">₱'.number_format($grand_total).'.00</td>
                    </tr>';
        $response['msg'] = true;
    }else{
        $response['msg'] = true;
        $output .= '<tr style="cursor:pointer">';
        $output .= '<td colspan="5" class="text-center">NO DATA</td>';
        $output .= '</tr>';
    }
    if (strtotime($start) > strtotime($end)) {
        $response['msg'] = false;
    }
    $response['output'] = $output;

    echo json_encode($response);
}

//Receipt logs
if (isset($customerReceipt)) {
    $where = '';
    if (isset($start) && isset($end)) {
        if (strtotime($start) < strtotime($end)) {
            $where .= "and DATE(date_order) BETWEEN '$start' and '$end'";
        }else{
            if (strtotime($start) == strtotime($end)) {
                $where .= "and DATE(date_order) = '$start'";
            }
        }
    }
    $response['start'] = date('F j, Y',strtotime($start));
    $response['end'] = date('F j, Y',strtotime($end));
    $table = "
    SELECT DISTINCT time_order, date(date_order) as date
    FROM tbl_cart where status = 'completed' and date_order is not null $where
    ";
    $x = 1;
    $output = '';
    $grand_total = 0;
    $product = fetchItem($table);
    if ($product['res_count'] > 0) {
        foreach ($product['res'] as $key => $value) {
            $output .= '<tr style="cursor:pointer">';
                $output .= '<td class="text-left">
                Date: '.date('F j, Y',strtotime($value['date'])).'
                <br>Customer '.$x++.'</td>';
                $output .= '<td class="text-left"><a target="_blank" href="database/report_pdf.php?report=collect_receipts&time_order='.$value['time_order'].'"><button type="button"  id="pdf-summarySoldItems" class="btn btn-sm btn-info no-print">PDF</button></a></td>';
            $output .= '</tr>';
        }
        $response['msg'] = true;
    }else{
        $response['msg'] = true;
        $output .= '<tr style="cursor:pointer">';
        $output .= '<td colspan="3" class="text-center">NO DATA</td>';
        $output .= '</tr>';
    }
    if (strtotime($start) > strtotime($end)) {
        $response['msg'] = false;
    }
    $response['output'] = $output;

    echo json_encode($response);
}

/*Notification */
if (isset($notification)) {
    if ($notification == 'readProudct') {
        //$new_status = $stocks <= 5 ? 1 : 0; dari

        $data = array(
            'status' => 1,
            'click_notif' => 1  //1 means wala pa na read else na read
        );
        $where = array(
            'id' => $id
        );
        $result = update_data('products',$data,$where);
    }else{
        $table = "
        SELECT * FROM products where stocks <= 5 and deleted = 0
        ";
        $x = 1;
        $output = '';
        $grand_total = 0;
        $product = fetchItem($table);
        $count = fetchItem('SELECT * FROM products where stocks <= 5 and status = 0');
        if ($product['res_count'] > 0) {
            foreach ($product['res'] as $key => $value) {
                if ($value['status'] == 0) {
                $output .= '<li style="margin-top:10px;">
                                <a id= "clickNotif" data-id = "'.$value['id'].'" class="dropdown-item" href="product-view.php?productName='.$value['product_name'].'"> 
                                <img src="uploads/products/'.$value['img'].'" alt="Image" class="left-img">
                                <span class="text">'.$value['product_name'].' <span class="label label-danger">UNREAD</span><br>REMAINING STOCK '.$value['stocks'].'<br>&#160;</span>
                                </a>
                            </li>';
                } else {
                $output .= '<li style="margin-top:10px;">
                                <a id= "clickNotif" data-id = "'.$value['id'].'" class="dropdown-item" href="product-view.php?productName='.$value['product_name'].'"> 
                                <img src="uploads/products/'.$value['img'].'" alt="Image" class="left-img">
                                <span class="text">'.$value['product_name'].' <span class="label label-success">READ</span><br>REMAINING STOCK '.$value['stocks'].'<br>&#160;</span>
                                </a>
                            </li>';
                }
            }
        }else{
            $output .= '';
        }
        $response['count'] = $count['res_count'];
        $response['output'] = $output;
    
        echo json_encode($response);
    }
}


//Delete History
function selectModule($table){
    $table = "SELECT * FROM $table where deleted = 1";
    return fetchItem($table);
}
if (isset($historys_view)) {
    $x = 1;
    $data = [];
    $product = selectModule('users');
    if ($product['res_count'] > 0) {
        foreach ($product['res'] as $key => $value) {
            $data[] = [
                '#' => $x++,
                'module_name' => 'User',
                'desc' => 'Full name: '.$value['first_name'].' '.$value['last_name'].'
                <br> Role: '.$value['role'].'
                <br> Email: '.$value['email'].'',      
                'deleted_at' =>  date('M d,Y @ h:i:s A', strtotime($value['deleted_at'])),
                'action' => '<div class="btn-group" role="group" aria-label="...">
                                <button type="button" id="restore" data-table_name="users" data-primary_id="'.$value['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-history"></i>  Restore</button>
                                <button type="button" id="delete_perma" data-table_name="users" data-primary_id="'.$value['id'].'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </div>'
            ];
        }
    }
    $product2 = selectModule('suppliers');
    if ($product2['res_count'] > 0) {
        foreach ($product2['res'] as $key => $value) {
            $data[] = [
                '#' => $x++,
                'module_name' => 'Supplier',
                'desc' => 'Supplier name: '.$value['supplier_name'].'
                <br> Supplier Location: '.$value['supplier_location'].'
                <br> Contact Details: '.$value['email'].'/'.$value['c_number'].'',     
                'deleted_at' =>  date('M d,Y @ h:i:s A', strtotime($value['deleted_at'])),
                'action' => '<div class="btn-group" role="group" aria-label="...">
                                <button type="button" id="restore" data-table_name="suppliers" data-primary_id="'.$value['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-history"></i>  Restore</button>
                                <button type="button" id="delete_perma" data-table_name="suppliers" data-primary_id="'.$value['id'].'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </div>'
            ];
        }
    }
    $product3 = selectModule('products');
    if ($product3['res_count'] > 0) {
        foreach ($product3['res'] as $key => $value) {
            $data[] = [
                '#' => $x++,
                'module_name' => 'Product',
                'desc' => 'Item code: '.$value['item_code'].'
                <br> Product_name: '.$value['product_name'].'
                 <br> Description: '.$value['description'].'
                 <br> Category: '.$value['category'].'',     
                'deleted_at' =>  date('M d,Y @ h:i:s A', strtotime($value['deleted_at'])),
                'action' => '<div class="btn-group" role="group" aria-label="...">
                                <button type="button" id="restore" data-table_name="products" data-primary_id="'.$value['id'].'" class="btn btn-primary btn-sm"><i class="fas fa-history"></i>  Restore</button>
                                <button type="button" id="delete_perma" data-table_name="products" data-primary_id="'.$value['id'].'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                            </div>'
            ];
        }
    }
    echo json_encode(['data' => $data]);
}

//Restore deleted file history
if(isset($restore_data)){
    if ($restore_data == 'RESTORE') {
        $data = array(
            'deleted' => 0,
        );
        $where = array(
            'id' => $id
        );
        $result = update_data($table_name,$data,$where);
        $response['msg'] = $result ? 'Restore Success' : 'Error message!';
    }
    if ($restore_data == 'delete') {
        if($table_name === 'suppliers' || $table_name === 'products'){
            $data = array(
                'id' => $id
            );
            $result = delete_data('productsuppliers',$data);
		}
        $data = array(
            'id' => $id
        );
        $result = delete_data($table_name,$data);
        $response['msg'] = $result ? 'Restore Success' : 'Error message!';
    }
    echo json_encode($response);
}
?>
