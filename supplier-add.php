<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');

	$_SESSION['table'] = 'suppliers';
	$_SESSION['redirect_to'] = 'supplier-add.php';

	$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Supplier - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/login.css ?v=<?php echo time(); ?>">
</head>

<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
				<div class="dashboard_content">
					<div class="dashboard_content_main">		
						<div class="row">
							<div class="column column-12">
								<h1 class="section_header"> Create Supplier</h1>
								<div id="userAddFormContainer">						
									<form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
										<div class="appFormInputContainer">
											<label for="s_tin">VAT REG. TIN</label>
											<input type="text" class="appFormInput" placeholder="Enter supplier TIN..." id="s_tin" name="s_tin" required="" >
										</div>
										<div class="appFormInputContainer">
											<label for="supplier_name">Supplier Name</label>
											<input type="text" class="appFormInput" id="supplier_name" placeholder="Enter supplier name..." name="supplier_name" required="" />	
										</div>
										<div class="appFormInputContainer">
											<label for="supplier_location">Location</label>
											<input type="text" class="appFormInput" placeholder="Enter product supplier location..." id="supplier_location" name="supplier_location" required="" >
										</div>
										<div class="appFormInputContainer">
											<label for="email">Email</label>
											<input type="text" class="appFormInput" placeholder="Enter supplier email..." id="email" name="email" required="" >
										</div>
										<div class="appFormInputContainer">
											<label for="email">Phone Number</label>
											<input type="number" class="appFormInput" placeholder="Enter supplier number..." id="#" name="c_number" required="" >
										</div>
										<button type="submit" class="appBtn"><i class="fa fa-plus"></i> Create Supplier</button>
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
	</div>
	<?php include('partials/app-scripts.php'); ?>
</body>
</html>