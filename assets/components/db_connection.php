<?php
  //Connecting the database
  $host     = "localhost";
  $username = "root";
  $password = "";
  $db_name  = "db_gas_by_gas";

  // Opening the database
  $mysqli = new mysqli($host, $username, $password, $db_name);
  // Check connection
  if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }

 ?>