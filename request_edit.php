<?php
session_start();
require("assets/components/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $req_id = $_POST['req_id'];
    $cylinder_brand = $_POST['cylinder_brand'];
    $cylinder_type = $_POST['cylinder_type'];
    $quantity = (int) $_POST['quantity']; // Ensure it's an integer

    // Update the request in the database
    $sql = "UPDATE tbl_request SET cylinder_brand = ?, cylinder_type = ?, quantity = ? WHERE req_id = ?";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt === false) {
        die('MySQL prepare error: ' . $mysqli->error);
    }
    
    $stmt->bind_param('ssii', $cylinder_brand, $cylinder_type, $quantity, $req_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Request updated successfully!'); window.location.href = 'request_view.php';</script>";
    } else {
        echo "<script>alert('Error updating request.'); window.history.back();</script>";
    }

    $stmt->close();
}

$mysqli->close();
?>