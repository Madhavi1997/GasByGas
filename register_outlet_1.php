<?php
//Connect the database.
require("assets/components/db_connection.php");
?>

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
                <h2 class="fw-bold">Sign Up - Outlet</h2>
                <form action="register_outlet_2.php" method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <!-- <label class="form-label">First Name</label> -->
                            <input type="text" name="outlet_name" class="form-control" placeholder="Outlet Name"
                                required>
                        </div>
                        <div class="col">
                            <!-- <label class="form-label">Last Name</label> -->
                            <input type="text" name="outlet_reg" class="form-control"
                                placeholder="Outlet  Registration No." required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="col">
                            <input type="text" name="contact" class="form-control" placeholder="Contact No" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="add_1" class="form-control" placeholder="Address" required>
                    </div>
                    <div class="row mb-3">

                        <div class="col-md-6">
                            <select id="district" class="form-select">
                                <option selected>Select District</option>
                                <option>Ampra</option>
                                <option>Anuradhapura</option>
                                <option>Badulla</option>
                                <option>Batticaloa</option>
                                <option>Colombo</option>
                                <option>Galle</option>
                                <option>Gampaha</option>
                                <option>hambantota</option>
                                <option>Jaffna</option>
                                <option>kaluthara</option>
                                <option>Kandy</option>
                                <option>Kegalle</option>
                                <option>Kilinochchi</option>
                                <option>Kurunegala</option>
                                <option>Mannar</option>
                                <option>Matale</option>
                                <option>Matara</option>
                                <option>Monaragala</option>
                                <option>Mullativu</option>
                                <option>Nuwara Eliya</option>
                                <option>Polonnaruwa</option>
                                <option>Puttalam</option>
                                <option>Rathnapura</option>
                                <option>Trincomalee</option>
                                <option>vavuniya</option>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <input type="text" name="city" class="form-control" placeholder="City" required>
                        </div>

                    </div>
                    <div class="mb-3 position-relative">
                        <!-- <label class="form-label">Password</label> -->
                        <input type="password" name="access_code" class="form-control" placeholder="Password"
                            id="password" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <!-- <label class="form-label">Retype Password</label> -->
                        <input type="password" name="confirm_password" class="form-control"
                            placeholder="Confirm Password" id="confirm_password" required>
                    </div>

                    <div id="passwordMatchMessage"></div>

                    <!-- Match Passwords -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var passwordField = document.getElementById("password");
                            var confirmPasswordField = document.getElementById(
                                "confirm_password"); // Fix the case here
                            var messageElement = document.getElementById(
                                "passwordMatchMessage"); // Add an element to display the message

                            function checkPasswords() {
                                var password = passwordField.value;
                                var confirm_password = confirmPasswordField.value;

                                if (password === confirm_password) {
                                    // Passwords match
                                    messageElement.innerHTML = "Passwords match";
                                    messageElement.style.color =
                                        "green"; // Optional: Change the text color for a visual cue
                                } else {
                                    // Passwords do not match
                                    messageElement.innerHTML = "Passwords do not match";
                                    messageElement.style.color =
                                        "red"; // Optional: Change the text color for a visual cue
                                }
                            }

                            // Add event listeners to both password and confirmPassword fields
                            passwordField.addEventListener("input", checkPasswords);
                            confirmPasswordField.addEventListener("input", checkPasswords);
                        });
                    </script>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">I agree to all Terms, Privacy, and Fees.</label>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary w-100">Sign Up</button> -->
                    <button id="sumbit" type="submit">Register</button>
                    <button id="reset" type="reset" style="margin-left: 10px;">Clear</button>

                    <p class="mt-3 text-center">Already have an account? <a href="login_1.php">Log in</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>
</body>

</html>