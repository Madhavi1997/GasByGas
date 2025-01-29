<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container-fluid d-flex align-items-center" style="padding-top: 100px;">
        <div class=" row w-100">
            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center">
                <div class="placeholder-image" style="width: 80%; height: 80%; background-color: #ddd;"></div>
            </div>
            <div class="col-md-6 p-5">
                <h2 class="fw-bold">Sign Up</h2>
                <form action="signup_process.php" method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIC</label>
                        <input type="text" name="nic" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">TP</label>
                        <input type="text" name="tp" class="form-control" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Retype Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm-password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">I agree to all Terms, Privacy, and Fees.</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                    <p class="mt-3 text-center">Already have an account? <a href="login.php">Log in</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>
</body>

</html>