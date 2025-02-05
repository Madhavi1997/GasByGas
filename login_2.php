<?php
session_start();

require("assets/components/db_connection.php");

$user_name    = $_REQUEST['user_name'];
$access_code  = $_REQUEST['access_code'];

$sql = "SELECT user_name, access_code, user_type from tbl_logs where user_name='$user_name'";

$result = $mysqli->query($sql);

if ($result->num_rows == 0) {
  header("location:invalid_login.php");
} else {

  $rs = $mysqli->query($sql);

  $row = mysqli_fetch_assoc($rs);
  if ($row['access_code'] === crypt($access_code, "AB")) {

    $_SESSION['user_name']  = $user_name;
    $_SESSION['access_code']  = $access_code;
    $_SESSION['user_type'] = $row['user_type'];

    $_userType = $row['user_type'];

    if ($row['user_type'] == "Domestic") {
      header("location:index_domestic.php");
    } else if ($row['user_type'] == "Industrial") {
      header("location:index_industrial.php");
    } else if ($row['user_type'] == "Outlet") {
      header("location:index_outlet.php");
    } else if ($row['user_type'] == "Admin") {
      header("location:index_admin.php");
    }
  } else {
    header("location:invalid_login.php");
  }
}
