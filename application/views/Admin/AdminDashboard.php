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
    body {
      background: #f7f6fb;
    }

    .card-box {
      border-radius: 20px;
      padding: 20px;
      color: white;
      border: none;
    }

    .bg-pink { background: linear-gradient(135deg, #ff758c, #ff7eb3); }
    .bg-blue { background: linear-gradient(135deg, #42a5f5, #478ed1); }
    .bg-green { background: linear-gradient(135deg, #00cdac, #02aab0); }

    .chart-card, .stat-card {
      background: #fff;
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
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
    <?php $this->load->view('include/Navbar'); ?>
    <div class="main-content p-4" id="mainContent">
      <!-- Navbar Include -->

      <div class="container-fluid">
        <!-- Stats Row -->
        <div class="row g-4 mb-4">
          <div class="col-12 col-md-4">
            <div class="chart-card h-100">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Sales</h6>
                <select class="form-select form-select-sm w-auto" id="salesSelect">
                  <option value="daily">Daily</option>
                  <option value="weekly" selected>Weekly</option>
                  <option value="monthly">Monthly</option>
                </select>
              </div>
              <h3 id="salesAmount">$15,000</h3>
              <small id="salesInfo">Increased by 60%</small>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="chart-card h-100">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Revenue</h6>
                <select class="form-select form-select-sm w-auto" id="revenueSelect">
                  <option value="daily">Daily</option>
                  <option value="weekly" selected>Weekly</option>
                  <option value="monthly">Monthly</option>
                </select>
              </div>
              <h3 id="revenueAmount">$30,000</h3>
              <small id="revenueInfo">Increased by 20%</small>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="chart-card h-100">
              <h6>Total Payments</h6>
              <p>Cash: <strong>$10,000</strong> | Online: <strong>$20,000</strong></p>
              <h6>Total Inventory</h6>
              <p><strong>1,200</strong> items</p>
            </div>
          </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4">
          <div class="col-12 col-lg-8">
            <div class="chart-card h-100">
              <h6 class="fw-bold mb-3">Visit And Sales Statistics</h6>
              <canvas id="barChart" height="150"></canvas>
            </div>
          </div>
          <div class="col-12 col-lg-4">
            <div class="chart-card h-100">
              <h6 class="fw-bold mb-3">Traffic Sources</h6>
              <canvas id="pieChart" height="150"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.getElementById("salesSelect").addEventListener("change", function(e) {
      const val = e.target.value;
      if (val === 'daily') {
        salesAmount.textContent = '$2,000';
        salesInfo.textContent = 'Decreased by 5%';
      } else if (val === 'weekly') {
        salesAmount.textContent = '$15,000';
        salesInfo.textContent = 'Increased by 60%';
      } else {
        salesAmount.textContent = '$60,000';
        salesInfo.textContent = 'Increased by 90%';
      }
    });

    document.getElementById("revenueSelect").addEventListener("change", function(e) {
      const val = e.target.value;
      if (val === 'daily') {
        revenueAmount.textContent = '$3,000';
        revenueInfo.textContent = 'Decreased by 2%';
      } else if (val === 'weekly') {
        revenueAmount.textContent = '$30,000';
        revenueInfo.textContent = 'Increased by 20%';
      } else {
        revenueAmount.textContent = '$120,000';
        revenueInfo.textContent = 'Increased by 35%';
      }
    });

    // Bar chart
    new Chart(document.getElementById("barChart"), {
      type: 'line',
      data: {
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG'],
        datasets: [
          { label: "Revenue", backgroundColor: "rgba(255,206,86,0.4)", borderColor: "#ffca28", fill: true, data: [5000, 8000, 6000, 9000, 11000, 13000, 12500, 14500] },
          { label: "Orders", backgroundColor: "rgba(66,165,245,0.4)", borderColor: "#42a5f5", fill: true, data: [400, 420, 460, 480, 500, 540, 560, 590] },
          { label: "Cancelled", backgroundColor: "rgba(255,99,132,0.4)", borderColor: "#ff6384", fill: true, data: [50, 40, 35, 30, 45, 55, 50, 60] }
        ]
      }
    });

    // Pie chart
    new Chart(document.getElementById("pieChart"), {
      type: 'doughnut',
      data: {
        labels: ["Cash Payments", "Online Payments"],
        datasets: [{
          backgroundColor: ["#ffda06ff", "#ee8011ff"],
          data: [33, 67]
        }]
      }
    });

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
  const profileIcon = document.getElementById('profileToggle');
  const profileDropdown = document.getElementById('profileDropdown');

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

  
</body>
</html>
