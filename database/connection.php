<?php

	$servername = 'localhost';
	$username = 'root';
	$password = '';


	// Connecting to database.
	try {
		// $conn = new PDO("mysql:host=$servername;dbname=client02", $username, $password);
		$conn = new PDO("mysql:host=$servername;dbname=client02", $username, $password);
		// set the PDO error mode to exception.
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (\Exception $e) {
		$error_message = $e->getMessage();
	}
?>
