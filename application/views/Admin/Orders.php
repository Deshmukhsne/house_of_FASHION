<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .golden-btn {
      background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
      color: #000;
      border: none;
    }
    .golden-btn:hover {
      background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
      color: #000;
    }
    .form-control, .form-select {
      border: 1px solid #D4AF37;
    }
    .modal-title {
      color: #D4AF37;
    }
    .table img {
      width: 80px;
      border-radius: 8px;
    }
    .badge {
      font-size: 0.8rem;
    }

    .category-option {
  cursor: pointer;
  padding: 6px 12px;
  border-bottom: 2px solid transparent;
  color: #333;
  font-weight: 500;
}

.category-option:hover {
  color: #000;
}

.category-option.active {
  border-bottom: 2px solid #000;
  color: #000;
}

  </style>


</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php $this->load->view('include/sidebar'); ?>

        <!-- Main Content Area -->
        <div class="main">
            <!-- Navbar -->
            <?php $this->load->view('include/navbar'); ?>

            <!-- Page Content -->
            <div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Rental Orders</h2>
      <div>
        <button class="btn golden-btn me-2" data-bs-toggle="modal" data-bs-target="#createOrderModal">Create Order</button>
        <!-- <button class="btn golden-btn me-2" onclick="downloadPDF()">Download PDF</button>
        <button class="btn golden-btn" onclick="downloadExcel()">Download Excel</button> -->
      </div>
    </div>

  <!-- Search Filter -->
  <div class="mb-3">
    <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control" placeholder="Search by customer name...">
  </div>


  <!-- Create Order Modal -->
  <div class="modal fade" id="createOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form onsubmit="return confirmOrder()">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create Rental Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body row g-3">

            <div class="col-md-6">
              <label>Customer</label>
              <select class="form-select" required id="customerName">
                <option value="">Select</option>
                <option>Priya Sharma</option>
                <option>Rahul Mehta</option>
              </select>
            </div>

            <div class="col-md-6 ">
              <label>Category</label>
              <select class="form-select" id="orderCategory" required>
                <option selected disabled>Select Category</option>
                <option value="Gown">Gown</option>
                <option value="Saree">Saree</option>
                <option value="Lehenga">Lehenga</option>
                <option value="Sherwani">Sherwani</option>
                <option value="Accessories">Accessories</option>
              </select>
          </div>
            <div class="col-md-6">
              <label>Product</label>
              <select class="form-select" id="productSelect" required>
                <option value="">Select</option>
                <option data-price="500" data-photo="https://5.imimg.com/data5/SELLER/Default/2020/11/BB/ZB/QN/80075047/designer-gown.jpeg" data-id="gown">Red Designer Gown</option>
                <option data-price="300" data-photo="https://cdn.rajwadi.com/image/cache/data-2024/graceful-beige-heavy-embroidered-groom-sherwani-set-59169-800x1100.jpg" data-id="sherwani">Royal Sherwani</option>
              </select>
            </div>
          
            <div class="col-md-6">
              <label>Product Image</label><br>
              <img id="productImage" src="https://i.pinimg.com/736x/85/55/d2/8555d25bcc4788c780a250c2000fe5fa.jpg" style="max-width: 120px; max-height: 150px; object-fit: cover;" class="border p-1">
            </div>

            <div class="col-md-6">
              <label>Number of Days</label>
              <input type="number" id="totalDays" class="form-control" value="1" min="1" required>
            </div>

            <div class="col-md-6">
              <label>Date of Issue</label>
              <input type="date" id="issueDate" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>Date of Return</label>
              <input type="date" id="returnDate" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label>Total Price (₹)</label>
              <input type="text" id="totalPrice" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label>Status</label>
              <select class="form-select" id="status">
                <option>Rented</option>
                <option>Returned</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn golden-btn">Create Order</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="d-flex justify-content-start align-items-center mb-3 gap-3 flex-wrap" id="categoryFilter">
  <span class="category-option active" onclick="filterByCategory('All')">All</span>
  <span class="category-option" onclick="filterByCategory('Saree')">Saree</span>
  <span class="category-option" onclick="filterByCategory('Lehenga')">Lehenga</span>
  <span class="category-option" onclick="filterByCategory('Gown')">Gown</span>
  <span class="category-option" onclick="filterByCategory('Sherwani')">Sherwani</span>
  <span class="category-option" onclick="filterByCategory('Accessories')">Accessories</span>
