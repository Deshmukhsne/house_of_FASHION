<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add to Dry Cleaning</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('CommonLinks'); ?>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

  <style>
    body {
      background: #f3f4f6;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: #dadada;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      margin: 35px auto;
      animation: fadeIn 0.5s ease-in-out;
    }

    h2.form-title {
      background-color: #000;
      color: #FFD27F;
      padding: 5px;
      border-radius: 8px;
      text-align: center;
      font-weight: 200;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .form-control,
    .form-select,
    textarea {
      border: 2px solid #ccc;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s ease;
      font-size: 16px;
    }

    .btn-warning {
      background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
      border: none;
      color: #000;
      padding: 10px 30px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(249, 168, 37, 0.3);
    }

    .btn-warning:hover {
      background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
      color: #fff;
      transform: translateY(-2px);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
      .form-container { padding: 20px; }
      .btn-warning { width: 100%; }
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <?php $this->load->view('include/sidebar'); ?>
    <div class="main">
      <?php $this->load->view('include/navbar'); ?>

      <div class="container-fluid p-4">
        <div class="form-container">
          <h2 class="form-title">Forward to Dry Cleaning</h2>
          <form id="cleaningForm" method="post" action="<?= base_url('AdminController/DryCleaning_status') ?>">
            <div class="row g-3">
              
              <!-- Vendor Name -->
              <div class="col-md-6">
                <input type="text" name="vendor_name" class="form-control"
                  placeholder="Vendor Name" required
                  pattern="^[A-Za-z\s]{2,50}$"
                  title="Vendor name should only contain letters and spaces (2-50 characters)">
              </div>

              <!-- Vendor Mobile -->
              <div class="col-md-6">
                <input type="tel" name="vendor_mobile" class="form-control"
                  placeholder="Vendor Mobile Number" required
                  pattern="^[6-9][0-9]{9}$"
                  title="Enter a valid 10-digit Indian mobile number starting with 6-9">
              </div>

              <!-- Product Dropdown -->
              <div class="col-md-6">
                <select name="forward_dress_id" class="form-select" required>
                  <option value="">-- Select Product --</option>
                  <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                      <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option value="">No products available</option>
                  <?php endif; ?>
                </select>
              </div>

              <!-- Forward Date -->
              <div class="col-md-6">
                <input type="date" name="forward_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <select name="status" class="form-select" required>
                  <option value="">-- Select Status --</option>
                  <option>Forwarded</option>
                  <option>In Cleaning</option>
                  <option>Returned</option>
                </select>
              </div>

              <!-- Expected Return -->
              <div class="col-md-6">
                <input type="date" name="expected_return" class="form-control" required>
              </div>

              <!-- Notes -->
              <div class="col-12">
                <textarea name="cleaning_notes" class="form-control"
                  placeholder="Cleaning Notes" rows="3"
                  maxlength="255"
                  title="Notes can be up to 255 characters"></textarea>
              </div>

              <!-- Submit -->
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-warning px-5">Forward to Cleaning</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <!-- SweetAlert on Submit -->
  <script>
    document.getElementById("cleaningForm").addEventListener("submit", function(e) {
      if (!this.checkValidity()) {
        e.preventDefault();
        this.reportValidity();
        return;
      }
      e.preventDefault();
      Swal.fire({
        icon: 'success',
        title: 'Dress Forwarded!',
        text: 'The dress has been successfully forwarded for cleaning.',
        confirmButtonColor: '#f9a825'
      }).then(() => {
        this.submit();
      });
    });
  </script>

  <!-- Sidebar Toggler -->
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
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add to Dry Cleaning</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('CommonLinks'); ?>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

  <style>
    body {
      background: #f3f4f6;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: #dadada;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      margin: 35px auto;
      animation: fadeIn 0.5s ease-in-out;
    }

    h2.form-title {
      background-color: #000;
      color: #FFD27F;
      padding: 5px;
      border-radius: 8px;
      text-align: center;
      font-weight: 200;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .form-control,
    .form-select,
    textarea {
      border: 2px solid #ccc;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s ease;
      font-size: 16px;
    }

    .btn-warning {
      background: linear-gradient(90deg, #B37B16 0%, #FFD27F 100%);
      border: none;
      color: #000;
      padding: 10px 30px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(249, 168, 37, 0.3);
    }

    .btn-warning:hover {
      background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
      color: #fff;
      transform: translateY(-2px);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
      .form-container { padding: 20px; }
      .btn-warning { width: 100%; }
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <?php $this->load->view('include/sidebar'); ?>
    <div class="main">
      <?php $this->load->view('include/navbar'); ?>

      <div class="container-fluid p-4">
        <div class="form-container">
          <h2 class="form-title">Forward to Dry Cleaning</h2>
          <form id="cleaningForm" method="post" action="<?= base_url('Admin/DryCleaning_status') ?>">
            <div class="row g-3">
              
              <!-- Vendor Name -->
              <div class="col-md-6">
                <input type="text" name="vendor_name" class="form-control"
                  placeholder="Vendor Name" required
                  pattern="^[A-Za-z\s]{2,50}$"
                  title="Vendor name should only contain letters and spaces (2-50 characters)">
              </div>

              <!-- Vendor Mobile -->
              <div class="col-md-6">
                <input type="tel" name="vendor_mobile" class="form-control"
                  placeholder="Vendor Mobile Number" required
                  pattern="^[6-9][0-9]{9}$"
                  title="Enter a valid 10-digit Indian mobile number starting with 6-9">
              </div>
               <!-- product list -->
             
<div class="col-md-6">
    <select name="product_name" class="form-select" required>
        <option value="">-- Select Product --</option>

        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <option value="<?= htmlspecialchars($product->product_name) ?>">
                    <?= htmlspecialchars($product->product_name) ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No products available</option>
        <?php endif; ?>
    </select>
</div>


              <!-- Forward Date -->
              <div class="col-md-6">
                <input type="date" name="forward_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
              </div>

              <!-- Status -->
              <div class="col-md-6">
               <select name="product_status" class="form-select" required>

                  <option value="">-- Select Status --</option>
                  <option>Forwarded</option>
                  <option>In Cleaning</option>
                  
                </select>
              </div>

              <!-- Expected Return -->
              <div class="col-md-6">
                <input type="date" name="expected_return" class="form-control" required>
              </div>

              <!-- Notes -->
              <div class="col-12">
                <textarea name="cleaning_notes" class="form-control"
                  placeholder="Cleaning Notes" rows="3"
                  maxlength="255"
                  title="Notes can be up to 255 characters"></textarea>
              </div>

              <!-- Submit -->
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-warning px-5">Forward to Cleaning</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <!-- SweetAlert on Submit -->
  <script>
    document.getElementById("cleaningForm").addEventListener("submit", function(e) {
      if (!this.checkValidity()) {
        e.preventDefault();
        this.reportValidity();
        return;
      }
      e.preventDefault();
      Swal.fire({
    title: 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'OK'
}).then((result) => {
    if (result.isConfirmed) {
        document.getElementById("forwardForm").submit();
    }
});

  </script>

  <!-- Sidebar Toggler -->
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
</body>
</html>
