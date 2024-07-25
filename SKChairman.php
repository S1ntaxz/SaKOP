<?php
// Include the database configuration file
include 'db_config.php';

// Establish database connection
$conn = connectDB();

// Initialize search and pagination variables
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Prepare search query
$searchQuery = $search ? "WHERE firstname LIKE '%$search%' OR middlename LIKE '%$search%' OR lastname LIKE '%$search%' OR barangay LIKE '%$search%'" : '';

// Query to fetch total number of records
$totalResult = $conn->query("SELECT COUNT(*) as total FROM skchairman $searchQuery");
$totalRecords = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Query to fetch data with search and pagination
$sql = "SELECT * FROM skchairman $searchQuery LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Function to calculate age from birthday
function calculateAge($birthday) {
    $birthDate = new DateTime($birthday);
    $today = new DateTime('today');
    $age = $today->diff($birthDate)->y;
    return $age;
}

// Fetch barangays that are not already in the database
function fetchAvailableBarangays($conn, $currentBarangay = null) {
    $allBarangays = [
        "Aga", "Balaytigue", "Balok-Balok", "Banilad", "Barangay 1", "Barangay 2", "Barangay 3", "Barangay 4", "Barangay 5", "Barangay 6", "Barangay 7", "Barangay 8", "Barangay 9", "Barangay 10", "Barangay 11", "Barangay 12", "Bilaran", "Bucana", "Bulihan", "Bunducan", "Butucan", "Calayo", "Catandaan", "Cogunan", "Dayap", "Kayrilaw", "Kaylaway", "Latag", "Looc", "Lumbangan", "Malapad Na Bato", "Mataas Na Pulo", "Maugat", "Munting Indang", "Natipuan", "Pantalan", "Papaya", "Putat", "Reparo", "Talangan", "Tumalim", "Utod", "Wawa"
    ];
   
    $sql = "SELECT DISTINCT barangay FROM skchairman";
    $result = $conn->query($sql);
   
    $existingBarangays = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $existingBarangays[] = $row['barangay'];
        }
    }
   
    // Remove the current barangay from the list if it exists
    if ($currentBarangay !== null) {
        $existingBarangays = array_filter($existingBarangays, function($barangay) use ($currentBarangay) {
            return $barangay !== $currentBarangay;
        });
    }
   
    return array_diff($allBarangays, $existingBarangays);
}

function fetchChairmanDetails($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM skchairman WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Check if ID is passed and set
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $chairmanId = intval($_GET['id']); // Ensure the ID is an integer
    // Fetch the current SK Chairman details
    $currentChairman = fetchChairmanDetails($conn, $chairmanId);

    // Check if the currentChairman is fetched successfully
    if ($currentChairman) {
        $currentFirstname = $currentChairman['firstname'];
        $currentMiddlename = $currentChairman['middlename'];
        $currentLastname = $currentChairman['lastname'];
        $currentBirthday = $currentChairman['birthday'];
        $currentAddress = $currentChairman['address'];
        $currentMaritalStatus = $currentChairman['marital_status'];
        $currentBarangay = $currentChairman['barangay'];
        $currentContactNumber = $currentChairman['contact_number'];
        $currentEmail = $currentChairman['email'];
        $currentGender = $currentChairman['gender'];
    } else {
        // Handle error - chairman not found
        $currentFirstname = $currentMiddlename = $currentLastname = '';
        $currentBirthday = $currentAddress = $currentMaritalStatus = '';
        $currentBarangay = $currentContactNumber = $currentEmail = '';
        $currentGender = '';
    }
} else {
    // Handle error - ID not provided
    $chairmanId = 0; // or handle as needed
    $currentFirstname = $currentMiddlename = $currentLastname = '';
    $currentBirthday = $currentAddress = $currentMaritalStatus = '';
    $currentBarangay = $currentContactNumber = $currentEmail = '';
    $currentGender = '';
}

// Fetch available barangays
$availableBarangays = fetchAvailableBarangays($conn);

