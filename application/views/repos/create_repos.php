<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <title>Create Project</title>
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
    	<script src="<?php echo base_url('public/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js')?>"></script>
    	<script src="<?php echo base_url('public/js/plugins/c3/c3.min.js')?>"></script>
    	<script src="<?php echo base_url('public/js/plugins/d3/d3.min.js')?>"></script>
   
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
															<strong class="font-bold">Generator</strong>
														</a>
													</span>
													<span class="text-muted text-xs block">
													<a><?php echo $this->session->username ?></a>
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
                <a href="<?php echo site_url('repos/repos/listProject') ?>"><i class="fa fa-folder-open"></i><span class="nav-label">My Project</span></a>
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
									<h4><strong>Create Project</strong></h4>
								</div>
							</div>
							<ul class="nav navbar-top-links navbar-right">
								<li>
									<a style="color: #1ab394;" href="<?php echo site_url('repos/repos/panduan') ?>" target="_blank">
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
        <div id="notifications"><?php echo $this->session->flashdata('msg');?></div>

        <form  class="form-user" method="post" action="<?php echo site_url('repos/repos/save');?>">

        <div id="app" class="row white-bg" >
			<div class="col-md-12" style="padding-left:20px">
				<div class="wrapper wrapper-content">
					<div class="row">
						<div class="col-md-9">
                        <label class="col-sm-2 control-label">Nama Proyek</label>
                        <div class="form-group">
                        <input type="text" name="nama_project" class="form-control" id="name" placeholder="Project Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
						<div class="validation"></div>
						
                        <label class="col-sm-2 control-label">Nama Repository</label>
                        <div class="form-group">
                        <input type="text" name="project_name" class="form-control" id="name" placeholder="Project Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                        <div class="validation"></div>
                    </div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Database</label>
								<div class="form-group">
                        <select name="database"class="form-control" id="exampleFormControlSelect1">
                            <option disabled selected>Database</option>
                            <option>PostgreSQL</option>
                            <option>MariaDB</option>
                            <option>MySQL</option>
                        </select>
                    </div>
							</div>
                            <label class="col-sm-2 control-label">Deskripsi</label>
							<div class="form-group">
                        <textarea type="text" name="deskripsi" class="form-control" id="name" placeholder="Deskripsi" data-rule="minlen:4" data-msg="Please enter at least 4 chars" ></textarea>
                        <div class="validation"></div>
                        <?php if(!empty($data))
                        echo $this->session->flashdata('msg');  ?>
                    </div>
							
							
							
						</div>
					</div></div>
                    <?php echo form_close() ?>
                    <button class="btn btn-primary btn-xs" style="margin-right:5px" type="submit" onclick="cmd()" type="submit"><i class="fa fa-check"></i> Create</button>
				</div>
			</div>
		</div>

        
		<div class="footer">
						<div class="pull-right">
							Load time {elapsed_time} seconds | {memory_usage}
						</div>
						<div>
							<strong><?php echo config_item('app_name') ?></strong> &copy; <?php echo date('Y') ?>
						</div>
					</div>
        </form>            
        
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

        <!-- JavaScript Libraries -->
        <script src="assets/lib/jquery/jquery.min.js"></script>
        <script src="assets/lib/jquery/jquery-migrate.min.js"></script>
        <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/lib/easing/easing.min.js"></script>
        <script src="assets/lib/mobile-nav/mobile-nav.js"></script>
        <script src="assets/lib/wow/wow.min.js"></script>
        <script src="assets/lib/waypoints/waypoints.min.js"></script>
        <script src="assets/lib/counterup/counterup.min.js"></script>
        <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="assets/lib/isotope/isotope.pkgd.min.js"></script>
        <script src="assets/lib/lightbox/js/lightbox.min.js"></script>
        <!-- Contact Form JavaScript File -->
        <script src="assets/contactform/contactform.js"></script>

        <!-- Template Main Javascript File -->
        <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

        <script>
            $('#notifications').slideDown('slow').delay(100000).slideUp('slow');
            </script>

</body>



    <?php
    function cmd(){
            //$cmd = $_GET['project_name'];

            if (isset($_GET['project_name'])) {
                
                    echo "<pre>";
                    system('svnadmin create ' . $_GET['project_name'] . ' && cd ' . $_GET['project_name'] . ' && svn checkout http://Notebook/svn/Kerja_Praktek_2019/ && cls');
                //echo system('cd ' . $_GET['project_name'] . 'svn checkout http://Notebook/svn/Kerja_Praktek_2019/');
                echo "</pre>";
            }
        }

        if(array_key_exists('test',$_POST)){
            cmd();
         }
            ?>




</html>