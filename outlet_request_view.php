<?php
session_start();
require("assets/components/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Fetch outlet ID from session
$user_name = $_SESSION['user_name']; // Email stored as user_name
$sql = "SELECT outlet_id FROM tbl_outlet WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cust_id = $row['outlet_id']; // Correct variable usage
$stmt->close();

// Fetch request details for the logged-in outlet
$sql = "SELECT req_id, cust_id, cylinder_brand, cylinder_type, quantity, scheduled_date, cylinder_status, delivery_status 
        FROM tbl_request WHERE outlet_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $cust_id); // Fixed incorrect variable
$stmt->execute();
$request_result = $stmt->get_result();
$stmt->close();

// Fetch outlet names
$cust_names = [];
$cust_query = "SELECT cust_id, f_name, l_name FROM tbl_dom_cust";
$cust_result = $mysqli->query($cust_query);
while ($row = $cust_result->fetch_assoc()) {
    $cust_names[$row['cust_id']] = $row['f_name'] . ' ' . $row['l_name'];
}

// Fetch payment statuses
$payment_statuses = [];
$payment_query = "SELECT req_id, pay_status FROM tbl_payment";
$payment_result = $mysqli->query($payment_query);
while ($row = $payment_result->fetch_assoc()) {
    $payment_statuses[$row['req_id']] = $row['pay_status'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outlet Gas Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'assets/components/header_outlet.php'; ?>

    <div class="container-fluid d-flex align-items-center" style="padding-top: 150px; padding-bottom: 200px;">
        <div class="row w-100">
            <div class="col-md-12">
                <h2 class="text-center fw-bold" style="color: var(--blue)">Gas Requests</h2>
                <p class="text-center" style="color: var(--dark-grey); font-weight: bold;">View Gas Request History</p>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Token No.</th>
                            <th>Name</th>
                            <th>Gas</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Scheduled Date</th>
                            <th>Delivery Status</th>
                            <th>Cylinder Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $request_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['req_id']; ?></td>
                            <td><?php echo $cust_names[$row['cust_id']] ?? 'Unknown'; ?></td>
                            <!-- Fixed incorrect variable -->
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
                                    $badgeClass = ($status === 'Not Returned') ? 'badge bg-danger' : 
                                                 (($status === 'Returned') ? 'badge bg-success' : 
                                                 (($status === 'New Cylinder Issued') ? 'badge bg-warning text-dark' : 'badge bg-secondary'));
                                ?>
                                <span class="<?php echo $badgeClass; ?>"> <?php echo $status; ?> </span>
                            </td>
                            <td>
                                <?php 
                                $pay_status = $payment_statuses[$row['req_id']] ?? 'Not Paid';
                                $badgeClass = ($pay_status === 'Paid') ? 'badge bg-warning text-dark' : 'badge bg-danger';
                                ?>
                                <span class="<?php echo $badgeClass; ?>"> <?php echo $pay_status; ?> </span>
                            </td>
                            <td>
                                <?php if ($pay_status !== 'Paid') : ?>
                                <button class="btn btn-sm btn-primary edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editGasRequestModal" data-req_id="<?php echo $row['req_id']; ?>"
                                    data-cylinder_brand="<?php echo $row['cylinder_brand']; ?>"
                                    data-name="<?php echo $cust_names[$row['cust_id']] ?? 'Unknown'; ?>"
                                    data-cylinder_type="<?php echo $row['cylinder_type']; ?>"
                                    data-quantity="<?php echo $row['quantity']; ?>"
                                    data-cylinder_status="<?php echo $row['cylinder_status']; ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <!-- Delete Button (Triggers Modal) -->
                                <button class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-req_id="<?php echo $row['req_id']; ?>">
                                    Reallocate
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editGasRequestModal" tabindex="-1" aria-labelledby="editGasRequestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGasRequestModalLabel">Edit Gas Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGasRequestForm">
                        <input type="hidden" id="req_id" name="req_id">

                        <!-- User Name -->
                        <div class="mb-3">
                            <label for="f_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="f_name" name="f_name" readonly>
                        </div>

                        <!-- Cylinder Brand -->
                        <div class="mb-3">
                            <label for="cylinder_brand" class="form-label">Cylinder Brand</label>
                            <input type="text" class="form-control" id="cylinder_brand" name="cylinder_brand" readonly>
                        </div>

                        <!-- Cylinder Type -->
                        <div class="mb-3">
                            <label for="cylinder_type" class="form-label">Cylinder Type</label>
                            <input type="text" class="form-control" id="cylinder_type" name="cylinder_type" readonly>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity Returned</label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>

                        <!-- Cylinder Status (Dropdown) -->
                        <div class="mb-3">
                            <label for="cylinder_status" class="form-label">Cylinder Status</label>
                            <select class="form-select" id="cylinder_status" name="cylinder_status">
                                <option value="out_of_stock">Returned</option>
                                <option value="delivered">New Cylinder Issued</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>

                    <!-- Alert message container -->
                    <div id="updateMessage" class="mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            // Get data from button's attributes
            var req_id = this.getAttribute('data-req_id');
            var f_name = this.getAttribute('data-name'); // Ensure this attribute exists in your button
            var cylinder_brand = this.getAttribute('data-cylinder_brand');
            var cylinder_type = this.getAttribute('data-cylinder_type');
            var quantity = this.getAttribute('data-quantity');
            var cylinder_status = this.getAttribute('data-cylinder_status');

            // Populate the modal form fields
            document.getElementById('req_id').value = req_id;
            document.getElementById('f_name').value = f_name;
            document.getElementById('cylinder_brand').value = cylinder_brand;
            document.getElementById('cylinder_type').value = cylinder_type;
            document.getElementById('quantity').value = quantity;

            // Ensure dropdown selection works correctly
            let statusDropdown = document.getElementById('cylinder_status');
            if (statusDropdown) {
                for (let i = 0; i < statusDropdown.options.length; i++) {
                    if (statusDropdown.options[i].value === cylinder_status) {
                        statusDropdown.selectedIndex = i;
                        break;
                    }
                }
            }
        });
    });
    </script>


    <!-- Reallocate Confirmation Modal -->
    <div class="modal fade" id="reallocateModal" tabindex="-1" aria-labelledby="reallocateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reallocateModalLabel">Confirm Reallocation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reallocate this gas request?</p>
                </div>
                <div class="modal-footer">
                    <form id="reallocateForm" method="post" action="reallocate.php">
                        <input type="hidden" id="reallocate_req_id" name="req_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Handle Reallocate Button Click
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            var req_id = this.getAttribute('data-req_id');
            document.getElementById('reallocate_req_id').value = req_id;
        });
    });
    </script>

</body>

</html>