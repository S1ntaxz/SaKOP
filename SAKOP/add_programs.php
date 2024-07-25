<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script
$conn = connectDB();

if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    $sk_chairman_id = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $selected_programs = $_POST['programs'] ?? [];
    $date_started = date('Y-m-d'); // Set to current date
    $date_ended = date('Y-m-d', strtotime('+6 months')); // Set to 6 months from now

    foreach ($selected_programs as $program_name) {
        $program_name = mysqli_real_escape_string($conn, $program_name);

        $sql = "INSERT INTO programs (sk_chairman_id, program_name, date_added, date_started, date_ended, status)
                VALUES ('$sk_chairman_id', '$program_name', NOW(), '$date_started', '$date_ended', 'Pending')";

        if (!$conn->query($sql)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add program: ' . $conn->error]);
            $conn->close();
            exit();
        }
    }

    $conn->close();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
}
?>
