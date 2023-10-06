function checkInventory(product, supplierEmail) {
    const currentInventory = product.inventory;
    const threshold = product.threshold;
    
    if (currentInventory <= threshold) {
      const message = `Dear supplier, we need to order more ${product.name}. Current inventory is ${currentInventory} and threshold is ${threshold}.`;
      sendEmail(supplierEmail, message);
    }
  }
  
  function sendEmail(recipient, message) {
    // code to send email using a service like SendGrid or Nodemailer
  }
  
  // example usage
  const product = {
    name: "Widget",
    inventory: 100,
    threshold: 50
  };
  
  const supplierEmail = "supplier@example.com";
  checkInventory(product, supplierEmail);
  