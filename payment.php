<?php
// session_start();
// require("assets/components/db_connection.php");

// // Check if user is logged in
// if (!isset($_SESSION['user_name'])) {
//     header("Location: login.php");
//     exit();
// }

// // Get data from the URL (via GET)
// if (isset($_GET['req_id']) && isset($_GET['pay_status']) && isset($_GET['cost'])) {
//     $req_id = $_GET['req_id'];          // Request ID passed from the modal
//     $pay_status = $_GET['pay_status'];  // "Paid"
//     $cost = $_GET['cost'];              // Cost passed from the modal

//     // Insert payment record into tbl_payment with req_id, cost, and pay_status
//     $sql = "INSERT INTO tbl_payment (req_id, pay_status, total) VALUES (?, ?, ?)";
//     $stmt = $mysqli->prepare($sql);
//     $stmt->bind_param("isd", $req_id, $pay_status, $cost); // "i" for integer, "s" for string, "d" for decimal
//     if ($stmt->execute()) {
//         // Redirect back to the request view page or success page after inserting payment
//         header("Location: request_view.php?payment_status=success");
//         exit();
//     } else {
//         // Error inserting payment
//         echo "Error: " . $stmt->error;
//     }
//     $stmt->close();
// } else {
//     echo "Invalid payment data.";
// }
?>

<?php
session_start();
require("assets/components/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Get data from the URL (via GET)
if (isset($_GET['req_id']) && isset($_GET['pay_status']) && isset($_GET['cost'])) {
    $req_id = $_GET['req_id'];          // Request ID passed from the modal
    $pay_status = $_GET['pay_status'];  // "Paid"
    $cost = $_GET['cost'];              // Cost passed from the modal

    // Insert payment record into tbl_payment with req_id, cost, and pay_status
    $sql = "INSERT INTO tbl_payment (req_id, pay_status, total) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("isd", $req_id, $pay_status, $cost); // "i" for integer, "s" for string, "d" for decimal
    if ($stmt->execute()) {
        // Store the req_id and payment success status in session or URL
        $_SESSION['payment_success'] = true;
        $_SESSION['req_id'] = $req_id;  // Store the request ID in session to pass to the modal
        // Redirect back to the request view page or success page after inserting payment
        header("Location: request_view.php");
        exit();
    } else {
        // Error inserting payment
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid payment data.";
}
?>