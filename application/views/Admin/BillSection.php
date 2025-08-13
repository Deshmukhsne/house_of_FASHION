<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #D4AF37;
            --secondary-color: #a86d01;
            --light-gold: #FFD27F;
            --dark-gold: #B37B16;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .bill-card {
            position: relative;
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 2rem 3rem;
        }

        .bill-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--dark-gold), var(--light-gold));
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        h4 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: var(--secondary-color);
            display: block;
            margin-bottom: 0.3rem;
        }

        .form-section-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            border-bottom: 3px solid var(--dark-gold);
            padding-bottom: 0.25rem;
        }

        .table thead {
            background-color: rgba(212, 175, 55, 0.2);
        }

        .table th {
            font-weight: 600;
            color: var(--secondary-color);
            vertical-align: middle;
        }

        .btn-gold {
            background: linear-gradient(90deg, var(--dark-gold), var(--light-gold));
            color: #000;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(90deg, var(--light-gold), var(--dark-gold));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-gold {
            border: 1px solid var(--primary-color);
            color: var(--secondary-color);
            font-weight: 500;
        }

        .btn-outline-gold:hover {
            background-color: rgba(212, 175, 55, 0.1);
        }

        .total-display {
            background-color: rgba(212, 175, 55, 0.1);
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
        }

        .summary-section {
            margin-top: 2rem;
        }

        .summary-left,
        .summary-right {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgb(212 175 55 / 0.2);
            padding: 1.5rem 2rem;
        }

        .summary-left span,
        .summary-right label {
            font-weight: 600;
            color: var(--secondary-color);
        }

        .summary-left span.value {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .summary-right input,
        .summary-right select {
            border: 1px solid rgba(212, 175, 55, 0.5);
            border-radius: 6px;
            padding: 0.5rem;
            width: 100%;
            font-weight: 600;
            color: #000;
        }

        .summary-right input[readonly] {
            background-color: #f1f1f1;
        }

        /* Invoice info inputs */
        .row.mb-4>div {
            margin-bottom: 1rem;
        }

        input.form-control {
            box-shadow: 0 2px 6px rgb(212 175 55 / 0.15);
            border: 1px solid var(--light-gold);
            transition: border-color 0.3s ease;
        }

        input.form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 2px 10px var(--primary-color);
        }

        /* Buttons container */
        .action-buttons {
            margin-top: 2rem;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .summary-left,
            .summary-right {
                margin-bottom: 1rem;
            }
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
                    <div class="bill-card">
                        <h4>RENTAL INVOICE</h4>

                        <!-- Invoice Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="invoiceNo">Invoice No:</label>
                                <input type="text" id="invoiceNo" class="form-control" placeholder="Enter Invoice Number" required />
                            </div>
                            <div class="col-md-6">
                                <label for="customerName">Customer Name:</label>
                                <input type="text" id="customerName" class="form-control" placeholder="Enter Customer Name" required />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="date">Date</label>
                                <input type="date" id="date" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label for="depositAmount">Deposit Amount (₹):</label>
                                <input type="number" id="depositAmount" class="form-control" min="0" step="0.01" value="0" oninput="updateBalance()" />
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="mb-4">
                            <label class="form-section-title">Items</label>
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Item Name</th>
                                        <th>Price (₹)</th>
                                        <th>Qty</th>
                                        <th>Total (₹)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemTable">
                                    <tr>
                                        <td>
                                            <select class="form-select" onchange="updatePrice(this)">
                                                <option value="">Select</option>
                                                <option value="Category1">Category1</option>
                                                <option value="Category2">Category2</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" onchange="updateTotal(this)">
                                                <option value="">Select Item</option>
                                                <option value="100">Item 1</option>
                                                <option value="200">Item 2</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control price" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control qty" min="1" value="1" oninput="updateTotal(this)" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control total" readonly />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-gold" type="button" onclick="addRow()">+Add Item</button>
                        </div>

                        <!-- Summary -->
                        <div class="row summary-section">
                            <div class="col-md-6 summary-left">
                                <div class="mb-2 d-flex justify-content-between">
                                    <span>Total Amount:</span>
                                    <span class="value" id="totalAmount">₹0.00</span>
                                </div>
                                <div class="mb-3">
                                    <label for="discountAmount">Discount (₹):</label>
                                    <input type="number" id="discountAmount" min="0" step="0.01" class="form-control" value="0" oninput="updateAllTotals()" />
                                </div>

                                <div class="mb-2 d-flex justify-content-between fw-bold text-danger">
                                    <span>Total Payable:</span>
                                    <span class="value" id="totalPayable">₹0.00</span>
                                </div>
                            </div>
                            <div class="col-md-6 summary-right">
                                <div class="mb-3">
                                    <label for="paidAmount">Paid Amount (₹):</label>
                                    <input type="number" id="paidAmount" min="0" step="0.01" class="form-control" value="0" oninput="updateBalance()" />
                                </div>
                                <div class="mb-3">
                                    <label for="dueAmount">Due Amount (₹):</label>
                                    <input type="number" id="dueAmount" class="form-control" value="0" readonly />
                                </div>
                                <div>
                                    <label for="paymentMode">Payment Mode:</label>
                                    <select id="paymentMode" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="UPI">UPI</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-gold me-2">Save Invoice</button>
                            <button class="btn btn-outline-gold me-2" type="reset" onclick="resetForm()">Clear</button>
                            <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                        </div>
                    </div>
                </div>

                <script>
                    function addRow() {
                        const tbody = document.getElementById('itemTable');
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                <td>
                    <select class="form-select" onchange="updatePrice(this)">
                        <option value="">Select</option>
                        <option value="Category1">Category1</option>
                        <option value="Category2">Category2</option>
                    </select>
                </td>
                <td>
                    <select class="form-select" onchange="updateTotal(this)">
                        <option value="">Select Item</option>
                        <option value="100">Item 1</option>
                        <option value="200">Item 2</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control price" readonly />
                </td>
                <td>
                    <input type="number" class="form-control qty" min="1" value="1" oninput="updateTotal(this)" />
                </td>
                <td>
                    <input type="number" class="form-control total" readonly />
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button>
                </td>
            `;
                        tbody.appendChild(tr);
                    }

                    function removeRow(btn) {
                        const tr = btn.closest('tr');
                        tr.remove();
                        updateAllTotals();
                    }

                    function updatePrice(select) {
                        const tr = select.closest('tr');
                        const priceInput = tr.querySelector('.price');
                        priceInput.value = select.value || '';
                        updateTotal(priceInput);
                    }

                    function updateTotal(element) {
                        const tr = element.closest('tr');
                        const price = parseFloat(tr.querySelector('.price').value) || 0;
                        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
                        const totalInput = tr.querySelector('.total');
                        totalInput.value = (price * qty).toFixed(2);
                        updateAllTotals();
                    }

                    function updateAllTotals() {
                        let totalAmount = 0;
                        document.querySelectorAll('.total').forEach(input => {
                            totalAmount += parseFloat(input.value) || 0;
                        });
                        document.getElementById('totalAmount').textContent = `₹${totalAmount.toFixed(2)}`;

                        const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
                        const validDiscount = discount > totalAmount ? totalAmount : discount;
                        if (discount !== validDiscount) {
                            document.getElementById('discountAmount').value = validDiscount.toFixed(2);
                        }

                        const totalPayable = totalAmount - validDiscount;
                        document.getElementById('totalPayable').textContent = `₹${totalPayable.toFixed(2)}`;

                        updateBalance();
                    }

                    function updateBalance() {
                        const totalPayable = parseFloat(document.getElementById('totalPayable').textContent.replace('₹', '')) || 0;
                        const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
                        const depositAmount = parseFloat(document.getElementById('depositAmount').value) || 0;

                        let dueAmount = totalPayable - (paidAmount + depositAmount);
                        if (dueAmount < 0) dueAmount = 0;

                        document.getElementById('dueAmount').value = dueAmount.toFixed(2);
                    }

                    function resetForm() {
                        document.getElementById('invoiceNo').value = '';
                        document.getElementById('customerName').value = '';
                        document.getElementById('date').value = '';
                        document.getElementById('depositAmount').value = 0;
                        document.getElementById('discountAmount').value = 0;
                        document.getElementById('paidAmount').value = 0;
                        document.getElementById('dueAmount').value = 0;
                        document.getElementById('paymentMode').value = '';
                        // Remove all item rows except first
                        const tbody = document.getElementById('itemTable');
                        while (tbody.rows.length > 1) {
                            tbody.deleteRow(1);
                        }
                        // Reset first row inputs
                        const firstRow = tbody.rows[0];
                        firstRow.querySelectorAll('select').forEach(sel => sel.value = '');
                        firstRow.querySelectorAll('input.price, input.qty, input.total').forEach(inp => {
                            if (inp.classList.contains('qty')) inp.value = 1;
                            else inp.value = '';
                        });
                        updateAllTotals();
                    }

                    // Initial totals update
                    updateAllTotals();
                </script>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar toggler
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