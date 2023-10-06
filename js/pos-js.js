// Declare the products and cart variables globally
let products = [];
let cart = [];

// Get the product ID from the query string
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

// Fetch products
function fetchProducts() {
  const url = 'database/connection-pos.php'; // Modify the URL if necessary

  fetch(url)
    .then(response => response.json())
    .then(data => {
      products = data.map(item => ({
        id: item.id,
        name: item.product_name,
        img: item.img,
        category: item.category,
        price: parseFloat(item.price),
        stocks: parseInt(item.stocks)
      }));

      displayProducts();

      // Fetch the product by ID and display it
      if (id) {
        fetchProductById(id)
          .then(product => {
            console.log("Fetched product:", product);
            // Rest of the code
          })
          .catch(error => {
            console.error("Error fetching product:", error);
            // Rest of the error handling code
          });
      }
    })
    .catch(error => {
      console.error("Error fetching products:", error);
    });
}

fetchProducts();


// Update stock count
function updateStock(productId, stockCount) {
  const url = 'database/update-stock.php'; // Modify the URL if necessary
  const data = new URLSearchParams();
  data.append('id', productId);
  data.append('stocks', stockCount);

  return fetch(url, {
    method: 'POST',
    body: data
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Failed to update stock count');
      }
    })
    .catch(error => {
      console.error('Error updating stock count:', error);
      throw error;
    });
}




// Fetch product by ID
function fetchProductById(id) {
  const url = `database/g-product.php?id=${id}`;

  return fetch(url)
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error("Failed to fetch product");
      }
    })
    .then(data => {
      if (data && data.products) {
        const product = data.products; // Change 'product' to 'products'
        product.image = data.image; // Assuming the image URL is available in the 'image' property of the response
        return product;
      } else {
        throw new Error("Product not found");
      }
    })
    .catch(error => {
      console.error("Error fetching product:", error);
      throw error;
    });
}



// View product image
function viewProductImage(productId) {
  const product = products.find(item => item.id === productId);
  const modal = document.getElementById("productImageModal");
  const modalImage = document.getElementById("modalImage");

  if (product && product.image) {
    modalImage.src = `./uploads/products/${product.image}`;
    modal.style.display = "block";
  } else {
    console.error("Product image not found");
  }
}



// Function to get product details by ID
function getProductById(productId) {
  // Implement your logic to retrieve the product details from the server
  // Return the product details as an object
}

// Function to display product details
function viewProductDetails(productId) {
  // Get the product details using the getProductById function
  const product = getProductById(productId);

  // Display the product details
  console.log("Product Details:");
  console.log("Name:", product.name);
  console.log("Price:", product.price);
  console.log("Description:", product.description);
}

// Event handler for the view details button
function handleViewDetails(event) {
  const productId = event.target.dataset.productId;
  viewProductDetails(productId);
}

// Attach event listeners to view details buttons
const viewDetailsButtons = document.querySelectorAll(".view-details");
viewDetailsButtons.forEach((button) => {
  button.addEventListener("click", handleViewDetails);
});


function filterProducts(category) {
  if (category === "all") {
    displayProducts();
  } else {
    const filteredProducts = products.filter(product => product.category.toLowerCase() === category.toLowerCase());
    const productList = document.getElementById("productList");

    // Remove existing rows from the table
    while (productList.rows.length > 1) {
      productList.deleteRow(1);
    }

    filteredProducts.forEach(product => {
      const row = productList.insertRow();

      const productNameCell = row.insertCell();
      productNameCell.textContent = product.name;

      const viewButtonCell = row.insertCell();
      const viewButton = document.createElement("button");
      viewButton.textContent = "View";
      viewButton.addEventListener("click", () => viewProductDetails(product.id));
      viewButtonCell.appendChild(viewButton);

      const categoryCell = row.insertCell();
      categoryCell.textContent = product.category;

      const priceCell = row.insertCell();
      priceCell.textContent = `₱${parseFloat(product.price).toFixed(2)}`;

      const stocksCell = row.insertCell();
      stocksCell.textContent = product.stocks;

      const qtyCell = row.insertCell();
      const quantityInput = document.createElement("input");
      quantityInput.type = "number";
      quantityInput.min = 1;
      quantityInput.max = product.stocks;
      quantityInput.style.width = "100px"; // Change the width as desired
      qtyCell.appendChild(quantityInput);

      const actionCell = row.insertCell();
      const addButton = document.createElement("button");
      addButton.textContent = "+Add Product";
      addButton.addEventListener("click", () => addProductToCart(product.id, quantityInput)); // Pass the quantityInput value
      actionCell.appendChild(addButton);
    });
  }
}




