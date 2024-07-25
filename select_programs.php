<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script
$conn = connectDB(); 

// Check if SK chairman is logged in
if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    // Fetch SK Chairman ID from session
    $sk_chairman_id = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $selected_programs = $_POST['programs'] ?? [];
    $date_added = date('Y-m-d'); // Current date
    $status = 'Pending'; // Default status

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO programs (sk_chairman_id, program_name, date_added, date_started, date_ended, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $sk_chairman_id, $program_name, $date_added, $date_started, $date_ended, $status);

    // Loop through each selected program and insert into the database
    foreach ($selected_programs as $program) {
        // Assume date_started and date_ended are set dynamically or retrieved from somewhere
        $date_started = '2024-08-01'; // Example date, adjust as needed
        $date_ended = '2024-12-31'; // Example date, adjust as needed
        $program_name = $program;

        // Execute the prepared statement
        if (!$stmt->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert program']);
            exit();
        }
    }

    $stmt->close();
    $conn->close();
    
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
}
?>
