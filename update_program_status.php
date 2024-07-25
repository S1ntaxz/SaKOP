<?php
require 'db_config.php'; // Ensure this path is correct

// Get POST data
$programId = $_POST['program_id'];
$action = $_POST['action'];
$currentDate = $_POST['current_date'];

// Validate input
if (!in_array($action, ['start', 'end', 'cancel'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    exit;
}

// Initialize status variables
$updateFields = [];
$updateValues = [];

// Determine fields to update based on action
switch ($action) {
    case 'start':
        $updateFields[] = 'date_started = ?';
        $updateValues[] = $currentDate;
        break;
    case 'end':
        $updateFields[] = 'date_ended = ?';
        $updateValues[] = $currentDate;
        break;
    case 'cancel':
        $updateFields[] = 'date_ended = ?'; // Use end date for canceled programs
        $updateValues[] = $currentDate;
        $updateFields[] = 'status = ?';
        $updateValues[] = 'Cancelled';
        break;
}

// Add status field for 'start' and 'end' actions
if ($action === 'start') {
    $updateFields[] = 'status = ?';
    $updateValues[] = 'Ongoing';
} elseif ($action === 'end') {
    $updateFields[] = 'status = ?';
    $updateValues[] = 'Completed';
}

// Construct the SQL query
$sql = "UPDATE programs SET " . implode(', ', $updateFields) . " WHERE id = ?";
$updateValues[] = $programId;

// Prepare and execute the SQL query
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($updateValues)), ...$updateValues);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Program status updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update program status.']);
}

$stmt->close();
$conn->close();
?>
