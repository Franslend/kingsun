<?php
include('fetchProduct.php');
	//Fetching data
	require_once('database/category-conn.php');
	$query = "select * from categories";
	$result = mysqli_query($con, $query);
	$categories = array();

	while ($row = mysqli_fetch_assoc($result)) {
		$categories[] = $row['category_name'];
	}
$tableName = 'SELECT DISTINCT category FROM products';
  $categories = fetchItem($tableName);
  date_default_timezone_set('Asia/Manila');
?>
<style>
  .text-center {
    text-align: center !important;
}
</style>
<!DOCTYPE html>
<html>
<head>
  <title>KingSun Point of Sale System</title>
  <link rel="stylesheet" type="text/css" href="./css/login.css ?v=<?php echo time(); ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
  <!-- <script src="./js/jquery/jquery-3.5.1.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<style>
thead th {
  position: sticky;
  top: 0;
  background-color: #f2f2f2; /* Optional background color for the header */
  z-index: 2;
}
.bor{
    border: 5px solid red;
}
/* table, th, td {
    border:none;
    border-collapse: none;
} */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
}
.text-center{
    text-align:center !important;
}
.text-left{
    text-align:left !important;
}
.text-right{
    text-align:right !important;
}
</style>
<body class="pos-body">
<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="background: #3498db; border: none;">
      <div class="modal-body text-center" style="background: #3498db;">
        <h1 class="display-3" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ecf0f1; font-weight: normal; line-height: 1.2; font-size: 2.5rem;">Welcome to KingSun Enterprises</h1>
        <h1 class="display-3" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ecf0f1; font-weight: normal; line-height: 1.2; font-size: 2.5rem;">POS System</h1>
        <p class="lead" style="font-size: 1.25rem; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #ecf0f1;">Empowering your business transactions with efficiency and accuracy.</p>
      </div>
    </div>
  </div>
