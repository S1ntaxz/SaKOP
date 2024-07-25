<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
    <!-- Existing head content -->
    <link rel="icon" href="head.png" type="image/x-icon">
    <title>SaKOP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
</head>

</head>
<body>


	 <!-- SIDEBAR -->
     <section id="sidebar">
    <?php include 'sidebar2.php'?>
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
            <h1>Document Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">SK Chairman</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Document Management</a>
                </li>
            </ul>
        </div>
        <a href="SKdocuadd.php" class="btn-download" id="addMemberBtn">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">My Documents</span>
                </a>
    </div>

    <!--<div class="upload-section">
    <h3>Upload Document</h3>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Choose file to upload:</label>
            <input type="file" id="file" name="file" required>
        </div>
        <div class="form-group">
            <label for="docName">Document Name:</label>
            <input type="text" id="docName" name="docName" placeholder="Enter document name" required>
        </div>
        <button type="submit" name="submit" class="btn-upload">Upload</button>
    </form>
</div>-->

<style>
    .upload-section {
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 20px;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .upload-section h3 {
        color: #333;
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    input[type="file"],
    input[type="text"] {
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1em;
    }

    button.btn-upload {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button.btn-upload:hover {
        background-color: #0056b3;
    }
</style>



    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Available Documents</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Upload Date</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch_documents.php'; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('upload') === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Document uploaded successfully!',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('upload') === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Document uploaded successfully!',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>