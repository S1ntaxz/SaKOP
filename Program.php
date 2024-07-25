<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
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
                    <h1>Program Recommendation</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">SK Federation</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Program Recommendation</a></li>
                    </ul>
                </div>
            </div>
            <!-- Program Container -->
            <div id="programsContainer">
                <!-- Programs will be dynamically loaded here -->
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include custom JavaScript -->
    <script>
		document.addEventListener("DOMContentLoaded", function() {
    const programsContainer = document.getElementById("programsContainer");

    function loadPrograms() {
        fetch('get_programs.php')
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
                <div class="program-item">
                    <h3>${program.program_name || 'No Name'}</h3>
                    <p><strong>Start Date:</strong> ${program.date_started || 'N/A'}</p>
                    <p><strong>End Date:</strong> ${program.date_ended || 'N/A'}</p>
                    <p><strong>Description:</strong> ${program.program_name || 'N/A'}</p>
                    <p><strong>Barangay:</strong> ${program.barangay || 'N/A'}</p>
                </div>
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
