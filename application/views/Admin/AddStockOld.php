<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddStock</title>
</head>
<body>
     <!-- Sidebar -->
<?php $this->load->view('include/Sidebar'); ?>
  <div class="wrapper sidebar-expanded" id="dashboardWrapper">
    <div class="main-content p-4" id="mainContent">
      <!-- Navbar Include -->
<?php $this->load->view('include/Navbar'); ?>
    <!-- Form -->
<div class="form-container">
  <div class="form-title">Add Stock</div>
  <form id="addCustomerForm">
    <div class="row g-4">

      <div class="col-md-6">
        <label for="productId" class="form-label">Product ID</label>
        <input type="text" id="productId" class="form-control" placeholder="e.g. P1023" required>
      </div>

      <div class="col-md-6">
        <label for="productName" class="form-label">Product Name</label>
        <input type="text" id="productName" class="form-control" placeholder="e.g. Golden Sherwani" required>
      </div>

      <div class="col-md-6">
        <label for="category" class="form-label">Category</label>
        <select id="category" class="form-select" required>
          <option value="" selected disabled>Select Category</option>
          <option>Lehenga</option>
          <option>Sherwani</option>
          <option>Gown</option>
          <option>Suit</option>
          <option>Accessories</option>
        </select>
      </div>

      <div class="col-md-4">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" id="quantity" class="form-control" value="1" min="1" required>
      </div>

      <div class="col-md-4">
        <label for="price" class="form-label">Price per Unit (₹)</label>
        <input type="number" id="price" class="form-control" value="0" required>
      </div>

      <div class="col-md-4">
        <label for="total" class="form-label">Total Price (₹)</label>
        <input type="text" id="total" class="form-control" readonly>
      </div>

      <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <input type="text" id="status" class="form-control" value="Available" readonly>
      </div>

      <div class="col-md-6">
        <label for="image" class="form-label">Upload Product Image</label>
        <input type="file" id="image" class="form-control" accept="image/*">
      </div>

      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-gold w-100">Add Product</button>
      </div>

    </div>
  </form>
</div>

<!-- Script -->
<script>
  const priceInput = document.getElementById('price');
  const quantityInput = document.getElementById('quantity');
  const totalInput = document.getElementById('total');

  function updateTotal() {
    const price = parseFloat(priceInput.value) || 0;
    const quantity = parseInt(quantityInput.value) || 0;
    totalInput.value = (price * quantity).toFixed(2);
  }

  priceInput.addEventListener('input', updateTotal);
  quantityInput.addEventListener('input', updateTotal);

  document.getElementById('addCustomerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Customer and product added successfully!');
    this.reset();
    updateTotal();
  });

  updateTotal();
</script>

</body>
</html>


