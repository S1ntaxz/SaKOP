<?php
session_start();
include 'db_config.php'; // Include your database configuration script

// Check if SK Chairman ID is set in session
if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Retrieve SK Chairman ID from session
$sk_chairman_id = $_SESSION['userid'];

// Initialize variables
$firstname = $middlename = $lastname = $birthday = $address = $barangay = $contact_number = $email = $gender = "";
$firstname_err = $lastname_err = $contact_number_err = $age_err = $duplicate_entry_err = "";
$input_valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();

    // Check if connection is successful
    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]);
        exit();
    }

    // Sanitize inputs
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validate contact number
    if (!preg_match("/^\d{11}$/", $contact_number)) {
        $contact_number_err = "Contact number must be exactly 11 digits.";
        $input_valid = false;
    }
    
    // Validate age
    $birthday_date = new DateTime($birthday);
    $current_date = new DateTime();
    $calculated_age = $current_date->diff($birthday_date)->y;
    if ($calculated_age < 15 || $calculated_age > 30) {
        $age_err = "Age must be between 15 and 30.";
        $input_valid = false;
    }

    // Check for duplicate contact number
    $sql_check_duplicate_contact = "SELECT COUNT(*) FROM kk_members WHERE contact_number = '$contact_number' AND sk_chairman_id = '$sk_chairman_id'";
    $result_check_duplicate_contact = mysqli_query($conn, $sql_check_duplicate_contact);
    $row_check_duplicate_contact = mysqli_fetch_array($result_check_duplicate_contact);
    if ($row_check_duplicate_contact[0] > 0) {
        $contact_number_err = "This contact number is already in use.";
        $input_valid = false;
    }

    // Check for duplicate entries
    $sql_check_duplicate = "SELECT COUNT(*) FROM kk_members WHERE sk_chairman_id = '$sk_chairman_id' AND firstname = '$firstname' AND middlename = '$middlename' AND lastname = '$lastname'";
    $result_check_duplicate = mysqli_query($conn, $sql_check_duplicate);
    $row_check_duplicate = mysqli_fetch_array($result_check_duplicate);
    if ($row_check_duplicate[0] > 0) {
        $duplicate_entry_err = "This member already exists in this barangay.";
        $input_valid = false;
    }

    if ($input_valid) {
        // Prepare the SQL statement to insert the data
        $sql = "INSERT INTO kk_members (sk_chairman_id, firstname, middlename, lastname, birthday, age, gender, address, barangay, contact_number, email) 
                VALUES ('$sk_chairman_id', '$firstname', '$middlename', '$lastname', '$birthday', '$age', '$gender', '$address', '$barangay', '$contact_number', '$email')";

        // Execute the SQL statement
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($conn)]);
        }
    } else {
        // Return validation errors
        echo json_encode([
            "status" => "error",
            "contact_number_err" => $contact_number_err,
            "age_err" => $age_err,
            "duplicate_entry_err" => $duplicate_entry_err
        ]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
