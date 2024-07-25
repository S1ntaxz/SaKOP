<?php
session_start();
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
                            <a href="#">Budget Allocation</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Transactions History</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Remaining Budget Card -->
            
            <!-- Recent Transactions Table -->
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Transaction History</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $db_host = 'localhost';
                        $db_user = 'root';
                        $db_pass = '';
                        $db_name = 'sakoplogin';

                        // Check if SK chairman is logged in
                        if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
                            $conn_history = new mysqli($db_host, $db_user, $db_pass, $db_name);

                            // Check connection
                            if ($conn_history->connect_error) {
                                die("Connection failed: " . $conn_history->connect_error);
                            }

                            $userid = mysqli_real_escape_string($conn_history, $_SESSION['userid']);
                            $sql_history = "SELECT date, description, type, amount FROM transactions_history WHERE sk_chairman_id='$userid' ORDER BY date DESC";
                            $result_history = $conn_history->query($sql_history);

                            if ($result_history->num_rows > 0) {
                                while ($row_history = $result_history->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row_history['date'] . "</td>";
                                    echo "<td>" . $row_history['description'] . "</td>";
                                    echo "<td>₱ " . number_format($row_history['amount'], 2) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No transaction history found</td></tr>";
                            }

                            $conn_history->close();
                        } else {
                            echo "<tr><td colspan='4'>Please log in to view transaction history.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </main>
            <!-- MAIN -->
    
        </section>
        
    </body>
    </html>
    
                           

