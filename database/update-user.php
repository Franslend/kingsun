<?php
	$data = $_POST;
	$user_id  = (int) $data['userId'];
	$first_name  = $data['f_name'];
	$last_name  = $data['l_name'];
	$email = $data['email'];
	$c_number = $data['c_number'];

	// Adding the record.
	try {			
		$sql = "UPDATE users SET email=?,  c_number=?, first_name=?, last_name=?, updated_at=? WHERE id=?";
		include('connection.php');
		$conn->prepare($sql)->execute([$email,$c_number, $first_name, $last_name, date('Y-m-d h:i:s'), $user_id]);
		echo json_encode([
 			'success' => true,
 			'message' => $first_name . ' ' . $last_name . ' successfully updated.'
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
 			'message' => 'Error processing your request!'
		]);
	}
?>

