<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="head.png" type="image/x-icon">
    <title>SaKOP</title>
    <style>
        /* General button styles */
        .btn-submit {
            margin: 10px;
            padding: 8px 16px;
            background-color: #007bff; /* Green color for submit button */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Container styles */
        .form-container, .pending-programs-container, .ongoing-programs-container, .completed-programs-container {
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        /* Program item styles */
        .program-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #eee;
            border-radius: 4px;
        }

        .program-item span {
            margin-right: 10px;
            color: #333;
        }

        /* Button styles */
        .btn-start {
            padding: 6px 12px;
            background-color: #007bff; /* Green color for start button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-end {
            padding: 6px 12px;
            background-color: #007bff; /* Green color for end button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cancel {
            padding: 6px 12px;
            background-color: #dc3545; /* Red color for cancel button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-end:disabled, .btn-cancel:disabled {
            background-color: #6c757d;
            cursor: default;
        }

        /* Table styles */
        #completedProgramsTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        #completedProgramsTable th, #completedProgramsTable td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        #completedProgramsTable th {
            background-color: #f2f2f2;
            color: #333;
        }

        .hidden {
            display: none;
        }

        h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
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
                    <h1>Program Recommendation</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">SK Chairman</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Program Recommendation</a></li>
                    </ul>
                </div>
            </div>

            <!-- Program Selection -->
            <div id="programSelection" class="form-container">
                <h2>Select Programs</h2>
                <form id="programsForm">
                    <div id="programsContainer">
                        <!-- Programs will be loaded here by JavaScript -->
                    </div>
                    <button type="button" id="generatePrograms" class="btn-submit">Generate Programs</button>
                    <button type="button" id="addProgramsBtn" class="btn-submit">Add Selected Programs</button>
                </form>
            </div>
            <!-- Program Selection End -->

            <!-- Pending Programs -->
            <div id="pendingProgramsContainer" class="pending-programs-container hidden">
                <h2>Pending Programs</h2>
                <div id="pendingPrograms">
                    <!-- Pending programs will be loaded here by JavaScript -->
                </div>
            </div>
            <!-- Pending Programs End -->

            <!-- Ongoing Programs -->
            <div id="ongoingProgramsContainer" class="ongoing-programs-container hidden">
                <h2>Ongoing Programs</h2>
                <div id="ongoingPrograms">
                    <!-- Ongoing programs will be loaded here by JavaScript -->
                </div>
            </div>
            <!-- Ongoing Programs End -->

            <!-- Completed Programs -->
            <div id="completedProgramsContainer" class="completed-programs-container hidden">
                <h2>Completed Programs</h2>
                <table id="completedProgramsTable">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Date Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Completed programs will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
            <!-- Completed Programs End -->

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var generateProgramsBtn = document.getElementById("generatePrograms");
            var programsContainer = document.getElementById("programsContainer");
            var addProgramsBtn = document.getElementById("addProgramsBtn");
            var pendingProgramsContainer = document.getElementById("pendingProgramsContainer");
            var ongoingProgramsContainer = document.getElementById("ongoingProgramsContainer");
            var completedProgramsContainer = document.getElementById("completedProgramsContainer");
            var programSelectionContainer = document.getElementById("programSelection");

            function loadPrograms() {
                fetch('get_programs.php', {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        var hasPendingPrograms = data.pending.length > 0;
                        var hasOngoingPrograms = data.ongoing.length > 0;
                        var hasCompletedPrograms = data.completed.length > 0;

                        // Handle pending programs
                        if (hasPendingPrograms) {
                            pendingProgramsContainer.classList.remove("hidden");
                            programSelectionContainer.classList.add("hidden"); // Hide program selection
                            ongoingProgramsContainer.classList.add("hidden"); // Hide ongoing programs
                            completedProgramsContainer.classList.add("hidden"); // Hide completed programs
                            pendingProgramsContainer.innerHTML = '<h2>Pending Programs</h2>'; // Ensure heading is included
                            data.pending.forEach(program => {
                                pendingProgramsContainer.innerHTML += `
                                    <div class="program-item">
                                        <span>${program.program_name}</span>
                                        <button class="btn-start" data-id="${program.id}" ${program.status === 'Ongoing' || program.status === 'Completed' ? 'disabled' : ''}>Start Program</button>
                                        <button class="btn-cancel" data-id="${program.id}" ${program.status === 'Completed' ? 'disabled' : ''}>Cancel Program</button>
                                    </div>
                                `;
                            });

                            // Attach event listeners for start and cancel buttons
                            document.querySelectorAll('.btn-start').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    var programId = this.getAttribute('data-id');
                                    updateProgramStatus(programId, 'start');
                                });
                            });

                            document.querySelectorAll('.btn-cancel').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    var programId = this.getAttribute('data-id');
                                    updateProgramStatus(programId, 'cancel');
                                });
                            });
                        } else {
                            pendingProgramsContainer.classList.add("hidden");
                            programSelectionContainer.classList.remove("hidden"); // Show program selection
                            addProgramsBtn.style.display = 'block'; // Show the add button
                            programsContainer.style.display = 'block'; // Show the program selection

                            pendingProgramsContainer.innerHTML = '<h2>Pending Programs</h2><p>No pending programs.</p>';
                        }

                        // Handle ongoing programs
                        if (hasOngoingPrograms) {
                            ongoingProgramsContainer.classList.remove("hidden");
                            programSelectionContainer.classList.add("hidden"); // Hide program selection
                            pendingProgramsContainer.classList.add("hidden"); // Hide pending programs
                            completedProgramsContainer.classList.add("hidden"); // Hide completed programs
                            ongoingProgramsContainer.innerHTML = '<h2>Ongoing Programs</h2>'; // Ensure heading is included
                            data.ongoing.forEach(program => {
                                ongoingProgramsContainer.innerHTML += `
                                    <div class="program-item">
                                        <span>${program.program_name}</span>
                                        
                                        <button class="btn-end" data-id="${program.id}" ${program.status === 'Completed' ? 'disabled' : ''}>End Program</button>
                                    </div>
                                `;
                            });

                            // Attach event listeners for end buttons in ongoing programs
                            document.querySelectorAll('.btn-end').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    var programId = this.getAttribute('data-id');
                                    updateProgramStatus(programId, 'end');
                                });
                            });
                        } else {
                            ongoingProgramsContainer.classList.add("hidden");
                        }

                        // Handle completed programs
                        if (hasCompletedPrograms) {
                            completedProgramsContainer.classList.remove("hidden");
                            completedProgramsContainer.innerHTML = `
                                <h2>Completed Programs</h2>
                                <table id="completedProgramsTable">
                                    <thead>
                                        <tr>
                                            <th>Program Name</th>
                                            <th>Date Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.completed.map(program => `
                                            <tr>
                                                <td>${program.program_name}</td>
                                                <td>${program.date_ended}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            `;
                        } else {
                            completedProgramsContainer.classList.add("hidden");
                        }
                    } else {
                        alert('Failed to load programs. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error); // Log error for debugging
                    alert('Something went wrong. Please try again.');
                });
            }

            function updateProgramStatus(programId, action) {
                const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' '); // Format date as YYYY-MM-DD HH:MM:SS

                fetch('update_program_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'program_id': programId,
                        'action': action,
                        'current_date': currentDate // Send the current date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire(
                            'Success!',
                            `Program ${action === 'start' ? 'started' : action === 'end' ? 'ended' : 'cancelled'} successfully.`,
                            'success'
                        ).then(() => {
                            loadPrograms(); // Reload programs after update
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error); // Log error for debugging
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                });
            }

            generateProgramsBtn.onclick = function() {
                fetch('get_programs.php', {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        programsContainer.innerHTML = ''; // Clear existing programs
                        data.programs.forEach(program => {
                            programsContainer.innerHTML += `
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="programs[]" value="${program}" required>
                                        ${program}
                                    </label>
                                </div>
                            `;
                        });
                    } else {
                        alert('Failed to load programs. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error); // Log error for debugging
                    alert('Something went wrong. Please try again.');
                });
            }

            addProgramsBtn.onclick = function() {
                var form = document.getElementById('programsForm');
                var selectedPrograms = form.querySelectorAll('input[name="programs[]"]:checked');

                if (selectedPrograms.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select at least one program to add.',
                        confirmButtonText: 'OK'
                    });
                    return; // Exit the function if no programs are selected
                }

                var formData = new FormData(form);

                fetch('add_programs.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire(
                            'Success!',
                            'Programs added successfully.',
                            'success'
                        ).then(() => {
                            loadPrograms(); // Reload programs after adding
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error); // Log error for debugging
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                });
            }

            // Initial load of programs
            loadPrograms();
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.side-menu');
    const toggleButton = document.querySelector('.toggle-sidebar'); // Adjust selector as needed

    toggleButton.addEventListener('click', function() {
        if (sidebar.classList.contains('collapsed')) {
            sidebar.classList.remove('collapsed');
            sidebar.classList.add('expanded');
        } else {
            sidebar.classList.remove('expanded');
            sidebar.classList.add('collapsed');
        }
    });
});
</script>
<script src="script.js"></script>
</body>
</html>