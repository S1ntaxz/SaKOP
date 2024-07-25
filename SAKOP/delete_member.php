<?php
// Include the database configuration file
include 'db_config.php';

// Check if ID parameter exists
if(isset($_POST['id'])) {
    // Establish database connection
    $conn = connectDB();

    // Escape user inputs for security
    $id = $conn->real_escape_string($_POST['id']);

    // Prepare a delete statement
    $sql = "DELETE FROM skchairman WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Close the database connection
    $conn->close();
} else {
    echo 'error';
}
?>
