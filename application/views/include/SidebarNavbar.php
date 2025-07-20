<!-- <head>
  <link rel="stylesheet" href="<?php echo base_url('/assets/css/style.css'); ?>">
  <style>
    .sidebar {
  height: 100vh;
  width: 250px;
  position: fixed;
  padding: 30px 20px;
background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.9)), 
            url('<?php echo base_url("assets/images/sidebar_bg.jpg"); ?>') no-repeat center center;
  background-size: cover;
  transition: width 0.3s ease;
  z-index: 999;
}

    /* Topbar */
    .topbar {
  position: sticky;
  top: 0;
  z-index: 998;
  height: 70px;
  background-color: #000;
  padding: 10px 30px;
  margin-left: 250px;
  display: flex;
  justify-content: space-between;
  align-items: center;
background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.9)), 
            url('<?php echo base_url("assets/images/sidebar_bg.jpg"); ?>') no-repeat center center;
  background-size: cover;
  border-bottom: 4px solid;
  border-image: linear-gradient(to right, gold, orange) 1;
  transition: margin-left 0.3s ease;
}
  </style>
</head>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-logo">
<img src="<?php echo base_url('assets/images/logo.jpg'); ?>" class="logo-full" alt="Full Logo">
<img src="<?php echo base_url('assets/images/logo-small.jpg'); ?>" class="logo-circle" alt="Circle Logo">
  </div>

  <a href="Dashboard.html" class="nav-link active"><i class="bi bi-house-door me-2"></i><span>Dashboard</span></a>

  <!-- Stock -->
  <div class="sidebar-item">
    <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#productMenu" role="button" aria-expanded="false" aria-controls="productMenu">
      <div><i class="bi bi-box me-2"></i><span class="menu-text">Stock</span></div>
      <i class="bi bi-chevron-down arrow-icon"></i>
    </a>
    <div class="collapse" id="productMenu">
      <ul class="submenu ps-4">
        <li><a class="nav-link" href="#">Add Stock</a></li>
        <li><a class="nav-link" href="#">View Details</a></li>
      </ul>
    </div>
  </div>

  <!-- Orders -->
  <div class="sidebar-item">
    <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#customerMenu" role="button" aria-expanded="false" aria-controls="customerMenu">
      <div><i class="bi bi-cart-check me-2"></i><span class="menu-text">Orders</span></div>
      <i class="bi bi-chevron-down arrow-icon"></i>
    </a>
    <div class="collapse" id="customerMenu">
      <ul class="submenu ps-4">
        <li><a class="nav-link" href="#">Create Order</a></li>
        <li><a class="nav-link" href="#">View Details</a></li>
      </ul>
    </div>
  </div>

  <a href="#" class="nav-link"><i class="bi bi-currency-rupee me-2"></i><span>Billing</span></a>

  <!-- Dry Cleaning -->
  <div class="sidebar-item">
    <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#dryMenu" role="button" aria-expanded="false" aria-controls="dryMenu">
      <div><i class="bi bi-droplet-half me-2"></i><span class="menu-text">Dry Cleaning</span></div>
      <i class="bi bi-chevron-down arrow-icon"></i>
    </a>
    <div class="collapse" id="dryMenu">
      <ul class="submenu ps-4">
        <li><a class="nav-link" href="#">Add Product</a></li>
        <li><a class="nav-link" href="#">View Details</a></li>
      </ul>
    </div>
  </div>

  <a href="#" class="nav-link"><i class="bi bi-bar-chart-line me-2"></i><span>Reports</span></a>
  <a href="#" class="nav-link"><i class="bi bi-person-badge me-2"></i><span>Roles</span></a>
  <a href="#" class="nav-link"><i class="bi bi-gear me-2"></i><span>Settings</span></a>
  <a href="#" class="nav-link text-danger mt-4"><i class="bi bi-box-arrow-right me-2"></i><span>Logout</span></a>
</div>

