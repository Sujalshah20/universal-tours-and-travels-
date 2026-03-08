<?php
// Database Configuration
// FOR LOCALHOST (XAMPP/WAMP)
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "ofbsphp";

// FOR LIVE SERVER (InfinityFree) - Update these manually once provided
// $servername = "sqlXXX.infinityfree.com";
// $db_username = "if0_XXXXXXXX";
// $db_password = "YOUR_PASSWORD";
// $db_name = "if0_XXXXXXXX_ofbsphp";

// Attempt to connect
$conn = @mysqli_connect($servername, $db_username, $db_password, $db_name);

if (!$conn) {
    // Instead of die(), we store the error to show it gracefully in the UI if needed
    $db_connection_error = mysqli_connect_error();
}
