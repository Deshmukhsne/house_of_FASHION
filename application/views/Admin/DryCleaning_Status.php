<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dry Cleaning Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .container {
            overflow: auto;
        }

        h2.section-heading {
            background-color: #000;
            color: #FFD700;
            padding: 7px;
            border-radius: 8px;
            text-align: center;
            font-weight: 400;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: fadeZoom 1s ease-in-out;
            font-size: 2rem;
        }

        .btn-stock {
            background-color: #28a745;
            color: white;
            padding: 5px 15px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            transition: 0.3s;
        }

        .btn-stock:hover {
            background-color: #218838;
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
            <!-- Dress Cleaning Status Table -->
            <div class="container mt-5 p-4 bg-light rounded shadow">
                <h2 class="section-heading mb-4">Dress Cleaning Status</h2>

                <table class="table table-bordered table-striped" id="cleaningTable">
                    <thead class="table-dark">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Forward Date</th>
                        <th>Expected Return</th>
                        <th>Cleaning Charges</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Example row (replace with PHP loop) -->
                    <tr>
                        <td>P1001</td>
                        <td>White-Sherwani</td>
                        <td>Sherwani</td>
                        <td>2025-07-23</td>
                        <td>2025-07-26</td>
                        <td>1500.00</td>
                        <td class="text-warning">
                            <select name="status" class="form-select" required>
                                <option value="">-- Select Status --</option>
                                <option>Forwarded</option>
                                <option>In Cleaning</option>
                                <option>Returned</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-stock">Add in Stock</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#cleaningTable").on("click", ".btn-stock", function() {
        let row = $(this).closest("tr");
        let productID = row.find("td:eq(0)").text().trim();
        let productName = row.find("td:eq(1)").text().trim();
        let category = row.find("td:eq(2)").text().trim();
        let forwardDate = row.find("td:eq(3)").text().trim();
        let expectedReturn = row.find("td:eq(4)").text().trim();
        let cleaningCharges = row.find("td:eq(5)").text().trim();
        let status = row.find("select[name='status']").val();

        if (!status) {
            Swal.fire({
                icon: 'warning',
                title: 'Select Status',
                text: 'Please choose a status before adding to stock.'
            });
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Add to Stock?',
            text: `Do you want to add ${productName} to stock?`,
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Add'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('stock/add') ?>", // Your controller method
                    type: "POST",
                    data: {
                        product_id: productID,
                        product_name: productName,
                        category: category,
                        forward_date: forwardDate,
                        expected_return: expectedReturn,
                        cleaning_charges: cleaningCharges,
                        status: status
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Stock',
                            text: `${productName} has been added successfully!`
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add item to stock.'
                        });
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
