<?php
// Database connection (make sure this is included)
require("assets/components/db_connection.php");

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the POST request
    $cylinder_brand = $_POST['cylinder_brand'];
    $cylinder_type = $_POST['cylinder_type'];
    $unit_price = $_POST['unit_price'];

    // Validate data (optional but recommended)
    if (empty($cylinder_brand) || empty($cylinder_type) || empty($unit_price)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    // Prepare the SQL query to insert data into tbl_product
    $sql = "INSERT INTO tbl_product (cylinder_brand, cylinder_type, unit_price) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $mysqli->error);
    }

    // Bind the parameters (ssds means two strings and one decimal)
    $stmt->bind_param("ssd", $cylinder_type, $unit_price);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href='product.php';</script>";
    } else {
        echo "<script>alert('Error adding product.'); window.history.back();</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();
}
?>