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
						<td><?php echo btnSubmit(); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="app" class="row border-bottom white-bg" style="padding:10px;">
		<div class="col-md-12" style="padding-left:20px">
			<div class="wrapper wrapper-content">
				<?php echo form_open($form_action, $form_attributes) ?>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Menu</label>
							<div class="col-sm-10">
								<?php echo form_hidden('menu_id', $id) ?>
								<?php echo form_input('nama', isset($data_detail->nama) ? $data_detail->nama : set_value('nama', ''), ['class' => 'form-control input-sm required']) ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">URL</label>
							<div class="col-sm-10">
								<?php echo form_input('url', isset($data_detail->url) ? $data_detail->url : set_value('url', ''), ['class' => 'form-control input-sm required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Parent Id</label>
							<div class="col-sm-10">
								<?php
										echo form_dropdown(
											'parent_id',
											$parents_option,
											isset($data_detail->parent_id) ? $data_detail->parent_id : '',
											'id="parent_id"'
										);
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Icon</label>
							<div class="col-sm-10">
								<?php
								echo form_dropdown(
									'id_icon',
									$icons_option,
									isset($data_detail->id_icon) ? $data_detail->id_icon : '',
									'id="id_icon" required '
								);
								?>
							</div>
						</div>
					</div>
				</div>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// -- Define global variable --
	var formId = '<?php echo $form_attributes['id'] ?>';
	$(document).ready(function () {
		chk_all('chk_all_roles', 'roles');
	});

	$('#btn_add_row').click(function () {
		row_add('table-role');
	});
</script>
<script src="<?php echo base_url('public/js/plugins/Crud/crudForm.js') ?>"></script> <!-- JS Form -->
