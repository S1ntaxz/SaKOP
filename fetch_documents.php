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

$sql = "SELECT filename, upload_date FROM documents";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['filename']) . "</td>";
        echo "<td>" . htmlspecialchars($row['upload_date']) . "</td>";
        echo "<td><a href='download.php?file=" . urlencode($row['filename']) . "'>Download</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No documents found</td></tr>";
}

$conn->close();
?>
