<?php
session_start();
require("assets/components/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Fetch customer ID from session
$user_name = $_SESSION['user_name']; // Email stored as user_name
$sql = "SELECT cust_id FROM tbl_dom_cust WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cust_id = $row['cust_id'];
$stmt->close();

// Fetch request details for the logged-in user
$sql = "SELECT req_id, outlet_id, cylinder_brand, cylinder_type, quantity, scheduled_date, cylinder_status 
        FROM tbl_request WHERE cust_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $cust_id);
$stmt->execute();
$request_result = $stmt->get_result();
$stmt->close();

// Fetch outlet names
$outlet_names = [];
$outlet_query = "SELECT outlet_id, outlet_name FROM tbl_outlet";
$outlet_result = $mysqli->query($outlet_query);
while ($row = $outlet_result->fetch_assoc()) {
    $outlet_names[$row['outlet_id']] = $row['outlet_name'];
}

// Check if payment was successful
if (isset($_SESSION['payment_success']) && $_SESSION['payment_success'] === true) {
    // Show the modal for card details
    echo '<script>
            $(document).ready(function(){
                $("#cardDetailsModal").modal("show");
            });
          </script>';

    // Unset session to prevent the modal from opening on every page load
    unset($_SESSION['payment_success']);
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
    <!-- Corrected Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- Header -->
    <?php include 'assets/components/header_domestic.php'; ?>

    <div class="container-fluid d-flex align-items-center" style="padding-top: 150px; padding-bottom: 200px;">
        <div class="row w-100">
            <div class="col-md-12">
                <h2 class="text-center fw-bold" style="color: var(--blue)">Gas Requests</h2>
                <p class="text-center" style="color: var(--dark-grey); font-weight: bold;">View Gas Request History</p>

                <table class="table table-hover" style="margin-left: 15px; margin-right: 15px;">
                    <thead>
                        <tr>
                            <th>Token No.</th>
                            <th>Outlet Name</th>
                            <th>Gas</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Scheduled Date</th>
                            <th>Delivery Status</th>
                            <th>Cylinder Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $request_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['req_id']; ?></td>
                            <td><?php echo $outlet_names[$row['outlet_id']] ?? 'Unknown'; ?></td>
                            <td><?= htmlspecialchars($row['cylinder_brand'] . ' - ' . $row['cylinder_type'] . ' kg'); ?>
                            </td>
                            <td><?php echo $row['quantity']; ?></td>

                            <?php 
                        $cylinder_brand = $row['cylinder_brand'];
                        $cylinder_type = $row['cylinder_type'];
                        $quantity = $row['quantity'];
                
                        // Fetch unit price
                        $cost_query = "SELECT unit_price FROM tbl_product WHERE LOWER(cylinder_brand) = LOWER(?) AND LOWER(cylinder_type) = LOWER(?)";
                        $cost_stmt = $mysqli->prepare($cost_query);
                        $cost_stmt->bind_param("ss", $cylinder_brand, $cylinder_type);
                        $cost_stmt->execute();
                        $cost_result = $cost_stmt->get_result();

                        $cost = 0;
                        if ($cost_result->num_rows > 0) {
                            $cost_row = $cost_result->fetch_assoc();
                            $cost = $cost_row['unit_price'] * $quantity; // Multiply by quantity
                        }
                        $cost_stmt->close();
                    ?>
                            <td>Rs. <?php echo number_format($cost, 2); ?></td>
                            <td><?php echo $row['scheduled_date']; ?></td>
                            <td>
                                <?php 
                                    $delivery_status = htmlspecialchars($row['delivery_status']); 
                                    $badgeClass = ($delivery_status === 'Pending') ? 'badge bg-secondary' : 
                                        (($delivery_status === 'Re-Scheduled') ? 'badge bg-info' : 
                                        (($delivery_status === 'Dispatched') ? 'badge bg-warning' : 
                                        (($delivery_status === 'Delivered') ? 'badge bg-success' : 'badge bg-secondary')));
                                ?>
                                <span class="<?php echo $badgeClass; ?>"> <?php echo $delivery_status; ?> </span>
                            </td>
                            <td>
                                <?php 
                                    $status = htmlspecialchars($row['cylinder_status']); 
                                    $badgeClass = '';

                                    if ($status === 'Not Returned') {
                                        $badgeClass = 'badge bg-danger'; // Red
                                    } elseif ($status === 'Returned') {
                                        $badgeClass = 'badge bg-success'; // Green
                                    } elseif ($status === 'New Cylinder Issued') {
                                        $badgeClass = 'badge bg-warning text-dark'; // Yellow
                                    } else {
                                        $badgeClass = 'badge bg-secondary'; // Default Gray
                                    }
                                ?>
                                <span class="<?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                            </td>
                            <td>
                                <span class="badge bg-danger">Not Paid</span>
                            </td>

                            <td class="action-btns">
                                <?php 
                                    $cylinder_status = htmlspecialchars($row['cylinder_status']); 
                                    if ($cylinder_status === "Not Returned") { 
                                ?>
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-primary edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editGasRequestModal" data-req_id="<?php echo $row['req_id']; ?>"
                                    data-cylinder_brand="<?php echo $row['cylinder_brand']; ?>"
                                    data-cylinder_type="<?php echo $row['cylinder_type']; ?>"
                                    data-quantity="<?php echo $row['quantity']; ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <!-- Delete Button (Triggers Modal) -->
                                <button class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-req_id="<?php echo $row['req_id']; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>


                                <?php } ?>

                                <!-- Pay Button -->
                                <button class="btn btn-sm btn-success pay-btn" data-bs-toggle="modal"
                                    data-bs-target="#receiptModal" data-req_id="<?php echo $row['req_id']; ?>"
                                    data-cylinder_brand="<?php echo $row['cylinder_brand']; ?>"
                                    data-cylinder_type="<?php echo $row['cylinder_type']; ?>"
                                    data-quantity="<?php echo $row['quantity']; ?>"
                                    data-cost="<?php echo number_format($cost, 2); ?>">
                                    <!-- Cost calculated in the table -->
                                    <i class="fas fa-wallet"></i>
                                </button>

                            </td>

                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Gas Request Modal -->
    <div class="modal fade" id="editGasRequestModal" tabindex="-1" aria-labelledby="editGasRequestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGasRequestModalLabel">Edit Gas Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="request_edit.php" method="POST">
                    <div class="modal-body">
                        <!-- Hidden Request ID -->
                        <input type="hidden" name="req_id" id="edit-req_id">

                        <!-- Cylinder Brand -->
                        <div class="mb-3">
                            <label class="form-label">Cylinder Brand</label>
                            <select name="cylinder_brand" id="edit-cylinder_brand" class="form-select" required>
                                <?php
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
                            <input type="radio" name="cylinder_type" value="2" id="edit-cylinder_2"> 2.5kg
                            <input type="radio" name="cylinder_type" value="5" id="edit-cylinder_5"> 5kg
                            <input type="radio" name="cylinder_type" value="12" id="edit-cylinder_12"> 12kg
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="edit-quantity" class="form-label">Enter Quantity</label>
                            <input type="number" name="quantity" id="edit-quantity" class="form-control" min="1" max="3"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll(".edit-btn");

        editButtons.forEach(button => {
            button.addEventListener("click", function() {
                const reqId = this.getAttribute("data-req_id");
                const cylinderBrand = this.getAttribute("data-cylinder_brand");
                const cylinderType = this.getAttribute("data-cylinder_type");
                const quantity = this.getAttribute("data-quantity");

                // Set values in the modal
                document.getElementById("edit-req_id").value = reqId;
                document.getElementById("edit-cylinder_brand").value = cylinderBrand;
                document.getElementById("edit-quantity").value = quantity;

                // Select the correct radio button for cylinder type
                document.getElementById("edit-cylinder_2").checked = (cylinderType == "2");
                document.getElementById("edit-cylinder_5").checked = (cylinderType == "5");
                document.getElementById("edit-cylinder_12").checked = (cylinderType == "12");
            });
        });
    });
    </script>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: var(--dark-grey)">
                    Are you sure you want to delete this request? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="request_delete.php">
                        <input type="hidden" name="req_id" id="deleteReqId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                const reqId = this.getAttribute("data-req_id");
                document.getElementById("deleteReqId").value = reqId;
            });
        });
    });
    </script>


    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Payment Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: var(--dark-grey)">
                    <p><strong>Cylinder Brand:</strong> <span id="modal-cylinder-brand"></span></p>
                    <p><strong>Cylinder Type:</strong> <span id="modal-cylinder-type"></span>kg</p>
                    <p><strong>Quantity:</strong> <span id="modal-quantity"></span></p>
                    <p><strong>Total Cost:</strong> Rs. <span id="modal-cost"></span></p>
                </div>
                <div class="modal-footer">
                    <!-- Pay Now Button -->
                    <a href="#" id="pay-now-link" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Proceed
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // // Event listener for "Pay" button click
    // document.querySelectorAll('.pay-btn').forEach(button => {
    //     button.addEventListener('click', function() {
    //         // Get data from the pay button
    //         const cylinderType = this.getAttribute('data-cylinder_type');
    //         const cylinderBrand = this.getAttribute('data-cylinder_brand');
    //         const quantity = this.getAttribute('data-quantity');
    //         const cost = this.getAttribute('data-cost');
    //         const reqId = this.getAttribute('data-req_id');

    //         // Populate modal with the fetched data
    //         document.getElementById('modal-cylinder-type').textContent = cylinderType;
    //         document.getElementById('modal-cylinder-brand').textContent = cylinderBrand;
    //         document.getElementById('modal-quantity').textContent = quantity;
    //         document.getElementById('modal-cost').textContent = cost;

    //         // Set up the Pay Now link with the corresponding request ID
    //         const payLink = document.getElementById('pay-now-link');
    //         payLink.href = `pay_request.php?req_id=${reqId}`; // Redirect to the payment page
    //     });
    // });
    </script>

    <!-- Pay button Script -->
    <script>
    // Event listener for "Pay" button click
    document.querySelectorAll('.pay-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Get data from the pay button
            const cylinderType = this.getAttribute('data-cylinder_type');
            const cylinderBrand = this.getAttribute('data-cylinder_brand');
            const quantity = this.getAttribute('data-quantity');
            const cost = this.getAttribute('data-cost'); // This is the cost displayed in the modal
            const reqId = this.getAttribute('data-req_id');

            // Populate modal with the fetched data
            document.getElementById('modal-cylinder-type').textContent = cylinderType;
            document.getElementById('modal-cylinder-brand').textContent = cylinderBrand;
            document.getElementById('modal-quantity').textContent = quantity;
            document.getElementById('modal-cost').textContent = cost;

            // Set up the Pay Now link with the corresponding request ID and cost
            const payLink = document.getElementById('pay-now-link');
            payLink.setAttribute('href', `payment.php?req_id=${reqId}&pay_status=Paid&cost=${cost}`);
        });
    });
    </script>


    <!-- Card Details Modal -->
    <div class="modal fade" id="cardDetailsModal" tabindex="-1" aria-labelledby="cardDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cardDetailsModalLabel">Enter Card Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="process_payment.php" method="POST">
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date (MM/YY)</label>
                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" required>
                        </div>
                        <div class="mb-3">
                            <label for="cardholder_name" class="form-label">Cardholder Name</label>
                            <input type="text" class="form-control" id="cardholder_name" name="cardholder_name"
                                required>
                        </div>
                        <input type="hidden" name="req_id" value="<?php echo $_SESSION['req_id']; ?>">
                        <a href="request_view.php" id="pay-now-link" class="btn btn-primary">
                            <i class="fas fa-credit-card"></i> Pay Now
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




</body>

</html>