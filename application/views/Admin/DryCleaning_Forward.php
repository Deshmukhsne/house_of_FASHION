<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing Dashboard</title>
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
    body {
      background: #f3f4f6;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color:#dadada;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 900px;
      margin: 40px auto;
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

    .form-control:focus, 
    .form-select:focus,
    textarea:focus {
      border-color: #f9a825; 
      box-shadow: 0 0 6px rgba(249, 168, 37, 0.4);
      outline:none;
    }

    .btn-warning {
      background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
      border:black;
      color: #000;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(249, 168, 37, 0.3);
    }

    .btn-warning:hover {
      background: linear-gradient(90deg, #FFD27F 0%, #B37B16 100%);
      color: black;
      transform: translateY(-2px);
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
               <div class="container-fluid p-4">
        <div class="form-container">
          <h2 class="form-title">Forward to Dry Cleaning</h2>
      <form id="cleaningForm" method="post" action="<?= base_url('AdminController/DryCleaning_status') ?>">
          <!-- <form id="cleaningForm"> -->
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
                <button type="submit" class="btn btn-warning px-5">Forward to Cleaning</button>
              </div>
            </div>
          </form>
        </div>
      </div>

            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
 
    
<script>
  document.getElementById("cleaningForm").addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      icon: 'success',
      title: 'Dress Forwarded!',
      text: 'The dress has been successfully forwarded for cleaning.',
      confirmButtonColor: '#f9a825'
    }).then(() => {
      this.submit(); // Submit the form after alert
    });
  });
</script>
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
