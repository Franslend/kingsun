<?php
	$data = $_POST;
	$user_id  = (int) $data['userId'];
	$first_name  = $data['f_name'];
	$last_name  = $data['l_name'];
	$role  = $data['role'];
	$expertise = $data['expertise'];
	$email = $data['email'];
	$c_number = $data['c_number'];

	// Adding the record.
	try {			
		$sql = "UPDATE users SET expertise=?, email=?, c_number=?, first_name=?, last_name=?, role=?, updated_at=? WHERE id=?";
		include('connection.php');
		$conn->prepare($sql)->execute([$expertise, $email, $c_number, $first_name, $last_name, $role, date('Y-m-d h:i:s'), $user_id]);
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

