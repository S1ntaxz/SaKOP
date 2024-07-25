<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

// Check if SK Chairman is logged in
if (!isset($_SESSION['userid'])) {
    echo "<tr><td colspan='3'>You must be logged in to view documents.</td></tr>";
    exit();
}

$sk_chairman_id = $_SESSION['userid'];

$sql = "SELECT id, skfilename, uploadfiledate FROM sk_documents WHERE sk_chairman_id = ? ORDER BY uploadfiledate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sk_chairman_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['skfilename']}</td>
                <td>{$row['uploadfiledate']}</td>
                <td><a href='skdownload.php?file=" . $row['id'] . "'>Download</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No documents found</td></tr>";
}

$stmt->close();
$conn->close();
?>
