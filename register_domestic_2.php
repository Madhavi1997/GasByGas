<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/PHPMailer/src/Exception.php';
require 'assets/PHPMailer/src/PHPMailer.php';
require 'assets/PHPMailer/src/SMTP.php';


// Connect to the database.
require("assets/components/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $NIC = $_POST["NIC"];
    $add_1 = $_POST["add_1"];
    $city = $_POST["city"];
    $district = $_POST["district"];
    $access_code = $_POST["access_code"];
    $user_type = "Domestic";

    // Encrypt the password
    $hashedPassword = crypt($access_code, "AB");

    if ($user_type == "Domestic") {
        // Construct the SQL query for passenger
        $sql_main = "INSERT INTO tbl_dom_cust (f_name, l_name, email, contact, NIC, add_1, city, district) VALUES ('$f_name', '$l_name', '$email', '$contact', '$NIC', '$add_1', '$city', '$district')";
        $sql_log = "INSERT INTO tbl_logs (user_name, access_code, user_type) VALUES ('$email', '$hashedPassword', '$user_type')";
    } else {
        
    }

    echo "Main Query: $sql_main<br>";
    echo "Log Query: $sql_log<br>";

    // Use prepared statements to prevent SQL injection
    $stmt_main = $mysqli->query($sql_main);
    //$stmt_main->execute();

    $stmt_log = $mysqli->query($sql_log);
    //$stmt_log->execute();

    if ($stmt_main && $stmt_log) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'citytaxipvt@gmail.com';
        $mail->Password = 'gdhixrjekgybhbhq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('citytaxipvt@gmail.com');

        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation.';
        $mail->Body = ' 
        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxi Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
    <p>Dear '.$f_name.' '.$l_name.',</p>
        <p>Your Registration has been successful. Your Login Details are as follows</p>
        <ul>
            <li><strong>Username:</strong> '.$email.'</li>
            <li><strong>Password:</strong> '.$access_code.'</li>
            
        </ul>
        <p>If you have any questions or need to make changes, please contact us immediately.</p>
        <div class="footer">
            <p>Thank you for choosing our taxi service.</p>
            <p>Best regards,<br> City Taxi (PVT) LTD</p>
        </div>
        </div>';
        
        $mail->send();
      

        // Redirect to the login page if the insertion was successful
        session_start();
        $_SESSION['registration_success'] = true;
        header("Location: login_1.php");
        exit();
    } else {
        // Handle the case where the insertion failed (you might want to log or display an error)
        echo "Error: " . $stmt_main->error . "<br>" . $stmt_log->error;
    }

    // Close the statements
    $stmt_main->close();
    $stmt_log->close();
}

// Close the database connection
$mysqli->close();
?>