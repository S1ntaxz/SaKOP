<?php include 'logo.php'; ?>

<body class="sub_page">

  <div class="hero_area">
    <?php include 'header.php'; ?>
  </div>

  <!-- contact section -->
  <section class="contact_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>Contact Us</h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" placeholder="Your Name" />
              </div>
              <div>
                <input type="text" placeholder="Phone Number" />
              </div>
              <div>
                <input type="email" placeholder="Email" />
              </div>
              <div>
                <input type="text" class="message-box" placeholder="Message" />
              </div>
              <div class="btn_box">
                <button type="submit">SEND</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container">
            <div id="googleMap" style="width: 100%; height: 400px;"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end contact section -->

  <?php include 'footer.php'; ?>
  <?php include 'team.php'; ?>

  <!-- jQuery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- Custom JS -->
  <script type="text/javascript" src="js/custom.js"></script>
  <!-- Google Maps API -->
  <script>
    function myMap() {
      // Coordinates for the location you want to display
      var location = { lat: 14.074365544668689, lng: 120.63244228234939 }; // Example coordinates (Manila, Philippines)
      // Map options
      var mapOptions = {
        center: location,
        zoom: 12, // Adjust zoom level as needed
      };

      // Create the map
      var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

      // Add a marker
      var marker = new google.maps.Marker({
        position: location,
        map: map,
        title: 'Our Location',
      });
    }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap" async defer></script>
</body>

</html>
