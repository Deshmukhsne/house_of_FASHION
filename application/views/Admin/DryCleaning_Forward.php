

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cleaning Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->load->view('CommonLinks'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/script.js') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .form-container {
  background-color: #f9f9f9;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  max-width: 900px;
  margin: 40px auto;
  animation: fadeIn 0.5s ease-in-out;
}

/* === Heading === */
.form-container h2 {
  background-color: #000;
  color: #fff;
  padding: 12px;
  border-radius: 8px;
  text-align: center;
  margin-bottom: 30px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* === Inputs, Select, Textarea === */
.form-control,
.form-select {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px 15px;
  transition: all 0.2s ease;
  font-size: 16px;
}

.form-control:focus,
.form-select:focus {
  border-color: #f9a825;
  box-shadow: 0 0 5px rgba(249, 168, 37, 0.4);
  outline: none;
}

/* === Button === */
.btn-warning {
  background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
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

/* === Success Message === */
#success-message {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  padding: 12px;
  border-radius: 6px;
  text-align: center;
  margin-top: 20px;
  display: none;
  animation: fadeIn 0.4s ease-in-out;
}

/* === Animations === */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* === Responsive === */
@media (max-width: 576px) {
  .form-container {
    padding: 20px;
  }

  .btn-warning {
    width: 100%;
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
              

<!-- Forward to Dry Cleaning Form -->
<div class="container mt-4 p-4 bg-light rounded shadow">
  <h2 class="text-center mb-4">Forward to Dry Cleaning</h2>

  <!-- <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['forward'])) {
      echo '<div class="alert alert-success text-center">Dress forwarded to dry cleaning!</div>';
  }
  ?> -->

  <form method="post">
    <div class="row g-3">
      <div class="col-md-6">
        <input type="text" name="forward_dress_id" class="form-control" placeholder="Product ID" required />
      </div>
      <div class="col-md-6">
        <input type="date" name="forward_date" class="form-control" value="<?= date('Y-m-d') ?>" required />
      </div>
      <div class="col-md-6">
        <select name="status" class="form-select" required>
          <option value="">-- Select Status --</option>
          <option>Forwarded</option>
          <option>In Cleaning</option>
          <option>Returned</option>
        </select>
      </div>
      <div class="col-md-6">
        <input type="date" name="expected_return" class="form-control" required />
      </div>
      <div class="col-12">
        <textarea name="cleaning_notes" class="form-control" placeholder="Cleaning Notes" rows="3"></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" name="forward" class="btn btn-warning px-5">Forward to Cleaning</button>
      </div>
    </div>
  </form>
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById("cleaningForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Stop actual form submission

    // Show SweetAlert popup
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: 'Dress forwarded to cleaning!',
      confirmButtonColor: '#f9a825'
    });

    // Optionally reset the form
    this.reset();
  });
</script>








</body>

</html>


