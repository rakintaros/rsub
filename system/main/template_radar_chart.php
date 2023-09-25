<?php $member = $this->session->userdata('member_logged_in');?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('template')?>/img/favicon.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('template')?>/img/favicon.jpg">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('template')?>/img/favicon.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('template')?>/img/favicon.jpg">
    <meta name="msapplication-TileImage" content="<?=base_url('template')?>/img/favicon.jpg">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="<?=base_url('template')?>/css/theme2.css?v=<?=date('his')?>" rel="stylesheet" />
	<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  </head>
	<?php 
		$ar_colors= array('#ff6961','#ffb480','#f8f38d','#42d6a4','#08cad1','#59adf6','#9d94ff','#c780e8');
		
		
		foreach(@$examList as $item){
			$g_name['g_'.$item['group_id']] = $item['group_name'];
		}
		$result = array();
		$chart = array();
		$score_total = array();
		$score = array();
		if(@$examResult!=null){
			foreach($examResult as $item){
				$result['g_'.$item->submit_group_id] = (array)json_decode($item->submit_value);
				$chart['g_'.$item->submit_group_id] = $item->submit_score_percent;
				$score['g_'.$item->submit_group_id] = $item->submit_score;
				$score_total['g_'.$item->submit_group_id] = $item->submit_score_total;
			}
		}

	?>
	<style>
	#chart_box{
		position: relative;
		width: 500px;
	}
	.legend{position: absolute;z-index: 9;font-size: 13px;}
	.legend_1{top: 15%;right: 10%;color: <?=$ar_colors[0]?>;}
	.legend_2{top: 50%;right: 10%;color: <?=$ar_colors[1]?>;}
	.legend_3{bottom: 15%;right: 15%;color: <?=$ar_colors[2]?>;}
	.legend_4{bottom: 2%;left: 45%;color: <?=$ar_colors[3]?>;}
	.legend_5{bottom: 15%;left: 15%;color: <?=$ar_colors[4]?>;}
	.legend_6{bottom: 50%;left: 10%;color: <?=$ar_colors[5]?>;}
	.legend_7{top: 15%;left: 15%;color: <?=$ar_colors[6]?>;}
	.legend_8{top: 2%;left: 43%;color: <?=$ar_colors[7]?>;}
	</style>
	
	<body>
	
	<div class="container-fluid">
		<div class="pt-3 pb-3">
		<h2 class="mb-3"><?=$rsMember->member_name?></h2>
		<div id="chart_box">
			<span class="legend legend_1"><?=$g_name['g_1']?></span>
			<span class="legend legend_2"><?=$g_name['g_2']?></span>
			<span class="legend legend_3"><?=$g_name['g_3']?></span>
			<span class="legend legend_4"><?=$g_name['g_4']?></span>
			<span class="legend legend_5"><?=$g_name['g_5']?></span>
			<span class="legend legend_6"><?=$g_name['g_6']?></span>
			<span class="legend legend_7"><?=$g_name['g_7']?></span>
			<span class="legend legend_8"><?=$g_name['g_8']?></span>
			<div id="container"></div>
		</div>
		</div>
	</div>

    <script src="<?=base_url('template')?>/vendors/@popperjs/popper.min.js"></script>
    <script src="<?=base_url('template')?>/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url('template')?>/vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="<?=base_url('template')?>/vendors/fontawesome/all.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/highcharts-more.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/modules/accessibility.js"></script>
		<script>
		var colors = ['#ff6961','#ffb480','#f8f38d','#42d6a4','#08cad1','#59adf6','#9d94ff','#c780e8'];
		Highcharts.chart('container', {

			chart: {
				polar: true,
				type: 'area'
			},

			accessibility: {
				description: ''
			},

			title: {
				text: '',
				x: -80
			},

			pane: {
				size: '90%'
			},

			xAxis: {
				categories: ['<?=$g_name["g_1"]?>', '<?=$g_name["g_2"]?>', '<?=$g_name["g_3"]?>', '<?=$g_name["g_4"]?>', '<?=$g_name["g_5"]?>', '<?=$g_name["g_6"]?>', '<?=$g_name["g_7"]?>', '<?=$g_name["g_8"]?>'],
				tickmarkPlacement: 'off',
				lineWidth: 0,
				labels: {enabled: false}
			},

			yAxis: {
				gridLineInterpolation: 'polygon',
				tickInterval: 20,
				min: 0 ,
				max: 101,
				
			},

			tooltip: {enabled: false},
			credits: {enabled: false},
			legend: {enabled: false},
			series: [
				{
					type: 'area',
					name: 'Area',
					data: [<?=$chart["g_1"]?>, <?=$chart["g_1"]?>, 0, 0, 0, 0, 0, 0],
					color: colors[0]
				},
				{
					type: 'area',
					name: 'Area2',
					data: [0, <?=$chart["g_2"]?>, <?=$chart["g_2"]?>, 0, 0, 0, 0, 0],
					color: colors[1]
				},
				{
					type: 'area',
					name: 'Area3',
					data: [0, 0, <?=$chart["g_3"]?>, <?=$chart["g_3"]?>, 0, 0, 0, 0],
					color: colors[2]
				},
				{
					type: 'area',
					name: 'Area4',
					data: [0, 0, 0, <?=$chart["g_4"]?>, <?=$chart["g_4"]?>, 0, 0, 0],
					color: colors[3]
				},
				{
					type: 'area',
					name: 'Area5',
					data: [0, 0, 0, 0, <?=$chart["g_5"]?>, <?=$chart["g_5"]?>, 0, 0],
					color: colors[4]
				},
				{
					type: 'area',
					name: 'Area6',
					data: [0, 0, 0, 0, 0, <?=$chart["g_6"]?>, <?=$chart["g_6"]?>, 0],
					color: colors[5]
				},
				{
					type: 'area',
					name: 'Area7',
					data: [0, 0, 0, 0, 0, 0, <?=$chart["g_7"]?>, <?=$chart["g_7"]?>],
					color: colors[6]
				},
				{
					type: 'area',
					name: 'Area8',
					data: [<?=$chart["g_8"]?>, 0, 0, 0, 0, 0, 0, <?=$chart["g_8"]?>],
					color: colors[7]
				}
				
				
				
			]

		});
		</script>
  </body>

</html>