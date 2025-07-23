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
  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      if (isset($_POST['forward'])) {
          $message = "Dress forwarded to dry cleaning!";
      }
  }
  ?>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9fafb;
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: #dadada;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      animation: fadeIn 1s ease-in;
    }

    h1 {
      text-align: center;
      font-size: 28px;
      margin-bottom: 20px;
      color: #333;
    }

    section {
      margin-bottom: 30px;
      border-top: 1px solid #eee;
      padding-top: 20px;
    }

    h2 {
      font-size: 20px;
      color: #555;
      margin-bottom: 10px;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    input, select, textarea {
      flex: 1 1 45%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    textarea {
      flex-basis: 100%;
      resize: vertical;
    }

    button {
      padding: 10px 20px;
      background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: transform 0.2s ease;
    }

    button:hover {
      transform: scale(1.03);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 14px;
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }

    @media (max-width: 600px) {
      form {
        flex-direction: column;
      }

      input, select, textarea {
        flex-basis: 100%;
      }

      h1 {
        font-size: 24px;
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .message {
      background: #d1fae5;
      color: #065f46;
      padding: 10px 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <?php $this->load->view('include/sidebar'); ?>

    <div class="main">
      <?php $this->load->view('include/navbar'); ?>

      <div class="container-fluid p-4">
        <div class="container">
          <h1>Dry Cleaning Management</h1>

          <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
          <?php endif; ?>

          <!-- Section 2: Forward to Dry Cleaning -->
          <section>
            <h2>1. Forward to Dry Cleaning</h2>
            <form method="post">
              <input type="text" name="forward_dress_id" placeholder="Product ID" required />
              <input type="date" name="forward_date" value="<?= date('Y-m-d') ?>" required />
              <select name="status" required>
                <option value="">-- Select Status --</option>
                <option>Forwarded</option>
                <option>In Cleaning</option>
                <option>Returned</option>
              </select>
              <input type="date" name="expected_return" required />
              <textarea name="cleaning_notes" placeholder="Cleaning Notes"></textarea>
              <button type="submit" name="forward">Forward to Cleaning</button>
            </form>
          </section>

          <!-- Section 3: Status Table -->
          <section>
            <h2>2. Dress Cleaning Status</h2>
            <table>
              <thead>
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
                  <td style="color:orange;">In Cleaning</td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </div>
    </div>
  </div>

  <script>
    const toggler = document.querySelector(".toggler-btn");
    const closeBtn = document.querySelector(".close-sidebar");
    const sidebar = document.querySelector("#sidebar");

    if (toggler && sidebar) {
      toggler.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
      });
    }

    if (closeBtn && sidebar) {
      closeBtn.addEventListener("click", function () {
        sidebar.classList.remove("collapsed");
      });
    }
  </script>
</body>
</html>
