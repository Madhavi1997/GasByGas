<?php
session_start();
require("assets/components/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $product_id = $_POST['product_id'];
    $cylinder_brand = $_POST['cylinder_brand'];
    $cylinder_type = $_POST['cylinder_type'];
    $unit_price = $_POST['unit_price'];
    $created_at = date('Y-m-d H:i:s'); // Get current timestamp for updated time

    // Update the product in the database
    $sql = "UPDATE tbl_product SET cylinder_brand = ?, cylinder_type = ?, unit_price = ?, created_at = ? WHERE product_id = ?";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt === false) {
        die('MySQL prepare error: ' . $mysqli->error);
    }
    
    $stmt->bind_param('ssssi', $cylinder_brand, $cylinder_type, $unit_price, $created_at, $product_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href = 'product.php';</script>";
    } else {
        echo "<script>alert('Error updating product.'); window.history.back();</script>";
    }

    $stmt->close();
}

$mysqli->close();
?>