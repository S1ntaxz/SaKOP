<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script
$conn = connectDB();

if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    $sk_chairman_id = mysqli_real_escape_string($conn, $_SESSION['userid']);

    $sql = "SELECT * FROM programs WHERE sk_chairman_id = '$sk_chairman_id' AND status = 'Pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $programs = [];
        while ($row = $result->fetch_assoc()) {
            $programs[] = $row;
        }
        echo json_encode(['status' => 'success', 'programs' => $programs]);
    } else {
        echo json_encode(['status' => 'success', 'programs' => []]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
}
?>
