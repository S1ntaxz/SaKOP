<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_config.php'; // Ensure this includes your database connection script
$conn = connectDB();

// Check if SK chairman is logged in
if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    $sk_chairman_id = mysqli_real_escape_string($conn, $_SESSION['userid']);

    // Determine the number of KK members
    $sql_count = "SELECT COUNT(*) as count FROM kk_members WHERE sk_chairman_id='$sk_chairman_id'";
    $result_count = $conn->query($sql_count);

    if ($result_count && $row_count = $result_count->fetch_assoc()) {
        $kk_count = $row_count['count'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch KK member count']);
        exit();
    }

    // Define programs based on KK member count
    $programs = [];

    if ($kk_count >= 1 && $kk_count <= 5) {
        $programs = [
            'Program A',
            'Program B',
            'Program C',
            'Program D',
            'Program E'
        ];
    } elseif ($kk_count >= 6 && $kk_count <= 10) {
        $programs = [
            'Program F',
            'Program G',
            'Program H',
            'Program I',
            'Program J'
        ];
    } elseif ($kk_count >= 11 && $kk_count <= 20) {
        $programs = [
            'Program K',
            'Program L',
            'Program M',
            'Program N',
            'Program O'
        ];
    } else {
        $programs = [
            'Program P',
            'Program Q',
            'Program R',
            'Program S',
            'Program T'
        ];
    }

    // Fetch pending programs
    $sql_pending = "SELECT * FROM programs WHERE status = 'Pending' AND sk_chairman_id = ?";
    $stmt_pending = $conn->prepare($sql_pending);
    $stmt_pending->bind_param("i", $sk_chairman_id);
    $stmt_pending->execute();
    $result_pending = $stmt_pending->get_result();
    $pending_programs = $result_pending->fetch_all(MYSQLI_ASSOC);

    // Fetch ongoing programs
    $sql_ongoing = "SELECT * FROM programs WHERE status = 'Ongoing' AND sk_chairman_id = ?";
    $stmt_ongoing = $conn->prepare($sql_ongoing);
    $stmt_ongoing->bind_param("i", $sk_chairman_id);
    $stmt_ongoing->execute();
    $result_ongoing = $stmt_ongoing->get_result();
    $ongoing_programs = $result_ongoing->fetch_all(MYSQLI_ASSOC);

    // Fetch completed programs
    $sql_completed = "SELECT * FROM programs WHERE status = 'Completed' AND sk_chairman_id = ?";
    $stmt_completed = $conn->prepare($sql_completed);
    $stmt_completed->bind_param("i", $sk_chairman_id);
    $stmt_completed->execute();
    $result_completed = $stmt_completed->get_result();
    $completed_programs = $result_completed->fetch_all(MYSQLI_ASSOC);

    // Close statements and connection
    $stmt_pending->close();
    $stmt_ongoing->close();
    $stmt_completed->close();
    $conn->close();

    // Return the response
    echo json_encode([
        'status' => 'success',
        'programs' => $programs,
        'pending' => $pending_programs,
        'ongoing' => $ongoing_programs,
        'completed' => $completed_programs // Include completed programs
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
}
?>
