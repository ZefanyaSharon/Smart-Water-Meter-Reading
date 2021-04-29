<div class="">
	<div class="row border-bottom white-bg" style="padding:10px;">
		<div class="pull-left" style="padding-left:20px">
		<?php echo $breadcrumbs ?>
		</div>
	</div>

	<div id="app" class="row border-bottom white-bg" style="padding:10px;">
		<div class="row">
			<div class="col-md-12" style="padding-left:20px">
				<div class="wrapper wrapper-content">
					<div class="ibox">
						<div class="row">
							<div class="col-lg-6">
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>User Name</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->username) ? $data_detail->username : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Email</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->email) ? $data_detail->email : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Jabatan</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->jabatan) ? $data_detail->jabatan : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Level</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->level) ? $data_detail->level : '';?></a> </dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Pengadilan</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->pengadilan) ? $data_detail->pengadilan : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>First Name</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->first_name) ? $data_detail->first_name : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Last Name</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->last_name) ? $data_detail->last_name : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Is Active</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->active) && $data_detail->active == '1' ? 'Aktif' : 'Tidak Aktif';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Created</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->created) ? date('d/m/Y H:i:s', strtotime($data_detail->created)) : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Last Updated</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->updated) ? date('d/m/Y H:i:s', strtotime($data_detail->updated)) : '';?></dd></div>
								</dl>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
