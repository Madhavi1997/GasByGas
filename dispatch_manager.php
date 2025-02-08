<?php
session_start();
require("assets/components/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// Function to filter requests
function filterRequests($requests) {
    $filteredRequests = [];
    foreach ($requests as $request) {
        // Apply filtering criteria
        if ($request['type'] == 'urgent' || $request['priority'] == 'high' || $request['status'] == 'pending') {
            if ($request['stock'] > 0 && $request['payment_status'] == 'paid') {
                $filteredRequests[] = $request;
            }
        }
    }
    return $filteredRequests;
}

// Function to reschedule requests
function rescheduleRequests($requests) {
    foreach ($requests as &$request) {
        // Apply rescheduling rules
        if ($request['stock'] <= 0) {
            $request['reschedule_time'] = 'Next available supply';
        } elseif ($request['type'] == 'urgent') {
            $request['reschedule_time'] = 'Earlier slot';
        } else {
            $request['reschedule_time'] = 'Next available slot';
        }
    }
    return $requests;
}

// Retrieve requests data (example data)
$requests = [
    ['id' => 1, 'type' => 'urgent', 'priority' => 'high', 'status' => 'pending', 'stock' => 5, 'payment_status' => 'paid', 'area' => 'A'],
    ['id' => 2, 'type' => 'regular', 'priority' => 'low', 'status' => 'processing', 'stock' => 0, 'payment_status' => 'unpaid', 'area' => 'B'],
    // Add more requests as needed
];

// Filter and reschedule requests
$filteredRequests = filterRequests($requests);
$rescheduledRequests = rescheduleRequests($filteredRequests);

// Output the filtered and rescheduled requests
echo "<h1>Dispatch Manager - Filtered and Rescheduled Requests</h1>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Type</th><th>Priority</th><th>Status</th><th>Stock</th><th>Payment Status</th><th>Area</th><th>Rescheduled Time</th></tr>";
foreach ($rescheduledRequests as $request) {
    echo "<tr>";
    echo "<td>{$request['id']}</td>";
    echo "<td>{$request['type']}</td>";
    echo "<td>{$request['priority']}</td>";
    echo "<td>{$request['status']}</td>";
    echo "<td>{$request['stock']}</td>";
    echo "<td>{$request['payment_status']}</td>";
    echo "<td>{$request['area']}</td>";
    echo "<td>{$request['reschedule_time']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
