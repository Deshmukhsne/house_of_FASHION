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
    <!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    



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
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <div class="card revenue-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="stat-label">TOTAL REVENUE</h6>
                                        <h3 class="stat-number">₹1,25,480</h3>
                                    </div>
                                    <i class="bi bi-currency-rupee fs-1 text-success"></i>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-success bg-opacity-10 text-success">+12.5% from last month</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card profit-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="stat-label">TOTAL PROFIT</h6>
                                        <h3 class="stat-number">₹42,650</h3>
                                    </div>
                                    <i class="bi bi-graph-up-arrow fs-1 text-info"></i>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-info bg-opacity-10 text-info">+8.3% from last month</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card loss-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="stat-label">TOTAL LOSS</h6>
                                        <h3 class="stat-number">₹3,250</h3>
                                    </div>
                                    <i class="bi bi-graph-down-arrow fs-1 text-danger"></i>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-danger bg-opacity-10 text-danger">-2.1% from last month</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card payment-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="stat-label">PENDING PAYMENTS</h6>
                                        <h3 class="stat-number">₹15,780</h3>
                                    </div>
                                    <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-warning bg-opacity-10 text-warning">5 unpaid bills</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Revenue Analytics</h5>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary active">Daily</button>
                                    <button class="btn btn-sm btn-outline-secondary">Monthly</button>
                                    <button class="btn btn-sm btn-outline-secondary">Yearly</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Payment Methods</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="paymentChart" height="300"></canvas>
                                <div class="mt-3 text-center">
                                    <div class="d-flex justify-content-around">
                                        <div>
                                            <span class="badge bg-primary me-2"></span>
                                            <span>Cash: ₹68,420</span>
                                        </div>
                                        <div>
                                            <span class="badge bg-success me-2"></span>
                                            <span>Online: ₹57,060</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Sales and Recent Transactions -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Category-wise Sales</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Items Sold</th>
                                                <th>Revenue</th>
                                                <th>Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="category-badge saree-badge">Saree</span></td>
                                                <td>245</td>
                                                <td>₹68,750</td>
                                                <td class="text-success">₹23,150</td>
                                            </tr>
                                            <tr>
                                                <td><span class="category-badge dress-badge">Dress</span></td>
                                                <td>187</td>
                                                <td>₹42,390</td>
                                                <td class="text-success">₹14,320</td>
                                            </tr>
                                            <tr>
                                                <td><span class="category-badge accessories-badge">Accessories</span></td>
                                                <td>312</td>
                                                <td>₹14,340</td>
                                                <td class="text-success">₹5,180</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Transactions</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Bill #MLC-1025</h6>
                                            <small class="text-success">₹3,850</small>
                                        </div>
                                        <small class="text-muted">Saree (2), Accessories (3) - Cash Payment</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Bill #MLC-1024</h6>
                                            <small class="text-success">₹5,250</small>
                                        </div>
                                        <small class="text-muted">Dress (1), Accessories (2) - Online Payment</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Bill #MLC-1023</h6>
                                            <small class="text-warning">₹2,150 (Pending)</small>
                                        </div>
                                        <small class="text-muted">Saree (1) - Credit</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Bill #MLC-1022</h6>
                                            <small class="text-success">₹4,750</small>
                                        </div>
                                        <small class="text-muted">Dress (2) - Cash Payment</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>

    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['1 Jan', '2 Jan', '3 Jan', '4 Jan', '5 Jan', '6 Jan', '7 Jan', '8 Jan', '9 Jan', '10 Jan'],
                    datasets: [{
                            label: 'Saree',
                            data: [4500, 5200, 4800, 6100, 5900, 7200, 6800, 7500, 8200, 7900],
                            borderColor: '#ffda06ff',
                            backgroundColor: 'rgba(209, 78, 120, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Dress',
                            data: [3200, 3800, 4100, 3500, 4200, 3900, 4500, 5100, 4800, 5300],
                            borderColor: '#ee8011ff',
                            backgroundColor: 'rgba(23, 162, 184, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Accessories',
                            data: [1200, 1500, 1100, 1300, 1400, 1600, 1250, 1450, 1700, 1550],
                            borderColor: '#6bb819ff',
                            backgroundColor: 'rgba(108, 117, 125, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ₹' + context.raw.toLocaleString('en-IN');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString('en-IN');
                                }
                            }
                        }
                    }
                }
            });

            // Payment Method Chart
            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
            const paymentChart = new Chart(paymentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Cash', 'Online'],
                    datasets: [{
                        data: [68420, 57060],
                        backgroundColor: [" #f3ac29ff", "#8d6213ff"],           
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ₹${value.toLocaleString('en-IN')} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

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
    </script>

  
<?php if ($this->session->flashdata('login_success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Login Successful!",
            text: "<?= $this->session->flashdata('login_success') ?>",
            icon: "success",
            showConfirmButton: false,
            timer: 2000
        });
    });
</script>
<?php endif; ?>





</body>

</html>