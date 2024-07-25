<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sakoplogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Fetch all programs with barangay details
$sql = "
    SELECT p.*, s.barangay
    FROM programs p
    JOIN skchairman s ON p.sk_chairman_id = s.id
    ORDER BY p.date_ended DESC
";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(['status' => 'error', 'message' => 'SQL query error: ' . $conn->error]);
    exit();
}

// Fetch all programs
$programs = [];
while ($row = $result->fetch_assoc()) {
    $programs[] = $row;
}

// Return the results as JSON
echo json_encode(['status' => 'success', 'programs' => $programs]);

// Close the connection
$conn->close();
?>
