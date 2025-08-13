<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rental Billing - House of Fashion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

    <style>
        .Bill-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .form-section-title {
            font-weight: 700;
            color: #a86d01ff;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .btn-yellow {
            background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
            color: #000;
            font-weight: 600;
        }
        .btn-yellow:hover {
            background: linear-gradient(90deg, #e2a93e, #f7c872, #e1aa46);
            color: #000;
        }
        .btn-outline-gray {
            border: 1px solid #ccc;
            color: black;
        }
    </style>
</head>

<body>
<div class="d-flex">
    <!-- Sidebar -->
    <?php $this->load->view('include/sidebar'); ?>

    <!-- Main Content -->
    <div class="main">
        <!-- Navbar -->
        <?php $this->load->view('include/navbar'); ?>

        <!-- Page Content -->
        <div class="container-fluid p-4">
            <form method="POST" action="<?= base_url('Invoice/save_invoice') ?>">
                <div class="Bill-card p-4" id="printSection">
                    <h4 class="text-center fw-bold">RENTAL BILL</h4>

                    <!-- Bill Header -->
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Bill No:</label>
                            <input type="text" class="form-control" id="billNo" value="BILL-<?= date('Ymd-His') ?>" name="bill_no" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Date & Time:</label>
                            <input type="datetime-local" class="form-control" name="datetime" value="<?= date('Y-m-d\TH:i') ?>">
                        </div>
                    </div>

                    <!-- Customer & Rental Details -->
                    <h6 class="form-section-title">Customer & Rental Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Customer Name <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" name="customer_name" required>
                        </div>
                        <div class="col-md-3">
                            <label>Advance Amount:</label>
                            <input type="number" class="form-control" id="advance" name="advance" oninput="updatePending()">
                        </div>
                        <div class="col-md-3">
                            <label>Deposit Amount:</label>
                            <input type="number" class="form-control" id="deposit" name="deposit" oninput="updatePending()">
                        </div>

                        <div class="col-md-4">
                            <label>Issue Date:</label>
                            <input type="date" class="form-control" id="issueDate" name="issue_date" onchange="calculateDuration()">
                        </div>
                        <div class="col-md-4">
                            <label>Return Date:</label>
                            <input type="date" class="form-control" id="returnDate" name="return_date" onchange="calculateDuration()">
                        </div>
                        <div class="col-md-4">
                            <label>Rental Duration (Days):</label>
                            <input type="number" class="form-control" id="rentalDays" name="rental_days" readonly>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <h6 class="form-section-title">Rental Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product Code</th>
                                    <th>Item</th>
                                    <th>Price/Day</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Discount</th>
                                    <th>Payment Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemTable">
                                <tr>
                                    <td><input type="text" name="items[0][product_code]" class="form-control"></td>
                                    <td><input type="text" name="items[0][item]" class="form-control"></td>
                                    <td><input type="number" name="items[0][price]" class="form-control price" oninput="calculateTotal(this.closest('tr'))"></td>
                                    <td><input type="number" name="items[0][qty]" class="form-control qty" oninput="calculateTotal(this.closest('tr'))"></td>
                                    <td><input type="number" name="items[0][total]" class="form-control total" readonly></td>
                                    <td><input type="number" name="items[0][discount]" class="form-control" oninput="calculateTotal(this.closest('tr'))"></td>
                                    <td>
                                        <select name="items[0][payment_mode]" class="form-select">
                                            <option>Cash</option>
                                            <option>Online</option>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" id="totalAmountField" name="total_amount" />
                        <input type="hidden" id="pendingAmountField" name="pending_amount" />
                    </div>

                    <button class="btn btn-yellow mb-3" onclick="addRow()" type="button">Add Item</button>

                    <!-- Tax & Pending -->
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>CGST %:</label>
                            <input type="number" name="cgst" id="cgst" value="1.5" step="0.1" oninput="updateTotalAmount()">
                        </div>
                        <div class="col-md-4">
                            <label>SGST %:</label>
                            <input type="number" name="sgst" id="sgst" value="1.5" step="0.1" oninput="updateTotalAmount()">
                        </div>
                        <div class="col-md-4">
                            <label>Pending Amount:</label>
                            <input type="number" id="pendingAmount" class="form-control" readonly>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <button class="btn btn-yellow" type="submit">Save Bill</button>
                        <button class="btn btn-outline-gray" type="reset">Clear</button>
                        <button class="btn btn-primary" type="button" onclick="printFormattedInvoice()">Print Bill</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function calculateDuration() {
    const issue = new Date(document.getElementById('issueDate').value);
    const ret = new Date(document.getElementById('returnDate').value);
    if (!isNaN(issue) && !isNaN(ret)) {
        const diffDays = Math.ceil((ret - issue) / (1000 * 60 * 60 * 24));
        document.getElementById('rentalDays').value = diffDays > 0 ? diffDays : 0;
    }
}

function calculateTotal(row) {
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const discount = parseFloat(row.querySelector('[name$="[discount]"]').value || 0);
    const rowTotal = (price * qty) - discount;
    row.querySelector('.total').value = rowTotal.toFixed(2);
    updateTotalAmount();
}

function updateTotalAmount() {
    let subtotal = 0;
    const rows = document.querySelectorAll('#itemTable tr');
    rows.forEach(row => {
        const price = parseFloat(row.querySelector('.price')?.value || 0);
        const qty = parseFloat(row.querySelector('.qty')?.value || 0);
        const discount = parseFloat(row.querySelector('[name$="[discount]"]')?.value || 0);
        subtotal += (price * qty) - discount;
    });
    const cgst = parseFloat(document.getElementById('cgst').value || 0);
    const sgst = parseFloat(document.getElementById('sgst').value || 0);
    const taxAmount = (subtotal * (cgst + sgst)) / 100;
    const finalTotal = (subtotal + taxAmount).toFixed(2);
    document.getElementById('totalAmountField').value = finalTotal;
    updatePending();
}

function updatePending() {
    const total = parseFloat(document.getElementById('totalAmountField').value) || 0;
    const advance = parseFloat(document.getElementById('advance').value) || 0;
    const deposit = parseFloat(document.getElementById('deposit').value) || 0;
    const pending = total - advance - deposit;
    document.getElementById('pendingAmount').value = pending.toFixed(2);
    document.getElementById('pendingAmountField').value = pending.toFixed(2);
}

function addRow() {
    const table = document.getElementById('itemTable');
    const index = table.rows.length;
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" name="items[${index}][product_code]" class="form-control"></td>
        <td><input type="text" name="items[${index}][item]" class="form-control"></td>
        <td><input type="number" name="items[${index}][price]" class="form-control price" oninput="calculateTotal(this.closest('tr'))"></td>
        <td><input type="number" name="items[${index}][qty]" class="form-control qty" oninput="calculateTotal(this.closest('tr'))"></td>
        <td><input type="number" name="items[${index}][total]" class="form-control total" readonly></td>
        <td><input type="number" name="items[${index}][discount]" class="form-control" oninput="calculateTotal(this.closest('tr'))"></td>
        <td>
            <select name="items[${index}][payment_mode]" class="form-select">
                <option>Cash</option>
                <option>Online</option>
            </select>
        </td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
    `;
    table.appendChild(newRow);
}

function removeRow(button) {
    button.closest('tr').remove();
    updateTotalAmount();
}

function printFormattedInvoice() {
    window.print();
}
</script>

<script>
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

<?php if ($this->session->flashdata('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '<?= $this->session->flashdata('success'); ?>',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
});
</script>
<?php endif; ?>

</body>
</html>
