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
    <?php include 'assets/components/header_domestic.php'; ?>

    <div class="container-fluid d-flex align-items-center" style="padding-top: 150px; padding-bottom: 200px;">
        <div class="row w-100">
            <div class="col-md-12">
                <h2 class="text-center fw-bold" style="color: var(--blue)">Search your nearest Gas Outlet</h2>
                <p class="text-center" style="color: var(--dark-grey); font-weight: bold;">Select Outlet by District</p>

                <!-- Search Form -->
                <form action="request_search_2.php" method="POST">
                    <div class="row justify-content-center mb-4">
                        <!-- District Selection -->
                        <div class="col-md-4">
                            <label for="district" class="form-label" style="color: var(--dark-grey)">Select
                                District</label>
                            <select name="district" class="form-select" style="border-color: var(--pink);" required>
                                <option value="" selected disabled>Select a District</option>
                                <option value="Ampara">Ampara</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Galle">Galle</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Kegalle">Kegalle</option>
                                <option value="Kilinochchi">Kilinochchi</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Mannar">Mannar</option>
                                <option value="Matale">Matale</option>
                                <option value="Matara">Matara</option>
                                <option value="Monaragala">Monaragala</option>
                                <option value="Mullaitivu">Mullaitivu</option>
                                <option value="Nuwara Eliya">Nuwara Eliya</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Vavuniya">Vavuniya</option>
                            </select>
                        </div>

                        <!-- City Search Input -->
                        <div class="col-md-4">
                            <label for="city" class="form-label" style="color: var(--dark-grey);">Search by City</label>
                            <input type="text" name="city" class="form-control" id="city"
                                style="border-color: var(--pink);" placeholder="Enter City Name (Full or Partial)">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button id="submit" type="submit" class="btn btn-primary w-100">Find Outlets</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php 
        include 'assets/components/footer.php';
        include 'assets/components/scroll_top.php';     
    ?>

</body>

</html>