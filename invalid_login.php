<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - FlexStart Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: FlexStart
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Updated: Nov 01 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <?php
        include 'assets/components/header.php';
    ?>

    <main class="main">


        <!-- Contact Section -->
        <section id="login" class="login section" style="padding-top: 170px;">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Login</h2>
                <p>Login</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <!-- Animation -->
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                        <img src="assets/img/cyl_2.jpg" class="img-fluid animated" alt="">
                    </div>


                    <div class="col-lg-6">
                        <form action="login_2.php" method="post" class="login-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="login-title">
                                <h2 style="color: var(--pink)">
                                    <b>Authorized Access Only! </b><span></span>
                                </h2>
                                <p style="color: var(--dark-blue)">Access denied. Please log in and try again</p>
                            </div>
                            <div class="row gy-4">

                                <div class="col-md-12">
                                    <input type="email" id="user_name" name="user_name" class="form-control"
                                        placeholder="Email" required>
                                </div>

                                <div class="col-12">
                                    <input type="password" id="access_code" class="form-control" name="access_code"
                                        placeholder="Password" required>
                                </div>

                                <div class="col-6 text-center">
                                    <button id="sumbit" type="submit">Login</button>
                                    <button id="reset" type="reset" style="margin-left: 10px;">Cancel</button>
                                </div>
                                <div>
                                    <p style="color: var(--dark-grey);">Don't have an account? <a href="register_1.php"
                                            style="color: var(--pink);"><b>
                                                Register</b></a>
                                    </p>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <?php
            include 'assets/components/footer.php';
            include 'assets/components/scroll_up.php';
        ?>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>