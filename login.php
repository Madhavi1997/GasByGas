<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container-fluid vh-100 d-flex align-items-center" style="padding-top: 120px">
        <div class="row w-100">
            <div class="col-md-6 bg-light d-flex align-items-center justify-content-center">
                <img src="assets/img/cyl.png" class="img-fluid animated" alt="">
            </div>
            <div class="col-md-6 p-5">
                <h2 class="fw-bold">Log In</h2>
                <form action="login_process.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-muted">It must be a combination of minimum 8 letters, numbers, and symbols.</small>
                    </div>
                    <div class="mb-3 form-check d-flex justify-content-between">
                        <div>
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                    <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Sign Up</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>
</body>

</html>