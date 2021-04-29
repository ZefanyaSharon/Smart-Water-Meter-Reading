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
								echo btnMenuArrange();
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
		'Nama Menu',
		'Parent ID',
		'Sequence',
		'URL',
		'Icon',
	];
	var ondblClickRow = function (rowId) {
		redirect(url + '/detail/' + rowId);
	}
	var setModels = [
		{
			name   : 'id',
			index  : 'mnu.id',
			key    : true,
			hidden : true,
			frozen : false
		},
		{
			name          : 'nama',
			index         : 'mnu.nama',
			width         : 220,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'nama_parent',
			index         : 'mnu_parent.nama',
			width         : 200,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'sequence',
			index         : 'mnu.sequence',
			width         : 200,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'url',
			index         : 'mnu.url',
			width         : 250,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'nama_icon',
			index         : 'icon.nama',
			width         : 200,
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