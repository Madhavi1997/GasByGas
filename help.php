<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header.php'; ?>

    <div class="container" style="padding-top: 120px">
        <h2 class="text-center fw-bold">Help & Support</h2>

        <div class="row mt-4">
            <!-- Contact Form -->
            <div class="col-md-6">
                <h4>Contact Us</h4>
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="First Name*" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Last Name*" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email*" required>
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control" placeholder="Phone Number*" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" placeholder="Your message..." rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <!-- FAQ Section -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="fw-bold">Frequently Asked Questions (FAQs)</h5>
                    <p><strong>How do I reset my password?</strong></p>
                    <p>To reset your password, go to the login page and click on "Forgot Password" and follow the instructions to reset your password via email.</p>

                    <p><strong>How can I contact customer support?</strong></p>
                    <p>You can contact customer support by filling out the contact form or by calling our support hotline at 011-23 45 678.</p>

                    <p><strong>What are the operation hours of support?</strong></p>
                    <p>Our support team is available Monday to Friday, 8:00 AM to 7:00 PM.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>