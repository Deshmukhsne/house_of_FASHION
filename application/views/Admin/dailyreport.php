<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .card-header {
      background-color: #000;
      color: #FFD27F;
    }

    .report-header h2 {
      font-weight: 700;
      color: #B37B16;
    }

    .stat-box {
      background: #fff;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      transition: 0.3s;
    }

    .stat-box:hover {
      transform: translateY(-5px);
    }

    .stat-label {
      font-weight: 600;
      color: #a86d01;
    }

    .stat-value {
      font-size: 1.8rem;
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
              <div class="container my-5">
    <!-- Report Header -->
    <div class="text-center mb-5">
      <h2 class="text-uppercase">Daily Sales Report</h2>
      <p class="text-muted">Overview of today’s sales performance</p>
    </div>

    <!-- Stat Cards -->
    <div class="row text-center mb-4">
      <div class="col-md-4 mb-3">
        
        <div class="stat-box">
          <p class="stat-label mb-1">Total Orders</p>
          <div class="stat-value">120</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="stat-box">
          <p class="stat-label mb-1">Total Sales</p>
          <div class="stat-value">₹ 85,230.00</div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="stat-box">
          <p class="stat-label mb-1">Top Staff</p>
          <div class="stat-value">XYZ</div>
        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="card shadow-sm">
      <div class="card-header">
        Hourly Sales
      </div>
      <div class="card-body">
        <canvas id="hourlySalesChart" height="100"></canvas>
      </div>
    </div>
  </div>


            </div>
        </div>
    </div>

    </div>
    </div>
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
          <!-- Chart Script -->
  // Hourly Sales Chart
  const ctx = document.getElementById('hourlySalesChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['8 AM', '10 AM', '12 PM', '2 PM', '4 PM', '6 PM', '8 PM'],
      datasets: [{
        label: 'Sales (₹)',
        data: [4000, 6000, 8500, 10000, 12000, 9500, 7000],
        borderColor: '#B37B16', // Gold border
        backgroundColor: 'rgba(179, 123, 22, 0.2)', // Transparent gold fill
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Amount (₹)' }
        },
        x: {
          title: { display: true, text: 'Time of Day' }
        }
      }
    }
  });

    </script>
</body>

</html>