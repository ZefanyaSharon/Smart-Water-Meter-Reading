<style>
	.table>tbody>tr>td,
	.table>tfoot>tr>td {
		border-top: 0;
		line-height: 1.42857;
		padding: 8px;
		vertical-align: top;
	}
</style>

<body>
	<div class="">
		<div class="row border-bottom white-bg" style="padding:10px;">
			<div class="pull-left" style="padding-left:20px">
				<table class="table" style="margin-bottom: 0;">
					<tbody>
						<tr>
							<td><?php echo $breadcrumb ?></td>
						</tr>
						<tr>
							<td>
								<button class="btn btn-primary btn-sm href=form" href="<?php echo site_url('backend/user/form'); ?>"><a style="color:#fff" class="fa fa-plus" href="<?php echo site_url('backend/user/form'); ?>"> Tambah</a></button>
							</td>

							<td>

							</td>
							<td>
								<div class="dropdown">
									<button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown"> Ekspor
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="<?php echo site_url('backend/user/form'); ?>">PDF</li>
										<li><a href="#">EXCEL</a></li>
									</ul>
								</div>
							</td>
							<td>

							</td>
							<form action="user/cari">
							<td>
								<div class="input-group mb-3">
									<input id="keyword" type="text" class="form-control" name="keyword" placeholder="Keyword..." aria-label="Keyword..." aria-describedby="basic-addon2">
									<div class="input-group-append">
										<button class="btn btn-info" type="submit">Cari</button>
									</div>
								</div>

							</td>
							</form>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
<?php echo btnSearch() ?>
		
		<div id="app" class="row border-bottom white-bg" style="padding:10px; padding-bottom:40px;">
			<div class="col-md-12" style="padding-left:20px">
				<table id="jqGridTable" class="table table-striped table-bordered table-sm" cellspacing="0" aria-multiselectable="false" style="width: 100%;">
					<thead>
						<tr style="border: 1px solid #f5f5f6; background: #f5f5f6; ">
							<span class="ui-icon-triangle-1-n">
								<th class="th-sm icon-star icon-triangle ui-icon-triangle-1-n ui-sort-ltr" style="border: 1px solid #b6b6b6;  text-align: center;">Username</th>
							</span>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">Email</th>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">Jabatan</th>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">Level</th>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">Pengadilan</th>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">First Name</th>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">Last Name</th>
							<th style="border: 1px solid #b6b6b6;  text-align: center;">Action
						
						</th>
						</tr>
					</thead>
					<?php
					$count = 0;

					foreach ($user as $row) :
						$count++;
						?>
						<tr role="row" aria-selected="false">
							<td title="<?php echo $row->username ?>" style="solid #b6b6b6;  text-align: center;"><?php echo $row->username; ?></td>
							<td title="<?php echo $row->email ?>" style=" solid #b6b6b6;  text-align: center;"><?php echo $row->email; ?></td>
							<td title="<?php echo $row->jabatan ?>" style=" solid #b6b6b6;  text-align: center;"><?php echo $row->jabatan; ?></td>
							<td title="<?php echo $row->level ?>" style=" solid #b6b6b6;  text-align: center;"><?php echo $row->level; ?></td>
							<td title="<?php echo $row->id_pengadilan ?>" style=" solid #b6b6b6;  text-align: center;"><?php echo $row->id_pengadilan; ?></td>
							<td title="<?php echo $row->first_name ?>" style=" solid #b6b6b6;  text-align: center;"><?php echo $row->first_name; ?></td>
							<td title="<?php echo $row->last_name ?>" style="solid #b6b6b6;  text-align: center;"><?php echo $row->last_name; ?></td>
							<td style="text-align:center;">
							<?php echo btnEdits($row->id_pengadilan)
							
							?>								
							
							<?php echo btnHapus($row->id_pengadilan) ?>			
							<?php echo btnExcelPdf($row->id) ?>		
							</td>
						</tr>
					<?php endforeach; ?>
					<tr style=" border: 1px solid #f5f5f6; background: #f5f5f6; width= 80; ">
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
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dtBasicExample').DataTable({
			"paging": true // false to disable pagination (or any other option)
		});
		$('.dataTables_length').addClass('bs-select');
	});
</script>