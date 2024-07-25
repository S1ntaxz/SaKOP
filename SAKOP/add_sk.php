<?php
include 'db_config.php';

$conn = connectDB();

$firstname = $middlename = $lastname = $birthday = $address = $marital_status = $barangay = $contact_number = $email = $gender = "";
$firstname_err = $lastname_err = $barangay_err = $contact_number_err = $age_err = $duplicate_err = "";

$all_barangays = ["Aga", "Balaytigue", "Balok-Balok", "Banilad", "Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4", "Barangay 5", "Barangay 6", "Barangay 7", "Barangay 8", "Barangay 9", "Barangay 10", "Barangay 11", "Barangay 12", "Bilaran", "Bucana", "Bulihan", "Bunducan", "Butucan", "Calayo", "Catandaan", "Cogunan", "Dayap", "Kayrilaw", "Kaylaway", "Latag", "Looc", "Lumbangan", "Malapad Na Bato", "Mataas Na Pulo", "Maugat", "Munting Indang", "Natipuan", "Pantalan", "Papaya", "Putat", "Reparo", "Talangan", "Tumalim", "Utod", "Wawa"];
$available_barangays = [];

$sql = "SELECT barangay FROM skchairman";
$result = $conn->query($sql);
$taken_barangays = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $taken_barangays[] = $row['barangay'];
    }
}
$available_barangays = array_diff($all_barangays, $taken_barangays);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $marital_status = $_POST["marital_status"];
    $barangay = $_POST["barangay"];
    $contact_number = $_POST["contact_number"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    
    $input_valid = true;
    
    if (!preg_match("/^\d{11}$/", $contact_number)) {
        $contact_number_err = "Contact number must be exactly 11 digits.";
        $input_valid = false;
    }
    
    $birthday_date = new DateTime($birthday);
    $current_date = new DateTime();
    $age = $current_date->diff($birthday_date)->y;
    if ($age < 18 || $age > 24) {
        $age_err = "Age must be between 18 and 24 years.";
        $input_valid = false;
    }
    
    $sql = "SELECT id FROM skchairman WHERE firstname = ? AND middlename = ? AND lastname = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $firstname, $middlename, $lastname);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $duplicate_err = "An entry with the same name already exists.";
            $input_valid = false;
        }
        $stmt->close();
    }
    
    if (in_array($barangay, $taken_barangays)) {
        $barangay_err = "This barangay already has an entry.";
        $input_valid = false;
    }
    
    if ($input_valid) {
        $password = $firstname;

        $sql = "INSERT INTO skchairman (firstname, middlename, lastname, birthday, address, marital_status, barangay, contact_number, email, gender, password, age) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssssssis", $param_firstname, $param_middlename, $param_lastname, $param_birthday, $param_address, $param_marital_status, $param_barangay, $param_contact_number, $param_email, $param_gender, $param_password, $param_age);

            $param_firstname = $firstname;
            $param_middlename = $middlename;
            $param_lastname = $lastname;
            $param_birthday = $birthday;
            $param_address = $address;
            $param_marital_status = $marital_status;
            $param_barangay = $barangay;
            $param_contact_number = $contact_number;
            $param_email = $email;
            $param_gender = $gender;
            $param_password = $password;
            $param_age = $age;

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement.']);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'contact_number_err' => $contact_number_err,
            'age_err' => $age_err,
            'barangay_err' => $barangay_err,
            'duplicate_err' => $duplicate_err
        ]);
    }
}

$conn->close();
?>
