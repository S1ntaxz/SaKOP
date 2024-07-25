<?php
// Include the database configuration file
include 'db_config.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Fetch user ID from the session
$user_id = $_SESSION['userid'];

// Establish database connection
$conn = connectDB();

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$firstname = $middlename = $lastname = $email = $contact_number = "";
$firstname_err = $contact_number_err = $email_err = $password_err = $retype_password_err = "";

// Fetch user data
$sql = "SELECT firstname, middlename, lastname, email, contact_number, password FROM skchairman WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstname, $middlename, $lastname, $email, $contact_number, $stored_password);
    $stmt->fetch();
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement.']);
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize POST variables
    $old_password = isset($_POST["old_password"]) ? $_POST["old_password"] : "";
    $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : $firstname;
    $middlename = isset($_POST["middlename"]) ? $_POST["middlename"] : "";
    $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : $email;
    $contact_number = isset($_POST["contact_number"]) ? $_POST["contact_number"] : $contact_number;
    $new_password = isset($_POST["new_password"]) ? $_POST["new_password"] : "";
    $retype_password = isset($_POST["retype_password"]) ? $_POST["retype_password"] : "";

    $input_valid = true;

    // Check if the old password matches
    if (!empty($old_password) && $old_password !== $stored_password) {
        $password_err = "Old password is incorrect.";
        $input_valid = false;
    }

    if (!preg_match("/^\d{11}$/", $contact_number)) {
        $contact_number_err = "Contact number must be exactly 11 digits.";
        $input_valid = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
        $input_valid = false;
    }

    if ($new_password !== $retype_password) {
        $retype_password_err = "New passwords do not match.";
        $input_valid = false;
    }

    if ($input_valid) {
        // Update user details
        $sql = "UPDATE skchairman SET firstname = ?, middlename = ?, lastname = ?, email = ?, contact_number = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssi", $firstname, $middlename, $lastname, $email, $contact_number, $user_id);

            if ($stmt->execute()) {
                // Update password if provided
                if (!empty($new_password)) {
                    $sql = "UPDATE skchairman SET password = ? WHERE id = ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("si", $new_password, $user_id);
                        if ($stmt->execute()) {
                            echo json_encode(['status' => 'success']);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
                        }
                        $stmt->close();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare password update statement.']);
                    }
                } else {
                    echo json_encode(['status' => 'success']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update user details.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement.']);
        }
    } else {
        // Send validation errors as JSON
        echo json_encode([
            'status' => 'error',
            'contact_number_err' => $contact_number_err,
            'email_err' => $email_err,
            'password_err' => $password_err,
            'retype_password_err' => $retype_password_err
        ]);
    }
    exit(); // Ensure no HTML is sent after JSON response
}

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
        <?php include 'sidebar2.php'; ?>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'topbar.php'; ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
        <div class="head-title">
                <div class="left">
                    <h1>Account Settings</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Chairman</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Account Settings</a>
                        </li>
                    </ul>
                </div>
                <!--<a href="settings.php" class="btn-download" id="addMemberBtn" input type="submit">
                    <i class='bx bxs-cloud-download' type="submit"></i>
                    <span class="text">Save</span>
                </a>-->
            </div>
            
            <div class="container">
                <h2>Account Settings</h2>
                <form id="settingsForm" method="POST" action="settings.php">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" class="form-control" required><br>
                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" value="<?php echo htmlspecialchars($middlename); ?>" class="form-control" required><br>
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" class="form-control" required><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" required><br>
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" class="form-control" required><br>
                    <label for="old_password">Old Password:</label>
                    <input type="password" id="old_password" name="old_password" class="form-control"><br>
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" class="form-control"><br>
                    <label for="retype_password">Retype New Password:</label>
                    <input type="password" id="retype_password" name="retype_password" class="form-control"><br>
                    <input type="submit" value="Save Changes">
                </form>
            </div>

            <script>
            document.getElementById('settingsForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('settings.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire('Success', 'Account settings updated successfully!', 'success');
        } else {
            // Prepare error messages
            let errorMessage = '';
            if (data.contact_number_err) errorMessage += data.contact_number_err + '<br>';
            if (data.email_err) errorMessage += data.email_err + '<br>';
            if (data.password_err) errorMessage += data.password_err + '<br>';
            if (data.retype_password_err) errorMessage += data.retype_password_err + '<br>';

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
        Swal.fire('Error', 'An error occurred while processing your request.', 'error');
    });
});

            </script>
        </main>
    </section>
    <!-- CONTENT -->
</body>
</html>
