<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        :root{--primary-color:#D4AF37;--secondary-color:#a86d01;--light-gold:#FFD27F;--dark-gold:#B37B16;}
        body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background-color:#f8f9fa;}
        .bill-card{position:relative;border:none;border-radius:15px;box-shadow:0 6px 15px rgba(0,0,0,0.1);background:#fff;padding:2rem 3rem;}
        .bill-card::before{content:"";position:absolute;top:0;left:0;width:100%;height:8px;background:linear-gradient(90deg,var(--dark-gold),var(--light-gold));border-top-left-radius:15px;border-top-right-radius:15px;}
        h4{color:var(--secondary-color);font-weight:700;margin-bottom:1.5rem;text-align:center;}
        label{font-weight:600;color:var(--secondary-color);display:block;margin-bottom:.3rem;}
        .form-section-title{font-weight:700;color:var(--secondary-color);margin-bottom:1rem;border-bottom:3px solid var(--dark-gold);padding-bottom:.25rem;}
        .table thead{background-color:rgba(212,175,55,.2);}
        .table th{font-weight:600;color:var(--secondary-color);vertical-align:middle;}
        .btn-gold{background:linear-gradient(90deg,var(--dark-gold),var(--light-gold));color:#000;font-weight:600;border:none;transition:all .3s ease;}
        .btn-gold:hover{background:linear-gradient(90deg,var(--light-gold),var(--dark-gold));transform:translateY(-2px);box-shadow:0 4px 8px rgba(0,0,0,.1);}
        .total-display{background-color:rgba(212,175,55,.1);border-left:4px solid var(--primary-color);padding:1rem;border-radius:0 8px 8px 0;}
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
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <form action="<?= base_url('AdminController/save_invoice') ?>" method="post" id="invoiceForm">
                        <!-- Invoice Info -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Invoice No:</label>
                                <input type="text" name="invoiceNo" id="invoiceNo" class="form-control" readonly value="<?= isset($temp_invoice_no) ? $temp_invoice_no : '' ?>" />
                            </div>
                            <div class="col-md-4">
                                <label>Customer Name:</label>
                                <input type="text" name="customerName" id="customerName" class="form-control" required />
                            </div>
                            <div class="col-md-4">
                                <label>Customer Mobile No:</label>
                                <input type="text" name="customerMobile" id="customerMobile" class="form-control" maxlength="15" required />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="date" name="date" id="date" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label>Deposit Amount (₹):</label>
                                <input type="number" name="depositAmount" id="depositAmount" class="form-control" min="0" step="0.01" value="0" oninput="updateBalance()" />
                            </div>
                        </div>
                        <!-- Items Table -->
                        <div class="mb-4">
                            <label class="form-section-title">Items</label>
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
                                            <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                                                <option value="">Select</option>
                                                <?php foreach($categories as $c): ?>
                                                    <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="itemName[]" class="form-select product-select" onchange="onProductChange(this)">
                                                <option value="">Select Item</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="price[]" class="form-control price" readonly />
                                        </td>
                                        <td>
                                            <input type="number" name="qty[]" class="form-control qty" min="1" value="1" oninput="updateTotal(this)" />
                                        </td>
                                        <td>
                                            <input type="number" name="total[]" class="form-control total" readonly />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-gold" type="button" onclick="addRow()">+ Add Item</button>
                        </div>
                        <!-- Summary -->
                        <div class="row summary-section">
                            <div class="col-md-6">
                                <div class="mb-2 d-flex justify-content-between">
                                    <span>Total Amount:</span>
                                    <span class="value" id="totalAmount">₹0.00</span>
                                </div>
                                <div class="mb-3">
                                    <label>Discount (₹):</label>
                                    <input type="number" name="discountAmount" id="discountAmount" min="0" step="0.01" class="form-control" value="0" oninput="updateAllTotals()" />
                                </div>
                                <div class="mb-2 d-flex justify-content-between">
                                    <span>Total Payable:</span>
                                    <span class="value" id="totalPayable">₹0.00</span>
                                </div>
                                <div class="mb-3">
                                    <label>Paid Amount (₹):</label>
                                    <input type="number" name="paidAmount" id="paidAmount" class="form-control" min="0" step="0.01" value="0" oninput="updateBalance()" />
                                </div>
                                <div class="mb-3">
                                    <label>Due Amount (₹):</label>
                                    <input type="number" name="dueAmount" id="dueAmount" class="form-control" readonly />
                                </div>
                                <div class="mb-3">
                                    <label>Payment Mode:</label>
                                    <select name="paymentMode" id="paymentMode" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="UPI">UPI</option>
                                        <option value="Card">Card</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Hidden totals -->
                        <input type="hidden" name="totalAmount" id="totalAmountInput">
                        <input type="hidden" name="totalPayable" id="totalPayableInput">
                        <div class="text-center mt-4">
                            <button class="btn btn-gold" type="submit">Save Invoice</button>
                            <button class="btn btn-outline-secondary" type="reset" onclick="resetForm()">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// ------- Bootstrap the product dataset from PHP for instant filtering -------
const PRODUCTS = <?php
    $grouped = [];
    if (!empty($products)) {
        foreach ($products as $p) {
            $cid = (int)$p['category_id'];
            if (!isset($grouped[$cid])) $grouped[$cid] = [];
            $grouped[$cid][] = [
                'id'    => (int)$p['id'],
                'name'  => $p['name'],
                'price' => (float)$p['price'],
                'status'=> $p['status']
            ];
        }
    }
    echo json_encode($grouped);
?>;
function addRow() {
    const tbody = document.getElementById('itemTable');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <select name="category[]" class="form-select category-select" onchange="onCategoryChange(this)">
                <option value="">Select</option>
                <?php foreach($categories as $c): ?>
                <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select name="itemName[]" class="form-select product-select" onchange="onProductChange(this)">
                <option value="">Select Item</option>
            </select>
        </td>
        <td><input type="number" name="price[]" class="form-control price" readonly /></td>
        <td><input type="number" name="qty[]" class="form-control qty" min="1" value="1" oninput="updateTotal(this)" /></td>
        <td><input type="number" name="total[]" class="form-control total" readonly /></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
    `;
    tbody.appendChild(tr);
}
function removeRow(btn) {
    btn.closest('tr').remove();
    updateAllTotals();
}
function onCategoryChange(sel) {
    const tr = sel.closest('tr');
    const prodSelect = tr.querySelector('.product-select');
    const priceInput = tr.querySelector('.price');
    const totalInput = tr.querySelector('.total');
    prodSelect.innerHTML = `<option value="">Select Item</option>`;
    const cid = parseInt(sel.value || 0);
    priceInput.value = '';
    totalInput.value = '';
    if (cid && PRODUCTS[cid]) {
        PRODUCTS[cid].forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.name;
            opt.dataset.price = p.price;
            prodSelect.appendChild(opt);
        });
    }
    updateAllTotals();
}
function onProductChange(sel) {
    const tr = sel.closest('tr');
    const priceInput = tr.querySelector('.price');
    const qtyInput = tr.querySelector('.qty');
    const price = parseFloat(sel.selectedOptions[0]?.dataset.price || 0);
    priceInput.value = price ? price.toFixed(2) : '';
    updateTotal(qtyInput);
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
    document.getElementById('totalAmountInput').value = totalAmount.toFixed(2);
    const discount = parseFloat(document.getElementById('discountAmount').value) || 0;
    const validDiscount = discount > totalAmount ? totalAmount : discount;
    if (discount !== validDiscount) {
        document.getElementById('discountAmount').value = validDiscount.toFixed(2);
    }
    const totalPayable = totalAmount - validDiscount;
    document.getElementById('totalPayable').textContent = `₹${totalPayable.toFixed(2)}`;
    document.getElementById('totalPayableInput').value = totalPayable.toFixed(2);
    updateBalance();
}
function updateBalance() {
    const totalPayable = parseFloat(document.getElementById('totalPayable').textContent.replace('₹','')) || 0;
    let paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    // Cap paidAmount so it cannot exceed totalPayable
    if (paidAmount > totalPayable) {
        paidAmount = totalPayable;
        document.getElementById('paidAmount').value = paidAmount.toFixed(2);
        if (window.Swal) {
            Swal.fire({
                icon: 'warning',
                title: 'Paid amount adjusted',
                text: 'Paid amount cannot exceed total payable.',
                timer: 1800,
                showConfirmButton: false
            });
        }
    }
    // Due = totalPayable - paidAmount
    let dueAmount = totalPayable - paidAmount;
    if (dueAmount < 0) dueAmount = 0;
    document.getElementById('dueAmount').value = dueAmount.toFixed(2);
}
function resetForm() {
    document.getElementById('invoiceForm').reset();
    const tbody = document.getElementById('itemTable');
    tbody.innerHTML = '';
    addRow();
    updateAllTotals();
}
document.getElementById('invoiceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Show SweetAlert
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert(data.message);
            }
            // Set Invoice No
            document.getElementById('invoiceNo').value = data.invoice_no;
        } else {
            alert('Failed to save invoice.');
        }
    })
    .catch(() => alert('Error saving invoice.'));
});
updateAllTotals();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const toggler = document.querySelector(".toggler-btn");
    const closeBtn = document.querySelector(".close-sidebar");
    const sidebar = document.querySelector("#sidebar");
    if (toggler && sidebar) toggler.addEventListener("click", () => sidebar.classList.toggle("collapsed"));
    if (closeBtn && sidebar) closeBtn.addEventListener("click", () => sidebar.classList.remove("collapsed"));
</script>
</body>
</html>
