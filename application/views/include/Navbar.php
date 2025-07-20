<!-- Navbar -->
<nav class="topbar d-flex align-items-center justify-content-between px-4 py-2 shadow-sm" id="topbar">
  <div class="d-flex align-items-center gap-3">
    <!-- Sidebar Toggle Button -->
    <button class="btn btn-outline-light" id="sidebarToggle"><i class="bi bi-list fs-4"></i></button>
  </div>

  <div class="d-flex align-items-center gap-4">
    <!-- Search Icon -->
    <i class="bi bi-search text-light fs-5 cursor-pointer"></i>

    <!-- Notification Icon -->
    <div class="dropdown">
      <i class="bi bi-bell text-light fs-5 position-relative dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
      </i>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">New Order</a></li>
        <li><a class="dropdown-item" href="#">Payment Received</a></li>
        <li><a class="dropdown-item" href="#">Stock Low</a></li>
      </ul>
    </div>

    <!-- Profile Dropdown -->
    <div class="dropdown d-flex align-items-center gap-2">
      <img src="<?php echo base_url('assets/images/profile.jpg'); ?>" class="rounded-circle" width="32" height="32" alt="Profile">
      <a class="dropdown-toggle text-light text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
        Admin
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">View Profile</a></li>
        <li><a class="dropdown-item" href="#">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- CSS -->
<style>
  .topbar {
    position: fixed;
    top: 0;
    left: 250px;
    width: calc(100% - 250px);
    height: 60px;
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.9)),
                url('<?php echo base_url("assets/images/sidebar_bg.jpg"); ?>') no-repeat center center;
    background-size: cover;
    z-index: 998;
    transition: left 0.3s ease, width 0.3s ease;
  }

  .cursor-pointer {
    cursor: pointer;
  }

  /* Adjust topbar width when sidebar is collapsed */
  .sidebar.collapsed + #main-content #topbar {
    left: 80px;
    width: calc(100% - 80px);
  }

  /* Mobile view */
  @media (max-width: 991.98px) {
    .topbar {
      left: 0 !important;
      width: 100% !important;
    }

    #sidebar {
      top: 60px;
      left: -100%;
      width: 250px;
      height: calc(100vh - 60px);
      position: fixed;
      background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.9)),
                  url('<?php echo base_url("assets/images/sidebar_bg.jpg"); ?>') no-repeat center center;
      background-size: cover;
      z-index: 999;
      transition: left 0.3s ease;
    }

    #sidebar.mobile-show {
      left: 0;
    }
  }
</style>

<!-- JS -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');

    toggleBtn?.addEventListener('click', function () {
      const isMobile = window.innerWidth < 992;

      if (isMobile) {
        // Mobile: show/hide sidebar as overlay
        sidebar.classList.toggle('mobile-show');
      } else {
        // Desktop: toggle collapse
        sidebar.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
          topbar.style.left = '80px';
          topbar.style.width = 'calc(100% - 80px)';
        } else {
          topbar.style.left = '250px';
          topbar.style.width = 'calc(100% - 250px)';
        }
      }
    });

  });
</script>
