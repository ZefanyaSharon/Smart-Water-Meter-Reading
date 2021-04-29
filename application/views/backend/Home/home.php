<style>
	li.list-group-item {
		border: 0 none;
		padding: 0;
		margin: 0;
	}
	.legend-label {
		font-size: 11px;
	}
	.badge {
		padding : 0px;
	}
</style>
<div class="animated fadeInRight">
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/putusan'); ?>"><h5>Putusan</h5></a>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
						<small>Total putusan</small>
						<div id="chart_putusan"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/kaidah'); ?>"><h5>Kaidah</h5></a>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-3">
								<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
								<small>Total kaidah</small>
							</div>
							<div class="col-lg-9" id="donut_kaidah">
								<div class="col-md-5">
									<div id="chart"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/rumusan_kamar'); ?>"><h5>Rumusan Kamar</h5></a>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
						<small>Total Rumusan</small>
						<div id="chart_rumusan"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/yurisprudensi'); ?>"><h5>Yurisprudensi</h5></a>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
						<small>Total Yurisprudensi</small>
						<div id="chart_yurisprudensi"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/restatement'); ?>"><h5>Restatement</h5></a>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
						<small>Total restatement</small>
						<div id="chart_restatement"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/peraturan'); ?>"><h5>Peraturan</h5></a>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
						<small>Total peraturan</small>
						<div id="chart_peraturan"></div>
					</div>
				</div>
			</div>
			<!-- <div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<a href="<?php echo site_url('backend/meta_data'); ?>"><h5>Metadata Korupsi</h5></a>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins"><?php echo ($countVerdict) ? $countVerdict : '&#8212;' ?></h1>
						<small>Antrian metadata korupsi</small>
						<div id="chart_metadata"></div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
<?php if(isset($metabase_iframe)) { ?>
<div class="row">
<?php foreach ($metabase_iframe as $metabase) { ?>
	<div class="col-md-12">
		<iframe src="<?php echo $metabase ?>" width="1200" height="1000" frameborder="0"></iframe>
	</div>
<?php
}?>
</div>
<?php
	}
?>
</div>

<script>
	$(document).ready(function () {
		c3.generate({
			bindto: '#chart_putusan',
			size: {
				height: 50
			},
			data:{
				columns: [
					<?php echo $lineChartVerdict ?>
				],
				colors:{
					aa: '#1ab394',
					bb: '#BABABA'
				}
			},
			axis: {
				x: {show:false},
				y: {show:false}
			},
			legend: {
				show: false
			},
			tooltip: {
				format: {
					title: function (x, index) {
						return (x + 1) + ' ' + '<?php echo $configMonths[$currentMonth] ?>' + ' ' + '<?php echo $currentYear ?>';
					},
					name: function (name, ratio, id, index) {
						return name;
					}
				},
				position: function (data, width, height, element) {
					var left = d3.mouse(element)[0];
					if (left > 440)
						left -= 120;
      				return {top: -50, left: left}
				}
			}
		});
		var chart = c3.generate({
			bindto: '#chart',
			size: {
				height: 100,
				width: 100,
			},
			data: {
				// iris data from R
				columns: <?php echo $pieChartKaidah ?>,
				type : 'donut'
			},
			legend: {
				show: false
			},
		});

		d3.select('#donut_kaidah').insert('div')
			.attr('class', 'legend col-md-7')
			.insert('ul').attr('class', 'list-group')
			.selectAll('span')
			.data(['Kaidah', 'Tanpa Kaidah'])
			.enter().append('li').attr('class', 'list-group-item')
			.append('div').attr('class', 'legend-label')
			.attr('data-id', function(id) {
				return id;
			})
			.append('div', '.legend-label')
			.html(function(id) {
				var data = chart.data(id);
				return id + '&nbsp;&nbsp;&nbsp;';
			})
			.on('mouseover', function(id) {
				chart.focus(id);
			})
			.on('mouseout', function(id) {
				chart.revert();
			})
			.insert('span', '.legend-label').attr('class', 'badge')
			.each(function(id) {
				d3.select(this).style('background-color', chart.color(id));
			})
			.html(function(id){
				return '&nbsp&nbsp&nbsp&nbsp&nbsp'
			});

		c3.generate({
			bindto: '#chart_rumusan',
			size: {
				height: 50
			},
			data:{
				columns: [
					<?php echo $lineChartRumusan ?>
				],
				colors:{
					aa: '#1ab394',
					bb: '#BABABA'
				}
			},
			axis: {
				x: {show:false},
				y: {show:false}
			},
			legend: {
				show: false
			},
			tooltip: {
				format: {
					title: function (x, index) {
						return (x + 1) + ' ' + '<?php echo $configMonths[$currentMonth] ?>' + ' ' + '<?php echo $currentYear ?>';
					},
					name: function (name, ratio, id, index) {
						return name;
					}
				},
				position: function (data, width, height, element) {
					var left = d3.mouse(element)[0];
					if (left > 440)
						left -= 130;
      				return {top: -50, left: left}
				}
			}
		});

		c3.generate({
			bindto: '#chart_yurisprudensi',
			size: {
				height: 50
			},
			data:{
				columns: [
					<?php echo $lineChartYurisprudensi ?>
				],
				colors:{
					aa: '#1ab394',
					bb: '#BABABA'
				}
			},
			axis: {
				x: {show:false},
				y: {show:false}
			},
			legend: {
				show: false
			},
			tooltip: {
				format: {
					title: function (x, index) {
						return (x + 1) + ' ' + '<?php echo $configMonths[$currentMonth] ?>' + ' ' + '<?php echo $currentYear ?>';
					},
					name: function (name, ratio, id, index) {
						return name;
					}
				},
				position: function (data, width, height, element) {
					var left = d3.mouse(element)[0];
					if (left > 440)
						left -= 130;
      				return {top: -50, left: left}
				}
			}
		});

		c3.generate({
			bindto: '#chart_restatement',
			size: {
				height: 50
			},
			data:{
				columns: [
					<?php echo $lineChartRestatement ?>
				],
				colors:{
					aa: '#1ab394',
					bb: '#BABABA'
				}
			},
			axis: {
				x: {show:false},
				y: {show:false}
			},
			legend: {
				show: false
			},
			tooltip: {
				format: {
					title: function (x, index) {
						return (x + 1) + ' ' + '<?php echo $configMonths[$currentMonth] ?>' + ' ' + '<?php echo $currentYear ?>';
					},
					name: function (name, ratio, id, index) {
						return name;
					}
				},
				position: function (data, width, height, element) {
					var left = d3.mouse(element)[0];
					if (left > 440)
						left -= 130;
      				return {top: -50, left: left}
				}
			}
		});

		c3.generate({
			bindto: '#chart_peraturan',
			size: {
				height: 50
			},
			data:{
				columns: [
					<?php echo $lineChartPeraturan ?>
				],
				colors:{
					aa: '#1ab394',
					bb: '#BABABA'
				}
			},
			axis: {
				x: {show:false},
				y: {show:false}
			},
			legend: {
				show: false
			},
			tooltip: {
				format: {
					title: function (x, index) {
						return (x + 1) + ' ' + '<?php echo $configMonths[$currentMonth] ?>' + ' ' + '<?php echo $currentYear ?>';
					},
					name: function (name, ratio, id, index) {
						return name;
					}
				},
				position: function (data, width, height, element) {
					var left = d3.mouse(element)[0];
					if (left > 440)
						left -= 130;
      				return {top: -50, left: left}
				}
			}
		});
	});
</script>