</div>


  <div class="dasboard_content_container" id="dasboard_content_container">
    <?php include('./partials/app-topnav.php') ?>
    <h1 class="pos-title">KingSun Point of Sale System</h1>
    <div class="pos-container">
      <div class="pos-column">
        <div class="row">
          <div class="col-md-3">
            <div class="pos-category">
              <p>Categories</p>
              <div class="categoryContainer">
                <div class="categoryList">
                  <select id="categoryFilter">
                    <option value="all" selected>All</option>
                    <?php foreach ($categories['res'] as $item) { ?>
                      <option value="<?php echo $item['category']; ?>"><?php echo $item['category']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            <h2 class="product-pro">Products</h2>
            <div class="pos-search">
              <input type="text" class="search-input" id = "search-item" placeholder="Search products...">
            </div>
          </div>
        </div>
        <div class="pos-products2">
          <table id="productList" class="product-list">
            <thead>
            <tr>
              <th>Item Code</th>
              <th>Product Name</th>
              <th>Image</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stocks</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id="fetchProduct"></tbody>
          </table>
        </div>
      </div>
      <!-- Add the modal and backdrop elements to the HTML -->
      <div id="cartModal">
        <input type="number" id="quantityInput" placeholder="Enter quantity" />
        <button onclick="confirmCart()">Confirm</button>
      </div>
      <div id="backdrop"></div>
      <div class="pos-column">
        <div class="pos-cart">
          <h2>Selected Products</h2>
          <div class="pos-products2-cart">
            <input type="hidden" id="joinedItemIds">
            <table id="cartItems" class="cart-items">
              <thead>
              <tr>
                <th>Item Code</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Stocks</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody id="fetchSelectedProduct"></tbody>
            </table>
          </div>
          <div class="cart-total">
            <div class="cart-subtotal">
              <span>Sub Total:</span>
              <span id="cartSubtotal">₱0.00</span>
            </div>
            <div class="cart-discount">
              <label for="discountInput">Discount%:</label>
              <input type="number" id="discountInput" min="0" step="0.01">
            </div>
            <div class="cart-total-amount">
              <span>Grand Total:</span>
              <span id="cartTotal">₱0.00</span>
            </div>
          </div>
          <div class="cart-checkout">
            <button type= "button" id="checkoutButton" disabled>Checkout</button>
          </div> 
        </div>
      </div>
    </div>
  </div>

  <!-- <script src="./js/pos-js.js"></script> -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="image-modal">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<input type="hidden" id = "time_order" value = "<?= strtotime(date("Y-m-d H:i:s")) ?>" >
<input type="hidden" id = "sub_total">
<input type="hidden" id = "input-cartTotal">
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #55b0cf">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Checkout Details</b></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="print-preview">
              <div class="row">
                <div class="col-md-5"><p style="float:right !important"><img src="images/logo2.png" alt=""></p></div>
                <div class="col-md-5">
                  <h5 style="text-align:center !important;">
                    KING SUN ENTERPRISES <br> 
                    049 Corrales Ave., cor. Domingo Velez St.<br> 
                    Cagayan de Oro City, Mis. Or. Philippines <br>
                    Cell No. 0922-872-6189 <br> 
                    NEMIA LAO SING - Prop.<br>
                    VAT REG. TIN: 180-808-484-00000 <br> 
                  </h5>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p style="float:right !important">DATE: <?= date('F j, Y, g:i a'); ?></p>
                </div>
              </div>
              <table class="table table-hover table-bordered border-dark">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Product name</th>
                      <th scope="col">Qty</th>
                      <th scope="col">Price</th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody id="checkout-list">
                    <!-- <tr>
                      <th scope="row">1</th>
                      <td>Mark</td>
                      <td>Otto</td>
                      <td>₱100.00</td>
                      <td>@mdo</td>
                    </tr>
                    <tr>
                      <td scope="row" colspan="4" style="text-align:right">Sub Total:</td>
                      <th scope="row" style="text-align:left">₱1230.00</th>
                    </tr>
                    <tr>
                      <td scope="row" colspan="4" style="text-align:right">Discount:</td>
                      <th scope="row" style="text-align:left">100%</th>
                    </tr> 
                    <tr>
                      <td scope="row" colspan="4" style="text-align:right">Grand Total: </td>
                      <th scope="row" style="text-align:left">₱1000.10</th>
                    </tr>     -->
                  </tbody>
              </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="proceedToPaymentButton">Proceed to Payment</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #b5ebb5">
        <h5 class="modal-title" id="paymentModalLabel"><b>Payment Details</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Display Grand Total at the top in a bold, centered format -->
        <h3 class="fw-bold text-center" id="grandTotalPayment">₱0.00</h3>
        
        <!-- Rest of the content -->
        <label for="cashInput">Enter Cash Amount:</label>
        <input type="number" class="form-control" id="cashInput" placeholder="Amount..." required="">
        <hr>
        <div class="text-center">
          <p>Cash Entered: <span id="cashEntered">₱0.00</span></p>
          <p><b>Change: <span id="changeAmount">₱0.00</span></b></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="printSubmit">Print Receipt</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</body>
</html>

<script>
$(document).ready(function(){
  fetchProduct(0);
  fetchSelectedProduct('view',0,0,0);
  function fetchProduct(ids) {
    var cat = $('#categoryFilter').val();
    var search_item = $('#search-item').val();
        $.ajax({
            url: "fetchProduct.php",
            type: "POST",
            data: { fetchProduct:1, cat:cat,search_item:search_item,ids:ids },
            success: function(response) {
                $("#fetchProduct").html(response);
                //console.log(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
  }
  function fetchSelectedProduct(action,product_id,cart_id,qty){
        $.ajax({
            url: "fetchProduct.php",
            type: "POST",
            data: {fetchSelectedProduct:1,action:action,product_id:product_id,time_order:$('#time_order').val(),qty:qty,cart_id:cart_id},
            dataType: "json",
            success: function(response) {
                $("#fetchSelectedProduct").html(response.cart);
                var formattedNumber = response.subtotal.toLocaleString();
                $("#cartSubtotal").text('₱'+formattedNumber);
                $("#sub_total").val(response.subtotal);
                var message = response.result ? '' : alert('Check stocks!');
                discount()
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
}
$(document).on('change', '#categoryFilter', function () {
  fetchProduct(0);
});
$(document).on('keyup', '#search-item', function () {
  fetchProduct(0);
});
var clickedItemIds = [0];
$(document).on('click', '#add-product', function () {
    var itemId = $(this).data("product_id");
    clickedItemIds.push(itemId); // Add itemId to the array
    var joinedItemIds = clickedItemIds.join(","); // Join the array values
    $('#joinedItemIds').val(joinedItemIds);
    fetchSelectedProduct('add',$(this).data("product_id"),0,1);
    fetchProduct(joinedItemIds);
});
$(document).on('click', '#remove-product', function () {
    var itemId = $(this).data("id");
    var cart_id = $(this).data("cart_id");
    var indexToRemove = clickedItemIds.indexOf(itemId);
    if (indexToRemove !== -1) {
        clickedItemIds.splice(indexToRemove, 1);
    }
    var joinedItemIds = clickedItemIds.join(",");
    $('#joinedItemIds').val(joinedItemIds);
    fetchSelectedProduct('delete',itemId,cart_id,1);
    fetchProduct(joinedItemIds);
});
$(document).on('change', '.number-input', function () {
        var value = $(this).val();
        var itemId = $(this).data("id");
        var cart_id = $(this).data("cart_id");
        if (parseInt(value) > 1) {
          var new_val = sanitizeInput(value);
        }else{
          var new_val = 1;
        }
        fetchSelectedProduct('update',itemId,cart_id,new_val);
});
function sanitizeInput(input) {
  var sanitized = input.replace(/[^0-9.]/g, '');
  sanitized = sanitized.replace(/\.(?=.*\.)/g, '');
  return sanitized;
}

$(document).on('click', '#button-add', function () {
  var itemId = $(this).data("id");
  var cart_id = $(this).data("cart_id");
  var old_val = parseInt($('#product_id_'+itemId+'').val());
  //var old_stock_val = parseInt($('#stock_num_'+itemId+'').text());
  var new_val = old_val + 1;
  //var new_stock_val = old_stock_val - new_val;
  $('#product_id_'+itemId+'').val(new_val);
  //$('#stock_num_'+itemId+'').text(new_stock_val);
  fetchSelectedProduct('update',itemId,cart_id,new_val);
});
$(document).on('click', '#button-minus', function () {
  var itemId = $(this).data("id");
  var cart_id = $(this).data("cart_id");
  var old_val = parseInt($('#product_id_'+itemId+'').val());
  var new_val = old_val - 1;
  if (new_val >= 1) {
    $('#product_id_'+itemId+'').val(old_val - 1);
    fetchSelectedProduct('update',itemId,cart_id,new_val);
  }
});


/* Picture Modal */
$(document).on('click', '#view-img', function () {
  var itemId = $(this).data("id");
  $.ajax({
    url: "fetchProduct.php",
    type: "POST",
    data: { view_img: 1, itemId: itemId },
    dataType: "json",
    success: function (response) {
      $("#exampleModal").modal("show");

      // Create a variable to store the combined content
      var modalContent =
        '<div class="modal-image">' + response.src + '</div>' +
        '<div class="modal-location">' +
        '<b><p>Located At: </b>' + response.p_location + '</p>' +
        '</div>';

      // Set the combined content to the modal
      $("#image-modal").html(modalContent);
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error);
    }
  });
});




$(document).on('input', '#discountInput', function () {
  discount();
 
});

function discount() {
    var rowCount = $('#fetchSelectedProduct tr:not(.excepted)').length;
    var sub_total = $('#sub_total').val();
    var originalPrice = parseInt(sub_total);
    var discountPercentage = parseInt($('#discountInput').val());
   if (rowCount != 0 && !isNaN(originalPrice)) {
        if (!isNaN(discountPercentage)) {
          if (discountPercentage <= 100) {
            var discountAmount = (originalPrice * discountPercentage) / 100;
            var discountedPrice = originalPrice - discountAmount;
            var formattedDiscountedPrice = discountedPrice.toLocaleString('en-US', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $("#cartTotal").text(formattedDiscountedPrice);
            $('#checkoutButton').prop('disabled', false);
            $("#input-cartTotal").val(discountedPrice);
          }else{
            alert('input must less than 100 or equal!');
            $('#discountInput').val('');
            var originalPrice2 = originalPrice.toLocaleString('en-US', {
              style: 'currency',
              currency: 'PHP',
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
            $("#cartTotal").text(originalPrice2);
            $("#input-cartTotal").val(originalPrice);
          }
        }else{
          var originalPrice2 = originalPrice.toLocaleString('en-US', {
              style: 'currency',
              currency: 'PHP',
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
          });
          $("#cartTotal").text(originalPrice2);
          $("#input-cartTotal").val(originalPrice);
          $('#checkoutButton').prop('disabled', false);
        }
   } else {
        $('#checkoutButton').prop('disabled', true);
        $("#cartTotal").text('₱0.00');
   }
}

//for checout and dpayment
$(document).on('click', '#checkoutButton', function () {
    $.ajax({
      url: "fetchProduct.php",
      type: "POST",
      data: {
        viewAddEditDelete: 1,
        action: 'check_out',
        time_order: $('#time_order').val(),
        cartSubtotal: $("#sub_total").val(),
        discountInput: $("#discountInput").val(),
        cartTotal: $("#input-cartTotal").val()
      },
      dataType: "json",
      success: function (response) {
        $("#checkout-list").html(response.content);
        
        // Open the checkout details modal
        $('#exampleModal2').modal('show');
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
      }
    });
  });

  //hit enter for checkout
  // Add event listener for "Enter" key press on the document
$(document).keypress(function (e) {
    if (e.which === 13 && $('#checkoutButton').prop('disabled') === false) {
        // Trigger the "Checkout" button click
        $('#checkoutButton').trigger('click');
    }
});

  //hit enter for proceed to payment
  $('#exampleModal2').keypress(function (e) {
    if (e.which === 13) {
        // Trigger the "Proceed to Payment" button click
        $('#proceedToPaymentButton').trigger('click');
    }
});

function printPreview(content, css) {
    var printWindow = window.open('', '_blank');
    var printContent = $('#' + content + '').html();
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">');
    printWindow.document.write('<style>img { max-width: 65%; height: auto; } @media print { h5 { font-size: 9px; } }</style>');  // Add this line for h5 size adjustment
    printWindow.document.write('</head><style>' + css + '</style><body class="container">' + printContent + '</body></html>');
    printWindow.document.close();
    printWindow.focus();
    setTimeout(function () {
        printWindow.print();
        printWindow.close();
        // Delay the reload to ensure it happens after the print window is closed
        setTimeout(function () {
            location.reload();
        }, 100);
    }, 1000);
};

$(document).on('click', '#printSubmit', function() {
    $.ajax({
            url: "fetchProduct.php",
            type: "POST",
            data: {
              viewAddEditDelete:1,
              action:'proceed_to_payment',
              time_order:$('#time_order').val(),
              discountInput:$("#discountInput").val()
            },
            dataType: "json",
            success: function(response) {
              if (response.content == 'Success') {
                alert('Transaction Success!');
                fetchProduct(0);
                fetchSelectedProduct('view',0,0,0);
                var css = `
                @page {
                  margin-top: 30px;
                  margin-left: 3px;
                  margin-right: 3px;
                  margin-bottom: 3px;
                }
                @media print {
                  .col-md-5 {
                    flex: 0 0 auto;
                    width: 41.66666667%;
                  }
                }`;
                printPreview('print-preview', css);
                
              }else{
                alert('Transaction Failed!');
              }
              
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    $('#exampleModal2').modal('hide');
    // Clear the entered cash amount and change when closing the payment modal
    $("#cashInput").val('');
    $("#changeAmount").text('₱0.00');
        // Close the payment modal
        $('#paymentModal').modal('hide');
});
});


function calculateChange() {
    var totalAmount = parseFloat($("#input-cartTotal").val()) || 0;
    var cashEntered = parseFloat($("#cashInput").val()) || 0;

    if (!isNaN(totalAmount) && !isNaN(cashEntered) && cashEntered >= totalAmount) {
        var changeAmount = cashEntered - totalAmount;
        var formattedChange = '₱' + changeAmount.toFixed(2);

        $("#cashEntered").text('₱' + cashEntered.toFixed(2));
        $("#changeAmount").text(formattedChange);

        // Enable the "Print Receipt" button
        $('#printSubmit').prop('disabled', false);
    } else if (isNaN(cashEntered) || cashEntered < totalAmount) {
        // Disable the "Print Receipt" button
        $('#printSubmit').prop('disabled', true);

        if (isNaN(cashEntered)) {
            alert('Invalid cash amount. Please enter a valid amount.');
            // Clear entered cash amount and change when invalid
            $("#cashInput").val('');
            $("#changeAmount").text('₱0.00');
        }
    }

    // Optionally, you might want to update the grand total in the payment modal
    updateGrandTotalPayment();
}


// Function to update grand total in payment modal
function updateGrandTotalPayment() {
    var cartTotal = parseFloat($("#sub_total").val()) || 0;
    var discountInput = parseFloat($("#discountInput").val()) || 0;

    if (!isNaN(cartTotal)) {
        var discountedTotal = cartTotal - (cartTotal * discountInput / 100);
        $("#grandTotalPayment").text('₱' + discountedTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }
}

// Calculate change and update grand total on cash input
$(document).on('input', '#cashInput', function () {
    calculateChange();
    updateGrandTotalPayment();
});

// Show the payment details modal when "Proceed to Payment" button is clicked
$(document).on('click', '#proceedToPaymentButton', function () {
    // Update grand total in payment modal
    updateGrandTotalPayment();

    // Show the payment details modal
    $('#paymentModal').modal('show');

    // Allow typing in cash input field immediately after modal is shown
    $('#paymentModal').on('shown.bs.modal', function () {
        $('#cashInput').focus();
    });

    // Add event listener for "Enter" key press on the cash input field
    $('#cashInput').keypress(function (e) {
        if (e.which === 13) {
            // Trigger the "Print Receipt" button click
            $('#printSubmit').trigger('click');
        }
    });

    // Disable the "Print Receipt" button if needed
    var totalAmount = parseFloat($("#input-cartTotal").val()) || 0;
    var cashEntered = parseFloat($("#cashInput").val()) || 0;

    if (isNaN(totalAmount) || isNaN(cashEntered) || cashEntered < totalAmount) {
        // Disable the "Print Receipt" button
        $('#printSubmit').prop('disabled', true);
    }
});

//for welcoming
$(document).ready(function () {
  // Show the welcome modal on page load
  $('#welcomeModal').modal('show');

  // Hide the welcome modal after 3 seconds with a slow fade-out animation
  setTimeout(function () {
    $('#welcomeModal').modal('hide');
  }, 5000);

});



</script>