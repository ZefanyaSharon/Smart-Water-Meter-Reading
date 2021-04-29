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
									<div class="col-sm-3 text-sm-right"><dt>Nama Menu</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->nama) ? $data_detail->nama : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Parent ID</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->nama_parent) ? $data_detail->nama_parent : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Sequence</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->sequence) ? $data_detail->sequence : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>URL</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->url) ? $data_detail->url : '';?></a> </dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Breadcrumb</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->breadcrumb) ? $data_detail->breadcrumb : '';?></a> </dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Icon</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->nama_icon) ? $data_detail->nama_icon : '';?></dd></div>
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
