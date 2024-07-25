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
        /* Your existing styles */
        /* Add any additional styles specific to this interface */
        /* Ensure to include styles for modal, form controls, buttons, etc. */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        section {
            display: flex;
        }

        #sidebar {
            background-color: #333;
            color: #fff;
            min-width: 250px;
            padding: 20px;
        }

        #content {
            flex: 1;
            padding: 20px;
        }

        #topbar {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #topbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .default-content {
            text-align: center;
            margin-top: 50px;
        }

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
            max-width: 600px;
            border-radius: 8px;
            position: relative;
        }

        .close {
            color: #aaaaaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <ul>
            <li><a href="#" id="addMemberBtn">Add Member</a></li>
            <!-- Add other sidebar links as needed -->
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- TOP BAR -->
        <div id="topbar">
            <h1>SaKOP</h1>
            <!-- Add other top bar elements as needed -->
        </div>
        <!-- TOP BAR -->

        <!-- MAIN CONTENT -->
        <main id="mainContent">
            <!-- Default content when not adding a member -->
            <div class="default-content">
                <h1>Welcome to SaKOP</h1>
                <p>Select an action from the sidebar.</p>
            </div>

            <!-- Add Member Interface -->
            <div id="addMemberInterface" style="display: none;">
                <div class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add SK Chairman</h2>
                        <form id="addMemberForm">
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
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="marital_status">Marital Status</label>
                                <select id="marital_status" name="marital_status" class="form-control" required>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay</label>
                                <input type="text" id="barangay" name="barangay" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" id="contact_number" name="contact_number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-submit">Add Member</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Add Member Interface End -->
        </main>
        <!-- MAIN CONTENT -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var addMemberBtn = document.getElementById("addMemberBtn");
            var addMemberInterface = document.getElementById("addMemberInterface");

            // Event listener for Add Member button
            addMemberBtn.addEventListener("click", function(event) {
                event.preventDefault();
                // Hide default content and show add member interface
                document.querySelector(".default-content").style.display = "none";
                addMemberInterface.style.display = "block";
            });

            // Close modal when the <span> (x) is clicked
            document.querySelector(".close").addEventListener("click", function() {
                addMemberInterface.style.display = "none";
                // Show default content when closing add member interface
                document.querySelector(".default-content").style.display = "block";
            });

            // Handle form submission for adding a member
            document.getElementById("addMemberForm").addEventListener("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch('add_member.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        Swal.fire(
                            'Success!',
                            'New SK Chairman added successfully.',
                            'success'
                        ).then(() => {
                            // Reload page after success
                            window.location.reload();
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
            });
        });
    </script>
</body>
</html>
