<?php
session_start();
date_default_timezone_set('Asia/Manila');

// Ensure the method is POST and the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $sk_chairman_id = $_POST['sk_chairman_id'];

    // Validate and sanitize inputs
    $amount = filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    // File upload handling
    $receiptContent = null;

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
        // Check file size (optional)
        if ($_FILES['receipt']['size'] <= 5 * 1024 * 1024) { // 5MB limit
            // Read file content into a variable
            $receiptContent = file_get_contents($_FILES['receipt']['tmp_name']);
        } else {
            echo "File is too large.";
            exit();
        }
    }

    // Database connection parameters
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'sakoplogin';

    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if SK chairman is logged in
    if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
        // Insert transaction into database
        $current_date = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO transactions (sk_chairman_id, amount, description, receipt_content, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $sk_chairman_id, $amount, $description, $receiptContent, $current_date);

        if ($stmt->execute()) {
            // Update remaining budget in database
            $stmt_budget = $conn->prepare("UPDATE budget_info SET remaining_budget = remaining_budget - ? WHERE sk_chairman_id = ?");
            $stmt_budget->bind_param("di", $amount, $sk_chairman_id);

            if ($stmt_budget->execute()) {
                echo "Transaction added successfully.";
                header("Location: SKBudget.php");
                exit();
            } else {
                echo "Error updating budget: " . $stmt_budget->error;
            }
        } else {
            echo "Error inserting transaction: " . $stmt->error;
        }

        $stmt->close();
        $stmt_budget->close();
    } else {
        echo "Please log in to add a transaction.";
    }

    // Close connection
    $conn->close();
}
?>
