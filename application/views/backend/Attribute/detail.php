<div class="">
	<div class="row border-bottom white-bg" style="padding:10px;">
		<div class="pull-left" style="padding-left:20px">
		</div>
		<div class="pull-right" style="padding-right:20px">
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
									<div class="col-sm-3 text-sm-right"><dt>Category</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->category) ? $data_detail->category : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Key</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->key) ? $data_detail->key : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Value</dt> </div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->value) ? $data_detail->value : '';?> </dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Label</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->label) ? $data_detail->label : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Default</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->is_default) ? $data_detail->is_default : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>Position</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->position) ? ucwords(strtolower($data_detail->position)) : '';?></dd></div>
								</dl>
								<dl class="row mb-0">
									<div class="col-sm-3 text-sm-right"><dt>URL Path</dt></div>
									<div class="col-sm-6 text-sm-left"><dd class="mb-1"><?php echo isset($data_detail->url_path) ? strtoupper($data_detail->url_path) : '';?></dd></div>
								</dl>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
