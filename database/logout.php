<?php
	session_start();

	// remove all session variables
	session_unset();

	// destroy session
	session_destroy();

	// Redirect to the login page
	header('location: ../login.php');
?>