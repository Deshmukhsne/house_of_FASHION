

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>Dress Cleaning Status</title>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

      .container{
              overflow:auto;
             }
        h2.section-heading {
            background-color: #000;
            color: #FFD700;
            padding: 7px;
            border-radius: 8px;
            text-align: center;
            font-weight: 400;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: fadeZoom 1s ease-in-out;
            font-size: 2rem;
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
            
<!-- Dress Cleaning Status Table -->
<div class="container mt-5 p-4 bg-light rounded shadow">
  <h2 class=" section-heading mb-4">Dress Cleaning Status</h2>
 

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Forward Date</th>
        <th>Expected Return</th>
        <th>Cleaning Charges</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>P1001</td>
        <td>White-Sherwani</td>
        <td>Sherwani</td>
        <td>2025-07-23</td>
        <td>2025-07-26</td>
        <td>1500.00</td>
        <td class="text-warning">
         <select name="status" class="form-select" required>
                  <option value="">-- Select Status --</option>
                  <option>Forwarded</option>
                  <option>In Cleaning</option>
                  <option>Returned</option>
          </select>
        </td>
      </tr>
      <!-- You can loop through database records here -->
    </tbody>
  </table>
</div>


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


