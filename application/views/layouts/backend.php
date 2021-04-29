<!DOCTYPE html>
<html>
	<head>
		<title><?php echo config_item('app_name') ?></title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="<?php echo base_url('public/images/favicon.ico') ?>" sizes="16x16" type="image/ico">

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
    	<script src="<?php echo base_url('public/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js')?>"></script>
    	<script src="<?php echo base_url('public/js/plugins/c3/c3.min.js')?>"></script>
    	<script src="<?php echo base_url('public/js/plugins/d3/d3.min.js')?>"></script>
	</head>
	<body>
		<div id="app">
			<div id="wrapper" class="tooltips">
				<nav class="navbar-default navbar-static-side" role="navigation">
					<div class="sidebar-collapse">
						<ul class="nav metismenu" id="side-menu">
							<li class="nav-header">
								<div class="dropdown profile-element"> <span>
									<a data-toggle="dropdown" class="dropdown-toggle" href="#">
										<span class="clear">
											<div class="row">
												<div class="col-md-4">
													<img src="<?php echo base_url('public/images/logo_ma.png') ?>" width="50" height="64" />
												</div>
												<div class="col-md-8" style="padding: 10px 3px 0 5px">
													<span class="block m-t-xs">
														<a href="<?php echo site_url() ?>" target="_blank" title="Halaman depan">
															<strong class="font-bold"><?php echo config_item('app_name'); ?></strong>
														</a>
													</span>
													<span class="text-muted text-xs block">
														<?php echo $first_name . ' ' . $last_name; ?> <!--<span class="caret"></span>-->
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
										<img src="<?php echo base_url('public/images/logo_ma.png') ?>" width="50" height="64" />
								</div>
							</li>
							<?php echo menu($menus, $current_page);?>
						</ul>
					</div>
				</nav>

				<div id="page-wrapper" class="gray-bg">
					<div class="row border-bottom">
						<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
							<div class="col-lg-1">
								<div class="navbar-header">
									<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
								</div>
							</div>
							<div class="col-lg-7 col-xs-3">
								<div style="text-align:center; margin-top:22px;">
									<h4><strong><?php echo $page_title ?></strong></h4>
								</div>
							</div>
							<ul class="nav navbar-top-links navbar-right">
								<li>
									<a style="color: #1ab394;" href="<?php echo site_url('panduan/index') ?>" target="_blank">
										<i class="fa fa-info-circle"></i>Panduan
									</a>
								</li>
								<li>
									<a href="<?php echo site_url('auth/logout') ?>">
										<i class="fa fa-sign-out"></i>Log out
									</a>
								</li>
							</ul>
						</nav>
					</div>
					<!--<div class="animated fadeInRight">-->
					<?php
					if (!empty($flash_message)) {
						if($flash_message_type == 'SUCCESS')
							$class = 'alert-success';
						elseif($flash_message_type == 'WARNING')
							$class = 'alert-warning';
						elseif($flash_message_type == 'ERROR')
							$class = 'alert-danger';
						else
							$class = 'alert-info';
					?>
							<div class="alert <?php echo $class ?> alert-dismissable" id = "succes" style="margin-top:20px">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								<strong><?php echo $flash_message ?></strong>
							</div>
					<?php
						}
					?>
					<?php echo $page_content ?>
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
				</div>
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
		<script type="text/javascript">
			jQuery.datepicker.setDefaults({
				changeMonth : true,
				changeYear  : true,
				dateFormat  : client_picker_date_format
			});

			jQuery.validator.addMethod("date", function(value, element) {
				var check = isDate(value, client_validate_date_format);
				return this.optional(element) || check;
			}, "Please enter a valid date");

			$(document).ready(function() {
				$('.select2').select2();
				// Config box
				// Enable/disable fixed top navbar
				$('#fixednavbar').click(function () {
					if ($('#fixednavbar').is(':checked')) {
						$(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
						$("body").removeClass('boxed-layout');
						$("body").addClass('fixed-nav');
						$('#boxedlayout').prop('checked', false);
					} else {
						$(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
						$("body").removeClass('fixed-nav');
					}
				});
				// Enable/disable fixed sidebar
				$('#fixedsidebar').click(function () {
					if ($('#fixedsidebar').is(':checked')) {
						$("body").addClass('fixed-sidebar');
						$('.sidebar-collapse').slimScroll({
						height: '100%',
						railOpacity: 0.9,
						});
					} else {
						$('.sidebar-collapse').slimscroll({destroy: true});
						$('.sidebar-collapse').attr('style', '');
						$("body").removeClass('fixed-sidebar');
					}
				});
				// Enable/disable collapse menu
				$('#collapsemenu').click(function () {
					if ($('#collapsemenu').is(':checked')) {
						$("body").addClass('mini-navbar');
						SmoothlyMenu();
					} else {
						$("body").removeClass('mini-navbar');
						SmoothlyMenu();
					}
				});
				// Enable/disable boxed layout
				$('#boxedlayout').click(function () {
					if ($('#boxedlayout').is(':checked')) {
						$("body").addClass('boxed-layout');
						$('#fixednavbar').prop('checked', false);
						$(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
						$("body").removeClass('fixed-nav');
						$(".footer").removeClass('fixed');
						$('#fixedfooter').prop('checked', false);
					} else {
						$("body").removeClass('boxed-layout');
					}
				});
				// Enable/disable fixed footer
				$('#fixedfooter').click(function () {
					if ($('#fixedfooter').is(':checked')) {
						$('#boxedlayout').prop('checked', false);
						$("body").removeClass('boxed-layout');
						$(".footer").addClass('fixed');
					} else {
						$(".footer").removeClass('fixed');
					}
				});
				// SKIN Select
				$('.spin-icon').click(function () {
					$(".theme-config-box").toggleClass("show");
				});
				// Default skin
				$('.s-skin-0').click(function () {
					$("body").removeClass("skin-1");
					$("body").removeClass("skin-2");
					$("body").removeClass("skin-3");
				});
				// Blue skin
				$('.s-skin-1').click(function () {
					$("body").removeClass("skin-2");
					$("body").removeClass("skin-3");
					$("body").addClass("skin-1");
				});
				// Inspinia ultra skin
				$('.s-skin-2').click(function () {
					$("body").removeClass("skin-1");
					$("body").removeClass("skin-3");
					$("body").addClass("skin-2");
				});
				// Yellow skin
				$('.s-skin-3').click(function () {
					$("body").removeClass("skin-1");
					$("body").removeClass("skin-2");
					$("body").addClass("skin-3");
				});
				$('.dual_select').bootstrapDualListbox({
					selectorMinimalHeight: 160
				});
			});
		</script>
		<script type="text/javascript">
			// -- List Configuration --
			var jqRowNum = <?php echo config_item('jqgrid_limit_per_page'); ?>;
			var jqRowList = [<?php echo config_item('jqgrid_limit_pages'); ?>];
			var jqSubRowNum = <?php echo config_item('sub_grid_limit_per_page'); ?>;
			var jqSubRowList = [<?php echo config_item('sub_grid_limit_pages'); ?>];

			// -- Form Configuration --
			var imgLoading = '<img src="<?php echo base_url('public/images/ajax_loader/ajax-loader.gif'); ?>" />';
			var successUrl = '<?php echo site_url('backend/' . $this->controller_name); ?>';
		</script>
	</body>
</html>