// Search products
function searchProducts() {
  const searchTerm = document.querySelector(".search-input").value.toLowerCase();
  const filteredProducts = products.filter(product =>
    product.name.toLowerCase().includes(searchTerm)
  );
  const productList = document.getElementById("productList");

  // Remove existing rows from the table
  while (productList.rows.length > 1) {
    productList.deleteRow(1);
  }

  filteredProducts.forEach(product => {
    const row = productList.insertRow();

    const productNameCell = row.insertCell();
    productNameCell.textContent = product.name;

    const viewButtonCell = row.insertCell();
    const viewButton = document.createElement("button");
    viewButton.textContent = "View";
    viewButton.addEventListener("click", () => viewProductDetails(product.id));
    viewButtonCell.appendChild(viewButton);

    const categoryCell = row.insertCell();
    categoryCell.textContent = product.category;

    const priceCell = row.insertCell();
    priceCell.textContent = `₱${parseFloat(product.price).toFixed(2)}`;

    const stocksCell = row.insertCell();
    stocksCell.textContent = product.stocks;

    const qtyCell = row.insertCell();
    const quantityInput = document.createElement("input");
    quantityInput.type = "number";
    quantityInput.min = 1;
    quantityInput.max = product.stocks;
    quantityInput.style.width = "100px"; // Change the width as desired
    qtyCell.appendChild(quantityInput);

    const actionCell = row.insertCell();
    const addButton = document.createElement("button");
    addButton.textContent = "+Add Product";
    addButton.addEventListener("click", () => addProductToCart(product.id, quantityInput)); // Pass the quantityInput value
    actionCell.appendChild(addButton);
  });
}


