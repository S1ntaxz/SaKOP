<?php
// Include the database configuration file
include 'db_config.php';

// Start session to access session variables
session_start();

// Check if SK Chairman ID is set in session
if (!isset($_SESSION['sk_chairman_id'])) {
    // Redirect or handle unauthorized access
    header("Location: login.php"); // Example redirection to login page
    exit();
}

// Retrieve SK Chairman ID from session
$sk_chairman_id = $_SESSION['sk_chairman_id'];

// Handle form submission for updating a member
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (ensure to sanitize all inputs)
    $id = $_POST['id']; // Assuming KK member ID is passed via hidden input
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];

    // Update kk_members table
    $sql = "UPDATE kk_members 
            SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', 
                birthday = '$birthday', address = '$address', barangay = '$barangay', 
                contact_number = '$contact_number', email = '$email'
            WHERE id = '$id' AND sk_chairman_id = '$sk_chairman_id'";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // Return success message to JavaScript
    } else {
        echo "error: " . $conn->error; // Return error message to JavaScript
    }
}
?>
