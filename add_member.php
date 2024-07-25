<?php
// Include the database configuration file
include 'db_config.php';

// Establish database connection
$conn = connectDB();

// Initialize variables
$firstname = $middlename = $lastname = $birthday = $address = $marital_status = $barangay = $contact_number = $email = "";
$firstname_err = $lastname_err = $barangay_err = $contact_number_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $marital_status = $_POST["marital_status"];
    $barangay = $_POST["barangay"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    
    $input_valid = true;
    
    // Validate contact number
    if (!preg_match("/^\d{11}$/", $contact_number)) {
        $contact_number_err = "Contact number must be exactly 11 digits.";
        $input_valid = false;
    }
    
    // Check for duplicate barangay
    $sql = "SELECT id FROM skchairman WHERE barangay = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_barangay);
        $param_barangay = $barangay;

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $barangay_err = "This barangay already has an entry.";
                $input_valid = false;
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }

        $stmt->close();
    }
    
    if ($input_valid) {
        // Prepare an insert statement
        $sql = "INSERT INTO skchairman (firstname, middlename, lastname, birthday, address, marital_status, barangay, contact_number, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssss", $param_firstname, $param_middlename, $param_lastname, $param_birthday, $param_address, $param_marital_status, $param_barangay, $param_contact_number, $param_email);

            // Set parameters
            $param_firstname = $firstname;
            $param_middlename = $middlename;
            $param_lastname = $lastname;
            $param_birthday = $birthday;
            $param_address = $address;
            $param_marital_status = $marital_status;
            $param_barangay = $barangay;
            $param_contact_number = $contact_number;
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    } else {
        // Display errors
        echo $firstname_err . "<br>";
        echo $lastname_err . "<br>";
        echo $barangay_err . "<br>";
        echo $contact_number_err . "<br>";
    }
}

// Close connection
$conn->close();
?>
