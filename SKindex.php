<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script

// Check if SK chairman is logged in
if (isset($_SESSION['email']) && isset($_SESSION['userid'])) {
    // Establish database connection
    $conn = connectDB();

    // Check if connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize user ID from session
    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);

    // Fetch barangay
    $sql_chairmans = "SELECT barangay FROM skchairman WHERE id='$userid'";
    $result_chairmans = $conn->query($sql_chairmans);

    if ($result_chairmans->num_rows == 1) {
        $row_chairmans = $result_chairmans->fetch_assoc();
        $barangay = $row_chairmans['barangay'];
    } else {
        // Default to a known barangay if not found
        $barangay = "Default Barangay";
    }

    // Fetch chairman's details
    $sql_chairman = "SELECT firstname, address FROM skchairman WHERE id='$userid'";
    $result_chairman = $conn->query($sql_chairman);

    if ($result_chairman->num_rows == 1) {
        // Fetch chairman's details
        $row_chairman = $result_chairman->fetch_assoc();
        $firstname = $row_chairman['firstname'];
        $address = $row_chairman['address'];
    } else {
        // Chairman not found (unlikely scenario if userid is valid)
        $firstname = "Unknown";
        $address = "Unknown";
    }

    // Query to count KK members by age groups
    $sql_child_youth = "SELECT COUNT(*) as count FROM kk_members WHERE sk_chairman_id = '$userid' AND TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 15 AND 17";
    $result_child_youth = $conn->query($sql_child_youth);
    $child_youth_count = ($result_child_youth->num_rows > 0) ? $result_child_youth->fetch_assoc()['count'] : 0;

    $sql_core_youth = "SELECT COUNT(*) as count FROM kk_members WHERE sk_chairman_id = '$userid' AND TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 18 AND 24";
    $result_core_youth = $conn->query($sql_core_youth);
    $core_youth_count = ($result_core_youth->num_rows > 0) ? $result_core_youth->fetch_assoc()['count'] : 0;

    $sql_young_adult = "SELECT COUNT(*) as count FROM kk_members WHERE sk_chairman_id = '$userid' AND TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 25 AND 30";
    $result_young_adult = $conn->query($sql_young_adult);
    $young_adult_count = ($result_young_adult->num_rows > 0) ? $result_young_adult->fetch_assoc()['count'] : 0;

    $conn->close();
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
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
                    <h1>Welcome SK Chairman <?php echo $firstname; ?>!</h1>
                    <p>Barangay <?php echo $barangay; ?>, Nasugbu, Batangas</p>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Chairman</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3><?php echo $child_youth_count; ?></h3>
                <p>Child Youth</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3><?php echo $core_youth_count; ?></h3>
                <p>Core Youth</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3> <?php echo $young_adult_count; ?></h3>
                <p>Young Adult</p>
            </span>
        </li>
    </ul>

            <!-- Other content here -->

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="script.js"></script>
</body>
</html>
