<?php
// Retrieve the product ID from the request
if (isset($_POST['removeProductId'])) {
  $removeProductId = $_POST['removeProductId'];

  // Remove the product from the cart
  $itemIndex = array_search($removeProductId, array_column($cart, 'id'));
  if ($itemIndex !== false) {
    unset($cart[$itemIndex]);
    $cart = array_values($cart); // Re-index the cart array

    // TODO: Update the cart display using your own logic
    // Call the appropriate function or code here to update the cart display
    // For example: echo json_encode($cart);

    // Alternatively, you can redirect or reload the page
    // header('Location: cart.php');
    // exit();
  }
}
?>

