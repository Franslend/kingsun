<?php
	// Start the session.
	session_start();
	if(isset($_SESSION['user'])) header('location: dashboard.php');

	$error_message = '';

	if($_POST){
		include('database/connection.php');

		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = 'SELECT * FROM users WHERE users.email="'. $username .'" AND users.password="'. $password .'"';
		$stmt = $conn->prepare($query);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$user = $stmt->fetchAll()[0];

			// Captures data of currrently login users.
			$_SESSION['user'] = $user;

			header('Location: dashboard.php');
		} else $error_message = 'Please make sure that username and password are correct.';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>KIS Login - Product Management System</title>

	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body id="loginBody">

	<div class="container">
		<div class="loginHeader">
			<h1>IMS</h1>
			<p>KingSun Inventory System</p>
		</div>
		<div class="loginBody">
		<form action="login.php" method="POST">
					<?php if(!empty($error_message)) { ?>
						<div id="errorMessage">
							<p>Error: <?= $error_message ?> </p>
						</div>
					<?php } ?>
				<div class="form-control">
					<input type="text" name="username" required="">
					<label>
						<span style="transition-delay:0ms">U</span>
						<span style="transition-delay:50ms">s</span>
						<span style="transition-delay:100ms">e</span>
						<span style="transition-delay:150ms">r</span>
						<span style="transition-delay:200ms">n</span>
						<span style="transition-delay:250ms">a</span>
						<span style="transition-delay:300ms">m</span>
						<span style="transition-delay:350ms">e</span>
					</label>
	            </div>
				<div class="form-pass">
					<input type="password" name="password" required="">
					<label>
					    <span style="transition-delay:0ms">P</span>
						<span style="transition-delay:50ms">a</span>
						<span style="transition-delay:100ms">s</span>
						<span style="transition-delay:150ms">s</span>
						<span style="transition-delay:200ms">w</span>
						<span style="transition-delay:250ms">o</span>
						<span style="transition-delay:300ms">r</span>
						<span style="transition-delay:350ms">d</span>
					</label>
	            </div>
				<div class="loginButtonContainer"> 
                    <button>login</button> 
                </div> 
			</form>
		</div>
	</div>
</body>
</html>