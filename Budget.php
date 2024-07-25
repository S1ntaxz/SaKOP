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
                    <h1>Budget Status</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Federation</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Budget Status</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- All Transactions Table -->
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Barangay Budget Status</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Barangay</th>
                                <th>Remaining Budget</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include database configuration file
                            include 'db_config.php';

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch barangay, remaining budget and last updated date
                            $sql = "SELECT skchairman.barangay, budget_info.remaining_budget, budget_info.updated_at 
                                    FROM budget_info 
                                    JOIN skchairman ON budget_info.sk_chairman_id = skchairman.id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['barangay'] . "</td>";
                                    echo "<td>₱ " . number_format($row['remaining_budget'], 2) . "</td>";
                                    echo "<td>" . $row['updated_at'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No budget information available</td></tr>";
                            }

                            // Close connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->

    </section>
    <!-- CONTENT -->

    <!-- Modal for receipt -->
    <div id="receiptModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img class="modal-image" id="receiptImage" src="" alt="Receipt Image">
        </div>
    </div>

    <script>
        // Get modal elements
        var modal = document.getElementById("receiptModal");
        var modalImg = document.getElementById("receiptImage");
        var span = document.getElementsByClassName("close")[0];

        // Function to open the modal
        function openModal(receipt) {
            modal.style.display = "block";
            modalImg.src = receipt;
        }

        // Close the modal when the user clicks on <span> (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks anywhere outside of the modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Add event listeners to the view receipt buttons
        document.querySelectorAll('.view-receipt').forEach(button => {
            button.addEventListener('click', function() {
                var receipt = this.closest('tr').getAttribute('data-receipt');
                if (receipt) {
                    openModal(receipt);
                } else {
                    alert('No receipt available for this transaction.');
                }
            });
        });

        // Function to open receipt in a new window using the provided API
        function openNewWindow(filePath, options) {
            // Replace with actual API call to open new window with the receipt
            // Example: window.open(filePath, '_blank');
            alert('Opening receipt in a new window: ' + filePath);
        }
    </script>
    <script src="script.js"></script>
</body>
</html>
