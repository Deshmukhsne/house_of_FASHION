<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Responsive Sidebar - House of Fashion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      background-color: #f8f9fa;
    }

    /* Sidebar */
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

    .sidebar.collapsed {
      width: 80px;
    }

    /* Logo */
    .sidebar-logo {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo-full {
      width: 160px;
      transition: 0.3s ease;
    }

    .logo-circle {
      width: 50px;
      display: none;
      transition: 0.3s ease;
    }

    .sidebar.collapsed .logo-full {
      display: none;
    }

    .sidebar.collapsed .logo-circle {
      display: inline-block;
    }

    /* Nav Links */
    .sidebar .nav-link {
      color: #f0d75d;
      font-weight: 500;
      margin-bottom: 15px;
      border-radius: 10px;
      padding: 12px 18px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 15px;
      background: rgba(255, 215, 0, 0.05);
      white-space: nowrap;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
      color: black !important;
      transform: translateX(5px);
    }

    .sidebar.collapsed .nav-link span {
      display: none;
    }

    .sidebar.collapsed .nav-link {
      justify-content: center;
      padding: 12px 0;
    }

    /* Toggle Button */
    .toggle-btn {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1000;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    .sidebar.collapsed ~ .main-content {
      margin-left: 80px;
    }

    /* Responsive Behavior */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
        position: fixed;
        left: 0;
        top: 0;
        transition: transform 0.3s ease;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0 !important;
      }

      .toggle-btn {
        left: 15px;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar Toggle Button -->
  <button class="btn btn-dark toggle-btn d-lg-block d-inline-block" id="toggleSidebar">
    <i class="bi bi-list"></i>
  </button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
      <img src="<?php echo base_url('assets/images/logo.jpg'); ?>" class="logo-full" alt="Full Logo">
      <img src="<?php echo base_url('assets/images/logo-small.jpg'); ?>" class="logo-circle" alt="Circle Logo">
    </div>

    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="#">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="bi bi-box-seam"></i>
          <span>Inventory</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="bi bi-cash-stack"></i>
          <span>Payments</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="bi bi-basket2"></i>
          <span>Orders</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="bi bi-people"></i>
          <span>Users</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="main">
    <h1>Welcome to House of Fashion</h1>
    <p>This is your main content area. The sidebar is fully responsive, collapsible, and styled.</p>
  </div>

  <!-- Bootstrap & Sidebar Toggle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('toggleSidebar');

    toggle.addEventListener('click', function () {
      if (window.innerWidth < 992) {
        sidebar.classList.toggle('show');
      } else {
        sidebar.classList.toggle('collapsed');
        document.getElementById('main').classList.toggle('collapsed');
      }
    });
  </script>

</body>
</html>
