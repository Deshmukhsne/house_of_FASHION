<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Common Resources -->
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <script src="<?= base_url('assets/script.js') ?>"></script>

    <!-- Bootstrap CSS & Chart.js -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php $this->load->view('include/sidebar'); ?>

        <!-- Main Content Area -->
        <div class="main w-100">
            <!-- Navbar -->
            <?php $this->load->view('include/navbar'); ?>

            <!-- Page Content -->
            <div class="container-fluid p-4">
                <div class="container report-container">

                    <!-- Report Header -->
                    <div class="report-header mb-4">
                        <h2>Daily Sales Report</h2>
                        <p class="text-muted">Overview of today’s sales performance</p>
                    </div>

                    <!-- Stat Cards -->
                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-4 bg-light border rounded">
                                <p class="mb-1 fw-semibold">Total Orders</p>
                                <h4><?= $total_orders ?></h4>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-4 bg-light border rounded">
                                <p class="mb-1 fw-semibold">Total Sales</p>
                                <h4>₹ <?= number_format($total_sales, 2) ?></h4>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-4 bg-light border rounded">
                                <p class="mb-1 fw-semibold">Top Staff</p>
                                <h4><?= $top_staff ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="mt-4">
                        <h5 class="mb-3">Hourly Sales</h5>
                        <canvas id="hourlySalesChart" height="100"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hourly Sales Chart
        const hourlyLabels = ['8 AM', '10 AM', '12 PM', '2 PM', '4 PM', '6 PM', '8 PM'];
        const hourlyData = [
            <?= $hourly_sales[8] ?? 0 ?>,
            <?= $hourly_sales[10] ?? 0 ?>,
            <?= $hourly_sales[12] ?? 0 ?>,
            <?= $hourly_sales[14] ?? 0 ?>,
            <?= $hourly_sales[16] ?? 0 ?>,
            <?= $hourly_sales[18] ?? 0 ?>,
            <?= $hourly_sales[20] ?? 0 ?>
        ];

        new Chart(document.getElementById('hourlySalesChart'), {
            type: 'line',
            data: {
                labels: hourlyLabels,
                datasets: [{
                    label: 'Sales (₹)',
                    data: hourlyData,
                    borderColor: '#8B004D',
                    backgroundColor: 'rgba(139, 0, 77, 0.1)',
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

        // Sidebar toggler
        const toggler = document.querySelector(".toggler-btn");
        const closeBtn = document.querySelector(".close-sidebar");
        const sidebar = document.querySelector("#sidebar");

        if (toggler && sidebar) {
            toggler.addEventListener("click", () => sidebar.classList.toggle("collapsed"));
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener("click", () => sidebar.classList.remove("collapsed"));
        }
    </script>
</body>

</html>
