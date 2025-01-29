<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete - GasByGas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container my-5" style="padding-top: 120px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center border-success">
                    <div class="card-header bg-success text-white">
                        <h2 class="card-title mb-0">Order Complete!</h2>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Your gas request has successfully been placed. You'll be notified about your delivery or pick-up details through an email.</p>
                        <p class="card-text">Please use the following token to confirm your order at the pick-up or delivery:</p>
                        <div class="alert alert-info mb-4">
                            <p class="mb-0"><strong>Your Order ID:</strong> 0BG123456</p>
                            <p class="mb-0"><strong>Order Review:</strong> Pick up at the outlet</p>
                            <p class="mb-0"><strong>Product:</strong> Lastgis - 12.5 kg - Refill</p>
                        </div>
                        <a href="index.php" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>