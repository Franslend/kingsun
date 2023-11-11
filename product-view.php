<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');

	// Get all products.
	$show_table = 'products';
	$products = include('database/show.php');
	$categories = ['Cabin Filter', 'Capacitor', 'Compressor', 'Compressor Parts', 'Copper Tube', 'Dryer', 'Engine Filter', 'Evaporator', 'Refrigerant', 'Refrigerant Oil', 'Resistor Block', 'Rod', 'Rubber Insulation Tube', 'Others'];
	date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Products - KingSun Inventory System</title>
	<script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/login.css ?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> <!-- error for edit part -->
</head>
<body>
	<style>
        thead th {
            position: sticky;
            top: 0;
        }
	</style>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
				<div class="dashboard_content">
					<div class="dashboard_content_main">		
						<div class="row">
							<div class="column column-12" style="height: 595px; overflow: auto;">
								<h1 class="section_header">List of Products</h1>
								<?php
								if (isset($_SESSION['response_update_product'])) {
									echo $_SESSION['response_update_product'];
									unset($_SESSION['response_update_product']);
								}
								?>
								<div class="reportTypeContainer">
									<div class="reportType">
										<p>Categories</p>
										<div class="categoryContainer">
											<div class="categoryList">
												<select id="categorySelect" onchange="filterProducts(this.value)">
													<option value="all">All</option>
													<?php foreach ($categories as $category) { ?>
														<option value="<?php echo $category; ?>"><?php echo $category; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="reportType">
										<p>Search Products</p>
										<input type="text" id="searchInput" value = "<?= isset($_GET['productName']) ? $_GET['productName'] : '' ?>" placeholder="Enter item code or product name..." style="width: 350px;" oninput="filterProductsBySearch()" />

									</div>
									<div class="reportType">
										<p>Print Report Products</p>
										<div class="alignRight">
											<a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
											<a href="database/report_pdf.php?report=product" class="reportExportBtn">PDF</a>
										</div>
									</div>
								</div>
								<p class="userCount"><?= count($products) ?> products </p>
								<div class="section_content" style="height: 500px; overflow: auto;">
									<div class="users">
										<table>
											<thead>
												<tr>												
													<th>#</th>	
													<th width="0">Item Code</th>				
													<th width="10%">Image</th>
													<th>Product Name</th>
													<th width="8%">Category</th>
													<th width="15%">Description</th>
													<th>Stocks</th>
													<th width="8%">Location</th>
													<th>Price</th>
													<th width="8%">Suppliers</th>
													<th width="8%">Created By</th>
													<th width="10%">Created At</th>
													<th width="10%">Updated At</th>
													<th width="6%">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$stmt = $conn->prepare("SELECT * FROM products where deleted = 0 ORDER BY created_at DESC");
												$stmt->execute();
												$stmt->setFetchMode(PDO::FETCH_ASSOC);
												$products2 = $stmt->fetchAll();
												foreach($products2 as $index => $product){ ?>
													<tr>
														<td><?= $index + 1 ?></td>
														<td class="item_code"><?= $product['item_code'] ?></td>
														<td class="firstName">
															<img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt="" />
														</td>
														<td class="lastName"><?= $product['product_name'] ?></td>
														<td class="lastName"><?= $product['category'] ?></td>
														<td class="email"><?= $product['description'] ?></td>
														<td class="lastName"><?= number_format($product['stocks']) ?></td>
														<td class="lastName"><?= $product['p_location'] ?></td>
														<td class="lastName"><?= number_format($product['price']) ?></td>
														<td class="email">
															<?php
																$supplier_list = '-';

																$pid = $product['id'];
																$stmt = $conn->prepare("
																	SELECT supplier_name ,suppliers.id as suppliers_id
																		FROM suppliers, productsuppliers 
																		WHERE 
																			productsuppliers.product=$pid 
																				AND 
																			productsuppliers.supplier = suppliers.id
																	");
																$stmt->execute();
																$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

																if ($row) {                                                                
																	$supplier_arr = $row; // No need to use array_column now
																	$supplier_list = implode("<br>", array_map(function ($supplier) {
																		return "<a href='#view' id='view-suppliers' data-id='".$supplier['suppliers_id']."'>".$supplier['supplier_name']."</a>";
																	}, $supplier_arr));
																}															
																echo $supplier_list;
															?>
														</td>
														<td>
															<?php
																$uid = $product['created_by'];
																$stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
																$stmt->execute();
																$row = $stmt->fetch(PDO::FETCH_ASSOC);

																$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
																echo $created_by_name;
															?>
														</td>
														<td><?= date('M d,Y @ h:i:s A', strtotime($product['created_at'])) ?></td>
														<td><?= date('M d,Y @ h:i:s A', strtotime($product['updated_at'])) ?></td>
														<td>
															<a href="#edit" class="updateProduct-deleted" id="edit-Product" data-id="<?= $product['id'] ?>"> <i class="fa-regular fa-pen-to-square"></i> Edit</a> | 
															<a href="" class="deleteProduct" data-name="<?= $product['product_name'] ?>" data-pid="<?= $product['id'] ?>"> <i class="fa fa-trash"></i> Delete</a>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="modal fade" id="modal-custom-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade" id="modal-custom-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

<?php 
	include('partials/app-scripts.php'); 

	$show_table = 'suppliers';
	$suppliers = include('database/show.php');

	$suppliers_arr = [];

	foreach($suppliers as $supplier){
		$suppliers_arr[$supplier['id']] = $supplier['supplier_name'];
	}

	$suppliers_arr = json_encode($suppliers_arr);
?>


<script>
var suppliersList = <?= $suppliers_arr ?>;
	function script(){
		var vm = this;
		this.registerEvents = function(){
			document.addEventListener('click', function(e){
				targetElement = e.target; // Target element
				classList = targetElement.classList;

				if(classList.contains('deleteProduct')){
					e.preventDefault(); // this prevents the default mechanism.

					pId = targetElement.dataset.pid;
					pName = targetElement.dataset.name;

					BootstrapDialog.confirm({
						type: BootstrapDialog.TYPE_DANGER,
						title: 'Delete Product',
						message: 'Are you sure to delete <strong>'+ pName +'</strong>?',
						callback: function(isDelete){
							if(isDelete){								
								$.ajax({
									method: 'POST',
									data: {
										id: pId,
										table: 'products'
									},
									url: 'database/delete.php',
									dataType: 'json',
									success: function(data){
										message = data.success ? 
											pName + ' successfully deleted!' : 'Error processing your request!';

										BootstrapDialog.alert({
											type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
											message: message,
											callback: function(){
												if(data.success) location.reload();
											}
										});
									}
								});
							}
						}
					});
				}

				if (classList.contains('updateProduct')) {
					e.preventDefault();

					pId = targetElement.dataset.pid;
					showEditDialog(pId);
				}

				if (classList.contains('updateProudct2')) {
					var form = e.target.closest('form');
					if (!form.checkValidity()) {
						alert('Input is required');
						e.preventDefault();
					}else{
						e.target.closest('form').submit();
					}
				}

			});

			document.addEventListener('submit', function(e){
				e.preventDefault();
				targetElement = e.target;

				if(targetElement.id === 'editProductForm'){
					vm.saveUpdatedData(targetElement);
				}
			})

		},

		this.saveUpdatedData = function(form){
			$.ajax({
				method: 'POST',
				data: new FormData(form),
				url: 'database/update-product.php',
				processData: false,
        		contentType: false,
        		dataType: 'json',
				success: function(data){
					BootstrapDialog.alert({
						type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
						message: data.message,
						callback:function(){
							if(data.success) location.reload();
						}
					});
				}
			});
		},


function showEditDialogs(id) {
    $.get('database/get-product.php', { id: id }, function (productDetails) {
        let curSuppliers = productDetails['suppliers'];
        let supplierOption = '';

        for (let [supplierId, supplierName] of Object.entries(suppliersList)) {
            let selected = curSuppliers.includes(supplierId) ? 'selected' : '';
            supplierOption += `<option value="${supplierId}" ${selected}>${supplierName}</option>`;
        }

        let categoryCheckboxes = '';

        let categories = <?php echo json_encode($categories); ?>; // Add this line

        let columnCount = 0;
        categories.forEach((category, index) => {
            if (columnCount % 3 === 0) {
                categoryCheckboxes += '<div class="categoryColumn">';
            }

            categoryCheckboxes += `
                <div>
                    <input type="checkbox" name="categories[]" value="${category}" ${productDetails.categories.includes(category) ? 'checked' : ''}>
                    <label>${category}</label>
                </div>
            `;

            columnCount++;

            if (columnCount % 3 === 0 || index === categories.length - 1) {
                categoryCheckboxes += '</div>';
            }
        });


				BootstrapDialog.confirm({
				title: 'Update <strong>' + productDetails.product_name + '</strong>',
				message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
					<div class="appFormInputContainer">\
						<label for="item_code">Item code</label>\
						<input type="text" class="appFormInput" id="item_code" placeholder="Enter Item code..." name="item_code" required="" />\
					</div>\
					<div class="appFormInputContainer">\
						<label for="p_location">Product Location</label>\
						<input type="text" class="appFormInput" id="p_location" placeholder="Enter Item location..." name="p_location" required="" />\
					</div>\
					<div class="appFormInputContainer">\
						<label for="product_name">Product Name</label>\
						<input type="text" class="appFormInput" id="product_name" value="'+ productDetails.product_name +'"  placeholder="Enter product name..." name="product_name" />\
					</div>\
					<div class="appFormInputContainer">\
                            <label for="category">Product Category:</label>\
                        </div>\
                        <div class="appFormInputContainer categoryContainer" style="max-height: 150px; overflow-y: auto;"> ${categoryCheckboxes} </div>\
					<div class="appFormInputContainer">\
						<label for="description">Suppliers</label>\
						<select name="suppliers[]" id="suppliersSelect" multiple="">\
							<option value="">Select Supplier</option>\
							' +  supplierOption + '\
						</select>\
					</div>\
					<div class="appFormInputContainer">\
						<label for="price">Product Price</label>\
						<input type="number" class="appFormInput" id="price" placeholder="Enter product price..." name="price" required="" />\
					</div>\
					<div class="appFormInputContainer">\
						<label for="description">Description</label>\
						<textarea class="appFormInput productTextAreaInput" placeholder="Enter product description..." id="description" name="description"> '+ productDetails.description +'</textarea> \
					</div>\
					<div class="appFormInputContainer">\
						<label for="product_name">Product Image</label>\
						<input type="file" name="img" />\
					</div>\
					<input type="hidden" name="pid" value="'+ productDetails.id +'" />\
					<input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
				</form>\
				',
				callback: function(isUpdate){
					if(isUpdate){ // If user click 'Ok' button.
						document.getElementById('editProductSubmitBtn').click();
					}
				}
			});
			}, 'json');
		},

		this.initialize = function(){
			this.registerEvents();
		}
	}

	var script = new script;
	script.initialize();

	// Filter products based on category selection
	function filterProducts(category) {
		var rows = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
		if (category === 'all') {
			for (var i = 0; i < rows.length; i++) {
				rows[i].style.display = '';
			}
		} else {
			for (var i = 0; i < rows.length; i++) {
				var rowCategory = rows[i].getElementsByTagName('td')[4].innerHTML; //edit the number kung unsa na column ang category
				if (rowCategory === category) {
					rows[i].style.display = '';
				} else {
					rows[i].style.display = 'none';
				}
			}
		}
	}

		// Filter products based on search input
		filterProductsBySearch();
		function filterProductsBySearch() {
			var input = document.getElementById('searchInput').value.toLowerCase();
			var rows = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

			for (var i = 0; i < rows.length; i++) {
				var itemCode = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase(); // Change the column number to the item code column
				var productName = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase(); // Change the column number to the product name column

				if (itemCode.indexOf(input) > -1 || productName.indexOf(input) > -1) {
					rows[i].style.display = '';
				} else {
					rows[i].style.display = 'none';
				}
			}
		}

	

	function viewAddEditDelete(data){
		var modal_body = `<div class="modal-dialog modal-lg">
									<form action="fetchProduct.php" method="POST" enctype="multipart/form-data" id="editProductForm">
										<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">`+data.viewAddEditDelete+`</h4>
										</div>
										<div class="modal-body" id="modal-body-` + data.id_num + `">
																							
										</div>
										<div class="modal-footer">
											`+data.addtional_btn+`
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
										</div>
									</form>
								</div>`;
		$("#modal-custom-" + data.id_num).html(modal_body);
		$('#modal-custom-' + data.id_num).modal('show');
		
			$.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: data,
				dataType: "json",
				success: function(response) {
					$("#modal-body-" + data.id_num).html(response.content);
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
	}
	$(document).on('click', '#view-suppliers', function() {
		var data = {
					viewAddEditDelete:'Suppliers Details',
					addtional_btn:'',
					action:'view',
					id_num:1,
					id:$(this).data('id')
					};
		var id_num = 1;
		viewAddEditDelete(data);
	});
	$(document).on('click', '#edit-Product', function() {
		var data = { 
					viewAddEditDelete:'Product Details',
					addtional_btn:'<button type="submit" name = "updateProduct" id = "update-Product" class="btn btn-primary updateProudct2">Update</button>',
					action:'edit',
					id_num:2,
					id:$(this).data('id')
					};
		viewAddEditDelete(data);
	});

</script>
</body>
</html>
