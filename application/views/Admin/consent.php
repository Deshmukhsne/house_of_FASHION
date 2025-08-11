<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Shop Consent Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            max-width: 600px;
            width: 100%;
        }

        .form-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #007bff;
        }

        .form-check-label {
            font-size: 0.95rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-card mx-auto">
            <h3 class="form-title">Rental Shop Consent Form</h3>
            <form>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" placeholder="Enter your full name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" placeholder="Enter your contact number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rental Item</label>
                    <input type="text" class="form-control" placeholder="Enter item name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rental Duration</label>
                    <input type="text" class="form-control" placeholder="e.g., 3 days, 1 week" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" rows="3" placeholder="Enter your address" required></textarea>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="consentCheck" required>
                    <label class="form-check-label" for="consentCheck">
                        I hereby agree to the rental shop's terms and conditions, including responsibility for damage, loss, or late returns.
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                    <button type="reset" class="btn btn-secondary px-4">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>