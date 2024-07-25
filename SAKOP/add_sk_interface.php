<?php
// Include the database configuration file
include 'db_config.php';

// Establish database connection
$conn = connectDB();

// Initialize variables
$firstname = $middlename = $lastname = $birthday = $address = $marital_status = $barangay = $contact_number = $email = $gender = "";
$firstname_err = $lastname_err = $barangay_err = $contact_number_err = $age_err = "";

// Fetch available barangays
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
    $gender = $_POST["gender"];
    
    $input_valid = true;
    
    // Validate contact number
    if (!preg_match("/^\d{11}$/", $contact_number)) {
        $contact_number_err = "Contact number must be exactly 11 digits.";
        $input_valid = false;
    }
    
    // Validate age
    $birthday_date = new DateTime($birthday);
    $current_date = new DateTime();
    $age = $current_date->diff($birthday_date)->y;
    if ($age < 18 || $age > 24) {
        $age_err = "Age must be between 18 and 24 years.";
        $input_valid = false;
    }
    
    // Check for duplicate barangay
    if (in_array($barangay, $taken_barangays)) {
        $barangay_err = "This barangay already has an entry.";
        $input_valid = false;
    }
    
    if ($input_valid) {
        // Prepare an insert statement
        $sql = "INSERT INTO skchairman (firstname, middlename, lastname, birthday, address, marital_status, barangay, contact_number, email, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssssss", $param_firstname, $param_middlename, $param_lastname, $param_birthday, $param_address, $param_marital_status, $param_barangay, $param_contact_number, $param_email, $param_gender);

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
            $param_gender = $gender;

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
        echo $age_err . "<br>";
        echo $duplicate_err . "<br>";
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="head.png" type="image/x-icon">
    <title>SaKOP</title>
    
    <style>
        /* Additional styles for modal */
        /* Additional styles */
        .form-group {
            margin-bottom: 15px;
        }

        .btn-group {
            text-align: right;
        }

        .btn-group button {
            margin-left: 10px;
        }
        
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
    <?php include 'sidebar.php'?>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'topbar.php'?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Add SK Chairman</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">SK Federation</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a href="#">SK Chairman</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Add SK Chairman</a></li>
                    </ul>
                </div>
            </div>
            <div class="form-container">
                <h2>Personal Details</h2>
                <form id="addSkChairmanForm" action="add_sk.php" method="post">
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                        <span class="error" id="firstnameError"></span>
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name:</label>
                        <input type="text" id="middlename" name="middlename" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                        <span class="error" id="lastnameError"></span>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday:</label>
                        <input type="date" id="birthday" name="birthday" class="form-control" required>
                        <span class="error" id="ageError"></span>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Marital Status:</label>
                        <select id="marital_status" name="marital_status" class="form-control" required>
                            <option value="" disabled selected>Select Marital Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay:</label>
                        <select id="barangay" name="barangay" class="form-control" required>
                            <!-- Populate barangays from PHP -->
                            <option value="" disabled selected>Select Barangay</option>
                            <?php if (empty($available_barangays)): ?>
            <option value="" disabled>All barangays have entries</option>
        <?php else: ?>
                            <?php foreach ($available_barangays as $barangay): ?>
                                <option value="<?php echo htmlspecialchars($barangay); ?>"><?php echo htmlspecialchars($barangay); ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="error" id="barangayError"></span>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" required>
                        <span class="error" id="contactNumberError"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>
                    <div class="btn-group">
                        <button type="submit" id="submitBtn" class="btn btn-primary">Add SK Chairman</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </main>
    
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
        <script>
document.addEventListener('DOMContentLoaded', function() {
    const birthdayInput = document.getElementById('birthday');
    const ageInput = document.getElementById('age');
    const submitBtn = document.getElementById('submitBtn');

    // Calculate age based on birthday input
    birthdayInput.addEventListener('change', function() {
        const birthdayDate = new Date(birthdayInput.value);
        const today = new Date();
        const age = today.getFullYear() - birthdayDate.getFullYear();
        const monthDifference = today.getMonth() - birthdayDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdayDate.getDate())) {
            age--;
        }
        ageInput.value = age;
    });

    // Handle form submission
    document.getElementById('addSkChairmanForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('add_sk.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Success', 'SK Chairman added successfully!', 'success')
                    .then(() => location.reload()); // Reload the page on success
            } else {
                // Prepare error messages
                let errorMessage = '';
                if (data.contact_number_err) errorMessage += data.contact_number_err + '<br>';
                if (data.age_err) errorMessage += data.age_err + '<br>';
                if (data.barangay_err) errorMessage += data.barangay_err + '<br>';
                if (data.duplicate_err) errorMessage += data.duplicate_err + '<br>';

                // Display error messages using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessage,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.',
                confirmButtonText: 'OK'
            });
        });
    });
});

</script>




</body>
</html>