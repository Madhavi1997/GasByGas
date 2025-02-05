<?php
// session_start();
// require("assets/components/db_connection.php");

// // Check if user is logged in
// if (!isset($_SESSION['user_name'])) {
//     header("Location: login.php");
//     exit();
// }

// $user_name = $_SESSION['user_name']; // Email stored as user_name

// // 1. Fetch cust_id from tbl_dom_cust using user_name (email)
// $sql = "SELECT cust_id FROM tbl_dom_cust WHERE email = ?";
// $stmt = $mysqli->prepare($sql);
// if ($stmt === false) {
//     die('MySQL prepare error: ' . $mysqli->error);
// }

// $stmt->bind_param("s", $user_name);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows === 0) {
//     die("Unauthorized access: Customer ID not found.");
// }

// $row = $result->fetch_assoc();
// $cust_id = $row['cust_id'];
// $stmt->close(); // Close statement

// // 2. Get form inputs
// $outlet_name = isset($_POST['outlet_name']) ? trim($_POST['outlet_name']) : "";
// $cylinder_brand = isset($_POST['cylinder_brand']) ? trim($_POST['cylinder_brand']) : "";
// $cylinder_type = isset($_POST['cylinder_type']) ? trim($_POST['cylinder_type']) : "";
// $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

// // Validate input
// if (empty($outlet_name) || empty($cylinder_brand) || empty($cylinder_type) || $quantity < 1 || $quantity > 3) {
//     die("Invalid request data.");
// }

// // 3. Fetch outlet_id from tbl_outlet using outlet_name
// $sql = "SELECT outlet_id FROM tbl_outlet WHERE outlet_name = ?";
// $stmt = $mysqli->prepare($sql);
// if ($stmt === false) {
//     die('MySQL prepare error: ' . $mysqli->error);
// }

// $stmt->bind_param("s", $outlet_name);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows === 0) {
//     die("Invalid outlet selected.");
// }

// $row = $result->fetch_assoc();
// $outlet_id = $row['outlet_id'];
// $stmt->close(); // Close statement

// // 4. Insert request into tbl_request
// $sql = "INSERT INTO tbl_request (cust_id, outlet_id, cylinder_brand, cylinder_type, quantity, req_date, scheduled_date, cylinder_status)
//         VALUES (?, ?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), 'Not Returned')";

// $stmt = $mysqli->prepare($sql);
// if ($stmt === false) {
//     die('MySQL prepare error: ' . $mysqli->error);
// }

// $stmt->bind_param("iissi", $cust_id, $outlet_id, $cylinder_brand, $cylinder_type, $quantity);
// $success = $stmt->execute();

// if ($success) {
//     echo "<script>alert('Gas request submitted successfully!'); window.location.href='request_search_2.php';</script>";
// } else {
//     echo "<script>alert('Error submitting request.'); window.history.back();</script>";
// }

// // Close connections
// $stmt->close();
// $mysqli->close();
?>

<?php
session_start();

require("assets/components/db_connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'assets/PHPMailer/src/Exception.php';
require 'assets/PHPMailer/src/PHPMailer.php';
require 'assets/PHPMailer/src/SMTP.php';

require("assets/components/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name']; // Email stored as user_name

// 1. Fetch cust_id from tbl_dom_cust using user_name (email)
$sql = "SELECT cust_id, f_name, l_name FROM tbl_dom_cust WHERE email = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $mysqli->error);
}

$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Unauthorized access: Customer ID not found.");
}

$row = $result->fetch_assoc();
$cust_id = $row['cust_id'];
$f_name = $row['f_name'];
$l_name = $row['l_name'];
$stmt->close(); // Close statement

// 2. Get form inputs
$outlet_name = isset($_POST['outlet_name']) ? trim($_POST['outlet_name']) : "";
$cylinder_brand = isset($_POST['cylinder_brand']) ? trim($_POST['cylinder_brand']) : "";
$cylinder_type = isset($_POST['cylinder_type']) ? trim($_POST['cylinder_type']) : "";
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

// Validate input
if (empty($outlet_name) || empty($cylinder_brand) || empty($cylinder_type) || $quantity < 1 || $quantity > 3) {
    die("Invalid request data.");
}

// 3. Fetch outlet_id from tbl_outlet using outlet_name
$sql = "SELECT outlet_id FROM tbl_outlet WHERE outlet_name = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $mysqli->error);
}

$stmt->bind_param("s", $outlet_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid outlet selected.");
}

$row = $result->fetch_assoc();
$outlet_id = $row['outlet_id'];
$stmt->close(); // Close statement

// 4. Insert request into tbl_request
$sql = "INSERT INTO tbl_request (cust_id, outlet_id, cylinder_brand, cylinder_type, quantity, req_date, scheduled_date, cylinder_status)
        VALUES (?, ?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), 'Not Returned')";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $mysqli->error);
}

$stmt->bind_param("iissi", $cust_id, $outlet_id, $cylinder_brand, $cylinder_type, $quantity);
$success = $stmt->execute();

if ($success) {
    // 5. Send confirmation email
    $mail = new PHPMailer(true);
    try {
        // Enable SMTP Debugging for better error tracking
        $mail->SMTPDebug = 2;  // 0 = off, 1 = client messages, 2 = client and server messages
        $mail->Debugoutput = 'html'; // Output will be in HTML format

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'citytaxipvt@gmail.com';
        $mail->Password = 'gdhixrjekgybhbhq';  // Use an App Password if 2FA is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS encryption
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('citytaxipvt@gmail.com', 'Gas Delivery Service');
        $mail->addAddress($user_name);  // Send email to logged-in user

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Gas Request Confirmation';
        $mail->Body = "<p>Dear $f_name $l_name,</p>
                      <p>Your gas request has been successfully submitted.</p>
                      <p><strong>Outlet:</strong> $outlet_name</p>
                      <p><strong>Scheduled Delivery Date:</strong> " . date('Y-m-d', strtotime('+14 days')) . "</p>
                      <p><strong>Quantity:</strong> $quantity cylinder(s)</p>
                      <p>Thank you for using our service.</p>
                      <p>Best regards,<br>Gas Delivery Service</p>";

        $mail->send();
    } catch (Exception $e) {
        // Log the error to a file and display a user-friendly message
        error_log("Email sending failed: " . $mail->ErrorInfo, 3, 'error_log.txt'); // Log error to a file
        echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "'); window.history.back();</script>";
        exit();
    }

    // Show success message and redirect
    echo "<script>alert('Gas request submitted successfully! A confirmation email has been sent.'); window.location.href='request_view.php';</script>";
} else {
    echo "<script>alert('Error submitting request.'); window.history.back();</script>";
}

// Close database connection
$mysqli->close();
?>