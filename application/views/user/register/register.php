<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Rapid Bootstrap Template</title>
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

<header id="header" >

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
        <h1 class="text-light"><a href="#intro" class="scrollto"><span>Automatic Smart Meter Reading</span></a></h1>
        <!-- <a href="#header" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a> -->
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
		<li><a href="<?php echo site_url('auth/login') ?>">Login</a></li>
		<li class="active"><a href="<?php echo site_url('user/register') ?>">Register</a></li>
        </ul>
      </nav><!-- .main-nav -->
	</div>
    
  </header><!-- #header -->

  <section id="intro" class="clearfix">
  
    <center>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">

		<?php if (validation_errors()) : ?>
			<div class="col-md-12 alert alert-danger">
				<ul>
					<?= validation_errors('<li>', '</li>') ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if (isset($errors)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php foreach($errors as $error): ?>
					<li> <?= $error ?> </li>
					<?php endforeach ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="col-md-12">

			<div class="col-md-5 intro-info order-md-first order-last">
        <h2>Regis<span>ter</span></h2>
		<div class="container text-center loginscreen" style="width:450px; ">
			<form action="<?= base_url('user/register') ?>" method="post">
				<div class="form-group">
					<label style="font-weight:bold;" for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username" value='<?= set_value('username') ?>'>
					<span><?= form_error('username', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block" style="font-size:13px;">At least 4 characters, letters or numbers only</p>
				</div>
				<div class="form-group">
					<label style="font-weight:bold;" for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value='<?= set_value('email') ?>'>
					<span><?= form_error('email', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block" style="font-size:13px;">A valid email address</p>
				</div>
				<div class="form-group">
					<label style="font-weight:bold;" for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" value='<?= set_value('password') ?>'>
					<span><?= form_error('password', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block" style="font-size:13px;">At least 6 characters</p>
				</div>
				<div class="form-group">
					<label style="font-weight:bold;" for="password_confirm">Confirm password</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password" value='<?= set_value('password_confirm') ?>'>
					<span><?= form_error('password_confirm', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block" style="font-size:13px;">Must match your password</p>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg col-sm-3" value="Daftar">
					<input type="reset" class="btn btn-secondary btn-lg col-sm-3" value="Reset">
				</div>
			</form>

		</div>
	</div><!-- .row -->
</div><!-- .container -->
	</div>
</div>


</center>
  
  </section>

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