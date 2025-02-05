<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Nearest Outlets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container" style="padding-top: 120px;">
        <h1 class="text-center mb-4 fw-bold">Order History</h1>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Token</th>
                        <th>Order Total</th>
                        <th>Order Date</th>
                        <th>Pick Up/Delivery Date</th>
                        <th>Outlet</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>GBG123456</td>
                        <td>Rs. 3800.00</td>
                        <td>25-01-2025</td>
                        <td>05-02-2025</td>
                        <td>Outlet 3</td>
                        <td><span class="badge bg-warning text-dark">Processing</span></td>
                    </tr>
                    <tr>
                        <td>GBG123452</td>
                        <td>Rs. 3800.00</td>
                        <td>12-01-2025</td>
                        <td>27-01-2025</td>
                        <td>Outlet 3</td>
                        <td><span class="badge bg-info text-dark">Hand Over Empty Cylinder</span></td>
                    </tr>
                    <tr>
                        <td>GBG123455</td>
                        <td>Rs. 1300.00</td>
                        <td>19-11-2024</td>
                        <td>03-12-2024</td>
                        <td>Outlet 1</td>
                        <td><span class="badge bg-primary">Ready for pick up</span></td>
                    </tr>
                    <tr>
                        <td>GBG123453</td>
                        <td>Rs. 1300.00</td>
                        <td>23-09-2024</td>
                        <td>23-10-2024</td>
                        <td>Outlet 2</td>
                        <td><span class="badge bg-success">Complete</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>

</body>

</html>