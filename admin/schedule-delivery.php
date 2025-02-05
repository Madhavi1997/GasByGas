<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Header -->
    <?php include '../assets/components/header.php'; ?>
    

    <div class="container py-5">
        <h2 class="text-center fw-bold">Schedule Delivery</h2>

        <div class="d-flex justify-content-center mt-4">
            <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%;">
                <h4 class="text-center fw-bold">Schedule New Delivery</h4>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Outlet</label>
                        <select class="form-select" required>
                            <option selected disabled>Select an outlet</option>
                            <option value="1">Outlet 1</option>
                            <option value="2">Outlet 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Date</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Time</label>
                        <input type="time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" placeholder="Add any additional details" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">SCHEDULE DELIVERY</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../assets/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>