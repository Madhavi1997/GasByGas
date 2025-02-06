<?php
session_start();
require("assets/components/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Fetch request details for the logged-in user along with payment status
$sql = "SELECT r.req_id, r.outlet_id, r.cylinder_brand, r.cylinder_type, r.quantity, r.scheduled_date, r.cylinder_status, r.delivery_status, IFNULL(p.pay_status, 'Not Paid') AS pay_status
        FROM tbl_request r
        LEFT JOIN tbl_payment p ON r.req_id = p.req_id";
$stmt = $mysqli->prepare($sql);
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
    echo '<script>
            $(document).ready(function(){
                $("#cardDetailsModal").modal("show");
            });
          </script>';
    unset($_SESSION['payment_success']);
}

// Handle status update request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["req_id"]) && isset($_POST["status"])) {
    $req_id = $_POST["req_id"];
    $status = $_POST["status"];

    error_log("Updating req_id: $req_id to status: $status");

    // Corrected query: ensure correct table name and database connection
    $sql = "UPDATE tbl_request SET delivery_status = ? WHERE req_id = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $mysqli->error]);
        exit;
    }

    $stmt->bind_param("si", $status, $req_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Delivery status updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating status: " . $stmt->error]);
    }

    $stmt->close();
    exit;
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
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
                            <th>Cylinder Status</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $request_result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['req_id']; ?></td>
                                <td><?php echo $outlet_names[$row['outlet_id']] ?? 'Unknown'; ?></td>
                                <td><?= htmlspecialchars($row['cylinder_brand'] . ' - ' . $row['cylinder_type'] . ' kg'); ?></td>
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
                                    $cost = $cost_row['unit_price'] * $quantity;
                                }
                                $cost_stmt->close();
                                ?>
                                <td>Rs. <?php echo number_format($cost, 2); ?></td>
                                <td><?php echo $row['scheduled_date']; ?></td>
                                <td>
                                    <?php
                                    $status = htmlspecialchars($row['cylinder_status']);
                                    $badgeClass = match ($status) {
                                        'Not Returned' => 'badge bg-danger',
                                        'Returned' => 'badge bg-success',
                                        'New Cylinder Issued' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary'
                                    };
                                    ?>
                                    <span class="<?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                                </td>
                                <td>
                                    <?php
                                    $pay_status = htmlspecialchars($row['pay_status']);
                                    $payBadgeClass = match ($pay_status) {
                                        'Paid' => 'badge bg-success',
                                        'Not Paid' => 'badge bg-danger',
                                        'Pending' => 'badge bg-warning',
                                        default => 'badge bg-danger' // Default to Not Paid if no payment record
                                    };
                                    ?>
                                    <span class="<?php echo $payBadgeClass; ?>"><?php echo $pay_status; ?></span>
                                </td>
                                <td>
                                    <?php
                                    $delivery_status = htmlspecialchars($row['delivery_status']);
                                    $deliveryBadgeClass = match ($delivery_status) {
                                        'Dispatched' => 'badge bg-success',
                                        'Pending' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary'
                                    };
                                    ?>
                                    <span class="<?php echo $deliveryBadgeClass; ?>"><?php echo $delivery_status; ?></span>
                                </td>

                                <td class="action-btns">
                                    <?php if ($row['delivery_status'] === 'Pending') : ?>
                                        <button class="btn btn-sm btn-success dispatch-btn" data-req_id="<?php echo $row['req_id']; ?>">
                                            <i class="fas fa-truck"></i> Dispatch
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-success dispatch-btn" disabled>
                                            <i class="fas fa-truck"></i> Dispatch
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($row['delivery_status'] === 'Dispatched') : ?>
                                        <button class="btn btn-sm btn-danger cancel-dispatch-btn" data-req_id="<?php echo $row['req_id']; ?>">
                                            <i class="fas fa-times"></i> Cancel Dispatch
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-danger cancel-dispatch-btn" disabled>
                                            <i class="fas fa-times"></i> Cancel Dispatch
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

    <script>
        $(document).ready(function() {
            $(".dispatch-btn, .cancel-dispatch-btn").click(function() {
                var req_id = $(this).data("req_id");
                var status = $(this).hasClass("dispatch-btn") ? "Dispatched" : "Pending";

                console.log("Updating req_id:", req_id, "Status:", status);

                $.ajax({
                    url: window.location.href, // Ensure it points to the same file
                    type: "POST",
                    data: {
                        req_id: req_id,
                        status: status
                    },
                    dataType: "json",
                    success: function(response) {
                        alert(response.message);
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });
        });
    </script>

</body>

</html>