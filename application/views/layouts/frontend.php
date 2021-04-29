<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5LF4ZPX');</script>
	<!-- End Google Tag Manager -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Kepaniteraan Mahkamah Agung" />

	<!-- Stylesheets
	============================================= -->
	<link rel="icon" href="<?php echo base_url('public/images/favicon.ico') ?>" sizes="16x16" type="image/ico">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/js/plugins/Autocomplete/Autocomplete.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/assets/css/style.css') ?>" type="text/css" />
	
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/bootstrap.min.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/style.min.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/dark.min.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/font-icons.min.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/animate.min.css') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('public/css/font-awesome/css/font-awesome.min.css') ?>" type="text/css" />

	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/responsive.css') ?>" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- External JavaScripts
	============================================= -->
	<script src="<?php echo base_url('public/frontend/js/jquery.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Autocomplete/Autocomplete.js') ?>"></script>
	<script src="<?php echo base_url('public/frontend/js/plugins.js') ?>"></script>

	<!-- Document Title
	============================================= -->


	<style>

		.revo-slider-emphasis-text {
			font-size: 64px;
			font-weight: 700;
			letter-spacing: -1px;
			font-family: 'Raleway', sans-serif;
			padding: 15px 20px;
			border-top: 2px solid #FFF;
			border-bottom: 2px solid #FFF;
		}

		.revo-slider-desc-text {
			font-size: 20px;
			font-family: 'Lato', sans-serif;
			width: 650px;
			text-align: center;
			line-height: 1.5;
		}

		.revo-slider-caps-text {
			font-size: 16px;
			font-weight: 400;
			letter-spacing: 3px;
			font-family: 'Raleway', sans-serif;
		}

		.tp-video-play-button { display: none !important; }

		.tp-caption { white-space: nowrap; }

		.topleft {
			margin-top: -4px;
			margin-left: 16px;
			margin-bottom: 16px;
			padding: 16px;
			border: 1px solid black;
		}

	</style>

</head>

<body class="stretched">
	
	


		<!-- Breadcrumb
		============================================= -->

		<!-- Content
		============================================= -->
		

					<?php echo $page_content; ?>

		

		<!-- Footer -->
		
	</div>     <!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- Footer Scripts
	============================================= -->
	<script src="<?php echo base_url('public/frontend/js/functions.js') ?>"></script>

	<script>

		var tpj = jQuery;

		$( function() {
			var configAutocomplete = {
				source: "<?php echo site_url('search/autosuggest');?>",
				autoFocus: false,
				minLength: 3,
			};
			$("#search").autocomplete(configAutocomplete);
			$("#search2").autocomplete(configAutocomplete);
		});

		function redirect(url) {
			var ua        = navigator.userAgent.toLowerCase(),
				isIE      = ua.indexOf('msie') !== -1,
				version   = parseInt(ua.substr(4, 2), 10);

			// Internet Explorer 8 and lower
			if (isIE && version < 9) {
				var link = document.createElement('a');
				link.href = url;
				document.body.appendChild(link);
				link.click();
			}

			// All other browsers can use the standard window.location.href (they don't lose HTTP_REFERER like Internet Explorer 8 & lower does)
			else {
				window.location.href = url;
			}
		}

	</script>

</body>
</html>