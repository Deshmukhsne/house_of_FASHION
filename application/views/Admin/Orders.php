<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
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
              <label>Customer Name</label>
              <input type="text" class="form-control" id="customerName" placeholder="Enter customer name" required>
            </div>
            <div class="col-md-6">
              <label>Customer Number</label>
              <input type="tel" class="form-control" id="customerNumber" placeholder="Enter customer number" pattern="[0-9]{10}" maxlength="10" required>
            </div>
            <div class="col-md-6">
              <label>Date of Issue</label>
              <input type="date" id="issueDate" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Date of Return</label>
              <input type="date" id="returnDate" class="form-control" required>
            </div>
           
            <div class="col-md-12">
              <label>Items</label>
              <table class="table table-bordered" id="itemsTable">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Price/Day (₹)</th>
                    <th>Rented Number</th>
                    <th>Total Price (₹)</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="itemsTableBody">
                  <!-- Items will be added here -->
                </tbody>
                <tfoot>
                  <tr>
                    <td>
                      <select class="form-select" id="itemCategory" onchange="populateProducts('itemCategory','itemProduct')">
                        <option selected disabled>Select Category</option>
                        <option value="Gown">Gown</option>
                        <option value="Saree">Saree</option>
                        <option value="Lehenga">Lehenga</option>
                        <option value="Sherwani">Sherwani</option>
                        <option value="Accessories">Accessories</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-select" id="itemProduct" onchange="updateItemForm()">
                        <option value="">Select</option>
                      </select>
                    </td>
                    <td><input type="text" class="form-control" id="itemPrice" placeholder="Price per day"></td>
                    <td><input type="number" class="form-control" id="itemDays" value="1" min="1" onchange="updateItemForm()"></td>
                    <td><input type="number" class="form-control" id="itemRented" value="1" min="1"></td>
                    <td><input type="text" class="form-control" id="itemTotalPrice" readonly></td>
                    <td><img id="itemImage" src="" style="max-width: 60px; max-height: 60px; object-fit: cover;" class="border p-1"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="clearItemRow()">&#10006;</button>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="8" class="text-end mt-2">
                      <button type="button" class="btn btn-success btn-sm" onclick="addItemToTable()">Add Row</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
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


  <!-- Orders Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle mt-3" id="ordersTableContainer">
      <thead class="table-dark">
        <tr>
          <th>Order Id</th>
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

    // Populate products based on category (for both modal and item row)
    function populateProducts(categoryId = 'orderCategory', productId = 'productSelect') {
      const cat = document.getElementById(categoryId).value;
      const productSelect = document.getElementById(productId);
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
      if(productId === 'itemProduct') updateItemForm();
    }

    // Update item row fields (image, price, total)
    function updateItemForm() {
      const productSelect = document.getElementById('itemProduct');
      const itemPrice = document.getElementById('itemPrice');
      const itemDays = document.getElementById('itemDays');
      const itemTotalPrice = document.getElementById('itemTotalPrice');
      const itemImage = document.getElementById('itemImage');
      const selected = productSelect.selectedOptions[0];
      if(selected) {
        if(!itemPrice.value) itemPrice.value = selected.getAttribute('data-price') || 0;
        itemImage.src = selected.getAttribute('data-photo') || '';
      }
      const price = parseFloat(itemPrice.value) || 0;
      const days = parseInt(itemDays.value) || 0;
      itemTotalPrice.value = (price * days).toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('itemProduct').addEventListener('change', updateItemForm);
      document.getElementById('itemPrice').addEventListener('input', updateItemForm);
      document.getElementById('itemDays').addEventListener('input', updateItemForm);
    });

    // Add item to table
    let items = [];
    function addItemToTable() {
      const cat = document.getElementById('itemCategory').value;
      const prodSelect = document.getElementById('itemProduct');
      const prod = prodSelect.value;
      const price = parseFloat(document.getElementById('itemPrice').value) || 0;
      const days = parseInt(document.getElementById('itemDays').value) || 0;
      const rented = parseInt(document.getElementById('itemRented').value) || 1;
      const total = parseFloat(document.getElementById('itemTotalPrice').value) || 0;
      const img = document.getElementById('itemImage').src;
      if(!cat || !prod || !days) return;
      items.push({category: cat, product: prod, price, days, rented, total, img});
      renderItemsTable();
      clearItemRow();
    }

    function clearItemRow() {
      document.getElementById('itemCategory').selectedIndex = 0;
      document.getElementById('itemProduct').innerHTML = '<option value="">Select</option>';
      document.getElementById('itemPrice').value = '';
      document.getElementById('itemDays').value = 1;
      document.getElementById('itemRented').value = 1;
      document.getElementById('itemTotalPrice').value = '';
      document.getElementById('itemImage').src = '';
    }

    function renderItemsTable() {
      const tbody = document.getElementById('itemsTableBody');
      tbody.innerHTML = '';
      items.forEach((item, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${item.category}</td>
          <td>${item.product}</td>
          <td>${item.price}</td>
          <td>${item.days}</td>
          <td>${item.rented}</td>
          <td>${item.total}</td>
          <td><img src="${item.img}" style="max-width: 60px; max-height: 60px; object-fit: cover;" class="border p-1"></td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${idx})">&#10006;</button></td>
        `;
        tbody.appendChild(tr);
      });
    }

    function removeItem(idx) {
      items.splice(idx, 1);
      renderItemsTable();
    }

    // Update form fields (image, price, return date)
    function confirmOrder() {
      const customer = document.getElementById('customerName').value;
      const customerNumber = document.getElementById('customerNumber').value;
      const issue = document.getElementById('issueDate').value;
      const ret = document.getElementById('returnDate').value;
      const status = document.getElementById('status').value;
      if (!customer || !customerNumber || !issue || !ret || items.length === 0) {
        Swal.fire('Error', 'Please fill all required fields and add at least one item.', 'error');
        return false;
      }
      // Save as one order with multiple items
      orders.push({
        customer,
        customerNumber,
        issue,
        ret,
        status,
        items: [...items]
      });
      items = [];
      renderItemsTable();
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

    // Render orders with pagination (show customer and their items)
    function renderOrders() {
      const table = document.getElementById('ordersTable');
      table.innerHTML = '';
      const start = (currentPage - 1) * pageSize;
      const end = start + pageSize;
      const pageOrders = filteredOrders.slice(start, end);
      let rowNum = start + 1;
      pageOrders.forEach((order, idx) => {
        if(order.items && order.items.length) {
          order.items.forEach((item, itemIdx) => {
            const row = document.createElement('tr');
            let actionButtons = `
              <button class=\"btn btn-sm btn-primary\" onclick=\"openEditModal(this)\">Edit</button>
              <button class=\"btn btn-sm btn-danger\" onclick=\"confirmDelete(${start + idx})\">Delete</button>
            `;
            if (order.status === 'Returned' && item.category !== 'Accessories') {
              actionButtons = `
                <a class=\"btn btn-sm btn-warning\" href=\"<?= base_url('AdminController/DryCleaning_Forward') ?>\">Dry Clean</a> ` + actionButtons;
            }
            row.innerHTML = `
              ${itemIdx === 0 ? `<td rowspan='${order.items.length}'>${rowNum++}</td>` : ''}
              ${itemIdx === 0 ? `<td rowspan='${order.items.length}'>${order.customer}<br><small>${order.customerNumber}</small></td>` : ''}
              <td>${item.product}</td>
              <td><img src="${item.img}" style="max-width:40px;max-height:40px;object-fit:cover;"/></td>
              <td>${item.category}</td>
              <td>${item.days}</td>
              <td>${order.issue}</td>
              <td>${order.ret}</td>
              <td>${item.total}</td>
              <td>${item.rented || 1}</td>

              ${itemIdx === 0 ? `<td rowspan='${order.items.length}'>${order.status}</td>` : ''}
              ${itemIdx === 0 ? `<td rowspan='${order.items.length}'>${(order.status === 'Dry Cleaning') ? '' : actionButtons}</td>` : ''}
            `;
            table.appendChild(row);
          });
        }
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







