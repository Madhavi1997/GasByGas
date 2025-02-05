<?php
// session_start();
// require("assets/components/db_connection.php");

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
//     $product_id = (int) $_POST['product_id']; // Ensure it's an integer

//     // Fetch the data from tbl_product that we need to archive
//     $sql = "SELECT cylinder_brand, cylinder_type, unit_price FROM tbl_product WHERE product_id = ?";
//     $stmt = $mysqli->prepare($sql);

//     if ($stmt === false) {
//         die('MySQL prepare error: ' . $mysqli->error);
//     }

//     $stmt->bind_param("i", $product_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     if ($result->num_rows > 0) {
//         // Fetch the row data
//         $row = $result->fetch_assoc();

//         // Insert data into tbl_request_archive
//         $insert_sql = "INSERT INTO tbl_product_archive (cylinder_brand, cylinder_type, unit_price) VALUES (?, ?, ?)";
//         $insert_stmt = $mysqli->prepare($insert_sql);
        
//         if ($insert_stmt === false) {
//             die('MySQL prepare error: ' . $mysqli->error);
//         }

//         $insert_stmt->bind_param("iississs", 
//             $row['cylinder_brand'], 
//             $row['cylinder_type'], 
//             $row['unit_price'], 
//         );
        
//         if ($insert_stmt->execute()) {
//             // Now delete the data from tbl_product
//             $delete_sql = "DELETE FROM tbl_product WHERE product_id = ?";
//             $delete_stmt = $mysqli->prepare($delete_sql);

//             if ($delete_stmt === false) {
//                 die('MySQL prepare error: ' . $mysqli->error);
//             }

//             $delete_stmt->bind_param("i", $req_id);

//             if ($delete_stmt->execute()) {
//                 echo "<script>alert('product deleted successfully!'); window.location.href = 'product.php';</script>";
//             } else {
//                 echo "<script>alert('Error deleting product.'); window.history.back();</script>";
//             }

//             $delete_stmt->close();
//         } else {
//             echo "<script>alert('Error archiving product.'); window.history.back();</script>";
//         }

//         $insert_stmt->close();
//     } else {
//         echo "<script>alert('Product not found.'); window.history.back();</script>";
//     }

//     $stmt->close();
// }

// $mysqli->close();
?>

<?php
session_start();
require("assets/components/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int) $_POST['product_id']; // Ensure it's an integer

    // Fetch the data from tbl_product that we need to archive
    $sql = "SELECT cylinder_brand, cylinder_type, unit_price FROM tbl_product WHERE product_id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $mysqli->error);
    }

    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the row data
        $row = $result->fetch_assoc();

        // Insert data into tbl_product_archive
        $insert_sql = "INSERT INTO tbl_product_archive (cylinder_brand, cylinder_type, unit_price) VALUES (?, ?, ?)";
        $insert_stmt = $mysqli->prepare($insert_sql);
        
        if ($insert_stmt === false) {
            die('MySQL prepare error: ' . $mysqli->error);
        }

        // Bind parameters: cylinder_brand and cylinder_type are strings, unit_price is decimal
        $insert_stmt->bind_param("ssd", 
            $row['cylinder_brand'], 
            $row['cylinder_type'], 
            $row['unit_price']
        );
        
        if ($insert_stmt->execute()) {
            // Now delete the data from tbl_product
            $delete_sql = "DELETE FROM tbl_product WHERE product_id = ?";
            $delete_stmt = $mysqli->prepare($delete_sql);

            if ($delete_stmt === false) {
                die('MySQL prepare error: ' . $mysqli->error);
            }

            $delete_stmt->bind_param("i", $product_id);  // Use product_id for deletion

            if ($delete_stmt->execute()) {
                echo "<script>alert('Product deleted successfully!'); window.location.href = 'product.php';</script>";
            } else {
                echo "<script>alert('Error deleting product.'); window.history.back();</script>";
            }

            $delete_stmt->close();
        } else {
            echo "<script>alert('Error archiving product.'); window.history.back();</script>";
        }

        $insert_stmt->close();
    } else {
        echo "<script>alert('Product not found.'); window.history.back();</script>";
    }

    $stmt->close();
}

$mysqli->close();
?>