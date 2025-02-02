<?php
// Include database connection
require("assets/components/db_connection.php");

// Get user inputs from the form
$district = isset($_POST['district']) ? trim($_POST['district']) : "";
$city = isset($_POST['city']) ? trim($_POST['city']) : "";

// Build the SQL query securely using prepared statements
$sql = "SELECT outlet_name, contact, add_1, city, district, request_status FROM tbl_outlet WHERE district = ?";
$params = [$district];

if (!empty($city)) {
    $sql .= " AND city LIKE ?";
    $params[] = "%$city%";
}

// Prepare and execute the query
$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $mysqli->error);
}
$stmt->bind_param(str_repeat("s", count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('MySQL query error: ' . $mysqli->error);
}

?>

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
                <h2 class="text-center fw-bold" style="color: var(--blue); padding-top:50px;">Search Results</h2>
                <p class="text-center" style="color: var(--dark-grey); font-weight: bold;">Filtered Gas Outlets</p>

                <!-- Display the results as cards -->
                <div class="row" style="padding-left: 100px; padding-right: 100px;">
                    <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card p-3">
                            <h5 class="fw-bold"><?= htmlspecialchars($row['outlet_name']); ?></h5>
                            <p>Contact No: <?= htmlspecialchars($row['contact']); ?></p>
                            <p>Location:
                                <?= htmlspecialchars($row['add_1'] . ', ' . $row['city'] . ', ' . $row['district']); ?>
                            </p>

                            <?php
                // Check request status and apply colors accordingly
                $status = $row['request_status'];
                if ($status == "Enable") {
                    $statusClass = "text-success";
                    $dotClass = "text-success";
                } else {
                    $statusClass = "text-danger";
                    $dotClass = "text-danger";
                }
                ?>
                            <p>Status: <span class="dot <?= $dotClass; ?>">&#9679;</span> <span
                                    class="<?= $statusClass; ?>"><?= $status; ?></span></p>

                            <!-- Button with different modals depending on request_status -->
                            <?php if ($status == "Enable"): ?>
                            <button class="btn btn-primary request-gas-btn" data-bs-toggle="modal"
                                data-bs-target="#requestGasModal"
                                data-outlet="<?= htmlspecialchars($row['outlet_name']); ?>">
                                Request Gas
                            </button>
                            <?php else: ?>
                            <button class="btn btn-danger request-gas-btn" data-bs-toggle="modal"
                                data-bs-target="#unavailableModal"
                                data-outlet="<?= htmlspecialchars($row['outlet_name']); ?>">
                                Request Gas
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <div class="col-md-12">
                        <h3 class="display-6 text-danger text-center">No Matching Records Found!</h3>
                    </div>
                    <?php endif; ?>

                    <!-- Request Gas Modal -->
                    <div class="modal fade" id="requestGasModal" tabindex="-1" aria-labelledby="requestGasModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="requestGasModalLabel">Request Gas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="request_process.php" method="POST">
                                    <div class="modal-body">
                                        <p id="selected-outlet" class="fw-bold mb-3"></p>

                                        <!-- Hidden input for outlet name -->
                                        <input type="hidden" name="outlet_name" id="outlet_name">

                                        <!-- Cylinder Brand (Combo Box) -->
                                        <div class="mb-3">
                                            <label class="form-label">Cylinder Brand</label><br>
                                            <select name="cylinder_brand" class="form-select" required>
                                                <?php
                            // Fetch distinct cylinder brands from tbl_product
                            require("assets/components/db_connection.php");
                            $sql = "SELECT DISTINCT cylinder_brand FROM tbl_product";
                            $result = $mysqli->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['cylinder_brand']) . '">' . htmlspecialchars($row['cylinder_brand']) . '</option>';
                                }
                            } else {
                                echo '<option value="">No Brands Available</option>';
                            }
                            ?>
                                            </select>
                                        </div>
                                        <!-- Cylinder Type -->
                                        <div class="mb-3">
                                            <label class="form-label">Cylinder Type</label><br>
                                            <input type="radio" name="cylinder_type" value="2" checked> 2.5kg
                                            <input type="radio" name="cylinder_type" value="5"> 5kg
                                            <input type="radio" name="cylinder_type" value="12"> 12kg
                                        </div>

                                        <!-- Quantity -->
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Enter Quantity (Max: 3)</label>
                                            <input type="number" name="quantity" id="quantity" class="form-control"
                                                min="1" max="3" value="1" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Unavailable Request Modal -->
                    <div class="modal fade" id="unavailableModal" tabindex="-1" aria-labelledby="unavailableModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="unavailableModalLabel">Request Unavailable
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center" style="color: var(--dark-grey)">
                                    <p>Gas requests are currently unavailable for <strong
                                            id="unavailable-outlet"></strong>.</p>
                                    <p>Please check again later or try a different outlet.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const requestButtons = document.querySelectorAll(".request-gas-btn");

                        requestButtons.forEach(button => {
                            button.addEventListener("click", function() {
                                const outletName = this.getAttribute("data-outlet");
                                document.getElementById("selected-outlet").innerHTML =
                                    `Outlet: <strong>${outletName}</strong>`;
                                document.getElementById("outlet_name").value =
                                    outletName; // Pass outlet name in the form
                            });
                        });
                    });
                    </script>

                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>
    <?php include 'assets/components/scroll_top.php'; ?>

</body>

</html>

<?php
// Close the prepared statement
$stmt->close();
?>