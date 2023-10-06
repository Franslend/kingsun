<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');
	$_SESSION['table'] = 'users';
	$_SESSION['redirect_to'] = 'users-add.php';

	$show_table = 'users';
	$users = include('database/show.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add User - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
</head>
<?php
function generateFiveDigitNumber() {
    // Generate a random number between 10000 and 99999 (inclusive)
    $randomNumber = rand(10000, 99999);
    
    return $randomNumber;
}
?>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">		
					<div class="row">
						<div class="column column-12">
							<h1 class="section_header"> Create User</h1>
							<div id="userAddFormContainer">						
								<form action="database/add.php" method="POST" class="appForm">
									<div class="appFormInputContainer">
										<label for="first_name">First Name</label>
										<input type="hidden" class="awd" id="employee_id" name="employee_id" value = "0<?= generateFiveDigitNumber() ?>" required=""/>	

										<input type="text" class="appFormInput" id="first_name" name="first_name" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="last_name">Last Name</label>
										<input type="text" class="appFormInput" id="last_name" name="last_name" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="role">Role</label>
										<select class="appFormInput" id="role" name="role" required="">
											<option value="manager">Manager</option>
											<option value="employee">Employee</option>
										</select>
									</div>
									<div class="appFormInputContainer">
										<label for="email">Email</label>
										<input type="text" class="appFormInput" id="email" name="email" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="c_number">Phone number</label>
										<input type="text" class="appFormInput" id="c_number" name="c_number" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="password">Password</label>
										<input type="password" class="appFormInput" id="password" name="password" required="" />	
									</div>
									<button type="submit" class="appBtn"><i class="fa fa-plus"></i> Add User</button>
								</form>	
								<?php 
									if(isset($_SESSION['response'])){
										$response_message = $_SESSION['response']['message'];
										$is_success = $_SESSION['response']['success'];
								?>
									<div class="responseMessage">
										<p class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>" >
											<?= $response_message ?>
										</p>
									</div>
								<?php unset($_SESSION['response']); }  ?>
							</div>	
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
	<?php include('partials/app-scripts.php'); ?>
</body>
</html>
