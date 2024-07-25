<?php
session_start();
date_default_timezone_set('Asia/Manila');
// Check if the user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['userid'])) {
    echo "Please log in to edit the budget.";
    exit();
}

// Ensure the method is POST and the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newBudget = $_POST['editBudget'];
    $skChairmanId = $_POST['sk_chairman_id'];

    // Validate and sanitize inputs
    $newBudget = filter_var($newBudget, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Database connection parameters
    $db_host = 'localhost';  // Database host
    $db_user = 'root';       // Database username
    $db_pass = '';           // Database password
    $db_name = 'sakoplogin'; // Database name

    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update budget information
        $sqlUpdateBudget = "UPDATE budget_info SET remaining_budget = ? WHERE sk_chairman_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdateBudget);
        $stmtUpdate->bind_param("di", $newBudget, $skChairmanId);

        if (!$stmtUpdate->execute()) {
            throw new Exception("Error updating budget: " . $stmtUpdate->error);
        }

        // Insert into transactions_history
        $current_date = date('Y-m-d H:i:s');
        $amount = $newBudget; // Use the new budget amount
        $description = "Budget updated";
        $sqlInsertTransaction = "INSERT INTO transactions_history (sk_chairman_id, amount, description, date) 
                                VALUES (?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsertTransaction);
        $stmtInsert->bind_param("idss", $skChairmanId, $amount, $description, $current_date);

        if (!$stmtInsert->execute()) {
            throw new Exception("Error inserting transaction history: " . $stmtInsert->error);
        }

        // Commit transaction
        $conn->commit();
        echo "Budget updated and transaction history recorded successfully.";

        // Redirect to SKBudget.php or handle response
        header("Location: SKBudget.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction if there was an error
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    } finally {
        // Close connections
        $stmtUpdate->close();
        $stmtInsert->close();
        $conn->close();
    }
}
?>
