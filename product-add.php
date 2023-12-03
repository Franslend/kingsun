<?php
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');
	date_default_timezone_set('Asia/Manila');

	$_SESSION['table'] = 'products';
	$_SESSION['redirect_to'] = 'product-view.php';

	$user = $_SESSION['user'];

	//Fetching data
	require_once('database/category-conn.php');
	$query = "select * from categories";
	$result = mysqli_query($con, $query);

	$categories = array(); // This will be used for the dropdown
	$categoryTableData = array(); // This will be used for displaying in the table
	
	while ($row = mysqli_fetch_assoc($result)) {
		$categories[] = $row['category_name'];
	
		// You can also store the entire row for use in the table section
		$categoryTableData[] = $row;
	}
	

	// Check if the form is submitted for adding a new category
	if(isset($_POST['category_name'])) {
		$newCategoryName = $_POST['category_name'];
		$insertCategoryQuery = "INSERT INTO categories (category_name) VALUES ('$newCategoryName')";
		mysqli_query($con, $insertCategoryQuery);
		header('location: product-add.php'); // Replace with the actual page name
		exit();
	}
	
	// Check if the delete button is clicked
	if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
		$categoryId = $_GET['id'];
		$deleteCategoryQuery = "DELETE FROM categories WHERE cat_id = '$categoryId'";
		mysqli_query($con, $deleteCategoryQuery);
		header('location: product-add.php'); // Replace with the actual page name
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Product - KingSun Inventory System</title>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<style>
		/* Add your custom styles here */
		#categoryAddFormContainer {
			margin-top: 20px;
		}

		.categoryFormInputContainer {
			margin-bottom: 20px;
		}

		.categoryFormInput {
			width: 100%;
			padding: 10px;
			box-sizing: border-box;
		}

		.categoryBtn {
			background-color: #28a745;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
	</style>
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
							<div class="col-md-6" style="height: 597px; overflow: auto;">
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
									<form action="database/add-message.php" method="POST" class="appForm" enctype="multipart/form-data">
									<?php
													$show_table = 'products';
													$products = include('database/show.php');

													// foreach($products as $product){
													// 	echo "<option value='".  $supplier['id']  . "'> ".$supplier['supplier_name'] ."</option>";
													// }
												?>
											<input type="hidden" name="id" value="<?= max(array_column($products, 'id')) + 1 ?>" required="" />
										<div class="appFormInputContainer">
											<label for="item_code">Item code</label>
											<input type="text" class="appFormInput" id="item_code" placeholder="Enter Item code..." name="item_code" required="" />	
										</div>
										<div class="appFormInputContainer">
											<label for="p_location">Product Location</label>
											<input type="text" class="appFormInput" id="p_location" placeholder="Enter Item location" name="p_location" required="" />	
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

										<button type="submit" class="appBtn btn btn-primary"><i class="fas fa-plus"></i> Create Product</button>
									</form>	
								</div>	
							</div>

							<!--For add category-->
							<div class="col-md-6" style="height: 597px; overflow: auto;">
								<h1 class="section_header">Add Category</h1>
								<div id="addCategorySectionContainer">
								<div id="categoryAddFormContainer">
									<form action="" method="POST" class="appForm" id="addCategoryForm" onsubmit="return confirmAddCategory()">
										<div class="categoryFormInputContainer">
											<label for="category_name">Category Name</label>
											<input type="text" class="categoryFormInput" placeholder="Enter category name..." name="category_name" required="" />
										</div>
										<div style="float:right; padding-bottom: 10px;">
											<button type="submit" class="categoryBtn btn btn-primary"><i class="fas fa-plus"></i> Add Category</button>
										</div>

										<!-- Table for displaying categories -->
										<table class="table mt-4">
											<thead>
												<tr>
													<th>#</th>
													<th>Category Name</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$counter = 1; // Initialize a counter for displaying sequential numbers
													foreach ($categoryTableData as $row) {
												?>
													<tr>
														<td><?php echo $counter; ?></td>
														<td><?php echo $row['category_name']; ?></td>
														<td>
															<button type="button" class="updateCategory btn btn-primary" data-toggle="modal" data-target="#editCategoryModal" data-id='<?php echo $row['cat_id']; ?>'>
																Edit
															</button>
															<a href='#' class='deleteCategory btn btn-danger' data-id='<?php echo $row['cat_id']; ?>' data-name='<?php echo $row['category_name']; ?>'>
																Delete
															</a>
														</td>
													</tr>
												<?php
													$counter++; // Increment the counter for the next iteration
												}
												 // Display the newly added category at the last row
												if (isset($_POST['category_name'])) {
													?>
														<tr>
															<td><?php echo $counter; ?></td>
															<td><?php echo $_POST['category_name']; ?></td>
															<td>
																<button type="button" class="updateCategory btn btn-primary" data-toggle="modal" data-target="#editCategoryModal" data-id='<?php echo $row['cat_id']; ?>'>
																	Edit
																</button>
																<a href='#' class='deleteCategory btn btn-danger' data-id='<?php echo $row['cat_id']; ?>' data-name='<?php echo $row['category_name']; ?>'>
																	Delete
																</a>
															</td>
														</tr>
													<?php
												}
												?>
											</tbody>
										</table>

									</form>
								</div>
								</div>
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Add this modal markup -->
	<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header" style="background-color: #337AB7">
					<h5 class="modal-title text-light" id="editCategoryModalLabel">Edit Category:</h5>
					<p id="selectedCategoryName"></p>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="get-category.php" method="POST" class="appForm" id="editCategoryForm">
						<input type="hidden" id="category_id" name="category_id" value="">
						<div class="form-group">
							<label for="edit_category_name">Category Name:</label>
							<input type="text" class="form-control" placeholder="Enter category name..." name="edit_category_name" id="edit_category_name" required="">
						</div>
						<div style="float: right; padding-bottom: 10px;">
							<button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php include('partials/app-scripts.php'); ?>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    // Ensure that the document is fully loaded
    $(document).ready(function() {
        // Delete category function
        $(".deleteCategory").click(function() {
            var categoryId = $(this).data('id');
            var categoryName = $(this).data('name');

            // Confirm deletion
            if (confirm("Are you sure you want to delete category '" + categoryName + "'?")) {
                // Perform asynchronous deletion
                $.ajax({
                    type: "GET",
                    url: "product-add.php?action=delete&id=" + categoryId,
                    success: function(response) {
                        // Refresh the page after successful deletion
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        alert("Error deleting category.");
                    }
                });
            }
        });

        // Update category name in the modal header
        function updateCategoryName(categoryName) {
            $("#selectedCategoryName").text(categoryName);
        }

        // Edit category function
		$(".updateCategory").click(function() {
			var categoryId = $(this).data('id');
			var categoryName = $(this).closest('tr').find('td:eq(1)').text(); // Get the category name from the table row

			// Fetch category details for the selected category
			$.ajax({
				type: "GET",
				url: "get-category.php?id=" + categoryId,
				success: function(response) {
					var categoryDetails = JSON.parse(response);

					// Populate the modal with category details
					$("#editCategoryModal #category_id").val(categoryDetails.cat_id);
					$("#editCategoryModal #edit_category_name").val(categoryDetails.category_name);

					// Set the modal header text and style
					$("#editCategoryModal #editCategoryModalLabel").text("Edit Category: ");
					$("#editCategoryModal #selectedCategoryName").html(categoryName + ' &nbsp;').css({"color": "white", "font-weight": "bold"});

					// Show the modal
					$("#editCategoryModal").modal('show');
				},
				error: function(error) {
					console.log(error);
					alert("Error fetching category details.");
				}
			});
		});

        // Handle form submission for updating category
        $("#editCategoryForm").submit(function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Perform asynchronous update
            $.ajax({
                type: "POST",
                url: "update-category.php",
                data: $(this).serialize(), // Serialize the form data
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    if (response.success) {
                        // Update successful, you can display a success message or take other actions
                        alert(response.message);

                        // Close the modal
                        $("#editCategoryModal").modal('hide');

                        // Remove modal backdrop to fix the overlay issue
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();

                        location.reload();
                    } else {
                        // Update failed, display an error message or take appropriate actions
                        alert("Error updating category.");
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert("Error updating category.");
                }
            });
        });
    });
	    // Confirmation in adding the category
		function confirmAddCategory() {
        return confirm("Are you sure you want to add this category?");
    }
</script>