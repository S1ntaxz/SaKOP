<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script
$conn = connectDB(); 
// Check if SK chairman is logged in
if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    // Fetch barangay of the logged-in SK chairman
    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);

    // Establish database connection

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql_chairman = "SELECT barangay FROM skchairman WHERE id='$userid'";
    $result_chairman = $conn->query($sql_chairman);

    if ($result_chairman->num_rows == 1) {
        $row_chairman = $result_chairman->fetch_assoc();
        $barangay = $row_chairman['barangay'];
    } else {
        // Default to a known barangay if not found
        $barangay = "Default Barangay";
    }

    $conn->close();
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
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
        <?php include 'sidebar2.php' ?>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'topbar.php' ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Add KK Member</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Chairman</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="#">KK Members</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Add Member</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Add Member Form -->
            <div class="form-container">
                <h2>Personal Details</h2>
                <form id="addMemberForm">
                    <input type="hidden" id="sk_chairman_id" name="sk_chairman_id" value="<?php echo htmlspecialchars($_SESSION['userid']); ?>">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" id="middlename" name="middlename" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
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
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" id="barangay" name="barangay" class="form-control" value="<?php echo htmlspecialchars($barangay); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn-submit">Add Member</button>
                    </div>
                </form>
            </div>
            <!-- Add Member Form End -->
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Handle form submission for adding a member
    var addMemberForm = document.getElementById("addMemberForm");
    addMemberForm.onsubmit = function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        fetch('addkkmember.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Ensure the response is parsed as JSON
        })
        .then(data => {
            if (data.status === 'success') {
                Swal.fire(
                    'Success!',
                    'New KK member added successfully.',
                    'success'
                ).then(() => {
                    window.location.reload(); // Reload page after success
                });
            } else {
                let errorMessage = '';
                if (data.contact_number_err) errorMessage += data.contact_number_err + '<br>';
                if (data.age_err) errorMessage += data.age_err + '<br>';
                if (data.barangay_err) errorMessage += data.barangay_err + '<br>';
                if (data.duplicate_entry_err) errorMessage += data.duplicate_entry_err + '<br>';
                if (data.message) errorMessage += data.message + '<br>'; // General error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMessage,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            Swal.fire(
                'Error!',
                'Something went wrong. Please try again. If the problem persists, contact support.',
                'error'
            );
        });
    }

    // Calculate age based on birthday
    var birthdayInput = document.getElementById("birthday");
    var ageInput = document.getElementById("age");

    birthdayInput.addEventListener("input", function() {
        var birthday = new Date(this.value);
        var today = new Date();
        var age = today.getFullYear() - birthday.getFullYear();
        var monthDiff = today.getMonth() - birthday.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
            age--;
        }
        ageInput.value = age;
    });
});


    </script>
</body>
</html>
