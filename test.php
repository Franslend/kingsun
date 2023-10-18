


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select2 Example</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 CSS and JavaScript files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
    <h1>Select2 Example</h1>
    <select id="mySelect" style="width: 300px;">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        <option value="option4">Option 4</option>
        <option value="option5">Option 5</option>
    </select>
    <button type="button" class="orderBtn test1" id="test1">with search</button>
                            <div id="expTable" >
								<select name="penalty[]" class="productNameSelect" id="test123123">
									<option value="">Select Product</option>
								</select>
							</div>
                            <div id="expTableapeend"></div>
                            
    <script>
        // Initialize Select2 on the select element
        $(document).ready(function() {
            $('#mySelect').select2();
        });
        let ticket = 1;
        $(document).on('click', '#test1', function () {
            var newRow = $('#expTable:first').clone();
            newRow.find('#test123123')
                    .attr('id', 'input-set-' + ticket)
                    .removeClass('use_select2')
                    .val('');
            $('#expTableapeend').append(newRow);
            $('#input-set-' + ticket).select2();
            ticket++;
        });

        $(document).on('change', '#product_name0', function(e) {
				targetElement = e.target; // Target element
				classList = targetElement.classList;
				if(classList.contains('productNameSelect')){
					let pid = targetElement.value;
					let counterId = targetElement
						.closest('div.orderProductRow')
						.querySelector('.suppliersRows')
						.dataset.counter;
					$.get('database/get-product-suppliers.php', {id: pid}, function(suppliers){
						vm.renderSupplierRows(suppliers, counterId);
					}, 'json');
				}
			});
    </script>
</body>
</html>


<div class="orderProductRow">
   <div id="parent_id">
      <label for="product_name">PRODUCT NAME</label>				
      <select name="products[]" class="productNameSelect" id="product_name_0">
         <option value="">Select Product</option>
         <option value="19">R404A</option>
         <option value="18">R134A</option>
         <option value="17">Rubber Insolation Tube</option>
         <option value="16">Fiber Glass</option>
         <option value="15">Refregenrant oil</option>
         <option value="14">Compressor</option>
         <option value="13">Silver Rod</option>
         <option value="11">R22 Freon</option>
      </select>
      <button type="button" class="appbtn removeOrderBtn">Remove</button>		    
   </div>
   <div class="suppliersRows" id="supplierRows_0" data-counter="0">

   </div>
</div>


<div class="orderProductRow">
   <div id="parent_id">
      <label for="product_name">PRODUCT NAME</label>				
      <select name="products[]" class="productNameSelect" id="product_name_1">
         <option value="">Select Product</option>
         <option value="19">R404A</option>
         <option value="18">R134A</option>
         <option value="17">Rubber Insolation Tube</option>
         <option value="16">Fiber Glass</option>
         <option value="15">Refregenrant oil</option>
         <option value="14">Compressor</option>
         <option value="13">Silver Rod</option>
         <option value="11">R22 Freon</option>
      </select>
      <button type="button" class="appbtn removeOrderBtn">Remove</button>		    
   </div>
   <div class="suppliersRows" id="supplierRows_1" data-counter="0">
      <div class="row">
         <div style="width: 50%;">
            <p class="supplierName">Nemia</p>
         </div>
         <div style="width: 50%;">							<label for="quantity">Quantity: </label>							<input type="number" required="" class="appFormInput orderProductQty" id="quantity" placeholder="Enter quantity..." name="quantity[1][5]">					    </div>
      </div>
   </div>
</div>