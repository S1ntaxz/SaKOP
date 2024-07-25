<?php
// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- header section starts -->
<header class="header_section">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
      <!-- Logo with title -->
      <a class="navbar-brand" href="index.php">
        <img src="./images/muni.png" alt="Logo" width="80" height="80" class="d-inline-block align-top" loading="lazy">
        <div>
          <span class="brand-text">Sangguniang Kabataan</span><br>
          <span class="sub-text">Municipality of Nasugbu</span>
        </div>
      </a>

      <!-- Toggle button for mobile -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="about.php"> About</a>
          </li>
          <li class="nav-item <?php echo ($current_page == 'blogs.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="blogs.php">News</a>
          </li>
          <li class="nav-item <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
        </ul>

        <!-- User options -->
        <div class="user_optio_box">
          <a href="login.php" target="_blank">
            <i class="fa fa-user" aria-hidden="true" style="font-size: 2em;"></i>
          </a>
        </div>
      </div>
    </nav>
  </div>
</header>
<!-- end header section -->
