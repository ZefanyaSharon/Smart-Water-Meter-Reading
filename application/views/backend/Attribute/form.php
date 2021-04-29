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
						<div class="form-group row">
							<label class="col-sm-2 control-label">Category</label>
							<div class="col-sm-10">
								<?php echo form_hidden('attribute_id', $id) ?>
								<?php echo form_input('category', isset($data_detail->category) ? $data_detail->category : set_value('category', ''), ['class' => 'form-control input-sm required', 'maxlength' => '30']) ?>
							</div>
						</div>
						<?php
						?>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Key</label>
							<div class="col-sm-10">
								<?php echo form_input('key', isset($data_detail->key) ? $data_detail->key : set_value('key', ''), ['class' => 'form-control input-sm required', 'maxlength' => '30']) ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Value</label>
							<div class="col-sm-10">
								<?php echo form_input('value', isset($data_detail->value) ? $data_detail->value : set_value('value', ''), ['class' => 'form-control input-sm required', 'maxlength' => '100']) ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Label</label>
							<div class="col-sm-10">
								<?php echo form_input('label', isset($data_detail->label) ? $data_detail->label : set_value('value', ''), ['class' => 'form-control input-sm required', 'maxlength' => '100']) ?>
							</div>
						</div>
						<div class="form-group row">
                       	 <label class="col-sm-2 control-label">Default</label>
                       	 <div class="col-sm-2">
								<?php
									echo form_radio(
										'is_default',
										1,
										(isset($data_detail->is_default) && ! empty($data_detail->is_default)) ? true : false,
										'id="att_is_default_yes"'
									);
									echo form_label('Ya', 'att_is_default_yes', ['style'=>'margin-right:10px']) . '<br>';
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label"></label>
							 <div class="col-sm-4">
								<?php
									echo form_radio(
										'is_default',
										0,
										(isset($data_detail->is_default) && empty($data_detail->is_default)) ? true : (!isset($data_detail->is_default) && empty($data_detail->is_default)) ? true : false,
										'id="att_is_default_no"'
									);
									echo form_label('Tidak', 'att_is_default_no', ['style'=>'margin-right:10px']);
								?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Position</label>
							<div class="col-sm-10">
								<?php echo form_input('position', isset($data_detail->position) ? $data_detail->position : set_value('position', ''), ['class' => 'form-control input-sm digits', 'maxlength' => '5']) ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<?php echo form_input('description', isset($data_detail->description) ? $data_detail->description : set_value('description', ''), ['class' => 'form-control input-sm required', 'maxlength' => '300']) ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">URL Path</label>
							<div class="col-sm-10">
								<?php echo form_input('url_path', isset($data_detail->url_path) ? $data_detail->url_path : set_value('url_path', ''), ['class' => 'form-control input-sm', 'maxlength' => '100']) ?>
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

</script>
<script src="<?php echo base_url('public/js/plugins/Crud/crudForm.js') ?>"></script> <!-- JS Form -->
