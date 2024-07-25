<?php
session_start();

if (!isset($_SESSION['userid'])) {
    die("Unauthorized access");
}

if (!isset($_GET['id'])) {
    die("Receipt ID is required");
}

$receipt_id = $_GET['id'];

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'sakoplogin';

// Establish database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch receipt content from the database
$sql = "SELECT receipt_content FROM transactions WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receipt_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $receipt_content = $row['receipt_content'];

    if ($receipt_content) {

        // Output the receipt content
        echo $receipt_content;
    } else {
        die("No receipt content found.");
    }
} else {
    die("No receipt found.");
}

$conn->close();
?>
