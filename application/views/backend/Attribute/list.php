<style>
.border>tbody>tr>td{
	border:none !important;
}
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
	var is_can_edit = true;
	var is_can_delete = true;
	var multiselect = false;
	var setColumns = [
		'Id',
		'',
		'Category',
		'Key',
		'Value',
		'Label',
		'Default',
		'Position',
		'Description',
		'URL Path',
	];
	var jk = "l:Pria;p:Wanita";
	var ondblClickRow = function (rowId) {
		redirect(url + '/detail/' + rowId);
	}
	var setModels = [
		{
			name   : 'id',
			index  : 'atr.id',
			key    : true,
			hidden : true,
			frozen : false
		},
		{
			name          : 'id',
			index         : 'atr.id',
			width         : 70,
			frozen        : false,
			stype         : 'text',
			search		  : false,
			formatter:	action_formater
		},
		{
			name          : 'category',
			index         : 'atr.category',
			width         : 150,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'key',
			index         : 'atr.key',
			width         : 100,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'value',
			index         : 'atr.value',
			width         : 100,
			frozen        : false,
			stype         : 'text',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'label',
			index         : 'atr.label',
			width         : 100,
			frozen        : false,
			stype         : 'text',
			sortable      : false,
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'is_default',
			index         : 'atr.is_default',
			width         : 80,
			frozen        : false,
			stype         : 'select',
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			},
			formatter: function(cellvalue, options, rowObject) {
				value = '';
				if (rowObject['is_default'] == 1)
					value = 'Ya';
				else if (rowObject['is_default'] == 0)
					value = 'Tidak';

				return value;
			}
		},
		{
			name          : 'position',
			index         : 'atr.position',
			width         : 50,
			frozen        : false,
			stype         : 'text',
			sortable      : false,
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'description',
			index         : 'atr.description',
			width         : 100,
			frozen        : false,
			stype         : 'text',
			sortable      : false,
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
		{
			name          : 'url_path',
			index         : 'atr.url_path',
			width         : 100,
			frozen        : false,
			stype         : 'text',
			sortable      : false,
			searchoptions : {
				sopt        : jqgird_search_string_operators,
				clearSearch : true
			}
		},
	];
</script>
<script src="<?php echo base_url('public/js/plugins/Crud/CrudList.js') ?>"></script> <!-- JS List -->