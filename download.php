<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sakoplogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $sql = "SELECT filename, file_data FROM documents WHERE filename = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $file);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($filename, $fileData);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($fileData));
        echo $fileData;
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}

$conn->close();
?>
