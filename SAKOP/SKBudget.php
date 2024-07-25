<?php
session_start();

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'sakoplogin';

// Establish database connection
$conn_recent = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn_recent->connect_error) {
    die("Connection failed: " . $conn_recent->connect_error);
}

// Check if SK chairman is logged in
if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    $userid = mysqli_real_escape_string($conn_recent, $_SESSION['userid']);

    // Fetch recent transactions for the logged-in chairman
    $sql_recent = "SELECT id, date, description, amount, receipt_content FROM transactions WHERE sk_chairman_id='$userid' ORDER BY date DESC";
    $result_recent = $conn_recent->query($sql_recent);
} else {
    die("Please log in to view transaction history.");
}
?>
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
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: slide-down 0.3s ease-out;
        }

        @keyframes slide-down {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
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

        .modal-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Add Budget Form Styles */
        #addBudgetForm label,
        #addBudgetForm input,
        #addBudgetForm button {
            display: block;
            width: 100%;
            margin: 10px 0;
        }

        #addBudgetForm label {
            font-weight: bold;
        }

        #addBudgetForm input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #addBudgetForm button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #addBudgetForm button:hover {
            background-color: #218838;
        }

        .edit-budget-button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-budget-button:hover {
            background-color: #0056b3;
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
                    <h1>Budget Allocation</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Chairman</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Budget Allocation</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Remaining Budget Card -->
            <div class="budget-card">
                <h2>Remaining Budget</h2>
                <?php
                // Example PHP code to fetch and display remaining budget from database
                $db_host = 'localhost';  // Database host
                $db_user = 'root';       // Database username
                $db_pass = '';           // Database password
                $db_name = 'sakoplogin'; // Database name

                // Check if SK chairman is logged in
                if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
                    // Establish database connection
                    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch remaining budget
                    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);
                    $sql_budget = "SELECT id, remaining_budget, updated_at FROM budget_info WHERE sk_chairman_id='$userid'";
                    $result_budget = $conn->query($sql_budget);

                    if ($result_budget->num_rows > 0) {
                        $row = $result_budget->fetch_assoc();
                        $remaining_budget = $row['remaining_budget'];
                        echo "<p class='budget-amount'>₱ " . number_format($remaining_budget, 2) . "</p>"; // Display remaining budget
                        echo "<button class='edit-budget-button' id='editBudgetBtn'>Edit Budget</button>"; // Edit button
                    } else {
                        echo "<p>No budget information available</p>";
                        echo "<button id='addBudgetBtn'>Add Budget</button>";
                    }

                    // Close connection
                    $conn->close();
                } else {
                    echo "Please log in to view budget information.";
                }
                ?>
            </div>

            <!-- Transaction Form -->
            <div class="transaction-form">
                <h2>Add Transaction</h2>
                <form action="process_transaction.php" method="post" enctype="multipart/form-data">
    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" required>

    <label for="description">Description:</label>
    <input type="text" id="description" name="description" required>

    <label for="receipt">Attach Receipt:</label>
    <input type="file" id="receipt" name="receipt" accept="image/jpeg, image/png, image/gif">

    <input type="hidden" name="sk_chairman_id" value="<?php echo htmlspecialchars($_SESSION['userid']); ?>">
    

    <button type="submit">Add Transaction</button>
