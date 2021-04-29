<style>
.table > tbody > tr > td, .table > tfoot > tr > td {
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
						<td><?php
								echo btnNew();
								echo btnEdit();
								echo btnDelete();
								echo btnExcelPdf();
							?>
						</td>
						<td><?php echo btnSearch(); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="app" class="row border-bottom white-bg" style="padding:10px; padding-bottom:40px;">
		<div class="col-md-12" style="padding-left:20px">
			<table id="jqGridTable"></table>
			<div id="jqGridTableNav"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var url = '<?php echo base_url('backend/' . $controller_name); ?>';
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
	var ondblClickRow = function (rowId) {
		redirect(url + '/detail/' + rowId);
	}
	var setModels = [
		{
			name   : 'id',
			index  : 'u.id',
			key    : true,
			hidden : true,
			frozen : false
		},
		{
			name          : 'username',
			index         : 'users.username',
			width         : 170,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'email',
			index         : 'u.email',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'jabatan',
			index         : 'u.jabatan',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'level',
			index         : 'u.level',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'pengadilan',
			index         : 'pdl.pengadilan',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'first_name',
			index         : 'u.first_name',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'last_name',
			index         : 'u.last_name',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
	];
</script>
<script src="<?php echo base_url('public/js/plugins/Crud/CrudList.js') ?>"></script> <!-- JS List -->