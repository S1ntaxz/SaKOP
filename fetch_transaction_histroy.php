<?php
session_start();

$db_host = 'localhost';  // Database host
$db_user = 'root';       // Database username
$db_pass = '';           // Database password
$db_name = 'sakoplogin'; // Database name

header('Content-Type: application/json');

if (isset($_SESSION['userid'])) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    $sk_chairman_id = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $sql = "SELECT date, description, amount, type FROM transaction_history WHERE sk_chairman_id='$sk_chairman_id' ORDER BY date DESC";

    $result = $conn->query($sql);
    $history = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
    }

    $conn->close();
    echo json_encode($history);
} else {
    echo json_encode(['error' => 'Unauthorized access.']);
}
?>
