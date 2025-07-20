<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - House of Fashion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>

 .btn-gold {
  background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
  color: #000;
  font-weight: 600;
  border: none;
  transition: all 0.3s ease;
}

.btn-gold:hover {
  background: #b37b16;
  color: white;
}

.image-preview {
  position: relative;
  max-height: 300px;
  overflow: hidden;
  border: 2px solid #ddd;
}

.image-preview img {
  width: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.overlay-label {
  position: absolute;
  top: 10px;
  left: 10px;
  background-color: rgba(0,0,0,0.6);
  color: white;
  padding: 6px 12px;
  border-radius: 5px;
  font-size: 13px;
  display: none;
}

.view-details-btn {
  position: absolute;
  bottom: 10px;
  right: 10px;
  font-size: 12px;
}


    body {
      background: #f7f6fb;
    }

    .main-content {
      transition: all 0.3s ease;
      margin-left: 250px;
    }

    .wrapper.sidebar-collapsed .main-content {
      margin-left: 70px;
    }

    @media (max-width: 991.98px) {
      .main-content {
        margin-left: 0 !important;
      }
       .wrapper.sidebar-collapsed .main-content {
      margin-left: 170px;
    }
    }

    @media (max-width: 576px) {
      .chart-card, .stat-card {
        padding: 15px;
      }

      .main-content {
        padding: 1rem !important;
      }

      canvas {
        max-width: 100%;
        height: auto;
      }

      .d-flex.justify-content-between.align-items-center.mb-2 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
      }
        .wrapper.sidebar-collapsed .main-content {
      margin-left: 170px;
    }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
<?php $this->load->view('include/Sidebar'); ?>
    <div class="wrapper sidebar-expanded" id="dashboardWrapper">
        <div class="main-content p-4" id="mainContent">
            <!-- Navbar Include -->
            <?php $this->load->view('include/Navbar'); ?>
            <div class="container-fluid">
        <!-- Stats Row -->
            <!-- Add this inside your <body> -->
<button class="btn btn-gold m-4" data-bs-toggle="modal" data-bs-target="#addStockModal">Add Stock</button>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="addStockModalLabel">Add Stock</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="addStockForm">
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
                <option value="" disabled selected>Select Category</option>
                <option>Lehenga</option>
                <option>Sherwani</option>
                <option>Gown</option>
                <option>Suit</option>
                <option>Accessories</option>
              </select>
            </div>

            <div class="col-md-4">
              <label for="quantity" class="form-label">Quantity</label>
              <input type="number" id="quantity" class="form-control" min="1" value="1" required>
            </div>

            <div class="col-md-4">
              <label for="price" class="form-label">Price (₹)</label>
              <input type="number" id="price" class="form-control" min="0" value="0" required>
            </div>

            <div class="col-md-4">
              <label for="total" class="form-label">Total (₹)</label>
              <input type="text" id="total" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label for="status" class="form-label">Status</label>
              <select id="status" class="form-select" required>
                <option>Available</option>
                <option>Out of Stock</option>
                <option>On Rent</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="image" class="form-label">Upload Product Image</label>
              <input type="file" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="col-12">
              <div class="image-preview position-relative mt-3" id="imagePreviewBox" style="display:none;">
                <img id="preview" class="img-fluid rounded-3" />
                <div class="overlay-label" id="statusOverlay"></div>
                <button type="button" class="btn btn-dark btn-sm view-details-btn">View Details</button>
              </div>
            </div>

            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-gold w-100">Add Product</button>
            </div>

          </div>
        </form>
      </div>
    </div>
    </div
            </div>
        </div>
    </div>

  <!-- Scripts -->
   <Script>

    // Sidebar Toggle Logic
    const sidebar = document.getElementById("sidebar");
    const dashboardWrapper = document.getElementById("dashboardWrapper");
    const overlay = document.getElementById("overlay");
    const toggleSidebarBtn = document.getElementById("toggleSidebar");

    if (toggleSidebarBtn) {
      toggleSidebarBtn.addEventListener("click", function() {
        sidebar.classList.toggle("collapsed");
        dashboardWrapper.classList.toggle("sidebar-collapsed");
        dashboardWrapper.classList.toggle("sidebar-expanded");
        // For mobile, show overlay if sidebar is open
        if (window.innerWidth <= 768) {
          if (sidebar.classList.contains("collapsed")) {
            sidebar.classList.remove("show-mobile");
            if (overlay) overlay.classList.remove("show");
          } else {
            sidebar.classList.add("show-mobile");
            if (overlay) overlay.classList.add("show");
          }
        }
      });
    }

    // Hide sidebar on overlay click (mobile)
    if (overlay) {
      overlay.addEventListener("click", function() {
        sidebar.classList.remove("show-mobile");
        overlay.classList.remove("show");
      });
    }

    // Responsive auto-collapse for desktop
    function autoCollapseSidebar() {
      if (window.innerWidth < 1200) {
        sidebar.classList.add("collapsed");
        dashboardWrapper.classList.add("sidebar-collapsed");
        dashboardWrapper.classList.remove("sidebar-expanded");
      } else {
        sidebar.classList.remove("collapsed");
        dashboardWrapper.classList.remove("sidebar-collapsed");
        dashboardWrapper.classList.add("sidebar-expanded");
      }
    }
    window.addEventListener("resize", autoCollapseSidebar);
    window.addEventListener("load", autoCollapseSidebar);

    // Toggle Sidebar Submenus (Slide Open/Close)
    window.toggleSubMenu = function(el) {
      el.classList.toggle('active');
      const submenu = el.nextElementSibling;
      submenu.classList.toggle('show');
    }
  </script>

  <script>
const priceInput = document.getElementById('price');
const quantityInput = document.getElementById('quantity');
const totalInput = document.getElementById('total');
const statusSelect = document.getElementById('status');
const overlay = document.getElementById('statusOverlay');

function updateTotal() {
  const price = parseFloat(priceInput.value) || 0;
  const qty = parseInt(quantityInput.value) || 0;
  totalInput.value = (price * qty).toFixed(2);
}

priceInput.addEventListener('input', updateTotal);
quantityInput.addEventListener('input', updateTotal);

statusSelect.addEventListener('change', () => {
  const status = statusSelect.value;
  if (status === "Out of Stock" || status === "On Rent") {
    overlay.style.display = "block";
    overlay.textContent = "Out of Stock";
  } else {
    overlay.style.display = "none";
  }
});

function previewImage(event) {
  const preview = document.getElementById('preview');
  const box = document.getElementById('imagePreviewBox');
  preview.src = URL.createObjectURL(event.target.files[0]);
  box.style.display = "block";
}

document.getElementById('addStockForm').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Stock item added successfully!');
  this.reset();
  document.getElementById('imagePreviewBox').style.display = "none";
  overlay.style.display = "none";
  updateTotal();
});

updateTotal();
</script>


</body>
</html>







