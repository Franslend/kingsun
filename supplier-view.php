<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');

	
	$show_table = 'suppliers';
	$suppliers = include('database/show.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Suppliers - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div id="dashboardContent">
				<?php include('partials/app-topnav.php') ?>
				<!--<div id="dashboardScroll"> -->
					<div class="dashboard_content">
						<div class="dashboard_content_main">		
							<div class="row">
								<div class="column column-12" style="height: 596px; overflow: auto;">
									<h1 class="section_header"> List of Suppliers</h1>
									<div class="reportTypeContainer">
										<div class="reportType">
											<p>Search Supplier</p>
											<input type="text" id="searchInput" placeholder="Enter supplier name..." oninput="filterProductsBySearch()" />
										</div>
											<div class="reportType">
											<p>Print Report Suppliers</p>
											<div class="alignRight">
												<a href="database/report_csv.php?report=supplier" class="reportExportBtn">Excel</a>
												<a href="database/report_pdf.php?report=supplier" class="reportExportBtn">PDF</a>
											</div>
										</div>
									</div>
									<div class="section_content">
									<p class="userCount"><?= count($suppliers) ?> suppliers </p>
										<div class="users">
											<table>
												<thead>
													<tr>												
														<th>#</th>
														<th>VAT REG. TIN</th>					
														<th>Supplier Name</th>
														<th>Supplier Location</th>
														<th>Contact Details</th>
														<th>Products</th>
														<th>Created By</th>
														<th>Created At</th>
														<th>Updated At</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$stmt = $conn->prepare("SELECT * FROM suppliers where deleted = 0 ORDER BY created_at DESC");
													$stmt->execute();
													$stmt->setFetchMode(PDO::FETCH_ASSOC);
													
													$suppliers2 = $stmt->fetchAll();
													foreach($suppliers2 as $index => $supplier){ ?>
														<tr>
															<td><?= $index + 1 ?></td>
															<td><?= $supplier['s_tin'] ?> </td>
															<td>
																<?= $supplier['supplier_name'] ?>
															</td>
															<td><?= $supplier['supplier_location'] ?> </td>
															<td><a id = "emailTo" data-email = "<?= $supplier['email'] ?>" href="#email"><?= $supplier['email'] ?></a><br><?= $supplier['c_number'] ?></td>
															<td>
																<?php
																	$product_list = '-';

																	$sid = $supplier['id'];
																	$stmt = $conn->prepare("
																		SELECT product_name 
																			FROM products, productsuppliers 
																			WHERE 
																				productsuppliers.supplier=$sid 
																					AND 
																				productsuppliers.product = products.id
																		");
																	$stmt->execute();
																	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

																	if($row){																
																		$product_arr = array_column($row, 'product_name');
																		$product_list = '<li>' . implode("</li><li>", $product_arr);
																	}

																	echo $product_list;
																?>
															</td>
															<td>
																<?php
																	$uid = $supplier['created_by'];
																	$stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
																	$stmt->execute();
																	$row = $stmt->fetch(PDO::FETCH_ASSOC);

																	$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
																	echo $created_by_name;
																?>
															</td>
															<td><?= date('M d,Y @ h:i:s A', strtotime($supplier['created_at'])) ?></td>
															<td><?= date('M d,Y @ h:i:s A', strtotime($supplier['updated_at'])) ?></td>
															<td>
																<a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>"> <i class="fa fa-pencil"></i> Edit</a> | 
																<a href="" class="deleteSupplier" data-name="<?= $supplier['supplier_name'] ?>" data-sid="<?= $supplier['id'] ?>"> <i class="fa fa-trash"></i> Delete</a>
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
	</div>

<div class="modal fade" id="statusModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">SEND EMAIL</h4>
      </div>
      <div class="modal-body bootstrap-dialog-message">
			<label for="" style="margin-bottom: 1px; margin-top: 3px">FROM</label>
			<input id="fromEmail" type="text" class= "form-control" style="margin-bottom: 1px; margin-top: 3px" value="kingsun@gmail.com">													
			<label for="" style="margin-bottom: 1px; margin-top: 3px">TO</label>
			<input id="toEmail" type="text" class= "form-control" style="margin-bottom: 1px; margin-top: 3px" readonly>													
			<label for="" style="margin-bottom: 1px; margin-top: 3px">SUBJECT</label>
			<input id="subject" type="text" class= "form-control" style="margin-bottom: 1px; margin-top: 3px" >		
			<label for="">MESSAGE</label>
			<textarea id="msg" name="" id="" style="margin-bottom: 1px; margin-top: 3px" class= "form-control" cols="5" rows="5"></textarea>		
      </div>
      <div class="modal-footer">
	  	<button type="button" id="sendEmailTo" class="btn btn-success">Send now</button>
        <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php 
	include('partials/app-scripts.php'); 

	$show_table = 'products';
	$products = include('database/show.php');

	$products_arr = [];

	foreach($products as $product){
		$products_arr[$product['id']] = $product['product_name'];
	}

	$products_arr = json_encode($products_arr);
?>
<script>
	var productsList = <?= $products_arr ?>;


	function script(){
		var vm = this;

		this.registerEvents = function(){
			document.addEventListener('click', function(e){
				targetElement = e.target; // Target element
				classList = targetElement.classList;


				if(classList.contains('deleteSupplier')){
					e.preventDefault(); // this prevents the default mechanism.

					sId = targetElement.dataset.sid;
					supplierName = targetElement.dataset.name;

					BootstrapDialog.confirm({
						type: BootstrapDialog.TYPE_DANGER,
						title: 'Delete Supplier',
						message: 'Are you sure to delete <strong>'+ supplierName +'</strong>?',
						callback: function(isDelete){
							if(isDelete){
								$.ajax({
									method: 'POST',
									data: {
										id: sId,
										table: 'suppliers'
									},
									url: 'database/delete.php',
									dataType: 'json',
									success: function(data){
										message = data.success ? 
											supplierName + ' successfully deleted!' : 'Error processing your request!';

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

				if(classList.contains('updateSupplier')){
					e.preventDefault(); // this prevents the default mechanism.

					sId = targetElement.dataset.sid;
					vm.showEditDialog(sId);
				}

			});

			document.addEventListener('submit', function(e){
				e.preventDefault();
				targetElement = e.target;

				if(targetElement.id === 'editSupplierForm'){
					vm.saveUpdatedData(targetElement);
				}
			})

		},

		this.saveUpdatedData = function(form){
			$.ajax({
				method: 'POST',
				data: {
					s_tin: document.getElementById('s_tin').value,
					supplier_name: document.getElementById('supplier_name').value,
					supplier_location: document.getElementById('supplier_location').value,
					email: document.getElementById('email').value,
					c_number: document.getElementById('c_number').value,
					products: $('#products').val(),
					sid: document.getElementById('sid').value
				},
				url: 'database/update-supplier.php',
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

		this.showEditDialog = function(id){
			$.get('database/get-supplier.php', {id: id}, function(supplierDetails){
				let curProducts = supplierDetails['products'];
				let productOptions = '';


				for (const [pId, pName] of Object.entries(productsList)) {
					selected = curProducts.indexOf(pId) > -1 ? 'selected' : ''; 
					productOptions += "<option "+ selected +" value='"+ pId +"'>"+ pName +"</option>";
				}




				BootstrapDialog.confirm({
					title: 'Update <strong>' + supplierDetails.supplier_name + '</strong>',
					message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\
						<div class="appFormInputContainer">\
							<label for="s_tin">VAT REG. TIN</label>\
							<input type="text" class="appFormInput" placeholder="Enter supplier TIN..." id="s_tin" name="s_tin" required="" >\
						</div>\
						<div class="appFormInputContainer">\
							<label for="supplier_name">Supplier Name</label>\
							<input type="text" class="appFormInput" id="supplier_name" value="'+ supplierDetails.supplier_name +'" placeholder="Enter supplier name..." name="supplier_name" />\
						</div>\
						<div class="appFormInputContainer">\
							<label for="supplier_location">Location</label>\
							<input type="text" class="appFormInput" value="'+ supplierDetails.supplier_location +'" placeholder="Enter product supplier location..." id="supplier_location" name="supplier_location">\
						</div>\
						<div class="appFormInputContainer">\
							<label for="email">Email</label>\
							<input type="text" class="appFormInput" value="'+ supplierDetails.email +'" placeholder="Enter supplier email..." id="email" name="email">\
						</div>\
						<div class="appFormInputContainer">\
							<label for="email">Phone number</label>\
							<input type="text" class="appFormInput" value="'+ supplierDetails.c_number +'" placeholder="Enter supplier phone number..." id="c_number" name="c_number">\
						</div>\
						<div class="appFormInputContainer">\
							<label for="products">Products</label>\
							<select name="products[]" id="products" multiple="">\
								<option value="">Select Products</option>\
								' + 	productOptions + '\
							</select>\
						</div>\
						<input type="hidden" name="sid" id="sid" value="'+ supplierDetails.id +'" />\
						<input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden"/>\
					</form>\
					',
					callback: function(isUpdate){
						if(isUpdate){ // If user click 'Ok' button.
							document.getElementById('editSupplierSubmitBtn').click();
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
				var rowCategory = rows[i].getElementsByTagName('td')[3].innerHTML; //edit the number kung unsa na column ang category
				if (rowCategory === category) {
					rows[i].style.display = '';
				} else {
					rows[i].style.display = 'none';
				}
			}
		}
	}

	    // Filter products based on search input
		function filterProductsBySearch() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var rows = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var productName = rows[i].getElementsByTagName('td')[1].innerHTML.toLowerCase(); // edit the number kung unsa na column imo ganahan ma search
            if (productName.indexOf(input) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
	$(document).on('click', '#emailTo', function() {
		$('#toEmail').val($(this).data('email'));
		$('#statusModal2').modal('show');
	});
	$(document).on('click', '#sendEmailTo', function() {
		var fromEmail = $('#fromEmail').val();
		var toEmail = $('#toEmail').val();
		var subject = $('#subject').val();
		var msg = $('#msg').val();
		if(fromEmail != '' && toEmail != '' && subject != '' && msg != ''){
			var data = { 
			fromEmail: fromEmail, 
			toEmail: toEmail, 
			subject: subject, 
			msg: msg, 
			phpmailer:'send_email' 
			};
			phpMailer(data);
		}else{
			alert('All fields required!')
		}
  	});

	function phpMailer(data) {
		$.ajax({
			url: "fetchProduct.php",
			type: "POST",
			data: data,
			dataType: "json",
			beforeSend: function(response){
				$('#sendEmailTo').prop('disabled', true).html('Please wait sending...');
				$('#closeModal').prop('disabled', true);
			},
			success: function(response) {
				$('#sendEmailTo').prop('disabled', false).html('Send now');
				$('#closeModal').prop('disabled', false);
				switch (data.phpmailer) {
				case 'send_email':
					if (response.msg) {
						var toEmail = $('#toEmail').val('');
						var subject = $('#subject').val('');
						var msg = $('#msg').val('');
						alert('Message Sent!');
						$('#statusModal2').modal('hide');
					}else{
						alert("Email doesn't exist!");
					}
					break;
				default:
					alert("ERROR");
					break;
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error:", status, error);
			}
		});
	}
</script>
</body>
</html>