<!-- Topbar -->
<div class="topbar" id="topbar">
  <div class="d-flex align-items-center">
    <button id="sidebarToggle" class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <h5 class="m-0 fw-bold dash">Dashboard</h5>
  </div>

  <div class="d-flex align-items-center position-relative">
    <input class="form-control" type="text" placeholder="Search...">

    <i id="notifToggle" class="bi bi-bell-fill fs-5 mx-3 text-dark position-relative" style="cursor:pointer;">
      <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
        <span class="visually-hidden">New alerts</span>
      </span>
    </i>

    <div id="notifDropdown" class="dropdown-menu shadow" style="position: absolute; right: 60px; top: 60px; min-width: 250px; display: none; z-index: 999;">
      <div class="dropdown-item">🔔 New order placed</div>
      <div class="dropdown-item">👤 User signed up</div>
      <div class="dropdown-item">✅ Server backup completed</div>
    </div>

    <i id="profileToggle" class="bi bi-person-circle fs-5 text-dark profile-icon" style="cursor:pointer;"></i>
    <div id="profileDropdown" class="dropdown-menu shadow" style="position: absolute; right: 0; top: 60px; min-width: 180px; display: none; z-index: 999;">
      <a href="#" class="dropdown-item">👤 View Profile</a>
      <a href="#" class="dropdown-item text-danger">🚪 Logout</a>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle -->
 <script>
  // ===============================
// Global JavaScript – House of Fashion Admin
// Theme: Black & Gold
// ===============================

// Toggle Sidebar Collapse
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('collapsed');
  document.getElementById('topbar').classList.toggle('collapsed');
  document.getElementById('mainContent').classList.toggle('collapsed');
}

// Toggle Sidebar Submenus (Slide Open/Close)
function toggleSubMenu(el) {
  el.classList.toggle('active');
  const submenu = el.nextElementSibling;
  submenu.classList.toggle('show');
}

// Search Filter (Matches Sidebar Items by Text)
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('.topbar input[type="text"]');
  const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

  if (searchInput) {
    searchInput.addEventListener('input', () => {
      const query = searchInput.value.toLowerCase();

      sidebarLinks.forEach(link => {
        const text = link.textContent.toLowerCase();
        const parentDropdown = link.closest('.dropdown');

        if (text.includes(query)) {
          link.style.display = 'flex';
          if (parentDropdown) parentDropdown.style.display = 'block';
        } else {
          link.style.display = 'none';
          if (parentDropdown && parentDropdown.querySelectorAll('.nav-link:visible').length === 0) {
            parentDropdown.style.display = 'none';
          }
        }
      });
    });
  }

});

 // Notification dropdown
  const notifIcon = document.querySelector('#notifToggle');
  const notifDropdown = document.querySelector('#notifDropdown');

  if (notifIcon && notifDropdown) {
    notifIcon.addEventListener('click', (e) => {
      notifDropdown.classList.toggle('show');
      e.stopPropagation();
    });

    document.addEventListener('click', (e) => {
      if (!notifIcon.contains(e.target) && !notifDropdown.contains(e.target)) {
        notifDropdown.classList.remove('show');
      }
    });
  }

  // Profile dropdown
  const profileIcon = document.querySelector('#profileToggle');
  const profileDropdown = document.querySelector('#profileDropdown');

  if (profileIcon && profileDropdown) {
    profileIcon.addEventListener('click', (e) => {
      profileDropdown.classList.toggle('show');
      e.stopPropagation();
    });

    document.addEventListener('click', (e) => {
      if (!profileIcon.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.remove('show');
      }
    });
  }

 </script>
 <script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle'); // Add an ID to your toggle button
    const wrapper = document.getElementById('dashboardWrapper');

    toggleBtn.addEventListener('click', () => {
      wrapper.classList.toggle('sidebar-collapsed');
    });
  });
</script>
<script>
  const sidebar = document.getElementById("sidebar");
  const toggleSidebar = document.getElementById("toggleSidebar");
  const overlay = document.getElementById("overlay");

  function autoCollapseSidebar() {
    if (window.innerWidth < 1200) {
      sidebar.classList.add("collapsed");
    } else {
      sidebar.classList.remove("collapsed");
    }

    if (window.innerWidth <= 768) {
      sidebar.classList.remove("collapsed");
      sidebar.classList.remove("show-mobile");
      overlay.classList.remove("show");
    }
  }

  toggleSidebar.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
      sidebar.classList.toggle("show-mobile");
      overlay.classList.toggle("show");
    } else {
      sidebar.classList.toggle("collapsed");
    }
  });

  overlay.addEventListener("click", () => {
    sidebar.classList.remove("show-mobile");
    overlay.classList.remove("show");
  });

  window.addEventListener("resize", autoCollapseSidebar);
  window.addEventListener("load", autoCollapseSidebar);
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script> -->