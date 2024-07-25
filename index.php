<?php include 'logo.php'; ?>

<body>
  <div class="hero_area">
    <?php include 'header.php'; ?>
    <!-- slider section -->
    <section class="slider_section">
      <div class="slider_bg_box">
        <img src="./images/bg.jpg" alt="">
      </div>
    </section>
    <!-- end slider section -->
  </div>

  <!-- service section -->
  <section class="service_section">
    <div class="container-fluid">
      <div class="row">
        <!-- Service content here -->
        <div class="col-md-6 col-lg-3">
          <div class="box">
            <div class="img-box">
              <img src="./images/services-icon.png" alt="">
            </div>
            <div class="detail-box">
              <h5>Good Governance</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="box">
            <div class="img-box">
              <img src="./images/24.png" alt="">
            </div>
            <div class="detail-box">
              <h5>No No Sleep</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="box">
            <div class="img-box">
              <img src="./images/quality.png" alt="">
            </div>
            <div class="detail-box">
              <h5>Quality Service</h5>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="box">
            <div class="img-box">
              <img src="./images/transparent.png" alt="">
            </div>
            <div class="detail-box">
              <h5>Transparency</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end service section -->


  <!-- Banner -->
  <div class = "Banner">
    <img src="./images/banner.jpg" alt="Banner">
  </div>

  <!-- service section -->
<section class="service_section">
  <div class="container-fluid">
      <h5 class="text-center heading-large" style="margin-top: 50px;">Government News Sources</h5>
    <div class="row justify-content-center">
      <!-- Service content here -->
      <div class="col-md-6 col-lg-3 d-flex justify-content-center">
        <div class="box text-center">
          <a href="https://pia.gov.ph/" target="_blank" class="img-box2">
            <img src="./images/PhilippineNewsAgency.png" alt="Philippine News Agency Logo">
          </a>
          <div class="detail-box">
            <h5>Philippines News Agency</h5>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 d-flex justify-content-center">
        <div class="box text-center">
          <a href="https://covid19.gov.ph/information/covid-19-news-and-updates" target="_blank" class="img-box2">
            <img src="./images/LagingHanda.png" alt="Laging Handa Logo">
          </a>
          <div class="detail-box">
            <h5>COVID-19 News Page (Presidential Communications Operations Office)</h5>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 d-flex justify-content-center">
        <div class="box text-center">
          <a href="https://www.pna.gov.ph/" target="_blank" class="img-box2">
            <img src="./images/PIA-1.png" alt="Philippine Information Agency Logo">
          </a>
          <div class="detail-box">
            <h5>Philippine Information Agency</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end service section -->



  <?php include 'footer.php'; ?>
  <?php include 'team.php'; ?>

  <!-- Back to Top Button -->
  <button id="back-to-top-btn"><i class="fas fa-arrow-up"></i></button>

  <!-- jQuery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- Bootstrap JS -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- Custom JS -->
  <script type="text/javascript" src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->

  <!-- Back to Top JS -->
  <script>
    // Show or hide the "Back to Top" button
    window.onscroll = function() {
      let backToTopBtn = document.getElementById('back-to-top-btn');
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopBtn.style.display = 'block';
      } else {
        backToTopBtn.style.display = 'none';
      }
    };

    // Scroll to the top when the button is clicked
    document.getElementById('back-to-top-btn').addEventListener('click', function() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    });
  </script>
</body>
</html>
