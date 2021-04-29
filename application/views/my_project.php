<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Smart Automatic Reading Website</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="keywords">
	<meta content="" name="description">

	<!-- Favicons -->
	<link rel="shortcut icon" href="<?php echo base_url('public/images/favicon.ico'); ?>" type="image/x-icon">


	<link href="<?php echo base_url('public/css/bootstrap-min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/css/bootstrap.min-min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/css/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/JqueryUi/css/v1.12.1/jquery-ui.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/JqGrid/JqGrid.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/ICheck/Custom.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/DatePicker/DatePicker3.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/DateTimePicker/DateTimePicker.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Chosen/Chosen.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Select2/Select2.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Toastr/ToastrMin.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Switchery/Switchery.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/FullCalendar/FullCalendar.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/SweetAlert/SweetAlert.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Summernote/Summernote.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Summernote/Summernote-bs3.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/SweetAlert/Custom.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/Fileinput/fileinput.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/js/plugins/c3/c3.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/css/DailyCalendar.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/css/animate-min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/css/style.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('public/css/custom-min.css') ?>" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('public/js/plugins/Autocomplete/Autocomplete.css') ?>" type="text/css" />
	<script type="text/javascript">
		var client_picker_datetime_format = "<?php echo config_item('client_picker_datetime_format') ?>";
		var client_picker_date_format = "<?php echo config_item('client_picker_date_format') ?>";
		var client_picker_time_format = "<?php echo config_item('client_picker_time_format') ?>";
		var client_picker_time_nosecond_format = "<?php echo config_item('client_picker_time_nosecond_format') ?>";

		var client_validate_date_format = "<?php echo config_item('client_validate_date_format') ?>";
		var client_validate_datetime_format = "<?php echo config_item('client_validate_datetime_format') ?>";
		var client_validate_datetime_nosecond_format = "<?php echo config_item('client_validate_datetime_nosecond_format') ?>";
		var client_validate_time_format = "<?php echo config_item('client_validate_time_format') ?>";
		var client_validate_time_nosecond_format = "<?php echo config_item('client_validate_time_nosecond_format') ?>";

		var server_date_format = "<?php echo config_item('server_date_format') ?>";
		var server_datetime_format = "<?php echo config_item('server_datetime_format') ?>";
		var server_datetime_nosecond_format = "<?php echo config_item('server_datetime_nosecond_format') ?>";
		var server_time_format = "<?php echo config_item('server_time_format') ?>";
		var server_time_nosecond_format = "<?php echo config_item('server_time_nosecond_format') ?>";

		var server_client_parse_validate_date_format = "<?php echo config_item('server_client_parse_validate_date_format') ?>";
		var server_client_parse_validate_datetime_format = "<?php echo config_item('server_client_parse_validate_datetime_format') ?>";
		var server_client_parse_validate_datetime_nosecond_format = "<?php config_item('server_client_parse_validate_datetime_nosecond_format') ?>";
		var server_client_parse_validate_time_format = "<?php echo config_item('server_client_parse_validate_time_format') ?>";
		var server_client_parse_validate_time_nosecond_format = "<?php echo config_item('server_client_parse_validate_time_nosecond_format') ?>";

		var client_jqgrid_date_format = "<?php echo config_item('client_jqgrid_date_format') ?>";
		var client_jqgrid_datetime_format = "<?php echo config_item('client_jqgrid_datetime_format') ?>";
		var client_jqgrid_datetime_nosecond_format = "<?php echo config_item('client_jqgrid_datetime_nosecond_format') ?>";
		var client_jqgrid_time_format = "<?php echo config_item('client_jqgrid_time_format') ?>";
		var client_jqgrid_time_nosecond_format = "<?php echo config_item('client_jqgrid_time_nosecond_format') ?>";

		var boolean_selectors = JSON.parse('<?php echo json_encode(config_item('boolean')) ?>');
		var boolean_invers_selectors = JSON.parse('<?php echo json_encode(config_item('boolean_invers')) ?>');
		var is_active_selectors = JSON.parse('<?php echo json_encode(config_item('is_active')) ?>');
		var is_publish_selectors = JSON.parse('<?php echo json_encode(config_item('is_publish')) ?>');
		var log_auth_type = JSON.parse('<?php echo json_encode(config_item('log_auth_type')) ?>');
	</script>

	<script src="<?php echo base_url('public/js/plugins/Jquery/jquery-3.1.1.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Bootstrap/Bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/JqueryUi/JqueryUiMin.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Autocomplete/Autocomplete.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/MetisMenu/MetisMenu.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/MetisMenu/jquery.metisMenu.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/SlimScroll/SlimScroll.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/JqueryForm/JqueryForm.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Validation/Validate.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/SerializeJson/SerializeJson.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/JqGrid/i18n/grid.locale-en.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/JqGrid/JqGridMin.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/JqGrid/JqGridExtend.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/BlockUi/BlockUi.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Moment/Moment.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/DatePicker/BootstrapDatePicker.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/DateTimePicker/BootstrapDateTimePicker.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/SweetAlert/SweetAlert.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/FullCalendar/FullCalendar.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/ICheck/icheck.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Select2/Select2Full.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/DigitGrouping/DigitGrouping.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/DynamicRow/DynamicRow.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Switchery/Switchery.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Toastr/ToastrMin.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Chosen/Chosen.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Media/Media.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/FileUpload/FileUpload.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/DateConverter/DateConverter.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Pace/Pace.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Peity/Peity.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Summernote/Summernote.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/JasnyBootstrap/JasnyBootstrapMin.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/PreetyTextDiff/PrettyTextDiff.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/DiffMatchPatch/DiffMatchPatch.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Ajax/Ajax.js') ?>"></script>
	<script src="<?php echo base_url('public/js/popper.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.tooltip.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.spline.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.resize.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.pie.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.symbol.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Flot/jquery.flot.time.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/nestable/jquery.nestable.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Inspinia/Inspinia.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Inspinia/FirstLoad.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/Fileinput/fileinput.js') ?>"></script>
	<!-- Dual Listbox -->
	<script src="<?php echo base_url('public/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/c3/c3.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/plugins/d3/d3.min.js') ?>"></script>
	<title>Grafik Stok Barang</title>

	<?php
		foreach($project['project'] as $data){
			$merk[] = $data->Tanggal;
			$stok[] = (float) $data->total_pemakaian;
		}
	?>
