<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            background-color: var(--light-gold);
            color: var(--secondary-color);
            font-weight: bold;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.1);
            transition: 0.2s;
        }

        /* Gold table header for better visibility */
        .table-gold-header {
            background-color: var(--light-gold);
            color: var(--secondary-color);
            font-weight: bold;
        }

        /* Improve mobile responsiveness */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                padding: 0.5rem;
                background: white;
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border: none;
                border-bottom: 1px solid #eee;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 1rem;
                font-weight: bold;
                text-align: left;
                color: var(--secondary-color);
            }
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
    </style>
</head>

<body>
    <div class="d-flex">
        <?php $this->load->view('include/sidebar'); ?>
        <div class="main">
            <?php $this->load->view('include/navbar'); ?>
            <div class="container-fluid p-4">
                <div class="container my-5">
                    <div class="bill-card">
                        <h4>RENTAL INVOICE</h4>

                        <!-- Invoice Info -->
                        <!-- Row 1: Invoice Number -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="invoiceNo">Invoice No:</label>
                                <input type="text" id="invoiceNo" class="form-control" placeholder="Enter Invoice Number" required />
                            </div>
                        </div>

                        <!-- Row 2: Customer Name & Mobile -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="customerName">Customer Name:</label>
                                <input type="text" id="customerName" class="form-control" placeholder="Enter Customer Name" required />
                            </div>
                            <div class="col-md-6">
                                <label for="customerMobile">Customer Mobile No:</label>
                                <input type="text" id="customerMobile" class="form-control" placeholder="Enter Mobile Number" required />
                            </div>
                        </div>

                        <!-- Row 3: Issue Date, Return Date, CGST, SGST -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="issueDate">Issue Date:</label>
                                <input type="date" id="issueDate" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label for="returnDate">Return Date:</label>
                                <input type="date" id="returnDate" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label for="cgst">CGST (%):</label>
                                <input type="number" id="cgst" class="form-control" min="0" step="0.01" value="0" oninput="updateAllTotals()" />
                            </div>
                            <div class="col-md-3">
                                <label for="sgst">SGST (%):</label>
                                <input type="number" id="sgst" class="form-control" min="0" step="0.01" value="0" oninput="updateAllTotals()" />
                            </div>
                        </div>


                        <!-- Items Table -->
                        <!-- Items Table -->
                        <!-- Items Table -->
                        <div class="mb-4">
                            <label class="form-section-title">Items</label>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-hover">
                                    <thead class="table-gold-header">
                                        <tr>
                                            <th>Category</th>
                                            <th>Item Name</th>
                                            <th>Price (₹)</th>
                                            <th>Qty</th>
                                            <th>Days</th>
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
                                                    <option value="">Select</option>
                                                    <option value="100">Item 1</option>
                                                    <option value="200">Item 2</option>
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control price" readonly /></td>
                                            <td><input type="number" class="form-control qty" min="1" value="1" oninput="updateTotal(this)" /></td>
                                            <td><input type="number" class="form-control days" min="1" value="1" oninput="updateTotal(this)" /></td>
                                            <td><input type="number" class="form-control total" readonly /></td>
                                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-sm btn-gold mt-2" type="button" onclick="addRow()">+ Add Item</button>
                        </div>

                        <!-- Summary -->
                        <div class="row summary-section">
                            <div class="col-md-6 summary-left">
                                <div class="mb-2">
                                    <label for="depositAmount">Deposit Amount (₹):</label>
                                    <input type="number" id="depositAmount" class="form-control" min="0" step="0.01" value="0" oninput="updateBalance()" />
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <span>Total Amount:</span>
                                    <span class="value" id="totalAmount">₹0.00</span>
                                </div>
                                <div class="mb-2">
                                    <label for="discountAmount">Discount (₹):</label>
                                    <input type="number" id="discountAmount" min="0" step="0.01" class="form-control" value="0" oninput="updateAllTotals()" />
                                </div>
                                <div class="mb-2 fw-bold text-danger d-flex justify-content-between">
                                    <span>Total Payable:</span>
                                    <span id="totalPayable">₹0.00</span>
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

                        <div class="action-buttons mt-4 text-center">
                            <button class="btn btn-gold me-2">Save Invoice</button>
                            <button class="btn btn-outline-gold me-2" type="reset" onclick="resetForm()">Clear</button>
                            <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addRow() {
            const tbody = document.getElementById('itemTable');
            const tr = document.createElement('tr');
            tr.innerHTML = `
        <td><select class="form-select" onchange="updatePrice(this)">
            <option value="">Select</option>
            <option value="Category1">Category1</option>
            <option value="Category2">Category2</option>
        </select></td>
        <td><select class="form-select" onchange="updateTotal(this)">
            <option value="">Select Item</option>
            <option value="100">Item 1</option>
            <option value="200">Item 2</option>
        </select></td>
        <td><input type="number" class="form-control price" readonly /></td>
        <td><input type="number" class="form-control qty" min="1" value="1" oninput="updateTotal(this)" /></td>
        <td><input type="number" class="form-control days" min="1" value="1" oninput="updateTotal(this)" /></td>
        <td><input type="number" class="form-control total" readonly /></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>`;
            tbody.appendChild(tr);
        }

        function updateTotal(element) {
            const tr = element.closest('tr');
            const price = parseFloat(tr.querySelector('.price').value) || 0;
            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            const days = parseFloat(tr.querySelector('.days').value) || 0;
            tr.querySelector('.total').value = (price * qty * days).toFixed(2);
            updateAllTotals();
        }


        function removeRow(btn) {
            btn.closest('tr').remove();
            updateAllTotals();
        }

        function updatePrice(select) {
            const tr = select.closest('tr');
            tr.querySelector('.price').value = select.value || '';
            updateTotal(select);
        }

        function updateTotal(element) {
            const tr = element.closest('tr');
            const price = parseFloat(tr.querySelector('.price').value) || 0;
            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            tr.querySelector('.total').value = (price * qty).toFixed(2);
            updateAllTotals();
        }

        function updateAllTotals() {
            let totalAmount = 0;
            document.querySelectorAll('.total').forEach(input => totalAmount += parseFloat(input.value) || 0);
            document.getElementById('totalAmount').textContent = `₹${totalAmount.toFixed(2)}`;

            const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
            const cgst = parseFloat(document.getElementById('cgst').value) || 0;
            const sgst = parseFloat(document.getElementById('sgst').value) || 0;

            const gstAmount = totalAmount * ((cgst + sgst) / 100);
            const totalWithGST = totalAmount + gstAmount;

            const validDiscount = discount > totalWithGST ? totalWithGST : discount;
            if (discount !== validDiscount) {
                document.getElementById('discountAmount').value = validDiscount.toFixed(2);
            }

            const totalPayable = totalWithGST - validDiscount;
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
            document.querySelectorAll('input').forEach(input => input.value = '');
            document.getElementById('itemTable').innerHTML = '';
            addRow();
            updateAllTotals();
        }

        updateAllTotals();
    </script>
</body>

</html>