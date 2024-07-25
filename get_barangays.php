<?php
include 'db_config.php';

$conn = connectDB();

// Get existing barangays
$sql = "SELECT DISTINCT barangay FROM skchairman";
$result = $conn->query($sql);

$existingBarangays = [];
while ($row = $result->fetch_assoc()) {
    $existingBarangays[] = $row['barangay'];
}

// List of all barangays
$allBarangays = [
    'Aga', 'Balaytigui', 'Banilad', 'Barangay 1-12', 'Bilaran', 'Bucana', 'Bulihan',
    'Bunducan', 'Butucan', 'Calayo', 'Catandaan', 'Cogunan', 'Dayap', 'Latag',
    'Looc', 'Lumbangan', 'Malapad na Bato', 'Mataas na Pulo', 'Maugat', 'Munting Indang',
    'Natipuan', 'Pantalan', 'Papaya', 'Putat', 'Reparo', 'Talangan', 'Tumalim', 'Utod', 'Wawa'
];

// Filter out existing barangays
$availableBarangays = array_diff($allBarangays, $existingBarangays);

echo json_encode($availableBarangays);

$conn->close();
?>
