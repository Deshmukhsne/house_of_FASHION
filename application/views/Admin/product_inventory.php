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
            background-color: #f9f9f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-header {
            background-color: #000;
            color: #FFD27F;
            font-weight: 600;
        }

        .btn-gold {
            background: linear-gradient(90deg, #B37B16, #FFD27F, #B37B16);
            color: #000;
            font-weight: 600;
        }

        .btn-gold:hover {
            background: linear-gradient(90deg, #e2a93eff, #f7c872ff, #e1aa46ff);
            color: #000;
        }

        .modal-header {
            background-color: #000;
            color: #FFD27F;
        }

        .table th {
            background-color: #343a40;
            color: #FFD27F;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .status-available {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rented {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-dryclean {
            background-color: #d1ecf1;
            color: #0c5460;
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
               <div class="container mt-5">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Product Inventory</h5>
    <div>
        <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
        <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
    </div>
</div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by product name...">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">Filter by Status</option>
                        <option value="Available">Available</option>
                        <option value="Rented">Rented</option>
                        <option value="In Dry Clean">In Dry Clean</option>
                    </select>
                </div>
            </div>
            <table class="table table-bordered mt-3">
    <thead>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><img src="<?= base_url('uploads/' . $product->image) ?>" alt="Img" height="60"></td>
            <td><?= $product->name ?></td>
            <td><?= $product->category_name ?></td>
            <td><?= $product->stock ?></td>
            <td><span class="status-badge <?= $product->status == 'Available' ? 'status-available' : ($product->status == 'Rented' ? 'status-rented' : 'status-dryclean') ?>"><?= $product->status ?></span></td>
            <td>
                <a href="<?= base_url('ProductController/edit_product/' . $product->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="<?= base_url('ProductController/delete_product/' . $product->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

        </div>
    </div>
</div>

<!-- Modal: Add Product -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-2" placeholder="Product Name" required>
                <input type="text" class="form-control mb-2" placeholder="Category">
                <input type="number" class="form-control mb-2" placeholder="Stock Quantity">
                <select class="form-select mb-2">
                    <option value="Available">Available</option>
                    <option value="Rented">Rented</option>
                    <option value="In Dry Clean">In Dry Clean</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-gold" type="submit">Save Product</button>
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
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= base_url('ProductController/add_product') ?>" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
                <select name="category_id" class="form-select mb-2" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="stock" class="form-control mb-2" placeholder="Stock Quantity" required>
                <select name="status" class="form-select mb-2">
                    <option value="Available">Available</option>
                    <option value="Rented">Rented</option>
                    <option value="In Dry Clean">In Dry Clean</option>
                </select>
                <input type="file" name="image" class="form-control mb-2">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-gold" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="post" action="<?= base_url('ProductController/add_category') ?>">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control mb-2" placeholder="Category Name" required>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-gold" type="submit">Add Category</button>
            </div>
        </form>
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