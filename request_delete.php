<?php
// session_start();
// require("assets/components/db_connection.php");

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['req_id'])) {
//     $req_id = (int) $_POST['req_id']; // Ensure it's an integer

//     $sql = "DELETE FROM tbl_request WHERE req_id = ?";
//     $stmt = $mysqli->prepare($sql);
    
//     if ($stmt === false) {
//         die('MySQL prepare error: ' . $mysqli->error);
//     }

//     $stmt->bind_param("i", $req_id);

//     if ($stmt->execute()) {
//         echo "<script>alert('Request deleted successfully!'); window.location.href = 'request_view.php';</script>";
//     } else {
//         echo "<script>alert('Error deleting request.'); window.history.back();</script>";
//     }

//     $stmt->close();
// }

// $mysqli->close();
?>

<?php
session_start();
require("assets/components/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['req_id'])) {
    $req_id = (int) $_POST['req_id']; // Ensure it's an integer

    // Fetch the data from tbl_request that we need to archive
    $sql = "SELECT cust_id, outlet_id, cylinder_brand, cylinder_type, quantity, req_date, scheduled_date, cylinder_status FROM tbl_request WHERE req_id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $mysqli->error);
    }

    $stmt->bind_param("i", $req_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the row data
        $row = $result->fetch_assoc();

        // Insert data into tbl_request_archive
        $insert_sql = "INSERT INTO tbl_request_archive (cust_id, outlet_id, cylinder_brand, cylinder_type, quantity, req_date, scheduled_date, cylinder_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $mysqli->prepare($insert_sql);
        
        if ($insert_stmt === false) {
            die('MySQL prepare error: ' . $mysqli->error);
        }

        $insert_stmt->bind_param("iississs", 
            $row['cust_id'], 
            $row['outlet_id'], 
            $row['cylinder_brand'], 
            $row['cylinder_type'], 
            $row['quantity'], 
            $row['req_date'], 
            $row['scheduled_date'], 
            $row['cylinder_status']
        );
        
        if ($insert_stmt->execute()) {
            // Now delete the data from tbl_request
            $delete_sql = "DELETE FROM tbl_request WHERE req_id = ?";
            $delete_stmt = $mysqli->prepare($delete_sql);

            if ($delete_stmt === false) {
                die('MySQL prepare error: ' . $mysqli->error);
            }

            $delete_stmt->bind_param("i", $req_id);

            if ($delete_stmt->execute()) {
                echo "<script>alert('Request deleted successfully!'); window.location.href = 'request_view.php';</script>";
            } else {
                echo "<script>alert('Error deleting request.'); window.history.back();</script>";
            }

            $delete_stmt->close();
        } else {
            echo "<script>alert('Error archiving request.'); window.history.back();</script>";
        }

        $insert_stmt->close();
    } else {
        echo "<script>alert('Request not found.'); window.history.back();</script>";
    }

    $stmt->close();
}

$mysqli->close();
?>