// Fetch marital statuses
$maritalStatuses = ['Single', 'Married', 'Widowed', 'Separated'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="head.png" type="image/x-icon">
    <title>SaKOP</title>
   
    <style>
        /* Additional styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px; /* Adjust as needed */
        }

        .close {
            color: #aaaaaa;
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

        .btn-group {
            margin-top: 20px;
            text-align: right;
        }

        .btn-group button {
            margin-left: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ddd;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
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
                    <h1>SK Chairman</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">SK Federation</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">SK Chairman</a>
                        </li>
                    </ul>
                </div>
                <a href="add_sk_interface.php" class="btn-download" id="addMemberBtn">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Add Member</span>
                </a>
            </div>

            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by name or barangay..." class="form-control" value="<?php echo htmlspecialchars($search); ?>">
            </div>

            <div class="table-data">
                <div class="order">
                    <table id="skChairmanTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Barangay</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr data-id="<?php echo $row['id']; ?>"
                                data-firstname="<?php echo htmlspecialchars($row['firstname']); ?>"
                                data-middlename="<?php echo htmlspecialchars($row['middlename']); ?>"
                                data-lastname="<?php echo htmlspecialchars($row['lastname']); ?>"
                                data-birthday="<?php echo htmlspecialchars($row['birthday']); ?>"
                                data-address="<?php echo htmlspecialchars($row['address']); ?>"
                                data-marital_status="<?php echo htmlspecialchars($row['marital_status']); ?>"
                                data-barangay="<?php echo htmlspecialchars($row['barangay']); ?>"
                                data-contact_number="<?php echo htmlspecialchars($row['contact_number']); ?>"
                                data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                data-gender="<?php echo htmlspecialchars($row['gender']); ?>">
                                <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($row['middlename']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($row['barangay']); ?></td>
                                <td>
                                    <!--<a href="javascript:void(0)" class="edit" title="Edit" data-id="<?php echo $row['id']; ?>"><i class='bx bxs-edit'></i></a>-->
                                    <a href="delete_member.php?id=<?php echo $row['id']; ?>" class="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this member?');"><i class='bx bxs-trash'></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <!-- EDIT MODAL -->
    <div id="editMemberModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Member</h2>
            <form id="editMemberForm">
                <input type="hidden" id="editId" name="id">
                <div class="form-group">
                    <label for="editFirstname">First Name</label>
                    <input type="text" id="editFirstname" name="firstname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editMiddlename">Middle Name</label>
                    <input type="text" id="editMiddlename" name="middlename" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editLastname">Last Name</label>
                    <input type="text" id="editLastname" name="lastname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editBirthday">Birthday</label>
                    <input type="date" id="editBirthday" name="birthday" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editAddress">Address</label>
                    <input type="text" id="editAddress" name="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editGender">Gender</label>
                    <select id="editGender" name="gender" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editMaritalStatus">Marital Status</label>
                    <select id="editMaritalStatus" name="marital_status" class="form-control" required>
                        <?php foreach ($maritalStatuses as $status): ?>
                            <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editBarangay">Barangay</label>
                    <select id="editBarangay" name="barangay" class="form-control" required>
                        <?php foreach ($availableBarangays as $barangay): ?>
                            <option value="<?php echo $barangay; ?>"><?php echo $barangay; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editContactNumber">Contact Number</label>
                    <input type="tel" id="editContactNumber" name="contact_number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="editGender">Gender</label>
                    <select id="editGender" name="gender" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    <!-- EDIT MODAL -->

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editMemberModal = document.getElementById('editMemberModal');
            const editMemberForm = document.getElementById('editMemberForm');
            const closeModal = document.querySelector('.close');
            const cancelEditBtn = document.getElementById('cancelBtn');
            const skChairmanTable = document.getElementById('skChairmanTable');
            const searchInput = document.getElementById('searchInput');

            let timerId; // Timer ID for debounce

            // Function to handle search input change
            function handleSearchInput() {
                clearTimeout(timerId); // Clear previous timer
                timerId = setTimeout(performSearch, 500); // Set a new timer for 500ms delay
            }

            // Function to perform search
            function performSearch() {
                const searchValue = searchInput.value.trim();
                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
                const url = `?search=${searchValue}&page=${currentPage}`;
                window.location.href = url;
            }

            // Event listener for table row click (unchanged from original code)
            skChairmanTable.addEventListener('click', function (e) {
                const target = e.target.closest('tr');
                if (target) {
                    document.getElementById('editId').value = target.dataset.id;
                    document.getElementById('editFirstname').value = target.dataset.firstname;
                    document.getElementById('editMiddlename').value = target.dataset.middlename;
                    document.getElementById('editLastname').value = target.dataset.lastname;
                    document.getElementById('editBirthday').value = target.dataset.birthday;
                    document.getElementById('editAddress').value = target.dataset.address;
                    document.getElementById('editMaritalStatus').value = target.dataset.marital_status;
                    document.getElementById('editBarangay').value = target.dataset.barangay;
                    document.getElementById('editContactNumber').value = target.dataset.contact_number;
                    document.getElementById('editEmail').value = target.dataset.email;
                    document.getElementById('editGender').value = target.dataset.gender;

                    editMemberModal.style.display = 'block';
                }
            });

            // Event listener for closing the modal (unchanged from original code)
            closeModal.addEventListener('click', function () {
                editMemberModal.style.display = 'none';
            });

            // Event listener for cancelling edit (unchanged from original code)
            cancelEditBtn.addEventListener('click', function () {
                editMemberModal.style.display = 'none';
            });

            // Event listener for submitting the edit form (unchanged from original code)
            editMemberForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(editMemberForm);
                fetch('update_member.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', 'SK Chairman details updated successfully', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'Failed to update SK Chairman details', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An error occurred while updating the SK Chairman details', 'error');
                });
            });

            // Event listener for search input (auto-trigger search on input change)
            searchInput.addEventListener('input', handleSearchInput);
        });
    </script>
    <!-- SCRIPTS -->

    <script src="script.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>