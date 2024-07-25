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

    <style>
        .search-container {
            margin: 20px;
            text-align: right;
        }

        #searchInput {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        /* Add any additional CSS for the table or modal as needed */
    </style>
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

            <!-- Search Bar -->
            <div class="search-container"> 
                <input type="text" id="searchInput" placeholder="Search Barangay" class="form-control">
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

                            // Pagination variables
                            $rows_per_page = 10;
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $offset = ($page - 1) * $rows_per_page;

                            // Fetch barangay, remaining budget and last updated date
                            $sql = "SELECT skchairman.barangay, budget_info.remaining_budget, budget_info.updated_at 
                                    FROM budget_info 
                                    JOIN skchairman ON budget_info.sk_chairman_id = skchairman.id
                                    LIMIT $offset, $rows_per_page";
                            $result = $conn->query($sql);

                            // Fetch total number of rows for pagination
                            $total_rows_sql = "SELECT COUNT(*) AS total FROM budget_info 
                                              JOIN skchairman ON budget_info.sk_chairman_id = skchairman.id";
                            $total_rows_result = $conn->query($total_rows_sql);
                            $total_rows = $total_rows_result->fetch_assoc()['total'];
                            $total_pages = ceil($total_rows / $rows_per_page);

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

            <!-- Pagination Controls -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>"<?php if ($i == $page) echo ' class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
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

        // Live search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var searchQuery = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('.table-data table tbody tr');

            tableRows.forEach(row => {
                var barangay = row.cells[0].textContent.toLowerCase();
                if (barangay.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <script src="script.js"></script>
</body>
</html>
