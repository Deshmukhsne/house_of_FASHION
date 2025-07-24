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
      font-weight: 600;
    }
    .golden-btn:hover {
      background: linear-gradient(90deg, #e2a93eff, #f7c872ff, #e1aa46ff);
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
    <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control" placeholder="Search by customer, product, or status...">
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
              <select class="form-select" id="orderCategory" required onchange="populateProducts()">
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
              <select class="form-select" id="productSelect" required onchange="updateForm()">
                <option value="">Select</option>
              </select>
            </div>
          
            <div class="col-md-6">
              <label>Product Image</label><br>
              <img id="productImage" src="https://paaneriindia.com/cdn/shop/files/3407.jpg?v=1720518038" style="max-width: 120px; max-height: 150px; object-fit: cover;" class="border p-1">
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
                <option>Defected</option>
                <option>Dry Cleaning</option>
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
          <th>Category</th>
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
        <!-- Orders will be rendered here by JS -->
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  <nav>
    <ul class="pagination justify-content-center" id="ordersPagination"></ul>
  </nav>
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
    // Product data by category
    const productsByCategory = {
      Gown: [
        { name: 'Red Designer Gown', price: 500, photo: 'https://5.imimg.com/data5/SELLER/Default/2020/11/BB/ZB/QN/80075047/designer-gown.jpeg', id: 'gown' }
      ],
      Saree: [
        { name: 'Blue Silk Saree', price: 400, photo: 'https://i.pinimg.com/originals/7d/7e/7d7e7d7e7d7e7d7e7d7e7d7e7d7e7d7e.jpg', id: 'saree' }
      ],
      Lehenga: [
        { name: 'Bridal Lehenga', price: 800, photo: 'https://i.pinimg.com/originals/2a/2b/2a2b2a2b2a2b2a2b2a2b2a2b2a2b2a2b.jpg', id: 'lehenga' }
      ],
      Sherwani: [
        { name: 'Royal Sherwani', price: 300, photo: 'https://cdn.rajwadi.com/image/cache/data-2024/graceful-beige-heavy-embroidered-groom-sherwani-set-59169-800x1100.jpg', id: 'sherwani' }
      ],
      Accessories: [
        { name: 'Golden Clutch', price: 100, photo: 'https://i.pinimg.com/originals/3c/3d/3c3d3c3d3c3d3c3d3c3d3c3d3c3d3c3d.jpg', id: 'accessory' }
      ]
    };

    // Orders data (initial)
    let orders = [
      {
        customer: 'Priya Sharma',
        product: 'Red Designer Gown',
        category: 'Gown',
        photo: 'https://5.imimg.com/data5/SELLER/Default/2020/11/BB/ZB/QN/80075047/designer-gown.jpeg',
        days: 3,
        issue: '2025-07-22',
        ret: '2025-07-25',
        price: 1500,
        rented: 1,
        status: 'Rented'
      },
      {
        customer: 'Rahul Mehta',
        product: 'Royal Sherwani',
        category: 'Sherwani',
        photo: 'https://cdn.rajwadi.com/image/cache/data-2024/graceful-beige-heavy-embroidered-groom-sherwani-set-59169-800x1100.jpg',
        days: 2,
        issue: '2025-07-21',
        ret: '2025-07-23',
        price: 600,
        rented: 1,
        status: 'Returned'
      }
    ];
    let filteredOrders = [...orders];
    let currentCategory = 'All';
    let currentPage = 1;
    const pageSize = 10;

    // Populate products based on category
    function populateProducts() {
      const cat = document.getElementById('orderCategory').value;
      const productSelect = document.getElementById('productSelect');
      productSelect.innerHTML = '<option value="">Select</option>';
      if (productsByCategory[cat]) {
        productsByCategory[cat].forEach(p => {
          const opt = document.createElement('option');
          opt.value = p.name;
          opt.textContent = p.name;
          opt.setAttribute('data-price', p.price);
          opt.setAttribute('data-photo', p.photo);
          opt.setAttribute('data-id', p.id);
          productSelect.appendChild(opt);
        });
      }
      updateForm();
    }

    // Update form fields (image, price, return date)
    function updateForm() {
      const productSelect = document.getElementById('productSelect');
      const totalDays = document.getElementById('totalDays');
      const totalPrice = document.getElementById('totalPrice');
      const issueDate = document.getElementById('issueDate');
      const returnDate = document.getElementById('returnDate');
      const productImage = document.getElementById('productImage');
      const selected = productSelect.selectedOptions[0];
      const price = selected ? selected.getAttribute('data-price') || 0 : 0;
      const days = parseInt(totalDays.value) || 0;
      totalPrice.value = (price * days).toFixed(2);
      const issue = new Date(issueDate.value);
      if (!isNaN(issue)) {
        issue.setDate(issue.getDate() + days);
        returnDate.value = issue.toISOString().split('T')[0];
      }
      const photoSrc = selected ? selected.getAttribute('data-photo') : '';
      if (photoSrc) productImage.src = photoSrc;
    }

    document.getElementById('productSelect').addEventListener('change', updateForm);
    document.getElementById('totalDays').addEventListener('input', updateForm);
    document.getElementById('issueDate').addEventListener('change', updateForm);

    // Confirm order creation
    function confirmOrder() {
      const customer = document.getElementById('customerName').value;
      const category = document.getElementById('orderCategory').value;
      const productSelect = document.getElementById('productSelect');
      const selected = productSelect.selectedOptions[0];
      if (!selected) return false;
      const productName = selected.value;
      const photo = selected.getAttribute('data-photo');
      const days = document.getElementById('totalDays').value;
      const issue = document.getElementById('issueDate').value;
      const ret = document.getElementById('returnDate').value;
      const price = document.getElementById('totalPrice').value;
      const status = document.getElementById('status').value;
      // Find or set rented count
      let rented = 1;
      const match = orders.find(o => o.product === productName && o.customer === customer);
      if (match) rented = match.rented + 1;
      orders.push({
        customer,
        product: productName,
        category,
        photo,
        days,
        issue,
        ret,
        price,
        rented,
        status
      });
      Swal.fire('Success!', 'Rental Order Created!', 'success');
      filterAndRender();
      return false;
    }

    // Unified search and category filter
    function filterAndRender() {
      const search = document.getElementById('searchInput').value.toLowerCase();
      filteredOrders = orders.filter(order => {
        const matchCategory = (currentCategory === 'All' || order.category === currentCategory);
        const matchSearch =
          order.customer.toLowerCase().includes(search) ||
          order.product.toLowerCase().includes(search) ||
          order.status.toLowerCase().includes(search);
        return matchCategory && matchSearch;
      });
      currentPage = 1;
      renderOrders();
    }

    function filterByCategory(cat) {
      currentCategory = cat;
      document.querySelectorAll('.category-option').forEach(el => el.classList.remove('active'));
      document.querySelector('.category-option[onclick*="' + cat + '"]').classList.add('active');
      filterAndRender();
    }

    function filterTable() {
      filterAndRender();
    }

    // Render orders with pagination
    function renderOrders() {
      const table = document.getElementById('ordersTable');
      table.innerHTML = '';
      const start = (currentPage - 1) * pageSize;
      const end = start + pageSize;
      const pageOrders = filteredOrders.slice(start, end);
      pageOrders.forEach((order, idx) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${start + idx + 1}</td>
          <td>${order.customer}</td>
          <td>${order.product}</td>
          <td><img src="${order.photo}" class="order-img-thumb" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImageModal('${order.photo}')" style="max-width: 50px; cursor: pointer;"></td>
          <td>${order.category}</td>
          <td>${order.days}</td>
          <td>${order.issue}</td>
          <td>${order.ret}</td>
          <td>₹${order.price}</td>
          <td>${order.rented} times</td>
          <td>${order.status}</td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="openEditModal(this)">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="confirmDelete(${start + idx})">Delete</button>
          </td>
        `;
        table.appendChild(row);
      });
      renderPagination();
    }

    function renderPagination() {
      const totalPages = Math.ceil(filteredOrders.length / pageSize);
      const pag = document.getElementById('ordersPagination');
      pag.innerHTML = '';
      if (totalPages <= 1) return;
      for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = 'page-item' + (i === currentPage ? ' active' : '');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', function(e) {
          e.preventDefault();
          currentPage = i;
          renderOrders();
        });
        pag.appendChild(li);
      }
    }

    // Delete order
    function confirmDelete(idx) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'This order will be deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          orders.splice(idx, 1);
          filterAndRender();
          Swal.fire('Deleted!', 'Order has been deleted.', 'success');
        }
      });
    }

    // On page load
    window.onload = function() {
      filterAndRender();
    };

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

    // filterTable is now handled by filterAndRender (searches customer, product, status, case-insensitive)

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
  // Edit modal logic
  let editOrderIdx = null;
  function openEditModal(button) {
    const row = button.closest("tr");
    const idx = row.rowIndex - 1 + (currentPage - 1) * pageSize;
    editOrderIdx = idx;
    document.getElementById("editRowIndex").value = idx;
    document.getElementById("editStatus").value = orders[idx].status;
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
  }
  function saveEdit() {
    const idx = editOrderIdx;
    const newStatus = document.getElementById("editStatus").value;
    if (orders[idx]) {
      orders[idx].status = newStatus;
      filterAndRender();
      Swal.fire('Updated!', 'Order status has been updated.', 'success');
    }
    const modalEl = document.getElementById('editModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
  }
</script>

  
</body>

</html>







