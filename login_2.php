<?php
//Start the session
 session_start();
 
  //Calling connect to db_connection
  require("assets/components/db_connection.php");

  //Copy the credentials provided by the user
  $user_name    = $_REQUEST['user_name'];
  $access_code  = $_REQUEST['access_code'];
  // $user_type    = $_REQUEST['user_type'];

  //Search for the provided user name in the database under the table "tbl_logs"
  $sql = "SELECT user_name, access_code, user_type from tbl_logs where user_name='$user_name'";

  $result = $mysqli->query($sql);

  if ($result->num_rows == 0) {
    header("location:invalid_login.php");

  }
   else {
    
  //Check whether the user is existing within the database
  $rs = $mysqli->query($sql);
    
    //Check whether the password matches to the user name
    $row = mysqli_fetch_assoc($rs);
    if($row['access_code'] === crypt($access_code, "AB")){

      // Start sessions to continue
      $_SESSION['user_name']  = $user_name;
      $_SESSION['access_code']  = $access_code;
      $_SESSION['user_type'] = $row['user_type'];

      $_userType = $row['user_type'];

      if ($row['user_type'] == "Domestic") {
        header("location:index_domestic.php");
      }
      else if ($row['user_type'] == "Industrial") {
        header("location:index_industrial.php");
      }
      else if ($row['user_type'] == "Admin") {
        header("location:admin.php");
      }
      
    }
    else{
      header("location:invalid_login.php");

}

}



?>