</div>
  <!-- Orders Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle mt-3" id="ordersTableContainer">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Image</th>
          <th>Days</th>
          <th>Issue</th>
          <th>Return</th>
          <th>Price</th>
          <th>Times Rented</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="ordersTable">
        <tr>
          <td>1</td>
          <td>Priya Sharma</td>
          <td>Red Designer Gown</td>
          <td><img src="https://5.imimg.com/data5/SELLER/Default/2020/11/BB/ZB/QN/80075047/designer-gown.jpeg" class="order-img-thumb" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImageModal(this.src)" style="max-width: 50px; cursor: pointer;"></td>
          <td>3</td>
          <td>2025-07-22</td>
          <td>2025-07-25</td>
          <td>₹1500</td>
          <td>1 times</td>
          <td>Rented</td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditModal(this)">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="confirmDelete()">Delete</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Rahul Mehta</td>
          <td>Royal Sherwani</td>
          <td><img src="https://cdn.rajwadi.com/image/cache/data-2024/graceful-beige-heavy-embroidered-groom-sherwani-set-59169-800x1100.jpg" class="order-img-thumb" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImageModal(this.src)" style="max-width: 50px; cursor: pointer;"></td>
          <td>2</td>
          <td>2025-07-21</td>
          <td>2025-07-23</td>
          <td>₹600</td>
          <td>1 times</td>
          <td>Returned</td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditModal(this)">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="confirmDelete()">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Image View Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 500px;">
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Order Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editRowIndex">
        <div class="mb-3">
          <label for="editStatus" class="form-label">Status</label>
          <select class="form-select" placeholder="Select Order Status" id="editStatus"> 
            <option value="Pending">Pending</option>
            <option value="Approved">Defected</option>
            <option value="Returned">Dry Cleaning</option>
            <option value="Returned">Rented</option>
            <option value="Returned">Returned</option>
            <option value="Returned">Cancelled</option>

          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveEdit()">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  function showImageModal(src) {
    document.getElementById("modalImage").src = src;
  }
</script>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const productSelect = document.getElementById('productSelect');
    const totalDays = document.getElementById('totalDays');
    const totalPrice = document.getElementById('totalPrice');
    const issueDate = document.getElementById('issueDate');
    const returnDate = document.getElementById('returnDate');
    const productImage = document.getElementById('productImage');

    const counts = {
      gown: 1,
      sherwani: 1
    };

    function updateForm() {
      const selected = productSelect.selectedOptions[0];
      const price = selected.getAttribute('data-price') || 0;
      const days = parseInt(totalDays.value) || 0;
      totalPrice.value = (price * days).toFixed(2);

      const issue = new Date(issueDate.value);
      if (!isNaN(issue)) {
        issue.setDate(issue.getDate() + days);
        returnDate.value = issue.toISOString().split('T')[0];
      }

      const photoSrc = selected.getAttribute('data-photo');
      if (photoSrc) productImage.src = photoSrc;
    }

    productSelect.addEventListener('change', updateForm);
    totalDays.addEventListener('input', updateForm);
    issueDate.addEventListener('change', updateForm);

    function confirmOrder() {
      const customer = document.getElementById('customerName').value;
      const selected = productSelect.selectedOptions[0];
      const productName = selected.text;
      const photo = selected.getAttribute('data-photo');
      const days = totalDays.value;
      const issue = issueDate.value;
      const ret = returnDate.value;
      const price = totalPrice.value;
      const status = document.getElementById('status').value;
      const productId = selected.getAttribute('data-id');

      const rentedCount = ++counts[productId];

      const table = document.getElementById('ordersTable');
      const rowCount = table.rows.length + 1;
      const newRow = `<tr>
        <td>${rowCount}</td>
        <td>${customer}</td>
        <td>${productName}</td>
        <td><img src="${photo}"></td>
        <td>${days}</td>
        <td>${issue}</td>
        <td>${ret}</td>
        <td>₹${price}</td>
        <td>${rentedCount} times</td>
        <td>${status}</td>
        <td>
          <button class="btn btn-sm btn-primary">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="confirmDelete()">Delete</button>
        </td>
      </tr>`;
      table.insertAdjacentHTML('beforeend', newRow);

      Swal.fire('Success!', 'Rental Order Created!', 'success');
      return false;
    }

    function confirmDelete() {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This order will be deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire('Deleted!', 'Order has been deleted.', 'success');
        }
      });
    }

    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#ordersTable tr");
      rows.forEach(row => {
        const customer = row.cells[1].textContent.toLowerCase();
        row.style.display = customer.includes(input) ? "" : "none";
      });
    }

    function downloadPDF() {
      Swal.fire('PDF Download', 'PDF export logic goes here.', 'info');
    }

    function downloadExcel() {
      Swal.fire('Excel Download', 'Excel export logic goes here.', 'info');
    }
  </script>
    
    </div>

    </div>
    </div>
    </div>

    <script>
        // Navbar  toggler
        const toggler = document.querySelector(".toggler-btn");
        const closeBtn = document.querySelector(".close-sidebar");
        const sidebar = document.querySelector("#sidebar");

        if (toggler && sidebar) {
            toggler.addEventListener("click", function() {
                sidebar.classList.toggle("collapsed");
            });
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener("click", function() {
                sidebar.classList.remove("collapsed");
            });
        }
    </script>

    <!-- edit button -->
     <script>
  function openEditModal(button) {
    const row = button.closest("tr");
    const statusCell = row.cells[9]; 
    const currentStatus = statusCell.textContent;

    document.getElementById("editRowIndex").value = row.rowIndex;
    document.getElementById("editStatus").value = currentStatus;

    // Show modal
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
  }

  function saveEdit() {
    const rowIndex = document.getElementById("editRowIndex").value;
    const newStatus = document.getElementById("editStatus").value;

    const table = document.getElementById("ordersTable");
    const row = table.rows[rowIndex - 1]; // Adjust for 0-index

    row.cells[9].textContent = newStatus;

    Swal.fire('Updated!', 'Order status has been updated.', 'success');
    const modalEl = document.getElementById('editModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
  }
</script>

  
</body>

</html>







