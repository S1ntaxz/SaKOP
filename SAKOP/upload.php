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

if (isset($_POST['submit'])) {
    $originalFileName = basename($_FILES["file"]["name"]);
    $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $docName = htmlspecialchars($_POST['docName']);
    $newFileName = $docName . '.' . $fileType;
    $fileContent = file_get_contents($_FILES["file"]["tmp_name"]);
    $fileContentEscaped = $conn->real_escape_string($fileContent);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf', 'doc', 'docx', 'xlsx');
    if (in_array($fileType, $allowTypes)) {
        // Insert file information into database
        $sql = "INSERT INTO documents (filename, file_data) VALUES ('$newFileName', '$fileContentEscaped')";
        if ($conn->query($sql) === TRUE) {
            header("Location: Docu.php?upload=success");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, XLSX files are allowed.";
    }
}

$conn->close();
?>
