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

// Get SK Chairman ID from request
$skChairmanId = isset($_GET['sk_chairman_id']) ? intval($_GET['sk_chairman_id']) : 0;

if ($skChairmanId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid SK Chairman ID']);
    exit();
}

// Fetch programs with barangay details
$sql = "
    SELECT p.*, s.barangay
    FROM programs p
    JOIN sk_chairman s ON p.sk_chairman_id = s.id
    WHERE p.sk_chairman_id = ?
    ORDER BY p.date_ended DESC
";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'SQL prepare error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $skChairmanId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all programs
$programs = [];
while ($row = $result->fetch_assoc()) {
    $programs[] = $row;
}

// Return the results as JSON
echo json_encode(['status' => 'success', 'programs' => $programs]);

// Close the connection
$stmt->close();
$conn->close();
?>
