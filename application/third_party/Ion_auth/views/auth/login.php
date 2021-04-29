<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link rel="shortcut icon" href="<?php echo base_url('public/images/favicon.ico'); ?>" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,600,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="<?php echo base_url('assets/lib/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

  <!-- Libraries CSS Files -->

  <link href="<?php echo base_url('assets/lib/lightbox/css/lightbox.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/lib/owlcarousel/assets/owl.carousel.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/lib/ionicons/css/ionicons.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/lib/animate/animate.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style1.css') ?>" type="text/css" />  

  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>


  <!-- =======================================================
    Theme Name: Rapid
    Theme URL: https://bootstrapmade.com/rapid-multipurpose-bootstrap-business-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>


<body>

<header id="header" style="background-color: transparent;">

    <!-- <div id="topbar">
      <div class="container">
        <div class="social-links">
          <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
          <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
          <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
          <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
        </div>
      </div>
    </div> -->

	<div class="container">

      <div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
        <h1 class="text-light"><a href="#intro" class="scrollto"><span>Generator</span></a></h1>
        <!-- <a href="#header" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a> -->
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
		<li class="active"><a href="<?php echo site_url('auth/login') ?>">Login</a></li>
		<li><a href="<?php echo site_url('user/register') ?>">Register</a></li>
        </ul>
      </nav><!-- .main-nav -->
	</div>
    
  </header><!-- #header -->






<section id="intro" class="clearfix">
  
    <center>
	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <div class="col-md-5 intro-info order-md-first order-last" style="margin-top: 100px">
        <h2>Log<span>in</span></h2>




        <div class="container text-center loginscreen" style="width:450px; *position:center;">
	<p>Please login with your <span>email/username</span> and <span>password</span> bellow</p>

	<div id="infoMessage"><?php echo $message;?></div>

	<?php echo form_open('auth/login');?>

	<div class="form-group">
		<?php echo lang('login_identity_label', 'identity');?>
		<?php echo form_input($identity);?>
	</div>
	<div class="form-group">
		<?php echo lang('login_password_label', 'password');?>
		<?php echo form_input($password);?>
	</div>

	<div class="form-group">
		<?php echo lang('login_remember_label', 'remember');?>
		<?php echo form_checkbox('remember', '1', false, 'id="remember"');?>
	</div>

	<div class="form-group" style="float: none !important; margin-left: 60px;">
		<div class="g-recaptcha" data-sitekey="<?php echo config_item('recaptcha_site_key') ?>"></div>
	</div>

	<p>
		<?php
			echo form_submit([
				'id' 	  => 'btnLogin',
				'name' 	=> 'btnLogin',
				'value'	=> lang('login_submit_btn'),
				'class' => 'btn btn-primary block full-width m-b'
			]);
			// echo form_hidden('return', $return);
		?>
	</p>

	<?php echo form_close();?>

	<a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
</div>



        <!-- <div class="col-md-6 intro-img order-md-last order-first">
          <img src="img/intro-img.svg" alt="" class="img-fluid">
        </div> -->
      </div>

    </center>
  
        </section>
  


  <!-- JavaScript Libraries -->
  
  <script src="<?php echo base_url('lib/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/jquery/jquery-migrate.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/easing/easing.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/mobile-nav/mobile-nav.js'); ?>"></script>
  <script src="<?php echo base_url('lib/wow/wow.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/waypoints/waypoints.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/counterup/counterup.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/owlcarousel/owl.carousel.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/isotope/isotope.pkgd.min.js'); ?>"></script>
  <script src="<?php echo base_url('lib/lightbox/js/lightbox.min.js'); ?>"></script>
  <!-- Contact Form JavaScript File -->
  <script src="<?php echo base_url('contactform/contactform.js'); ?>"></script>

  <!-- Template Main Javascript File -->
  <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
  <script>
    var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("header").style.top = "0";
  } else {
    document.getElementById("header").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}

  </script>


</body>