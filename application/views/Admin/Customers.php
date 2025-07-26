<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .btn-gold {
            background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
            color: #000;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            background: #b37b16;
            color: white;
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

<div class="container py-4">
  <h2>Customer Management</h2>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

  <div class="d-flex justify-content-between mb-3">
    <form class="d-flex" method="get">
      <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="<?= $search ?>">
      <button class="btn btn-gold">Search</button>
    </form>
    <div>
      <a href="<?= base_url('customers/export_excel') ?>" class="btn btn-gold">Export Excel</a>
      <a href="<?= base_url('customers/export_pdf') ?>" class="btn btn-gold">Export PDF</a>
      <button class="btn btn-gold"  data-bs-toggle="modal" data-bs-target="#addModal">Add Customer</button>
    </div>
  </div>

  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($customers as $cust): ?>
        <tr>
          <td><?= $cust->id ?></td>
          <td><?= $cust->name ?></td>
          <td><?= $cust->contact ?></td>
          <td>
            <button class="btn btn-sm btn-warning editBtn btn-gold" data-id="<?= $cust->id ?>">Edit</button>
            <a href="<?= base_url('customers/delete/' . $cust->id) ?>" class="btn btn-sm btn-gold" onclick="return confirm('Delete this customer?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?= $pagination ?>

</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" action="<?= base_url('customers/add') ?>" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Customer</h5></div>
      <div class="modal-body">
        <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>Contact</label><input name="contact" class="form-control" required></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-gold" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-gold">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" action="<?= base_url('customers/update') ?>" class="modal-content">
      <input type="hidden" name="id" id="edit_id">
      <div class="modal-header"><h5 class="modal-title">Edit Customer</h5></div>
      <div class="modal-body">
        <div class="mb-3"><label>Name</label><input name="name" id="edit_name" class="form-control" required></div>
        <div class="mb-3"><label>Contact</label><input name="contact" id="edit_contact" class="form-control" required></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-gold" data-bs-dismiss="modal">Close</button>
        <button class="btn bbtn-gold">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap + JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function() {
    $('.editBtn').click(function() {
      let id = $(this).data('id');
      $.get("<?= base_url('customers/get/') ?>" + id, function(data) {
        let customer = JSON.parse(data);
        $('#edit_id').val(customer.id);
        $('#edit_name').val(customer.name);
        $('#edit_contact').val(customer.contact);
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
      });
    });
  });
</script>
</body>
</html>
