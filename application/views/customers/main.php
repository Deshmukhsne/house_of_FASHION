<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .action-btns button {
      margin-right: 5px;
    }
    .top-buttons {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }
  </style>
</head>
<body>
<div class="container mt-4">

  <div class="top-buttons mb-3">
    <div>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add Customer</button>
    </div>
    <div>
      <a href="<?= base_url('customers/export_excel') ?>" class="btn btn-success">Export to Excel</a>
      <a href="<?= base_url('customers/export_pdf') ?>" class="btn btn-danger">Export to PDF</a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
  <?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php endif; ?>

  <form method="get" class="row g-3 mb-3">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= $search ?>">
    </div>
    <div class="col-md-4">
      <select name="filter" class="form-control">
        <option value="">All Proof Types</option>
        <option value="Aadhar" <?= $filter == 'Aadhar' ? 'selected' : '' ?>>Aadhar</option>
        <option value="PAN" <?= $filter == 'PAN' ? 'selected' : '' ?>>PAN</option>
        <option value="Driving License" <?= $filter == 'Driving License' ? 'selected' : '' ?>>Driving License</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-secondary" type="submit">Filter</button>
    </div>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact</th>
        <th>ID Proof Type</th>
        <th>ID Proof File</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($customers)): ?>
        <?php foreach ($customers as $customer): ?>
          <tr>
            <td><?= $customer->id ?></td>
            <td><?= $customer->name ?></td>
            <td><?= $customer->contact ?></td>
            <td><?= $customer->id_proof_type ?></td>
            <td>
              <?php if (!empty($customer->id_proof_file)): ?>
                <a href="<?= base_url('uploads/id_proofs/' . $customer->id_proof_file) ?>" target="_blank">View</a>
              <?php else: ?>
                N/A
              <?php endif; ?>
            </td>
            <td class="action-btns">
              <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                      data-bs-target="#viewCustomerModal<?= $customer->id ?>">View</button>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                      data-bs-target="#editCustomerModal<?= $customer->id ?>">Edit</button>
              <a href="<?= base_url('customers/delete/' . $customer->id) ?>"
                 onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
              <a href="#" class="btn btn-secondary btn-sm">Order</a>
            </td>
          </tr>

          <!-- View Modal -->
          <div class="modal fade" id="viewCustomerModal<?= $customer->id ?>" tabindex="-1"
               aria-labelledby="viewCustomerLabel<?= $customer->id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Customer Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><strong>Name:</strong> <?= $customer->name ?></p>
                  <p><strong>Contact:</strong> <?= $customer->contact ?></p>
                  <p><strong>ID Proof Type:</strong> <?= $customer->id_proof_type ?></p>
                  <?php if (!empty($customer->id_proof_file)): ?>
                    <p><strong>ID Proof File:</strong><br>
                      <a href="<?= base_url('uploads/id_proofs/' . $customer->id_proof_file) ?>" target="_blank">View File</a>
                    </p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Modal -->
          <div class="modal fade" id="editCustomerModal<?= $customer->id ?>" tabindex="-1"
               aria-labelledby="editCustomerLabel<?= $customer->id ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
              <div class="modal-content">
                <form action="<?= base_url('customers/edit/' . $customer->id) ?>" method="post" enctype="multipart/form-data">


                  <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label>Name</label>
                      <input type="text" name="name" value="<?= $customer->name ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label>Contact</label>
                      <input type="text" name="contact" value="<?= $customer->contact ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label>ID Proof Type</label>
                      <select name="id_proof_type" class="form-control">
                        <option value="Aadhar" <?= $customer->id_proof_type == 'Aadhar' ? 'selected' : '' ?>>Aadhar</option>
                        <option value="PAN" <?= $customer->id_proof_type == 'PAN' ? 'selected' : '' ?>>PAN</option>
                        <option value="Driving License" <?= $customer->id_proof_type == 'Driving License' ? 'selected' : '' ?>>Driving License</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label>ID Proof File</label>
                      <input type="file" name="id_proof" class="form-control">
                      <?php if (!empty($customer->id_proof_file)): ?>
                        <small>Current: <?= $customer->id_proof_file ?></small>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="text-center">No customers found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <?= $pagination ?>

  <!-- Add Modal -->
  <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <form action="<?= base_url('customers/add') ?>" method="post" enctype="multipart/form-data">

          <div class="modal-header">
            <h5 class="modal-title">Add New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Contact</label>
              <input type="text" name="contact" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>ID Proof Type</label>
              <select name="id_proof_type" class="form-control">
                <option value="Aadhar">Aadhar</option>
                <option value="PAN">PAN</option>
                <option value="Driving License">Driving License</option>
              </select>
            </div>
            <div class="mb-3">
              <label>ID Proof File</label>
              <input type="file" name="id_proof" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