</form>

            </div>

            <!-- Recent Transactions Table -->
            <div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Transaction History</h3>
            <button id="viewHistoryBtn">View History</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Establish database connection for recent transactions
            $conn_recent = new mysqli($db_host, $db_user, $db_pass, $db_name);

            // Check connection
            if ($conn_recent->connect_error) {
                die("Connection failed: " . $conn_recent->connect_error);
            }

            // Fetch recent transactions for the logged-in chairman
            $userid = mysqli_real_escape_string($conn_recent, $_SESSION['userid']);
            $sql_recent = "SELECT id, date, description, amount, receipt_content FROM transactions WHERE sk_chairman_id='$userid' ORDER BY date DESC";
            $result_recent = $conn_recent->query($sql_recent);

            if ($result_recent->num_rows > 0) {
                while ($row_recent = $result_recent->fetch_assoc()) {
                    echo "<tr data-receipt-id='" . htmlspecialchars($row_recent['id']) . "'>";
                    echo "<td>" . htmlspecialchars($row_recent['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row_recent['description']) . "</td>";
                    echo "<td>₱ " . number_format($row_recent['amount'], 2) . "</td>";
                    echo "<td><button class='view-receipt'>View Receipt</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No transactions found</td></tr>";
            }

            // Close connection for recent transactions
            $conn_recent->close();
            ?>
            </tbody>
        </table>
    </div>
</div>


            <!-- Modal for receipt -->
<div id="receiptModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeReceipt">&times;</span>
        <img id="receiptImage" class="modal-image" src="" alt="Receipt Image">
    </div>
</div>

<!-- Modal for Add Budget -->
<!-- Add Budget Modal -->
<!-- Add Budget Modal -->
<div id="addBudgetModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeAddBudget">&times;</span>
        <h2>Add Budget</h2>
        <form id="addBudgetForm" action="process_add_budget.php" method="post">
            <label for="newBudget">Budget Amount:</label>
            <input type="number" id="newBudget" name="newBudget" placeholder="Enter budget amount" required>

            <!-- Hidden input field for SK Chairman ID -->
            <input type="hidden" id="skChairmanId" name="sk_chairman_id" value="<?php echo htmlspecialchars($_SESSION['userid']); ?>">

            <button type="submit">Submit</button>
        </form>
    </div>
</div>



<!-- Modal for Edit Budget -->
<!-- Edit Budget Modal -->
<div id="editBudgetModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeEditBudget">&times;</span>
        <h2>Edit Budget</h2>
        <form id="editBudgetForm" action="process_edit_budget.php" method="post">
            <label for="editBudget">New Budget Amount:</label>
            <input type="number" id="editBudget" name="editBudget" placeholder="Enter new budget amount" class="form-control" required>
            
            <!-- Hidden input field for budget ID -->
            <input type="hidden" id="budgetId" name="budgetId">

            <!-- Hidden input field for SK Chairman ID -->
            <input type="hidden" id="skChairmanId" name="sk_chairman_id" value="<?php echo htmlspecialchars($_SESSION['userid']); ?>">

            <button type="submit">Update</button>
        </form>
    </div>
</div>





            <!-- Modals (existing modals for receipt, add budget, and edit budget) -->
            <!-- ... -->
        </main>
    </section>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    var receiptModal = document.getElementById("receiptModal");
    var receiptImg = document.getElementById("receiptImage");
    var closeReceipt = document.getElementById("closeReceipt");
    var addBudgetModal = document.getElementById("addBudgetModal");
    var closeAddBudget = document.getElementById("closeAddBudget");
    var editBudgetModal = document.getElementById("editBudgetModal");
    var closeEditBudget = document.getElementById("closeEditBudget");
    var viewHistoryBtn = document.getElementById("viewHistoryBtn");

    // Function to open the receipt modal
    function openReceiptModal(receiptId) {
        fetch('fetch_receipt.php?id=' + receiptId)
            .then(response => response.blob())
            .then(blob => {
                var url = URL.createObjectURL(blob);
                receiptImg.src = url;
                receiptModal.style.display = "block";
            })
            .catch(error => console.error('Error fetching receipt:', error));
    }

    // Function to open the add budget modal
    function openAddBudgetModal() {
        addBudgetModal.style.display = "block";
    }

    // Function to open the edit budget modal
    function openEditBudgetModal() {
        editBudgetModal.style.display = "block";
    }

    // Close the modal when the user clicks on <span> (x)
    closeReceipt.onclick = function() {
        receiptModal.style.display = "none";
    }

    closeAddBudget.onclick = function() {
        addBudgetModal.style.display = "none";
    }

    closeEditBudget.onclick = function() {
        editBudgetModal.style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside of the modal content
    window.onclick = function(event) {
        if (event.target == receiptModal) {
            receiptModal.style.display = "none";
        }
        if (event.target == addBudgetModal) {
            addBudgetModal.style.display = "none";
        }
        if (event.target == editBudgetModal) {
            editBudgetModal.style.display = "none";
        }
    }

    // Add event listeners to the view receipt buttons
    document.querySelectorAll('.view-receipt').forEach(button => {
        button.addEventListener('click', function() {
            var receiptId = this.closest('tr').getAttribute('data-receipt-id');
            if (receiptId) {
                openReceiptModal(receiptId);
            } else {
                alert('No receipt available for this transaction.');
            }
        });
    });

    // Add event listener to the add budget button
    var addBudgetBtn = document.getElementById("addBudgetBtn");
    if (addBudgetBtn) {
        addBudgetBtn.addEventListener('click', function() {
            openAddBudgetModal();
        });
    }

    // Add event listener to the edit budget button
    var editBudgetBtn = document.getElementById("editBudgetBtn");
    if (editBudgetBtn) {
        editBudgetBtn.addEventListener('click', function() {
            openEditBudgetModal();
        });
    }

    // Add event listener to the view history button
    if (viewHistoryBtn) {
        viewHistoryBtn.addEventListener('click', function() {
            window.location.href = 'view_history.php';
        });
    }
});


    </script>
</body>
</html>