<?php
 
    // //Execution Successful
    // header("location:index.php?status=pass");
 
    // session_start();
    // session_destroy();
 
?>

<?php
session_start();  // Start the session if it's not already started

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: index.php");
exit(); // Ensure script stops executing
?>