<?php session_start(); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mbouda Language translator</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Google fonts - Vidaloka-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Vidaloka">
    <!-- Google fonts - Poppins-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500">
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Fancy Box-->
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="css/custom-fonticons.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <header class="header">
      <!-- Top bar-->
      <!-- Main Navbar-->
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <!-- Navbar Brand --><a href="index.html" class="navbar-brand"><img width="200" src="https://placeholder.com/wp-content/uploads/2018/10/placeholder.com-logo1.png" alt="..."></a>
          <!-- Toggle Button-->
          <button type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarcollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span>Menu</span><i class="fa fa-bars"></i></button>
          <!-- Navbar Menu -->
          <div id="navbarcollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
              <!-- Search-->
              <li class="nav-item"><a href="index.html" class="nav-link active">Home</a>
			  
              <li class="nav-item"><a href="index.html" class="nav-link active">Quiz</a>
              <li class="nav-item"><a href="index.html" class="nav-link active">Words</a>
              <li class="nav-item"><a href="index.html" class="nav-link active">About</a>
              </li>
			
            </ul>
			<?php
				if(isset($_SESSION['valid'])) {			
					include("database/connection.php");
					$result = mysqli_query($mysqli, "SELECT * FROM login");
				?>
				<a href="dashboard/" class="btn navbar-btn btn-outline-primary mt-3 mt-lg-0 ml-lg-3">Dashboard</a>
			<a href="logout.php" class="btn navbar-btn btn-outline-primary mt-3 mt-lg-0 ml-lg-3">Logout</a>
			  <?php } else { ?>
			<a href="login.php" class="btn navbar-btn btn-outline-secondary mt-3 mt-lg-0 ml-lg-3">Login</a>
			<?php }?>
          </div>
        </div>
      </nav>
    </header>
    <!-- Hero Section-->
    <section style="background: url('https://d19m59y37dris4.cloudfront.net/places/1-1-4/img/hero-bg.jpg') no-repeat;" class="hero d-flex align-items-center">
      <div class="container">
        <p class="small-text-hero">Mbouda Language <span class="text-primary">Translator </span></p>
        <h1>Search <span class="text-primary">Words    </span> or Phrase</h1>
        <p class="text-hero">Ex. Good Morning</p>
        <div class="search-bar">
          <form action="#">
            <div class="row">
              <div class="form-group col-lg-10">
                <input type="search" name="search" placeholder="What are you searching for?">
              </div>
              
              <div class="form-group col-lg-2">
                <input type="submit" value="Search" class="submit">
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

	<footer class="main-footer">
      <div class="container">
        <div class="row">
          <div class="about col-md-4">
            <div class="logo"><img width="200" src="https://placeholder.com/wp-content/uploads/2018/10/placeholder.com-logo1.png" alt="..."></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
          </div>
          <div class="site-links col-md-4">
            <h3>Useful links</h3>
            <div class="menus d-flex">
              <ul class="list-unstyled">
                <li> <a href="index.html">Homepage</a></li>
                <li> <a href="detail.html">Quiz</a></li>
                <li> <a href="category.html">Words</a></li>
                <li> <a href="blog.html">About</a></li>
              </ul>
            </div>
          </div>
          <div class="contact col-md-4">
            <h3>Contact  us</h3>
            <div class="info">
              <p>53 Broadway, Broklyn, NY 11249</p>
              <p>Phone: (020) 123 456 789</p>
              <p>Email: <a href="mailto:info@company.com">Info@Company.com</a></p>
              
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>© <?= date('Y') ?><span class="text-primary">&nbsp Places.</span> All Rights Reserved.</p>
      </div>
    </footer>
    
    <!-- JavaScript files-->
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/vendor/jquery/jquery.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/vendor/@fancyapps/fancybox/jquery.fancybox.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/places/1-1-4/js/front.js"></script>
  </body>
</html>