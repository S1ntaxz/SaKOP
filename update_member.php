<?php
// Include the database configuration file
include 'db_config.php';

// Establish database connection
$conn = connectDB();

// Function to calculate age from birthday
function calculateAge($birthday) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id']; // Assuming the ID is sent via POST
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $marital_status = $_POST['marital_status'];
    $barangay = $_POST['barangay'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    
    // Calculate age from birthday
    $age = calculateAge($birthday);
    // Validate inputs
    $input_valid = true;
    $errors = [];

    // Validate contact number
    if (!preg_match("/^\d{11}$/", $contact_number)) {
        $errors[] = "Contact number must be exactly 11 digits.";
        $input_valid = false;
    }

    // Check for duplicate barangay excluding the current record
    $sql = "SELECT id FROM skchairman WHERE barangay = ? AND id <> ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $barangay, $id);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = "This barangay already has an entry.";
                $input_valid = false;
            }
        } else {
            $errors[] = "Something went wrong. Please try again later.";
            $input_valid = false;
        }

        $stmt->close();
    } else {
        $errors[] = "Failed to prepare statement.";
        $input_valid = false;
    }

    // If inputs are valid, proceed with update
    if ($input_valid) {
        // Prepare and bind
        $stmt = $conn->prepare("UPDATE skchairman SET firstname=?, middlename=?, lastname=?, birthday=?, age=?, address=?, marital_status=?, barangay=?, contact_number=?, email=? WHERE id=?");
        $stmt->bind_param("ssssisssssi", $firstname, $middlename, $lastname, $birthday, $age, $address, $marital_status, $barangay, $contact_number, $email, $id);


        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Something went wrong. Please try again later."]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "errors" => $errors]);
    }
}

// Close the connection
$conn->close();
?>
