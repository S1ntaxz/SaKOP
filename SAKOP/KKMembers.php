<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script

// Check if SK chairman is logged in
if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    // Establish database connection
    $conn = connectDB();

    // Check if connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch barangay of the logged-in SK chairman
    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);

    $sql_chairman = "SELECT barangay FROM skchairman WHERE id='$userid'";
    $result_chairman = $conn->query($sql_chairman);

    if ($result_chairman->num_rows == 1) {
        $row_chairman = $result_chairman->fetch_assoc();
        $barangay = $row_chairman['barangay'];
    } else {
        // Default to a known barangay if not found
        $barangay = "Default Barangay";
    }

    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $sql = "SELECT firstname, middlename, lastname, age, barangay FROM kk_members WHERE sk_chairman_id='$userid'";
    $result = $conn->query($sql);

    $members = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
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
        /* Additional styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px; /* Adjust as needed */
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-group {
            margin-top: 20px;
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
        <?php include 'sidebar2.php'?>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'topbar.php'?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <!-- Add Member Button -->
            <div class="head-title">
                <div class="left">
                    <h1>Katipunan ng Kabataan Members of Barangay <?php echo $barangay; ?></h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Chairman</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">KK Members</a>
                        </li>
                    </ul>
                </div>
                <a href="addkkinterface.php" class="btn-download" id="addMemberBtn">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Add Member</span>
                </a>
            </div>

            <!-- Table for displaying existing KK members -->
            <div class="table-data">
            <div class="order">
    <table id="kkMembersTable">
        <div class="order">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Age</th>
                
            </tr>
        </thead>
        <tbody id="kkMembersTableBody">
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?php echo $member['firstname']; ?></td>
                    <td><?php echo $member['middlename']; ?></td>
                    <td><?php echo $member['lastname']; ?></td>
                    <td><?php echo $member['age']; ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

            <!-- Add Member Modal -->
           
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var members = <?php echo json_encode($members); ?>;

    // Get the table body to append rows
    var tableBody = document.getElementById("kkMembersTableBody");

    members.forEach(function(member) {
        var row = document.createElement("tr");

        // Populate row cells
        row.innerHTML = `
            <td>${member.firstname}</td>
            <td>${member.middlename}</td>
            <td>${member.lastname}</td>
            <td>${member.age}</td>
            <td>${member.barangay}</td>
            <td>
                <button onclick="viewMemberDetails(${member.id})">View</button>
                <!-- Add other actions as needed -->
            </td>
        `;

        // Set data-id attribute to the row
        row.setAttribute("data-id", member.id);

        tableBody.appendChild(row);
    });

    // Function to view member details
    function viewMemberDetails(memberId) {
        // Find the member in the array
        var member = members.find(m => m.id === memberId);

        // Populate modal with member details
        document.getElementById("view_id").value = member.id;
        document.getElementById("view_firstname").value = member.firstname;
        document.getElementById("view_middlename").value = member.middlename;
        document.getElementById("view_lastname").value = member.lastname;
        document.getElementById("view_birthday").value = member.birthday;
        document.getElementById("view_address").value = member.address;
        document.getElementById("view_barangay").value = member.barangay;
        document.getElementById("view_contact_number").value = member.contact_number;
        document.getElementById("view_email").value = member.email;

        // Display the modal
        var viewEditMemberModal = document.getElementById("viewEditMemberModal");
        viewEditMemberModal.style.display = "block";
    }
    tableBody.appendChild(row);});
            // Get the modals
            var addMemberModal = document.getElementById("addMemberModal");
            var viewEditMemberModal = document.getElementById("viewEditMemberModal");

            // Get the buttons that open the modals
            var addMemberBtn = document.getElementById("addMemberBtn");

            // Get the <span> elements that close the modals
            var addMemberClose = addMemberModal.querySelector(".close");
            var viewEditMemberClose = viewEditMemberModal.querySelector(".close");

            // Event listener for Add Member button
            addMemberBtn.onclick = function() {
                addMemberModal.style.display = "block";
            }

            // Close modal when the <span> (x) is clicked
            addMemberClose.onclick = function() {
                addMemberModal.style.display = "none";
            }
            viewEditMemberClose.onclick = function() {
                viewEditMemberModal.style.display = "none";
            }

            // Close modal when clicked outside of it
            window.onclick = function(event) {
                if (event.target == addMemberModal) {
                    addMemberModal.style.display = "none";
                }
                if (event.target == viewEditMemberModal) {
                    viewEditMemberModal.style.display = "none";
                }
            }

            // Handle form submission for adding a member
            var addMemberForm = document.getElementById("addMemberForm");
            addMemberForm.onsubmit = function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch('addkkmember.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        Swal.fire(
                            'Success!',
                            'New KK member added successfully.',
                            'success'
                        ).then(() => {
                            window.location.reload(); // Reload page after success
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                });
            }

            // Handle row click to view/edit member details
            document.querySelectorAll("#kkMembersTable tbody tr").forEach(row => {
                row.onclick = function() {
                    var rowData = this.dataset;
                    document.getElementById("view_id").value = rowData.id;
                    document.getElementById("view_firstname").value = rowData.firstname;
                    document.getElementById("view_middlename").value = rowData.middlename;
                    document.getElementById("view_lastname").value = rowData.lastname;
                    document.getElementById("view_birthday").value = rowData.birthday;
                    document.getElementById("view_address").value = rowData.address;
                    document.getElementById("view_barangay").value = rowData.barangay;
                    document.getElementById("view_contact_number").value = rowData.contact_number;
                    document.getElementById("view_email").value = rowData.email;
                    viewEditMemberModal.style.display = "block";
                };
            });
        });
    </script>
</body>
</html>
