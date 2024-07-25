<?php include 'logo.php'; ?>

<body class="sub_page">

  <div class="hero_area">
    <?php include 'header.php'; ?>
  </div>

  <!-- client section -->
  <section class="client_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          News
        </h2>
      </div>
      <div class="row">
        <?php
        $apiKey = "ada0f25e63b2b3063d6f96b15ab5bedd";
        $query = urlencode("Sangguniang Kabataan");
        $url = "https://gnews.io/api/v4/search?q=$query&token=$apiKey";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json'
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
          echo '<p>Failed to fetch news articles. Curl error: ' . curl_error($ch) . '</p>';
        } else {
          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

          if ($httpCode == 200) {
            $newsData = json_decode($response);

            if (isset($newsData->articles)) {
              $articles = $newsData->articles;

              foreach ($articles as $article) {
                ?>
                <div class="col-md-4">
                  <div class="news_box">
                    <div class="news_image">
                      <img src="<?php echo $article->image; ?>" alt="">
                    </div>
                    <div class="news_content">
                      <h5><?php echo $article->source->name; ?></h5>
                      <h6><?php echo isset($article->author) ? $article->author : "Unknown Author"; ?></h6>
                      <p><?php echo $article->description; ?></p>
                    </div>
                  </div>
                </div>
                <?php
              }
            } else {
              echo "<p>No articles found or failed to decode the response.</p>";
            }
          } else {
            echo '<p>Failed to fetch news articles. HTTP response code: ' . $httpCode . '</p>';
          }
        }

        curl_close($ch);
        ?>
      </div>
    </div>
  </section>
  <!-- end client section -->

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
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->

</body>

</html>
