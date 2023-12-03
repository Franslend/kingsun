<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');



	// Get all products.
	$show_table = 'products';
	$products = include('database/show.php');
	$products = json_encode($products);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Order Product - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
	<!-- for select search -->
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->
		<!-- for select search -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
	<style>
		.d-none{
			display:none;
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
							<div class="column column-12" style="height: 596px; overflow: auto;">
								<h1 class="section_header"> Create Order</h1>
								<div>
									<form action="database/save-order.php" method="POST">

										<div class="alignRight" id="testawdawd">
											<button type="button" class="orderBtn orderProductBtn btn btn-secondary" id="orderProductBtn">Add Another Product</button>
											<!-- <button type="button" class="orderBtn test1" id="test1">with search</button> -->
										</div>

										<div id="appendHere">
											<div class="orderProductRow">
												<div id="parent_id">
													<label for="product_name">PRODUCT NAME</label>				
													<select name="products[]" class="productNameSelect" id="product_name_0">
														<option value="">Select Product</option>
													<?php 
													$stmt = $conn->prepare("SELECT * FROM products where deleted = 0");
													$stmt->execute();
													$stmt->setFetchMode(PDO::FETCH_ASSOC);
													$res = $stmt->fetchAll();
													foreach($res as $key => $value){ ?>
														<option value="<?= $value['id'] ?>"><?= $value['product_name'] ?></option>
													<?php } ?>
													</select>
													<button type="button" class="d-none appbtn removeOrderBtn btn btn-danger">Remove</button>		    
												</div>
												<div class="suppliersRows" id="supplierRows_0" data-counter="0"></div>
											</div>
										</div>	

										<div class="alignRight marginTop20">
											<button type="submit" class="orderBtn submitOrderProductBtn btn btn-primary">Submit Order</button>
										</div>
									</form>
								</div>
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
	<script src="js/script.js?v=<?= time(); ?>"></script>
	<?php include('partials/app-scripts.php'); ?> 
	<!-- for select search -->
	<!-- for select search -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
	        // Initialize Select2 on the select element
$(document).ready(function() { 

	var products  = <?= $products ?>;
	var counter = 0;

	function script(){
		var vm = this;

		let productOptions = '\
			<div id="parent_id">\
				<label for="product_name">PRODUCT NAME</label>\
				<select name="products[]" class="productNameSelect" id="product_name">\
					<option value="">Select Product</option>\
					INSERTPRODUCTHERE\
				</select>\
					<button type = "button" class="appbtn removeOrderBtn">Remove</button>\
		    </div>';

			
		this.initialize = function(){
			this.registerEvents();
			this.renderProductOptions();
		},

		this.renderProductOptions = function(){
			let optionHtml = '';
			products.forEach((product) => {
				optionHtml += '<option value="'+ product.id +'">'+ product.product_name +'</option>';
			})

			productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
		},

		this.registerEvents = function(){
			$(document).on('click', '#orderProductBtns', function(e){
				var targetElement = e.target; // Target element
				classList = targetElement.classList;

				// Add new product order event
				if(targetElement.id === 'orderProductBtn'){
					//document.getElementById('noData').style.display = 'none';
					$("#noData").remove();
					let orderProductListsContainer = document.getElementById('orderProductLists');
					orderProductListsContainer.innerHTML += '\
						<div class="orderProductRow">\
							'+ productOptions +'\
							<div class="suppliersRows" id="supplierRows_'+ counter +'" data-counter="'+ counter +'"></div>\
						</div>';
					$("#product_name").attr("id", "product_name_" + counter);
					console.log(orderProductLists);
					counter++;
					//triggerButtonClick()
				}
			});
			document.addEventListener('click', function(e){
				targetElement = e.target; // Target element
				classList = targetElement.classList;

				// Add new product order event
				// if(targetElement.id === 'orderProductBtn'){
				// 	document.getElementById('noData').style.display = 'none';
				// 	let orderProductListsContainer = document.getElementById('orderProductLists');
				// 	orderProductLists.innerHTML += '\
				// 		<div class="orderProductRow">\
				// 			'+ productOptions +'\
				// 			<div class="suppliersRows" id="supplierRows_'+ counter +'" data-counter="'+ counter +'"></div>\
				// 		</div>';
				// 	$("#product_name").attr("id", "product_name" + counter);	
				// 	counter++;
				// }

				//If remove id clicked
				if(targetElement.classList.contains('removeOrderBtn')){
					let orderRow = targetElement
						.closest('div.orderProductRow');
						orderRow.remove();
					//Remove element
				
					console.log(orderRow);
				}				
			});
			// document.addEventListener('change', function(e){
			// 	targetElement = e.target; // Target element
			// 	classList = targetElement.classList;


			// 	// Add suppliers row on product option change 
			// 	if(classList.contains('productNameSelect')){
			// 		let pid = targetElement.value;
			// 		alert(pid)
			// 		let counterId = targetElement
			// 			.closest('div.orderProductRow')
			// 			.querySelector('.suppliersRows')
			// 			.dataset.counter;
					

			// 		$.get('database/get-product-suppliers.php', {id: pid}, function(suppliers){
			// 			vm.renderSupplierRows(suppliers, counterId);
			// 		}, 'json');
			// 	}
			// });
			$(document).on('change', '.productNameSelect', function(e){
				let pid = $(this).val();
				let counterId = $(this)
					.closest('div.orderProductRow')
					.find('.suppliersRows')
					.data('counter');

				$.get('database/get-product-suppliers.php', {id: pid}, function(suppliers){
					vm.renderSupplierRows(suppliers, counterId);
				}, 'json');
			});
		},

		this.renderSupplierRows = function(suppliers, counterId){
			let supplierRows = '';
				
			suppliers.forEach((supplier) => {
				supplierRows += '\
					<div class="row">\
						<div style="width: 50%;">\
							<p class="supplierName">'+ supplier.supplier_name +'</p>\
					    </div>\
						<div style="width: 50%;">\
							<label for="quantity">Quantity: </label>\
							<input type="number" required="" class="appFormInput orderProductQty" id="quantity" placeholder="Enter quantity..." name="quantity['+ counterId +']['+ supplier.id +']" />\
					    </div>\
					</div>';
			});

			// Append to container
			let supplierRowContainer = document.getElementById('supplierRows_' + counterId);
			supplierRowContainer.innerHTML = supplierRows;
		}
	}

	(new script()).initialize();


// $(document).on('click', '#test1', function () {
// 	triggerButtonClick()
let ticket = 1;
$(document).on('click', '#orderProductBtn', function () {
	$('#product_name_0').select2('destroy');
	var newRow = $('.orderProductRow:first').clone();
	newRow.find('#supplierRows_0').attr('id', 'supplierRows_' + ticket);
	newRow.find('.removeOrderBtn').removeClass('d-none');
	newRow.find('#product_name_0')
			.attr('id', 'input-set-' + ticket)
			.removeClass('use_select2')
			.val('');
	$('#appendHere').append(newRow);
	$('#product_name_0').select2();
	$('#supplierRows_' + ticket).attr('data-counter', ticket);
	$('#supplierRows_' + ticket).html('');
	$('#input-set-' + ticket).select2();
	ticket++;

	// Initialize Select2 on the new select element
	$('#input-set-' + ticket).select2();
});

$('#product_name_0').select2();

//test
$(document).on('click', '#add-more-exp-form', function () {
  $('#type_vio_0').select2('destroy');
  var newRow = $('#tr-expBody-add:first').clone();
  newRow.find('input[name="ticketNo[]"]').val('');
  newRow.find('input[name="ticketAdd[]"]').val('');
  newRow.find('input[name="penalty[]"]').attr('id', 'input-set-penalty-type_vio_' + ticket).val('');
  newRow.find('#add-more-exp-form').attr('id', 'remove-exp');
  newRow.find('#remove-exp i').removeClass('fa-plus').addClass('fa-minus');
  newRow.find('#remove-exp').addClass('btn btn-danger');
  newRow.find('#type_vio_0')
        .attr('id', 'type_vio_' + ticket)
        .removeClass('use_select2')
        .val('');
  $('#expTable tbody').append(newRow);
  $('#type_vio_0').select2({
      theme: 'bootstrap',
      dropdownParent: $(".mfp-content")
  });
  $('#type_vio_' + ticket).select2({
      theme: 'bootstrap',
      dropdownParent: $(".mfp-content")
  });
  $('#type_vio_' + ticket).change(function () {
    var penalty = $(this).find('option:selected').data('penalty');
    $('#input-set-penalty-' + $(this).data('select2-id')).val(penalty)
  });
  ticket++;
});
$(document).on('click', '#remove-exp', function() {
  $(this).closest('tr').remove();
});
//test


});

</script>
</body>
</html>