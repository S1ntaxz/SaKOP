<?php
include 'db_config.php';

$conn = connectDB(); 
// Fetch the count of documents
$sql_documents = "SELECT COUNT(*) as document_count FROM documents";
$result_documents = $conn->query($sql_documents);
$documentCount = ($result_documents->num_rows > 0) ? $result_documents->fetch_assoc()['document_count'] : 0;

// Fetch the count of SK Chairman
$sql_skchairman = "SELECT COUNT(*) as skchairman_count FROM skchairman";
$result_skchairman = $conn->query($sql_skchairman);
$skchairmanCount = ($result_skchairman->num_rows > 0) ? $result_skchairman->fetch_assoc()['skchairman_count'] : 0;

// Fetch the remaining budget (assuming it represents total sales)
$sql_kkmembers = "SELECT COUNT(*) as kkmembers_count FROM kk_members";
$result_kkmembers = $conn->query($sql_kkmembers);
$kkmemberscount = ($result_kkmembers->num_rows > 0) ? $result_kkmembers->fetch_assoc()['kkmembers_count'] : 0;

$conn->close();
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
	<?php include 'sidebar.php'?>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'topbar.php'?>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Welcome SK Federation!</h1>
					<p>Municipality of Nasugbu</p>
					<ul class="breadcrumb">
						<li>
							<a href="#">SK Federation</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Dashboard</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <h3><?php echo $documentCount; ?></h3>
                <p>Uploaded Documents</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3><?php echo $skchairmanCount; ?></h3>
                <p>SK Chairman</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3> <?php echo $kkmemberscount; ?></h3>
                <p>Total KK Members</p>
            </span>
        </li>
    </ul>


			
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>