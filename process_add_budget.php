<?php
session_start();
date_default_timezone_set('Asia/Manila');
$db_host = 'localhost';  // Database host
$db_user = 'root';       // Database username
$db_pass = '';           // Database password
$db_name = 'sakoplogin'; // Database name

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['userid'])) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $budgetAmount = mysqli_real_escape_string($conn, $_POST['newBudget']);
    $sk_chairman_id = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $description = empty($budgetId) ? "Budget Added" : "Budget Edited";

    if (empty($budgetId)) {
        // Insert new budget
        $sql = "INSERT INTO budget_info (remaining_budget, sk_chairman_id) VALUES ('$budgetAmount', '$sk_chairman_id')";
    } else {
        // Update existing budget
        $sql = "UPDATE budget_info SET remaining_budget='$budgetAmount' WHERE id='$budgetId' AND sk_chairman_id='$sk_chairman_id'";
    }

    if ($conn->query($sql) === TRUE) {
        // Insert into history
        $historySql = "INSERT INTO transactions_history (sk_chairman_id, type, amount, description) VALUES ('$sk_chairman_id', 'edit', '$budgetAmount', '$description')";
        $conn->query($historySql);
        echo "Budget updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header('Location: SKBudget.php');
    exit();
} else {
    echo "Unauthorized access.";
}
?>
