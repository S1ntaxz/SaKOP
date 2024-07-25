<?php
session_start();
include 'db_config.php'; // Ensure this includes your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Establish database connection
    $conn = connectDB();

    // Check if connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Sanitize password input

    // Query the users table for the admin
    $sql_user = "SELECT * FROM users WHERE email='$email'";
    $result_user = $conn->query($sql_user);

    // Query the skchairman table for the chairman using email
    $sql_chairman = "SELECT * FROM skchairman WHERE email='$email'";
    $result_chairman = $conn->query($sql_chairman);

    if ($result_user->num_rows == 1) {
        // User found in users table, verify password
        $row_user = $result_user->fetch_assoc();
        $stored_password_user = $row_user['password']; 
        if ($password === $stored_password_user) {
            // Password is correct, set session variables
            $_SESSION['email'] = $email;
            header("Location: dashboard.php"); // Redirect to welcome page for admin
            exit();
        } else {
            // Invalid password for admin
            echo "Invalid username or password";
        }
    } elseif ($result_chairman->num_rows == 1) {
        // User found in skchairman table, verify password
        $row_chairman = $result_chairman->fetch_assoc();
        $stored_password_chairman = $row_chairman['password']; 
        
        // Check if password matches (assuming it's plaintext, you should hash it before storing in the future)
        if ($password === $stored_password_chairman) {
            // Convert plaintext password to hash and update the database
           
            // Password is correct, set session variables
            $_SESSION['email'] = $email;
            $_SESSION['userid'] = $row_chairman['id'];

            header("Location: SKindex.php"); // Redirect to SKChairman page for chairman
            exit();
        } else {
            // Invalid password for chairman
            echo "Invalid username or password";
        }
    } else {
        // User not found in either table
        echo "User not found";
    }

    $conn->close();
}
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="head.png" type="image/x-icon">
	<title>SaKOP</title>
    <style>
        body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        }
        .card {
        background-color: rgba(255, 255, 255, 0.8);
        color: #30334e;
        border: 1px solid rgba(48, 51, 78, 0.8);
        }
        .card-footer a {
        color: #30334e;
        }
        .bg {
        background-image: url('skbackground.jpg');
        height: 100%; 
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        }
        .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        }
        .form-control.transparent {
        background-color: rgba(255, 255, 255, 0.3);
        border: 1px solid rgba(48, 51, 78, 0.8);
        color: #30334e;
        }
        .form-control.transparent::placeholder {
        color: #30334e;
        }
        .content {
        padding-top: 80px;
        }
    </style>
    </head>
    <body>
    <div class="bg content">
        <div class="overlay"></div> 
        <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h3 class="text-center">Welcome!</h3>
                <h6 class="text-center">Sign in to your account</h6>
                <form action="login.php" method="POST">
                    <div class="form-group">
                    <input type="email" class="form-control transparent" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control transparent" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-block" style="background-color: #30334e; color: white;">Submit</button>
                    <a href="forgot_password.php" class="d-block text-center mt-2" style="color: #30334e;">Forgot password?</a>
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
