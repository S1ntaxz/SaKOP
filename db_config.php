<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change this to your actual MySQL password
$dbname = "sakoplogin";

// Create connection
function connectDB() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
