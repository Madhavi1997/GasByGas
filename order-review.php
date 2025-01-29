<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container py-5 d-flex justify-content-center">
        <div class="card p-4 shadow-lg" style="max-width: 800px; width: 100%;">
            <h2 class="text-center fw-bold">Where should we send the order?</h2>

            <form action="payment.php" method="POST">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card p-4 mb-4">
                            <h4 class="fw-bold mb-3">Shipping Address</h4>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Amara" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Dissanayake" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="abc@gmail.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="street_address" class="form-label">Street Address</label>
                                <input type="text" id="street_address" name="street_address" class="form-control" placeholder="123 Main Street" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="state" class="form-label">State/Province</label>
                                    <select id="state" name="state" class="form-select">
                                        <option selected>North Central</option>
                                        <option>Western</option>
                                        <option>Central</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <select id="city" name="city" class="form-select">
                                        <option selected>Anuradhapura</option>
                                        <option>Polonnaruwa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="zip_code" class="form-label">Zip/Postal Code</label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control" placeholder="500001" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="070 - 34 56 123" required>
                                </div>
                            </div>
                        </div>

                        <div class="card p-4 mb-4">
                            <h4 class="fw-bold mb-3">Choose your preferred delivery method</h4>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="shipping_method" id="pickup" value="Pick Up" checked>
                                <label class="form-check-label" for="pickup">
                                    Pick up the gas at our selected outlet: <strong>Outlet 1</strong><br>
                                    <span class="text-muted">You will be notified about the pick-up date.</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shipping_method" id="delivery" value="Delivery">
                                <label class="form-check-label" for="delivery">
                                    Deliver the product to your doorstep
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>