<?php
session_start();
require_once 'db_connect.php'; // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['req_id'])) {
    $req_id = intval($_POST['req_id']);

    // Update the request status in the database (mark as 'Reallocated')
    $update_query = "UPDATE tbl_payment SET cylinder_status = 'Reallocated' WHERE req_id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param("i", $req_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Request #$req_id has been reallocated successfully.";
    } else {
        $_SESSION['error_message'] = "Error reallocation request. Please try again.";
    }

    $stmt->close();
    $mysqli->close();

    // Redirect back to the request view page
    header("Location: outlet_request_view.php");
    exit();
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: outlet_request_view.php");
    exit();
}