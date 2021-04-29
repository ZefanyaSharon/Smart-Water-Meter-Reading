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
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<?php echo form_hidden('user_id', $id) ?>
								<?php echo form_input('username', isset($data_detail->username) ? $data_detail->username : set_value('username', ''), ['class' => 'form-control input-sm required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<?php echo form_input('email', isset($data_detail->email) ? $data_detail->email : set_value('email', ''), ['class' => 'form-control input-sm email required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Level</label>
							<div class="col-sm-10">
								<?php echo form_input('level', isset($data_detail->level) ? $data_detail->level : set_value('level', ''), ['class' => 'form-control input-sm required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Pengadilan</label>
							<div class="col-sm-10">
								<?php
									echo form_dropdown(
										'id_pengadilan',
										isset($data_detail->id_pengadilan) ? $data_detail->id_pengadilan : '',
										'id="id_pengadilan"'
									);
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Jabatan</label>
							<div class="col-sm-10">
								<?php echo form_input('jabatan', isset($data_detail->jabatan) ? $data_detail->level : set_value('jabatan', ''), ['class' => 'form-control input-sm required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">First name</label>
							<div class="col-sm-10">
								<?php echo form_input('first_name', isset($data_detail->first_name) ? $data_detail->first_name : set_value('first_name', ''), ['class' => 'form-control input-sm textspace required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Last name</label>
							<div class="col-sm-10">
								<?php echo form_input('last_name', isset($data_detail->last_name) ? $data_detail->last_name : set_value('last_name', ''), ['class' => 'form-control input-sm textspace required']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Is Active</label>
							<div class="col-sm-10">
								<?php
									echo form_checkbox(
										'active',
										'1',
										(isset($data_detail->active) && $data_detail->active == '1') ? true : false,
										'id="active" class="input-sm"'
									);
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<?php echo form_password('password', '', ['class' => 'form-control input-sm', 'id' => 'password', 'data-rule-password'=> 'true']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Password Confirm</label>
							<div class="col-sm-10">
								<?php echo form_password('password_confirm', '', ['class' => 'form-control input-sm', 'id' => 'password_confirm', 'data-rule-password'=> 'true', 'data-rule-equalTo'=> '#password']) ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Keterangan</label>
							<div class="col-sm-10">
								<?php echo form_textarea('deskripsi', isset($data_detail->deskripsi) ? $data_detail->deskripsi : set_value('deskripsi', ''), ['class' => 'form-control input-sm']) ?>
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

