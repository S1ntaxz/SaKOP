<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="head.png" type="image/x-icon">
    <title>SaKOP</title>
</head>
<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <?php include 'sidebar.php'; ?>
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
                    <h1>Program Status</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Federation</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Program Status</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Programs Table -->
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Programs</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Barangay</th>
                                <th>Program Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="programsContainer">
                            <!-- Programs will be dynamically loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->

    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const programsContainer = document.getElementById("programsContainer");

            function loadPrograms() {
                fetch('getskprograms.php')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Received data:', data); // Debugging line
                        if (data.status === 'success') {
                            populatePrograms(data.programs);
                        } else {
                            showAlert('error', 'Error', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        showAlert('error', 'Error', 'Something went wrong. Please try again.');
                    });
            }

            function populatePrograms(programs) {
                programsContainer.innerHTML = ''; // Clear existing programs
                programs.forEach(program => {
                    programsContainer.innerHTML += `
                        <tr>
                            <td>${program.barangay || 'N/A'}</td>
                            <td>${program.program_name || 'No Name'}</td>
                            <td>${program.status || 'N/A'}</td>
                        </tr>
                    `;
                });
            }

            function showAlert(type, title, text) {
                Swal.fire({
                    icon: type,
                    title: title,
                    text: text,
                    confirmButtonText: 'OK'
                });
            }

            // Load programs when the page loads
            loadPrograms();
        });
    </script>
</body>
</html>
