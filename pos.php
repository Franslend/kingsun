<?php
include('fetchProduct.php');
  $categories = ['Cabin Filter', 'Capacitor', 'Compressor', 'Compressor Parts', 'Copper Tube', 'Dryer', 'Engine Filter', 'Evaporator', 'Refrigerant', 'Refrigerant Oil', 'Resistor Block', 'Rod', 'Rubber Insulation Tube', 'Others'];
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
          <h2>Cart</h2>
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
              <span>Subtotal:</span>
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
      <div class="modal-body">
        <!-- Image or other content -->
      </div>
      <div id="location_container">
          <span style="display: block; text-align: left; padding-left: 15px;">Located at: </span>
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
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Check out</h1>
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
        <button type="button" class="btn btn-success" id="printSubmit">Print & Proceed to Payment</button>
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



/* mODAL POS picture
$(document).on('click', '#view-img', function () {
  var itemId = $(this).data("id");
          $.ajax({
            url: "fetchProduct.php",
            type: "POST",
            data: {view_img:1,itemId:itemId},
            dataType: "json",
            success: function(response) {
              $("#exampleModal").modal("show");
              '<p>Located at: ' + response.p_location + '</p>' +
              '</div>' +
              $(".modal-body").html(response.src);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
});*/


/* mODAL POS picture*/
$(document).on('click', '#view-img', function () {
    var itemId = $(this).data("id");
    $.ajax({
        url: "fetchProduct.php",
        type: "POST",
        data: { view_img: 1, itemId: itemId },
        dataType: "json",
        success: function (response) {
            $("#exampleModal").modal("show");

            // Combine the image and location data
            var modalContent = '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                '</div>' +
                '<div class="modal-body">' +
                '<div class="modal-image">' + response.src + '</div>' +
                '<div class="modal-location">' +
                '<p>Located at: ' + response.p_location + '</p>' +
                '</div>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>' +
                '</div>' +
                '</div>';

            $(".modal-dialog").html(modalContent);
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

$(document).on('click', '#checkoutButton', function () {  
        $.ajax({
            url: "fetchProduct.php",
            type: "POST",
            data: {
              viewAddEditDelete:1,
              action:'check_out',
              time_order:$('#time_order').val(),
              cartSubtotal:$("#sub_total").val(),
              discountInput:$("#discountInput").val(),
              cartTotal:$("#input-cartTotal").val()
            },
            dataType: "json",
            success: function(response) {
                $("#checkout-list").html(response.content);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
  $('#exampleModal2').modal('show');
});
function printPreview(content, css) {
    var printWindow = window.open('', '_blank');
    var printContent = $('#' + content + '').html();
    //printContent = printContent.replace(/<br\s*\/?>/gi, '');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">');
    printWindow.document.write(`</head><style>` + css + `</style><body class="container">` + printContent + `</body></html>`);
    printWindow.document.close();
    printWindow.focus();
    setTimeout(function() {
        printWindow.print();
        printWindow.close();
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
});
});

/* modal picture location*/
$(document).ready(function() {
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var product_id = button.data('product-id'); // Assuming you have a data attribute for product ID

      // Use AJAX to fetch location information
      $.get('get_location.php', { product_id: product_id }, function(data) {
        var locationData = JSON.parse(data);
        $('#p_location').html('Located at: ' + locationData.location);
      });
    });
  });

</script>