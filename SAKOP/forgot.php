<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="./images/muni.png" type="image/gif" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    .bg {
      background-image: url('./images/bg.jpg');
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
              <h3 class="text-center">Forgot Password</h3>
              <h6 class="text-center">Enter your email to reset your password</h6>
              <form action="forgot_password.php" method="POST">
                <div class="form-group">
                  <input type="email" class="form-control transparent" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" class="btn btn-block" style="background-color: #30334e; color: white;">Submit</button>
                <a href="login.php" class="d-block text-center mt-2" style="color: #30334e;">Back to Login</a>
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