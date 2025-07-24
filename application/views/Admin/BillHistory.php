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
        h2 {
            text-align: center;
            color: #a86d01ff;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            color: #a86d01ff;
        }

        .btn-primary {
            background-color: #0056d2;
            border-color: #0056d2;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .table th {
            color: #a86d01ff;
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

                <h2 class="text-dark">Bill & Invoices</h2>

                <div class="row mb-3">
                    <div class="col-md-4 mb-2">
                        <label for="fromDate" class="form-label">From Date:</label>
                        <input type="date" id="fromDate" class="form-control" placeholder="dd-mm-yyyy">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="toDate" class="form-label">To Date:</label>
                        <input type="date" id="toDate" class="form-control" placeholder="dd-mm-yyyy">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary mb-2 w-100">Generate Request</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                       <thead class="table-light">
    <tr>
        <th>Invoice Number</th>
        <th>Date</th>
        <th>Customer Name</th>
        <th>Staff Name</th>
        <th>Total Amount</th>
    </tr>
</thead>
<tbody>
<?php if (!empty($invoices)): ?>
    <?php foreach ($invoices as $inv): ?>
        <tr>
            <td><?= $inv->bill_no ?></td>
            <td><?= $inv->datetime ?></td>
            <td><?= $inv->customer_name ?></td>
            <td><?= $inv->staff_name ?></td>
            <td><?= $inv->total_amount ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="5">No records found.</td></tr>
<?php endif; ?>
</tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
    <a href="<?= base_url('AdminController/exportToPDF') ?>" class="btn btn-success">Export to PDF</a>
    <a href="<?= base_url('AdminController/exportToExcel') ?>" class="btn btn-warning">Export to Excel</a>
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
    </script>
</body>

</html>