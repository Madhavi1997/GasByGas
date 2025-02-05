<?php
include 'db_connection.php'; // Include your DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $req_id = $_POST['req_id'];
    $cylinder_status = $_POST['cylinder_status'];

    // Update cylinder_status in tbl_payment where req_id matches
    $sql = "UPDATE tbl_payment SET cylinder_status = ? WHERE req_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $cylinder_status, $req_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database update failed."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>