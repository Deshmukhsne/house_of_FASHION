<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->load->view('CommonLinks'); ?>

    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

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
        .btn-gold {
            background: linear-gradient(90deg, #B37B16, #FFD27F);
            color: #000;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }
        .btn-gold:hover {
            background: linear-gradient(90deg, #FFD27F, #B37B16);
            color: #000;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .btn-black {
            background: #111;
            color: #FFD27F;
            font-weight: 600;
            border: none;
            transition: all .3s ease;
        }
        .btn-black:hover {
            background: #FFD27F;
            color: #111;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
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

            <!-- Filter Form -->
            <form action="<?= base_url('AdminController/filter_billing_history') ?>" method="get" class="row mb-3">
                <div class="col-md-4 mb-2">
                    <label for="fromDate" class="form-label">From Date:</label>
                    <input type="date" id="fromDate" name="from" class="form-control"
                           value="<?= $this->input->get('from') ?>">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="toDate" class="form-label">To Date:</label>
                    <input type="date" id="toDate" name="to" class="form-control"
                           value="<?= $this->input->get('to') ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mb-2 w-100">Generate Request</button>
                </div>
            </form>

            <!-- Enhanced Billing Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle bg-white shadow-sm">
                    <thead class="table-light align-middle">
                        <tr style="background:linear-gradient(90deg,#FFD27F,#B37B16);color:#a86d01ff;">
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Mobile No</th>
                            <th>Total (₹)</th>
                            <th>Deposit (₹)</th>
                            <th>Paid (₹)</th>
                            <th>Due (₹)</th>
                            <th>Payment</th>
                            <th>Items</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($invoices)): ?>
                        <?php foreach ($invoices as $inv): ?>
                        <tr style="vertical-align:middle;">
                            <td><span class="fw-bold text-gold"><?= htmlspecialchars($inv['invoice_no']) ?></span></td>
                            <td><?= htmlspecialchars($inv['invoice_date']) ?></td>
                            <td><?= htmlspecialchars($inv['customer_name']) ?></td>
                            <td><?= htmlspecialchars($inv['customer_mobile'] ?? '-') ?></td>
                            <td class="text-end">₹<?= number_format($inv['total_amount'], 2) ?></td>
                            <td class="text-end">₹<?= number_format($inv['deposit_amount'], 2) ?></td>
                            <td class="text-end">₹<?= number_format($inv['paid_amount'], 2) ?></td>
                            <td class="text-end">₹<?= number_format($inv['due_amount'], 2) ?></td>
                            <td><?= htmlspecialchars($inv['payment_mode']) ?></td>
                            <td style="min-width:220px;max-width:350px;">
                                <?php if (!empty($inv['items'])): ?>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($inv['items'] as $item): ?>
                                    <li class="border-bottom pb-1 mb-1 small">
                                        <span class="fw-semibold text-dark">[<?= htmlspecialchars($item['category']) ?>]</span>
                                        <span><?= htmlspecialchars($item['item_name']) ?></span>
                                        <span class="badge bg-light text-dark border ms-1">₹<?= number_format($item['price'],2) ?> × <?= $item['quantity'] ?> = <span class="fw-bold">₹<?= number_format($item['total'],2) ?></span></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                    <span class="text-muted">No items</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-gold btn-sm mb-1 view-invoice-btn" data-invoice-id="<?= $inv['id'] ?>">View</button>
                                <a href="<?= base_url('AdminController/delete_invoice/' . $inv['id']) ?>" onclick="return confirm('Are you sure you want to delete this invoice?')" class="btn btn-gold btn-sm">Delete</a>
                                <?php if ($inv['due_amount'] > 0): ?>
                                <button type="button" class="btn btn-black btn-sm pay-due-btn" data-invoice-id="<?= $inv['id'] ?>" data-due="<?= $inv['due_amount'] ?>">Pay Due</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="11">No records found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Invoice Modal -->
            <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="invoiceModalBody">
                    <!-- Content loaded by JS -->
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal for Pay Due -->
            <div class="modal fade" id="payDueModal" tabindex="-1" aria-labelledby="payDueModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="payDueModalLabel">Pay Due Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="payDueForm">
                    <div class="modal-body">
                      <input type="hidden" name="invoice_id" id="payDueInvoiceId">
                      <div class="mb-3">
                        <label for="payDueAmount" class="form-label">Amount to Pay (₹):</label>
                        <input type="number" name="pay_amount" id="payDueAmount" class="form-control" min="1" step="0.01" required>
                        <div class="form-text">You can pay up to the due amount only.</div>
                      </div>
                      <div class="mb-3">
                        <label for="payDuePaymentMode" class="form-label">Payment Mode:</label>
                        <select name="pay_due_payment_mode" id="payDuePaymentMode" class="form-select" required>
                          <option value="">Select</option>
                          <option value="Cash">Cash</option>
                          <option value="Card">Card</option>
                          <option value="UPI">UPI</option>
                          <option value="Bank">Bank</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-gold">Pay</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Export Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="<?= base_url('AdminController/export_pdf') ?>" class="btn btn-success">Export to PDF</a>
                <a href="<?= base_url('AdminController/export_excel') ?>" class="btn btn-warning">Export to Excel</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-invoice-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var invoiceId = this.getAttribute('data-invoice-id');
            fetch('<?= base_url('index.php/AdminController/view_invoice/') ?>' + invoiceId, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                let html = `<div class='mb-2'><strong>Invoice #:</strong> ${data.invoice_no || ''}</div>`;
                html += `<div class='mb-2'><strong>Date:</strong> ${data.invoice_date || ''}</div>`;
                html += `<div class='mb-2'><strong>Customer:</strong> ${data.customer_name || ''}</div>`;
                html += `<div class='mb-2'><strong>Total:</strong> ₹${parseFloat(data.total_amount).toFixed(2)}</div>`;
                html += `<div class='mb-2'><strong>Paid:</strong> ₹${parseFloat(data.paid_amount).toFixed(2)}</div>`;
                html += `<div class='mb-2'><strong>Due:</strong> ₹${parseFloat(data.due_amount).toFixed(2)}</div>`;
                html += `<div class='mb-2'><strong>Payment Mode:</strong> ${data.payment_mode || ''}</div>`;
                html += `<h6 class='mt-3'>Items</h6>`;
                if (data.items && data.items.length > 0) {
                    html += `<table class='table table-bordered'><thead><tr><th>Category</th><th>Item Name</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead><tbody>`;
                    data.items.forEach(function(item) {
                        html += `<tr><td>${item.category}</td><td>${item.item_name}</td><td>₹${parseFloat(item.price).toFixed(2)}</td><td>${item.quantity}</td><td>₹${parseFloat(item.total).toFixed(2)}</td></tr>`;
                    });
                    html += `</tbody></table>`;
                } else {
                    html += `<div class='text-muted'>No items found.</div>`;
                }
                document.getElementById('invoiceModalBody').innerHTML = html;
                var modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                modal.show();
            })
            .catch(() => {
                document.getElementById('invoiceModalBody').innerHTML = '<div class="text-danger">Failed to load invoice details.</div>';
                var modal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                modal.show();
            });
        });
    });

    document.querySelectorAll('.pay-due-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var invoiceId = this.getAttribute('data-invoice-id');
            var due = this.getAttribute('data-due');
            // Defensive: ensure modal and fields exist before setting values
            var modalEl = document.getElementById('payDueModal');
            var invoiceInput = document.getElementById('payDueInvoiceId');
            var amountInput = document.getElementById('payDueAmount');
            var modeInput = document.getElementById('payDuePaymentMode');
            if (modalEl && invoiceInput && amountInput && modeInput) {
                invoiceInput.value = invoiceId;
                amountInput.value = due;
                amountInput.setAttribute('max', due);
                modeInput.value = '';
                // Fix: ensure modal is not already shown, then show
                bootstrap.Modal.getOrCreateInstance(document.getElementById('payDueModal')).show();
            } else {
                alert('Payment modal could not be opened. Please reload the page.');
            }
        });
    });

    document.getElementById('payDueForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var payAmount = parseFloat(form.pay_amount.value);
        var maxDue = parseFloat(form.pay_amount.max);
        var payMode = form.pay_due_payment_mode.value;
        if (isNaN(payAmount) || payAmount <= 0) {
            alert('Please enter a valid amount to pay.');
            return;
        }
        if (payAmount > maxDue) {
            alert('You cannot pay more than the due amount.');
            form.pay_amount.value = maxDue;
            return;
        }
        if (!payMode) {
            alert('Please select a payment mode.');
            return;
        }
        var formData = new FormData(form);
        fetch('<?= base_url('index.php/AdminController/pay_due_amount') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(function(data) {
            if (data.success) {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 1800,
                        showConfirmButton: false
                    });
                } else {
                    alert(data.message);
                }
                setTimeout(() => window.location.reload(), 1200);
            } else {
                alert(data.message || 'Failed to update due payment.');
            }
        })
        .catch(() => alert('Error updating due payment.'));
    });
});


// Sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
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
});

</body>
</html>
