<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'sakoplogin';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$receipt_id = $_GET['id'];

$sql = "SELECT receipt_content, receipt_type FROM transactions WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Failed to prepare SQL statement: " . $conn->error);
}

$stmt->bind_param("i", $receipt_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($receipt_content, $receipt_type);

if ($stmt->num_rows === 0) {
    die("No receipt found for the given ID.");
}

$stmt->fetch();
$stmt->close();
$conn->close();

header("Content-Type: $receipt_type");
echo $receipt_content;
?>