function updateCart() {
  const cartItems = document.getElementById("cartItems");
  cartItems.innerHTML = "";

  // Add column titles
  const cartHeaderRow = document.createElement("tr");
  cartHeaderRow.innerHTML = `
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Action</th>
  `;
  cartItems.appendChild(cartHeaderRow);

  cart.forEach(item => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${item.name}</td>
      <td>
        <button onclick="decreaseQuantity(${item.id})">-</button>
        ${item.quantity}
        <button onclick="increaseQuantity(${item.id})">+</button>
      </td>
      <td>₱${item.price.toFixed(2)}</td>
      <td>
        <button onclick="removeItemFromCart(${item.id})">Remove</button>
      </td>
    `;
    cartItems.appendChild(row);
  });

  updateTotal(); // Update total

  const total = calculateTotal();
  const cartTotal = document.getElementById("cartTotal");
  cartTotal.textContent = `₱${total.toFixed(2)}`;

  // Enable or disable checkout button based on cart items
  const checkoutButton = document.getElementById("checkoutButton");
  checkoutButton.disabled = cart.length === 0;
}


  
const increaseQuantity = (productId) => {
  const product = cart.find(item => item.id === parseInt(productId));
  if (product) {
    product.quantity++;
    updateCart();
    updateSubtotal();
  }
};

const decreaseQuantity = (productId) => {
  const product = cart.find(item => item.id === parseInt(productId));
  if (product) {
    if (product.quantity > 1) {
      product.quantity--;
      updateCart();
      updateSubtotal();
    }
  }
};


async function addProductToCart(productId, quantityInput) {
  // alert(quantityInput.value)
  displayProducts();
  const product = products.find(item => item.id === productId);
  if (product) {
    const quantity = parseInt(quantityInput.value);

    if (!isNaN(quantity) && Number.isInteger(quantity) && quantity > 0 && quantity <= product.stocks) {
      if (quantity > product.stocks) {
        alert("Not enough stocks!");
        return;
      }

      const item = {
        id: product.id,
        name: product.name,
        price: product.price,
        quantity: quantity
      };
      cart.push(item);
      product.stocks -= quantity;

      updateCart();
      updateSubtotal();

      try {
        await updateStock(product.id, product.stocks); // Update stock count in the database
        console.log("Stock count updated in the database.");
      } catch (error) {
        console.error("Error updating stock count:", error);
      }

    } else {
      alert("Invalid quantity 1!");
    }
  } else {
    alert("Invalid product!");
  }
}


  
  

// Display products
function displayProducts() {
  const productList = document.getElementById("productList");

  // Remove existing rows from the table
  while (productList.rows.length > 1) {
    productList.deleteRow(1);
  }

  products.forEach(product => {
    const row = productList.insertRow();

    const productNameCell = row.insertCell();
    productNameCell.textContent = product.name;

    const viewButtonCell = row.insertCell();
    const viewButton = document.createElement("button");
    viewButton.textContent = "View";
    //viewButton.addEventListener("click", () => viewProductDetails(product.id));
    viewButton.addEventListener("click", () => viewProductImage(product.id));
    viewButtonCell.appendChild(viewButton);

    const categoryCell = row.insertCell();
    categoryCell.textContent = product.category;
    

    const priceCell = row.insertCell();
    priceCell.textContent = `₱${parseFloat(product.price).toFixed(2)}`;

    const stocksCell = row.insertCell();
    stocksCell.textContent = product.stocks;

          const qtyCell = row.insertCell();
          const quantityInput = document.createElement("input");
          quantityInput.type = "number";
          quantityInput.min = 1;
          quantityInput.max = product.stocks;
          quantityInput.style.width = "100px"; // Change the width as desired
          qtyCell.appendChild(quantityInput);

          const actionCell = row.insertCell();
          const addButton = document.createElement("button");
          addButton.textContent = "+Add Product";
          addButton.addEventListener("click", () => addProductToCart(product.id, quantityInput)); // Pass the quantityInput value
          actionCell.appendChild(addButton);

  });
}

  


// Product View
function viewProductImage(productId) {
  //alert(productId)
  const product = products.find(item => item.id === productId);
  const productImageContainer = document.getElementById("productImageContainer");
  const productImage = document.getElementById("productImage");

  if (product && product.image) {
    productImage.src = `./uploads/products/${product.image}`;
    productImageContainer.style.display = "block";
  } else {
    console.error("Product image not found");
  }

    // AJAX request to fetch the image URL
    const xhr = new XMLHttpRequest();
  xhr.open('GET', `database/get-product-image.php?id=${productId}`, true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      const productImageContainer = document.getElementById("productImageContainer");
      const productImage = document.getElementById("productImage");
      
      if (data.image) {
        productImage.src = data.image;
        productImageContainer.style.display = "block";
      } else {
        console.error("Product image not found");
      }
    } else {
      console.error("Error fetching product image:", xhr.statusText);
    }
  };
  xhr.onerror = function() {
    console.error("Error fetching product image");
  };
  xhr.send();
}


// View product image
// function viewProductImage(productId) {
//   const product = products.find(item => item.id === productId);
//   const productImageContainer = document.getElementById("productImageContainer");
//   const productImage = document.getElementById("productImage");

//   if (product && product.image) {
//     productImage.src = product.image;
//     productImageContainer.style.display = "block";
//   } else {
//     console.error("Product image not found");
//   }
// }


// Remove item from cart
function removeItemFromCart(productId) {
  // Ask for confirmation
  if (confirm("Are you sure you want to remove this product from your cart?")) {
    const updatedCart = cart.filter(item => item.id !== productId);
    cart = updatedCart;
    updateCart();
    updateSubtotal(); // Update the subtotal
  }
}




// Calculate subtotal
function calculateSubtotal() {
  return cart.reduce((subtotal, item) => subtotal + item.price * item.quantity, 0);
}


function calculateTotal() {
  var subtotal = parseInt(document.getElementById("subtotal").value);
  var discount = parseInt(document.getElementById("discount").value);

  if (isNaN(discount)) {
    discount = 0; // Set discount to 0 if it is not a number
  }

  var total = subtotal - discount;

  if (isNaN(total)) {
    total = subtotal; // Set total to subtotal if it is not a number
  }

  document.getElementById("total").value = total;
}







function checkout() {
    const subtotal = calculateSubtotal();
    const checkoutAt = new Date().toLocaleString();
    const user = 'Jay'; // Replace with actual user
  
    // Send checkout data to the database or API
    // Replace with your implementation
    const checkoutData = {
      items: cart,
      subtotal: subtotal,
      checkoutAt: checkoutAt,
      user: user
    };
    console.log("Checkout Data:", checkoutData);
  
    // Clear cart and update UI
    cart = [];
    updateCart();
    updateSubtotal(); // Update the subtotal
    discountInput.value = "";
    alert("Checkout successful!");
  }
  


function updateSubtotal() {
  const subtotal = calculateSubtotal();

  // Update cart subtotal display
  const cartSubtotal = document.getElementById("cartSubtotal");
  cartSubtotal.textContent = `₱${subtotal.toFixed(2)}`;
}



// Update total amount
function updateTotal() {
  const subtotal = calculateSubtotal();
  const discountInput = document.getElementById("discountInput");
  const discountPercentage = parseFloat(discountInput.value);

  // Compute total with discount
  const discountAmount = subtotal * (discountPercentage / 100);
  const total = subtotal - discountAmount;

  // Update cart total display
  const cartTotal = document.getElementById("cartTotal");
  cartTotal.textContent = `₱${total.toFixed(2)}`;

  // Update subtotal even if no discount is applied
  const subtotalElement = document.getElementById("cartSubtotal");
  subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
}

// Add event listener to update total when the discount input changes
const discountInput = document.getElementById("discountInput");
discountInput.addEventListener("input", updateTotal);


  

  // modal for the cart quantity
  // Update the "Add to Cart" modal
function updateCartModal() {
  const quantityInput = document.getElementById("quantityInput");
  quantityInput.addEventListener("focus", updateCartModal);
  const modal = document.getElementById("cartModal");
  const backdrop = document.getElementById("backdrop");

  // Display the modal and backdrop
  modal.style.display = "block";
  backdrop.style.display = "block";

  // Center the modal on the screen
  const modalWidth = modal.offsetWidth;
  const modalHeight = modal.offsetHeight;
  const screenWidth = window.innerWidth;
  const screenHeight = window.innerHeight;
  const modalLeft = (screenWidth - modalWidth) / 2;
  const modalTop = (screenHeight - modalHeight) / 2;
  modal.style.left = `${modalLeft}px`;
  modal.style.top = `${modalTop}px`;

  // Blur the background
  document.body.style.filter = "blur(5px)";

  // Focus on the quantity input field
  quantityInput.focus();
}

// Handle the key press event
function handleKeyPress(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    confirmCart();
  }
}

// Confirm the cart
function confirmCart() {
  const quantityInput = document.getElementById("quantityInput");
  const quantity = parseInt(quantityInput.value);

  if (!isNaN(quantity) && quantity > 0) {
    // Add the product to the cart with the specified quantity
    // ...
    // Rest of the code to add the product to the cart
  }

  // Reset the quantity input field
  quantityInput.value = "";

  // Hide the modal and backdrop
  const modal = document.getElementById("cartModal");
  const backdrop = document.getElementById("backdrop");
  modal.style.display = "none";
  backdrop.style.display = "none";

  // Remove the blur effect from the background
  document.body.style.filter = "none";
}
