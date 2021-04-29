<head>
	<link href="/your-path-to-fontawesome/css/all.css" rel="stylesheet">
	<!--load all styles -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
	.table>tbody>tr>td,
	.table>tfoot>tr>td {
		border-top: 0;
		line-height: 1.42857;
		padding: 8px;
		vertical-align: top;
	}
</style>
<div class="">
	<div class="row border-bottom white-bg" style="padding:10px;">
		<div class="pull-left" style="padding-left:20px">
			<table class="table" style="margin-bottom: 0;">
				<tbody>
					<tr>
						<td><?php echo $breadcrumbs ?></td>
					</tr>
					<tr>
						<td>
							<button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</button>
						</td>
						<td>
							<button class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</button>
						</td>
						<td>
							<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
						</td>
						<td>
							<div class="dropdown">
								<button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown"> Ekspor
									<span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="#">PDF</li>
									<li><a href="#">EXCEL</a></li>
								</ul>
							</div>
						</td>
						<td>

						</td>
						<td>
							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Kata Kunci..." aria-label="Kata Kunci..." aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button class="btn btn-info" type="button">Cari</button>
								</div>
							</div>
							
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="app" class="row border-bottom white-bg" style="padding:10px; padding-bottom:40px;">
		<div class="col-md-12" style="padding-left:20px">
			<table style="width: 100%;">
				<tr style="border: 1px solid #b6b6b6; background: #eeeded; ">
					<th style="border: 1px solid #b6b6b6;  text-align: center;">Username</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;">Email</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;">Jabatan</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;">Level</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;">Pengadilan</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;">First Name</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;">Last Name</th>
					<th style="border: 1px solid #b6b6b6;  text-align: center;"></th>
				</tr>
				<tr style="height: 700px; border: 1px solid #b6b6b6;">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="border: 1px solid #b6b6b6; background: #eeeded;">
					<td colspan=8 style="text-align: center;">
						<nav aria-label="Page navigation example">
							<ul class="pagination">
								<li class="page-item"><a class="page-link" href="#">Previous</a></li>
								<li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item"><a class="page-link" href="#">Next</a></li>
							</ul>
						</nav>
					</td>
				</tr>
			</table>


		</div>
	</div>
</div>

<script type="text/javascript">
	var url = '<?php echo base_url('
	backend / ' . $controller_name); ?>';
	var tableId = 'jqGridTable';
	var multiselect = false;
	var setColumns = [
		'Id',
		'Username',
		'Email',
		'Jabatan',
		'Level',
		'Pengadilan',
		'First Name',
		'Last Name',
	];
	var ondblClickRow = function(rowId) {
		redirect(url + '/detail/' + rowId);
	}
	var setModels = [{
			name: 'id',
			index: 'u.id',
			key: true,
			hidden: true,
			frozen: false
		},
		{
			name: 'username',
			index: 'u.username',
			width: 170,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
		{
			name: 'email',
			index: 'u.email',
			width: 150,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
		{
			name: 'jabatan',
			index: 'u.jabatan',
			width: 150,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
		{
			name: 'level',
			index: 'u.level',
			width: 150,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
		{
			name: 'pengadilan',
			index: 'pdl.pengadilan',
			width: 150,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
		{
			name: 'first_name',
			index: 'u.first_name',
			width: 150,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
		{
			name: 'last_name',
			index: 'u.last_name',
			width: 150,
			frozen: false,
			stype: 'text',
			searchoptions: {
				sopt: jqgird_search_string_operators,
				clearSearch: true
			}
		},
	];
</script>
<script src="<?php echo base_url('public/js/plugins/Crud/CrudList.js') ?>"></script> <!-- JS List -->