</head>

<body>
	<!--==========================
  Header
  ============================-->
	<header id="header">

		<div id="app">
			<div id="wrapper" class="tooltips">
				<nav class="navbar-default navbar-static-side" role="navigation">
					<div class="sidebar-collapse">
						<ul class="nav metismenu" id="side-menu">
							<li class="nav-header" style="background-color:#fff">
								<div class="dropdown profile-element"> <span>
										<a data-toggle="dropdown" class="dropdown-toggle" href="#">
											<span class="clear">
												<div class="row">
													<div class="col-md-4">
														<img src="<?php echo base_url('public/images/gambarku.png') ?>" width="50" height="64" />
													</div>
													<div class="col-md-8" style="padding: 10px 3px 0 5px">
														<span class="block m-t-xs">
															<a href="<?php echo site_url() ?>" target="_blank" title="Halaman depan">
																<strong class="font-bold">Automatic Smart Meter Reading </strong>
															</a>
														</span>
														<span class="text-muted text-xs block">
															<a><?php echo $this->session->username ?></a>
															<!--<span class="caret"></span>-->
														</span>
													</div>
												</div>
											</span>
										</a>
										<ul class="dropdown-menu animated fadeInRight m-t-xs">
											<li><a href="<?php echo site_url('auth/logout') ?>">Logout</a></li>
										</ul>
								</div>
								<div class="logo-element">
									<img src="<?php echo base_url('public/images/gambarku.png') ?>" width="50" height="64" />
								</div>
							</li>




							<ul class="nav metismenu" id="side-menu">

								<li>
									<a href="<?php echo site_url('repos/repos/listProject') ?>"><i class="fa fa-home"></i><span class="nav-label">Home</span></a>
								</li>
								<li>
									<a href="<?php echo site_url('repos/repos/table') ?>"><i class="fa fa-table"></i><span class="nav-label">Table</span></a>
								</li>
								<li>
									<a href="<?php echo site_url('repos/repos/statistic') ?>"><i class="fa fa-bar-chart"></i><span class="nav-label">Statistic</span></a>
								</li>

							</ul>





						</ul>
					</div>
				</nav>

				<div id="page-wrapper" class="white-bg">
					<div class="row border-bottom">
						<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
							<div class="col-lg-1">
								<div class="navbar-header">
									<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
								</div>
							</div>
							<div class="col-lg-7 col-xs-3">
								<div style="text-align:center; margin-top:22px;">
									<h4><strong>Automatic Smart Meter Reading</strong></h4>
								</div>
							</div>
							<ul class="nav navbar-top-links navbar-right">
								<li>
									<a href="<?php echo site_url('auth/logout') ?>">
										<i class="fa fa-sign-out"></i>Log out
									</a>
								</li>
							</ul>
						</nav>
					</div>



							<div id="app" class="row white-bg" style="padding:10px; padding-bottom:20px;">
						<div style="padding-left:1px">
							<table id="app" class="table table-striped table-bordered table-sm" cellspacing="0" aria-multiselectable="false" style="width: 50%;">
								<thead>
									<tr style="border: 1px solid #f5f5f6; background: #f5f5f6; ">

										<th style="border: 1px solid #b6b6b6;  text-align: center;">Flow Rate (L/Menit)</th>
										<th style="border: 1px solid #b6b6b6;  text-align: center;">Total Pemakaian Air (L)	</th>
										<th colspan=1 style="border: 1px solid #b6b6b6;  text-align: center;">Detail</th>

										</th>
									</tr>
								</thead>
								<?php
								$count = 0;
								foreach ($project['project'] as $row) :
									$count++;
									?>
								<tr type="checkbox" class="success" role="row" aria-selected="false">
									
									<td title="<?php echo $row->flow_rate ?>" style=" solid #b6b6b6; word-wrap: break-word;  text-align: center"><?php echo $row->flow_rate; ?></td>
									<td title="<?php echo $row->total_pemakaian ?>" style=" solid #b6b6b6;  text-align: center"><?php echo $row->total_pemakaian; ?></td>
									<td>
										<a class="btn btn-primary" type="button" style=" solid #b6b6b6;  text-align: center" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable<?php echo $row->id; ?>"><i class="fa fa-list"></i></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>

				
			   </script>
				
			   <div id="app" class="row white-bg" style="padding:10px; padding-bottom:40px;">
						<div style="padding-left:1px">
							


							<!-- Modal Detail s-->
							<?php
							$count = 0;
							foreach ($project['project'] as $row) :
								$count++;
								?>
							<div class="modal fade" id="exampleModalScrollable<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-scrollable" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<center>
												<h2 class="modal-title" id="exampleModalLabel">Detail Project</h2>
											</center>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form>
												<div class="form-group">
													<label for="exampleInputEmail1">Tanggal Input :</label>
													<p title="<?php echo $row->Tanggal ?>" style="solid #b6b6b6;  "><?php echo $row->Tanggal; ?></p>

												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Total Pemakaian Air :</label>
													<p title="<?php echo $row->total_pemakaian ?>" style="solid #b6b6b6;  "><?php echo $row->total_pemakaian; ?></p>

												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Flow Rate :</label>
													<p title="<?php echo $row->flow_rate ?>" style="solid #b6b6b6;  "><?php echo $row->flow_rate; ?></p>

												</div>
												

												
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

										</div>
									</div>
								</div>
							</div>
							<?php endforeach; ?>

							<?php
							// Tampilkan link-link paginationnya
							if (!empty($project['pagination'])) {
								echo $project['pagination'];
							}
							?>
						</div>
					</div>


							
							
							<!-- Modal Detail s-->
							

					<div class="footer">
						<div class="pull-right">
							Load time {elapsed_time} seconds | {memory_usage}
						</div>
						<div>
							<strong><?php echo config_item('app_name') ?></strong> &copy; <?php echo date('Y') ?>
						</div>
					</div>
					<div id="dialog_alert_container">
						<p>
							<span id="dialog_alert_icon" style="float: left; margin: 0 7px 50px 0;"></span>
							<div id="dialog_alert_message"></div>
						</p>
					</div>
					<div id="dialog_confirm_container">
						<p>
							<span id="dialog_confirm_icon" style="float: left; margin: 0 7px 50px 0;"></span>
							<div id="dialog_confirm_message"></div>
						</p>
					</div>


					<div class="theme-config">
						<div class="theme-config-box">
							<div class="spin-icon">
								<i class="fa fa-cogs"></i>
							</div>
							<div class="skin-setttings">
								<div class="title">Configuration</div>
								<div class="setings-item">
									<span>
										Collapse menu
									</span>

									<div class="switch">
										<div class="onoffswitch">
											<input type="checkbox" id="collapsemenu" class="onoffswitch-checkbox" name="collapsemenu">
											<label for="collapsemenu" class="onoffswitch-label">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div>
									</div>
								</div>
								<div class="setings-item">
									<span>
										Fixed sidebar
									</span>

									<div class="switch">
										<div class="onoffswitch">
											<input type="checkbox" id="fixedsidebar" class="onoffswitch-checkbox" name="fixedsidebar">
											<label for="fixedsidebar" class="onoffswitch-label">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div>
									</div>
								</div>
								<div class="setings-item">
									<span>
										Top navbar
									</span>

									<div class="switch">
										<div class="onoffswitch">
											<input type="checkbox" id="fixednavbar" class="onoffswitch-checkbox" name="fixednavbar">
											<label for="fixednavbar" class="onoffswitch-label">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div>
									</div>
								</div>
								<div class="setings-item">
									<span>
										Boxed layout
									</span>

									<div class="switch">
										<div class="onoffswitch">
											<input type="checkbox" id="boxedlayout" class="onoffswitch-checkbox" name="boxedlayout">
											<label for="boxedlayout" class="onoffswitch-label">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div>
									</div>
								</div>
								<div class="setings-item">
									<span>
										Fixed footer
									</span>

									<div class="switch">
										<div class="onoffswitch">
											<input type="checkbox" id="fixedfooter" class="onoffswitch-checkbox" name="fixedfooter">
											<label for="fixedfooter" class="onoffswitch-label">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="title">Skins</div>
								<div class="setings-item default-skin">
									<span class="skin-name ">
										<a class="s-skin-0" href="#">
											Default
										</a>
									</span>
								</div>
								<div class="setings-item blue-skin">
									<span class="skin-name ">
										<a class="s-skin-1" href="#">
											Blue light
										</a>
									</span>
								</div>
								<div class="setings-item yellow-skin">
									<span class="skin-name ">
										<a class="s-skin-3" href="#">
											Yellow/Purple
										</a>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>










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

</html>