<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <style>
        .Bill-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-section-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            border-bottom: 3px solid var(--dark-gold);
            padding-bottom: 0.25rem;
        }

        .btn-yellow {
            background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
            color: #000;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-yellow:hover {
            background: linear-gradient(90deg, #e2a93eff, #f7c872ff, #e1aa46ff);
            color: #000;
            font-weight: 600;
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
                        <h4 class="text-center fw-bold">INVOICE FORM</h4>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="fw-bold">FASSI NO:</label>
                                <input type="text" class="form-control" value="11550207001581" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">GST NO:</label>
                                <input type="text" class="form-control" value="27ABJPL9876F1Z1" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">HSN/SAC Code:</label>
                                <input type="text" class="form-control" value="996331" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Bill no:</label>
                                <input type="text" class="form-control" id="billNo" value="BILL-20250710-102" name="bill_no">
                            </div>
                        </div>

                        <h6 class="form-section-title">Invoice Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Enter Customer Name:</label>
                                <input type="text" class="form-control" id="customerName" placeholder="Enter Customer Name" name="customer_name">
                            </div>
                            <div class="col-md-6">
                                <label>Advance Amount</label>
                                <input type="text" class="form-control" placeholder="Enter Advance Amount" id="advance" name="advance">
                            </div>
                            <div class="col-md-3">
                                <label>Date & Time:</label>
                                <input type="datetime-local" class="form-control" name="datetime">
                            </div>

                            <div class="col-md-3">
                                <label>Return Date</label>
                                <input type="datetime-local" class="form-control" name="datetime">
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label>CGST %:</label>
                               <input type="number" name="cgst" id="cgst" value="1.5" step="0.1" onchange="updateTotalAmount()" />
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label>SGST %:</label>
                               <input type="number" name="sgst" id="sgst" value="1.5" step="0.1" onchange="updateTotalAmount()" />
                            </div>
                        </div>
                        <h6 class="form-section-title">Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Item</th>
                                        <th>Price</th>
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
                                        <td>
                                            <select name="items[0][item]" class="form-select">
                                                <option>Saree</option>
                                                <option>Dress</option>
                                                <option>Accessories</option>
                                            </select>
                                        </td>
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
                                        <input type="hidden" id="totalAmountField" name="total_amount"  />
                                </div>

                        <button class="btn btn-yellow mb-3" onclick="addRow()" type="button">Add Item</button>

                        <div class="text-center mt-4">
                            <button class="btn btn-yellow" type="submit">Save Invoice</button>
                            <button class="btn btn-outline-gray" type="reset">Clear</button>
                            <button class="btn btn-primary" type="button" onclick="printFormattedInvoice()">Print Invoice</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
   function calculateTotal(row) {
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const discount = parseFloat(row.querySelector('[name$="[discount]"]').value || 0);
    const rowTotal = (price * qty) - discount;
    row.querySelector('.total').value = rowTotal.toFixed(2);
    updateTotalAmount(); // Recalculate the final total
}

function updateTotalAmount() {
    let subtotal = 0;

    const rows = document.querySelectorAll('#itemTable tr');
    rows.forEach(row => {
        const price = parseFloat(row.querySelector('.price')?.value || 0);
        const qty = parseFloat(row.querySelector('.qty')?.value || 0);
        const discount = parseFloat(row.querySelector('[name$="[discount]"]')?.value || 0);

        const rowTotal = price * qty;
        const rowTotalAfterDiscount = rowTotal - discount;
        subtotal += rowTotalAfterDiscount;
    });

    const cgst = parseFloat(document.getElementById('cgst').value || 0);
    const sgst = parseFloat(document.getElementById('sgst').value || 0);

    const taxPercent = cgst + sgst;
    const taxAmount = (subtotal * taxPercent) / 100;
    const finalTotal = (subtotal + taxAmount).toFixed(2);

    document.getElementById('totalAmountField').value = finalTotal;
}

        function addRow() {
            const table = document.getElementById('itemTable');
            const index = table.rows.length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="items[${index}][product_code]" class="form-control"></td>
                <td>
                    <select name="items[${index}][item]" class="form-select">
                        <option>Saree</option>
                        <option>Dress</option>
                        <option>Accessories</option>
                    </select>
                </td>
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
        }

        function printFormattedInvoice() {
            const waiter = document.getElementById('staffInput').value;
            const date = new Date().toLocaleString();
            const billNo = document.getElementById('billNo').value;

            let printItemsHTML = '';
            let foodTotal = 0;
            const rows = document.querySelectorAll('#itemTable tr');
            rows.forEach((row, index) => {
                const item = row.querySelector('select').value;
                const qty = parseFloat(row.querySelector('[name$="[qty]"]').value || 0);
                const rate = parseFloat(row.querySelector('[name$="[price]"]').value || 0);
                const discount = parseFloat(row.querySelector('[name$="[discount]"]').value || 0);
const amount = (qty * rate) - discount;
foodTotal += amount;
printItemsHTML += `<tr><td>${index + 1}</td><td>${item}</td><td>${qty}</td><td>${rate.toFixed(2)}</td><td>${amount.toFixed(2)}</td></tr>`;

            });

            const cgst = (foodTotal * 0.025).toFixed(2);
            const sgst = (foodTotal * 0.025).toFixed(2);
            const total = (parseFloat(foodTotal) + parseFloat(cgst) + parseFloat(sgst)).toFixed(2);

            const newWindow = window.open('', '_blank');
            newWindow.document.write(`<!DOCTYPE html><html><head><title>Print</title></head><body>
                <h3 style="text-align:center">House of Fashion</h3>
                <p>Bill No: ${billNo}<br>Date & Time: ${date}<br>Staff: ${waiter}</p>
                <table border="1" cellspacing="0" cellpadding="6" style="width:100%; text-align:center;">
                    <thead><tr><th>Sr.</th><th>Description</th><th>Qty</th><th>Rate</th><th>Amount</th></tr></thead>
                    <tbody>${printItemsHTML}</tbody>
                </table>
                <p style="text-align:right">Subtotal: ₹${foodTotal.toFixed(2)}<br>CGST: ₹${cgst}<br>SGST: ₹${sgst}<br><strong>Total: ₹${total}</strong></p>
                <p style="text-align:center; font-size:12px;">FASSI NO: 11550207001581 | GST NO: 27ABJPL9876F1Z1 | HSN/SAC: 996331<br>Thank you, visit again!</p>
            </body></html>`);
            newWindow.document.close();
            newWindow.print();
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

