<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domestic Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container" style="padding-top: 120px;">
        <h2 class="text-center fw-bold mb-4">Profile Info</h2>

        <!-- Profile Update Form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4 shadow-lg">
                    <form action="update-profile.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fist Name</label>
                                <input type="text" class="form-control" name="first_name" value="Amal" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="Dissanayake" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="abc@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIC</label>
                            <input type="text" class="form-control" name="nic" value="xxxxxxxxx" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="tel" class="form-control" name="mobile" value="070-3364785" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Home Address</label>
                            <input type="text" class="form-control mb-2" name="address_line1" placeholder="Address Line 1" required>
                            <input type="text" class="form-control mb-2" name="address_line2" placeholder="Address Line 2">
                            <input type="text" class="form-control mb-2" name="address_line3" placeholder="Address Line 3">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">SAVE CHANGES</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card p-4 shadow-lg">
                    <h4 class="text-center fw-bold mb-4">Change Password</h4>
                    <form action="change-password.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">CURRENT PASSWORD</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NEW PASSWORD</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CONFIRM PASSWORD</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">SAVE CHANGES</button>
                    </form>
                    <p class="text-muted mt-3">YOU WILL BE ASKED TO LOG IN AGAIN WITH YOUR NEW PASSWORD AFTER YOU SAVE YOUR CHANGES.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>