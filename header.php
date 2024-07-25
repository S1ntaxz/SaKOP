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
        
          <div class="user_option_box">
            <a href="login.php" target="_blank">
              <button style="font-size: 1em; padding: 10px 20px; background-color: transparent ; color: #0e5acd; border: 2px solid #007bff; border-radius: 5px; cursor: pointer;">
                Sign In
              </button>
            </a>
          </div>
        </ul>
      </div>
    </nav>
  </div>
</header>
<!-- end header section -->
<style>
  .navbar-nav .nav-item.active .nav-link {
    font-weight: bold;
    color: #007bff;
  }

  .navbar-nav .nav-link {
    padding: 0.5rem 1rem;
  }

  .user_optio_box {
    display: flex;
    align-items: center;
    margin-left: 20px;
  }

  .user_optio_box a {
    color: inherit;
    text-decoration: none;
  }

  .user_optio_box i.fa-user {
    font-size: 2em;
  }

  .collapse.navbar-collapse {
    margin-left: 500px;
  }
  .box {
  border: 1px solid #ddd;
  padding: 15px;
  text-align: center;
  transition: transform 0.3s;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.box:hover {
  transform: scale(1.05);
}

.img-box2 img {
  max-width: 100%;
  height: auto;
}

.detail-box h5 {
  margin-top: 10px;
  font-size: 1.2em;
  font-weight: bold;
}

.heading-large {
  font-size: 2em;
  font-weight: bold;
}

.carousel-item img {
  margin-top: 140px;
  width: 70%;
  height: 350px; /* Adjust the height as needed */
  object-fit: cover; /* This ensures the image covers the area without distortion */
}
.slider_section .carousel-inner {
  text-align: center;
}


.detail-box {
  display: flex;
  align-items: center; /* Center items vertically */
  justify-content: center; /* Center items horizontally */
  flex-direction: row; /* Align items horizontally */
  gap: 20px; /* Space between image and text */
}

.detail-box img {
  width: 50%; /* Adjust the width of the image as needed */
  height: auto; /* Maintain aspect ratio */
  max-height: 400px; /* Set a max height for the image */
  object-fit: cover; /* Ensure the image covers the area without distortion */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Adds a subtle shadow to the images */
}

.detail-box p {
  background: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
  color: #fff; /* White text color */
  padding: 10px 15px;
  border-radius: 5px;
  max-width: 50%; /* Adjust width to fit beside the image */
  text-align: left; /* Left-align the text for readability */
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Adds a dark shadow to the text */
}


.Banner {
  width: 105%; /* Full width of the parent container */
  overflow: hidden; /* Hide any overflow from the image */
}

.Banner img {
  width: 100%; /* Stretch the image to full width */
  height: auto; /* Maintain aspect ratio */
  display: block; /* Remove any extra space below the image */
}

.about_section {
  padding: 60px 0;
  background-color: #f8f9fa; /* Light background color for contrast */
}

.about_section .container {
  max-width: 1000px;
  margin: 0 auto;
}

.about_section h2 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #333; /* Dark text color for better readability */
}

.about_image img {
  width: 100%; /* Ensure the image is responsive */
  height: auto; /* Maintain aspect ratio */
  border-radius: 8px; /* Rounded corners */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for a lifting effect */
}

.about_content {
  padding-left: 20px;
}

.about_content p {
  font-size: 1rem;
  line-height: 1.6;
  color: #555; /* Slightly lighter text color */
  margin-bottom: 20px;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.news_box {
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 20px;
  background-color: #fff;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.news_image img {
  width: 100%;
  height: auto;
  object-fit: cover;
}

.news_content {
  padding: 15px;
}

.news_content h5 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}

.news_content h6 {
  margin: 5px 0;
  font-size: 16px;
  color: #555;
}

.news_content p {
  font-size: 14px;
  color: #333;
}


</style>