<?php

 function update_data($table,$data,$where){
    include('connection.php');
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

	$data = $_POST;
	$id  = (int) $data['id'];
	$table = $data['table'];


	// Adding the record.
	try {
		include('connection.php');

		// Delete junction table 

		// if($table === 'suppliers'){
		// 	$supplier_id = $id;				
		// 	$command = "DELETE FROM productsuppliers WHERE supplier={$id}";
		// 	$conn->exec($command);
		// }

		// if($table === 'products'){
		// 	$supplier_id = $id;				
		// 	$command = "DELETE FROM productsuppliers WHERE product={$id}";
		// 	$conn->exec($command);
		// }

		// Delete main table.
		// $command = "DELETE FROM $table WHERE id={$id}";
		// $conn->exec($command);
		$data = array(
            'deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s') //1 means wala pa na read else na read
        );
        $where = array(
            'id' => $id
        );
        $result = update_data($table,$data,$where);

		echo json_encode([
 			'success' => true,
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
		]);
	}


