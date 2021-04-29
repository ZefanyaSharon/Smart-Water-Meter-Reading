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
	<title>Tugas Akhir TE 2019/2020</title>

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
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5LF4ZPX"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="semi-transparent transparent-header full-header" data-sticky-class="not-dark">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo" class="col-lg-4" style="height: auto;">
						<a href="<?php echo site_url('beranda'); ?>" class="standard-logo" data-dark-logo="image/logo-dark.png"><img src=<?php echo base_url('public/frontend/images/logo.png') ?> alt="Mahkamah Agung Logo"></a>
						<a href="<?php echo site_url('beranda'); ?>" class="retina-logo" data-dark-logo="image/logo-dark@2x.png"><img src=<?php echo base_url('public/frontend/images/logo.png') ?> alt="Mahkamah Agung Logo"></a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu">

						<ul>
							<li><a href="<?php echo site_url('beranda'); ?>" style="padding-left: 0;"><div>Beranda</div></a></li>
							<li class="mega-menu"><a href="<?php echo site_url('search'); ?>"><div>Pencarian</div></a></li>
							<li class="mega-menu"><a href="<?php echo site_url('direktori'); ?>"><div>Direktori</div></a>
								<div class="mega-menu-content style-2 clearfix">
									<ul class="mega-menu-column col-lg-3">
										<li class="mega-menu-title"><a href="<?php echo site_url('direktori'); ?>"><div>Klasifikasi</div></a>
											<ul>
												<li><a href="<?php echo site_url('direktori'); ?>"><div>SEMUA</div></a></li>
												<?php
												if ( ! empty($kategori)) {
													foreach ($kategori as $kategori_val) {
														$sitekategori  = site_url('direktori/kategori/jenis/' . $kategori_val->url_name);
												?>
													<li><a href="<?php echo $sitekategori ?>"><?php echo $kategori_val->nama_kategori ?></a></li>
												<?php }
												} ?>
											</ul>
										</li>
									</ul>
									<ul class="mega-menu-column col-lg-2">
										<li class="mega-menu-title"><a href="<?php echo site_url('direktori/periode/jenis/putus'); ?>"><div>Putus</div></a>
											<ul>
												<?php
												$tahun_putus = $tahun['tahun_put_aggs'];
												foreach ($tahun_putus as $year) {
													?>
													<li><a href="<?php echo site_url('direktori/periode/jenis/putus/tahun/' . $year->key); ?>"><div><?php echo $year->key . ( ! empty($year->doc_count) ? ' <sup>(' . $year->doc_count . ')</sup>' : '') ?></div></a></li>
													<?php
												}
												?>
												<li><a href="<?php echo site_url('direktori/periode/jenis/putus'); ?>"><div>Selengkapnya</div></a></li>
											</ul>
										</li>
									</ul>
									<ul class="mega-menu-column col-lg-2">
										<li class="mega-menu-title"><a href="<?php echo site_url('direktori/periode/jenis/regis'); ?>"><div>Register</div></a>
											<ul>
												<?php
												$tahun_reg = $tahun['tahun_reg_aggs'];
												foreach ($tahun_reg as $year) {
													?>
													<li><a href="<?php echo site_url('direktori/periode/jenis/regis/tahun/' . $year->key); ?>"><div><?php echo $year->key . ( ! empty($year->doc_count) ? ' <sup>(' . $year->doc_count . ')</sup>' : '') ?></div></a></li>
													<?php
												}
												?>
												<li><a href="<?php echo site_url('direktori/periode/jenis/regis'); ?>"><div>Selengkapnya</div></a></li>
											</ul>
										</li>
									</ul>
									<ul class="mega-menu-column col-lg-2">
										<li class="mega-menu-title"><a href="<?php echo site_url('direktori/periode/jenis/upload'); ?>"><div>Upload</div></a>
											<ul>
												<?php
												$tahun_upl = $tahun['tahun_upl_aggs'];
												foreach ($tahun_upl as $year) {
													?>
													<li><a href="<?php echo site_url('direktori/periode/jenis/upload/tahun/' . $year->key); ?>"><div><?php echo $year->key . ( ! empty($year->doc_count) ? ' <sup>(' . $year->doc_count . ')</sup>' : '') ?></div></a></li>
													<?php
												}
												?>
												<li><a href="<?php echo site_url('direktori/periode/jenis/upload'); ?>"><div>Selengkapnya</div></a></li>
											</ul>
										</li>
									</ul>
									<ul class="mega-menu-column col-lg-3">
										<li class="mega-menu-title"><a href="<?php echo site_url('pengadilan/direktori/putusan/pilihan'); ?>"><div>Putusan Pilihan</div></a></li>
										<li class="mega-menu-title"><a href="<?php echo site_url('kaidah'); ?>"><div>Kaidah Hukum</div></a></li>
										<li class="mega-menu-title"><a href="<?php echo site_url('restatement'); ?>"><div>Restatement</div></a></li>
										<li class="mega-menu-title"><a href="<?php echo site_url('rumusan_kamar'); ?>"><div>Rumusan Kamar</div></a></li>
										<li class="mega-menu-title"><a href="<?php echo site_url('yurisprudensi'); ?>"><div>Yurisprudensi</div></a></li>
									</ul>

								</div>
							</li>
							<li><a href="<?php echo site_url('pengadilan'); ?>"><div>Pengadilan</div></a>
								<ul>
									<li><a href="<?php echo site_url('pengadilan'); ?>"><div><i class="icon-stack"></i>SEMUA</div></a>
									<?php foreach ($peradilan as $value => $val) {
													?>
									<li><a href="<?php echo site_url('pengadilan/index/ditjen/' . strtolower($value))?>"><div><?php echo $val ?></div></a>
									<?php
												} ?>
								</ul>
							</li>
							<li class="mega-menu"><a href="<?php echo site_url('peraturan'); ?>"><div>Peraturan</div></a></li>
							<li><a href="<?php echo site_url('tentang'); ?>"><div>Tentang</div></a>
								<ul>
									<li><a href="<?php echo site_url('penggunaan'); ?>"><div>Petunjuk</div></a></li>
									<li><a href="<?php echo site_url('rss'); ?>"><div>RSS</div></a></li>
								</ul>
							</li>
						</ul>

					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->

		<?php echo $slider; ?>

		<!-- Breadcrumb
		============================================= -->
		<?php echo $breadcrumb; ?>

		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap" style="padding: 0">

				<?php echo $statistik; ?>

				<?php echo $content_data; ?>

				<div class="container bottommargin-lg clearfix" style="margin-top: 30px">
					<?php echo $side_menu; ?>

					<!-- batas antara content dan side menu-->

					<?php echo $page_content; ?>

				</div>

				<?php echo $statistik_pengadilan; ?>

			</div>

		</section><!-- #content end -->

		<!-- Footer
				============================================= -->
		<footer id="footer" class="dark">

			<div class="container">

				<!-- Footer Widgets
								============================================= -->
				<div class="footer-widgets-wrap clearfix">

					<div class="col_full">

						<div class="col_two_fifth">

							<div class="widget clearfix">

								<img src=<?php echo base_url('public/frontend/images/logo-putih.png') ?>  alt="" class="footer-logo">

								<p>Publikasi Dokumen Elektronik <strong>Putusan</strong> seluruh Pengadilan di Indonesia</p>

								<div style="background: url('<?php echo base_url('public/frontend/images/world-map.png') ?>') no-repeat center center; background-size: 100%;">
									<address>
										<strong>Mahkamah Agung RI:</strong><br>
										Jl. Medan Merdeka Utara No. 9-13.<br>
										Jakarta Pusat - DKI Jakarta<br>
										Indonesia 10110<br>
									</address>
									<abbr title="Phone Number"><strong>Phone:</strong></abbr> (021) 384 3348<br>
									<abbr title="Phone Number"><strong>Phone:</strong></abbr> (021) 381 0350<br>
									<abbr title="Phone Number"><strong>Phone:</strong></abbr> (021) 345 7661<br>
									<abbr title="Email Address"><strong>Email:</strong></abbr> info[at]mahkamahagung.go.id
								</div>

							</div>

						</div>

						<div class="col_one_fourth">

							<div class="widget widget_links clearfix">

								<h4>Direktori</h4>

								<ul>
									<li><a href="<?php echo site_url('direktori'); ?>">Putusan</a></li>
									<li><a href="<?php echo site_url('peraturan'); ?>">Peraturan Perundangan</a></li>
									<li><a href="<?php echo site_url('kaidah'); ?>">Kaidah</a></li>
									<li><a href="<?php echo site_url('rumusan_kamar'); ?>">Rumusan Kamar</a></li>
									<li><a href="<?php echo site_url('restatement'); ?>">Restatement</a></li>
									<li><a href="<?php echo site_url('yurisprudensi'); ?>">Yurisprudensi</a></li>
								</ul>

							</div>

						</div>

						<div class="col_one_third col_last">

							<div class="widget clearfix">
								<h4>Putusan Terbaru</h4>

								<div id="post-list-footer">
								<?php
								if ( ! empty($putusan_footer)) {
										foreach ($putusan_footer as $result) {
											$putusan = $result->_source;
									?>
									<div class="spost clearfix">
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="<?php echo site_url('direktori/putusan/' . trim($putusan->id)) ?>"><?php echo $putusan->nama_pengadilan ?> Nomor <?php echo $putusan->nomor ?></a></h4>
											</div>
											<ul class="entry-meta">
												<li><?php echo convert_date('Y-m-d', $putusan->tanggal_putusan, 'd M Y') ?></li>
											</ul>
										</div>
									</div>
									<?php
										}
									}
									?>
								</div>
							</div>

						</div>

					</div>

				</div><!-- .footer-widgets-wrap end -->

			</div>

			<!-- Copyrights
							============================================= -->
			<div id="copyrights">
				<div class="container clearfix">
					<div class="col_half" style="color:#c7c7c7 !important;">
						Dikelola oleh Kepaniteraan Mahkamah Agung Republik Indonesia<br>
						© <?php echo date('Y') ?>. Hak Cipta dan Kekayaan Intelektual dilindungi Undang-Undang. <br>
						Halaman ini dibuka dalam waktu {elapsed_time} detik. {memory_usage}
					</div>
				</div>
			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

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