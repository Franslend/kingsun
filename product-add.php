<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');

	$_SESSION['table'] = 'products';
	$_SESSION['redirect_to'] = 'product-add.php';

	$user = $_SESSION['user'];

	$categories = ['Freon', 'Evaporator', 'Compressor', 'Capacitor', 'Dryer', 'Rubber Insolation Tube', 'Cabin Filter', 'Resistor Block', 'Others'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Product - KingSun Inventory System</title>
	<?php include('partials/app-header-scripts.php'); ?>
</head>

<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">		
					<div class="row">
						<div class="column column-12" style="height: 600px; overflow: auto;">
							<h1 class="section_header"> Create Product</h1>
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
							<div id="userAddFormContainer">						
								<form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
								<?php
												$show_table = 'products';
												$products = include('database/show.php');

												// foreach($products as $product){
												// 	echo "<option value='".  $supplier['id']  . "'> ".$supplier['supplier_name'] ."</option>";
												// }
											?>
										<input type="hidden" name="id" value = "<?= max(array_column($products, 'id')) + 1 ?>" required="" />
									<div class="appFormInputContainer">
										<label for="item_code">Item code</label>
										<input type="text" class="appFormInput" id="item_code" placeholder="Enter Item code..." name="item_code" required="" />	
									</div>	
									<div class="appFormInputContainer">
										<label for="product_name">Product Name</label>
										<input type="text" class="appFormInput" id="product_name" placeholder="Enter product name..." name="product_name" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="category">Product Category:</label>
									</div>
									<div class="appFormInputContainer categoryContainer" style="max-height: 150px; overflow-y: auto;">
									<select name="category" class="appFormInput">
										<!-- <?php
										$columnCount = 0;
											foreach ($categories as $category) {
												if ($columnCount % 3 == 0) {
													echo '<div class="categoryColumn">';
												}
												?>
												<div>
													<input type="checkbox" name="categories[]" value="<?php echo $category; ?>">
													<label><?php echo $category; ?></label>
												</div>
												<?php
												$columnCount++;
												if ($columnCount % 3 == 0 || $columnCount == count($categories)) {
													echo '</div>';
												}
											}
										?> -->
										<option value="">Select Category</option>
										<?php foreach ($categories as $category) { ?>
											<option value="<?= $category ?>"> <?= $category ?> </option>
										<?php } ?>
										</select>
									</div>
									<div class="appFormInputContainer">
										<label for="description">Description</label>
										<textarea class="appFormInput productTextAreaInput" placeholder="Enter product description..." id="description" name="description"></textarea>	
									</div>
									<div class="appFormInputContainer">
										<label for="price">Product Stocks</label>
										<input type="number" class="appFormInput" id="stocks" placeholder="Enter product stocks..." name="stocks" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="price">Product Price</label>
										<input type="number" class="appFormInput" id="price" placeholder="Enter product price..." name="price" required="" />	
									</div>
									<div class="appFormInputContainer">
										<label for="description">Suppliers</label>
										<select name="suppliers[]" id="suppliersSelect" multiple="">
											<option value="" disabled>Select Supplier</option>
											<?php
												$show_table = 'suppliers';
												$suppliers = include('database/show.php');

												foreach($suppliers as $supplier){
													echo "<option value='".  $supplier['id']  . "'> ".$supplier['supplier_name'] ."</option>";
												}
											?>
										</select>
									</div>
									<div class="appFormInputContainer">
										<label for="product_name">Product Image</label>
										<input type="file" name="img" accept="image/*"/>
									</div>

									<button type="submit" class="appBtn"><i class="fa-fa-plus"></i> Create Product</button>
								</form>	

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
