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
	
	<style>.section_title{color:#009aff;font-weight:500;border-bottom:1px dashed;font-size:17px}tr.pad-0 td{padding:0;font-size:13px}.pad-left-5{padding-left:8px!important}#container{height:550px}h4.reduce{font-size:16px;font-weight:500;color:#435ea8}h4.reduce span{background-color:#435ea8;padding:5px;border-radius:10px;color:#fff}</style>
  </head>
	<?php 
		$base_year = null;
		$detail = @json_decode($rsInfo->member_detail);
		if(@$detail!=null){
			$submit_data[$detail->member_year_default] = json_decode(json_encode(json_decode($rsInfo->member_base)));
			$base_year = $detail->member_year_default-543;
		}
		
		if(@$rsDatabaseProfile!=null){
			foreach($rsDatabaseProfile as $item){
				$submit_data[$item->data_year] = json_decode(json_encode(json_decode($item->data_base)));
			}
		}
		
		$submit_data_final = array();
		$SubmitRefrigerant = array();
		$SubmitEF = array();
		$year_text ='';
		if(@$submit_data!=null){
			foreach($submit_data as $k_year=>$submit){
				$year_text .=','.$k_year;
				if(@$submit_data[$k_year]->submit!=null){
					foreach($submit_data[$k_year]->submit as $k_g=>$g_v){
						$submit_data_final[$k_year][$k_g] = (array)$g_v;
						
					}
				}
				
				if(@$submit->submit_refrigerant!=null){
					foreach($submit->submit_refrigerant as $k=>$v){
						$v = (array)$v;
						$v['value'] = (array)$v['value'];
						$SubmitRefrigerant[$k_year][$k]= $v;
					}
				}
			}
		}
		if(@$rsSubmitEF!=null){
			foreach($rsSubmitEF as $v){
				$SubmitEF[$v->ef_key] = $v->ef_value;
			}
		}
		$year_text=substr($year_text,1);


		
		$ef_value = array(
			'scope_1'	=> 2.1892,
			'scope_2'	=> 2.7076,
			'scope_3'	=> 3.1133,
			'scope_4'	=> 3.1133,
			
			'scope_5'	=> 2.2373,
			'scope_6'	=> 2.7403,
			'scope_7'	=> 3.1988,
			'scope_8'	=> 0.2843,
			
			'scope_13'	=> 2.3200,
			
			'scope_17'	=> 1,
			'scope_18'	=> 0.4999,
		);
		$scope_value1 = array();
		$scope_value2 = array();
		$scope_value3 = array();
		
		?>
		
		<?php $ar_scope = array(1, 2, 3, 4)?>
										<?php foreach($rsScope as $item){?>
						
											<?php if($item['rsScope']!=null){?>
												<?php foreach($item['rsScope'] as $scope){?>
													<?php if(in_array($scope['scope_id'], $ar_scope)){?>
													
													<?php foreach($submit_data as $k=>$v){?>
														
															<?php 
															$row_total =0;
															for($i=1; $i<=12; $i++){
																$row_total+= @$submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]):0;
															}
															?>
															<?php 
															$result = ($ef_value['scope_'.$scope['scope_id']]*$row_total)/1000;
															@$scope_value1[$k] += $result;
															?>
															
													<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
										
										<?php $ar_scope = array(5, 6, 7)?>
										<?php foreach($rsScope as $item){?>
						
											<?php if($item['rsScope']!=null){?>
												<?php foreach($item['rsScope'] as $scope){?>
													<?php if(in_array($scope['scope_id'], $ar_scope)){?>
													
													<?php foreach($submit_data as $k=>$v){?>
														
															<?php 
															$row_total =0;
															for($i=1; $i<=12; $i++){
																$row_total+= @$submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]):0;
															}
															?>
															<?php 
															$result = ($ef_value['scope_'.$scope['scope_id']]*$row_total)/1000;
															@$scope_value1[$k] += $result;
															?>
															
													<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
										
										<?php foreach($rsScope as $item){?>
						
											<?php if($item['rsScope']!=null){?>
												<?php foreach($item['rsScope'] as $scope){?>
													<?php if($scope['scope_id']==9){?>
													
													<?php foreach($submit_data as $k=>$v){?>
														
															<?php 
															$row_total =0;
															$type_id = @$submit_data_final[$k]['scope_9'][0];
															for($i=1; $i<=12; $i++){
																$x	= @$submit_data_final[$k]['scope_10']['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_10']['v_'.$i]) : 0;
																$y	= @$submit_data_final[$k]['scope_11']['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_11']['v_'.$i]) : 0;
																$row_total+= $x*$y;
															}
															$row_total = ($row_total/12)/1000;
															?>
															<?php 
															$result = @(((getWatherTypeList($type_id,'value')*0.6)*$row_total)*28)/1000;
															@$scope_value1[$k] += $result;
															?>
															
															
													<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
										
										
										<?php $ar_scope = array(13)?>
										<?php foreach($rsScope as $item){?>
						
											<?php if($item['rsScope']!=null){?>
												<?php foreach($item['rsScope'] as $scope){?>
													<?php if(in_array($scope['scope_id'], $ar_scope)){?>
													
													<?php foreach($submit_data as $k=>$v){?>
														<?php 
															$row_total =0;
															for($i=1; $i<=12; $i++){
																$row_total+= @$submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]):0;
															}
															?>
															<?php 
															$result = ($ef_value['scope_'.$scope['scope_id']]*$row_total);
															@$scope_value1[$k] += $result;
															?>
															
													<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
										
										
										
													<?php $show_btn=0;foreach($SubmitRefrigerant as $kk=>$vv){?>
													<?php foreach($vv as $k=>$v){?>
														
														<?php if($vv[$k]['type']=='type_4'){?>
															
														<?php }else{?>
															
														<?php }?>
															
															<?php 
															$row_total =0;
															for($i=1; $i<=12; $i++){
																$row_total+= @$vv[$k]['value']['v_'.$i]!=null? rmComma($vv[$k]['value']['v_'.$i]):0;
															}
															?>
															
															<?php if($vv[$k]['type']=='type_4'){$show_btn = 1;?>
																<?php $result = @(0*$row_total);?>
																
																<?php $result = @($SubmitEF[$k]*$row_total)/1000;?>
															<?php }else{?>
																<?php $result = @(getRefrigerantTypeList($vv[$k]['type'], 'value')*$row_total)/1000;?>
															
															<?php }?>
															<?php 
																@$scope_value1[$k] += $result;
															?>
															
													<?php }?>
													<?php }?>
											
											
										
										<?php foreach($rsScope as $item){?>
						
											<?php if($item['rsScope']!=null){?>
												<?php foreach($item['rsScope'] as $scope){?>
													<?php if($scope['scope_id']==18){?>
													<?php foreach($submit_data as $k=>$v){?>
														
															<?php 
															$row_total =0;
															for($i=1; $i<=12; $i++){
																$row_total+= @$submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]):0;
															}
															?>
															<?php 
															$result = ($ef_value['scope_'.$scope['scope_id']]*$row_total)/1000;
															$scope_value2[$k] = $result;
															?>
															
													<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>

										<?php foreach($rsScope as $item){?>
						
											<?php if($item['rsScope']!=null){?>
												<?php foreach($item['rsScope'] as $scope){?>
													<?php if($scope['scope_id']==8){?>
													<?php foreach($submit_data as $k=>$v){?>
														
															<?php 
															$row_total =0;
															for($i=1; $i<=12; $i++){
																$row_total+= @$submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]!=null? rmComma($submit_data_final[$k]['scope_'.$scope['scope_id']]['v_'.$i]):0;
															}
															?>
															<?php 
															$result = ($ef_value['scope_'.$scope['scope_id']]*$row_total)/1000;
															$scope_value3[$k] = $result;
															?>

													<?php }?>
													<?php }?>
												<?php }?>
											<?php }?>
										<?php }?>
		
		
		<?php 
									$reduce_total 	= 0;
									$base_total 	= $scope_value1[($base_year+543)] + $scope_value2[($base_year+543)];
									if($rsMemberReduce!=null){
										foreach($rsMemberReduce as $item){
											$reduce_total+=$item->r_total;
										}
									}
									if($rsConfigReduce!=null){
										$data = (array)json_decode($rsConfigReduce[0]->config_value);
										$reduce_val1 = $data['reduce_val1'];
										$reduce_val2 = $data['reduce_val2'];
										$reduce_val3 = $data['reduce_val3'];
									}

									$ar_year = array('2030', '2050', '2065');
									$ar_list = array('Baseline Forecast', '% เป้าหมายการลด', 'ปริมาณก๊าซเรือนกระจกที่สามารถปล่อยได้', 'ปริมาณการลดก๊าซเรือนกระจกจากกิจกรรม', 'เหลือปริมาณก๊าซเรือนกระจกที่ต้องลด');
									
									
									
									$target[0][1] 	= @$rsReductionTarget[0]->target_value1!=null ? $rsReductionTarget[0]->target_value1 : 0;
									$target[1][1] 	= @$rsReductionTarget[0]->target_value2!=null ? $rsReductionTarget[0]->target_value2 : 0;
									$target[2][1] 	= @$rsReductionTarget[0]->target_value3!=null ? $rsReductionTarget[0]->target_value3 : 0;
									
									$target[0][0]	= number_format($base_total+($base_total*$data['reduce_val1']/100));
									$target[1][0]	= number_format($base_total+($base_total*$data['reduce_val2']/100));
									$target[2][0]	= number_format($base_total+($base_total*$data['reduce_val3']/100));
									
									$target[0][2]	= number_format($base_total-($base_total*$target[0][1]/100));
									$result			= $base_total-($base_total*$target[0][1]/100);
									$target[1][2]	= number_format($result-($result*$target[1][1]/100));
									$target2		= $result-($result*$target[1][1]/100);
									$target[2][2]	= number_format($target2-($target2*$target[2][1]/100));
									$target4		= $target2-($target2*$target[2][1]/100);
									
									$target[0][3]	= number_format($reduce_total);
									$target[1][3]	= number_format($reduce_total+($reduce_total*$target[1][1]/100));
									$target3		= $reduce_total+($reduce_total*$target[1][1]/100);
									$target[2][3]	= number_format($target3+($target3*$target[2][1]/100));
									$target5		= $target3+($target3*$target[2][1]/100);
									
									$target[0][4]	= number_format($reduce_total - $result);
									$target[1][4]	= number_format($target3 - $target2);
									$target[2][4]	= number_format($target5 - $target4);
									
									$Forecast[0]	= $base_total;
									$Forecast[1]	= $base_total+($base_total*$data['reduce_val1']/100);
									$Forecast[2]	= $base_total+($base_total*$data['reduce_val2']/100);
									$Forecast[3]	= $base_total+($base_total*$data['reduce_val3']/100);
									
									$Target[0]	= $base_total;
									$Target[1]	= $result;
									$Target[2]	= $target2;
									$Target[3]	= $target4;
									
									$Reduce[0]	= $base_total;
									$Reduce[1]	= $reduce_total;
									$Reduce[2]	= $target3;
									$Reduce[3]	= $target5;
	?>

	
	<body>
	
	<div class="container-fluid">
		<div class="pt-3 pb-3">
		<h2 class="mb-3"><?=$rsMember->member_name?></h2>
			
			<div class="mb-3 row">
				<div class="col-sm-4 col-form-label"><h4 class="reduce">เป้าหมายลดปี 2030 : <span><?=@$rsReductionTarget[0]->target_value1?>%</span></h4><div class="stat_line"></div></div>
				<div class="col-sm-4 col-form-label"><h4 class="reduce">เป้าหมายลดปี 2050 : <span><?=@$rsReductionTarget[0]->target_value2?>%</span></h4><div class="stat_line"></div></div>
				<div class="col-sm-4 col-form-label"><h4 class="reduce">เป้าหมายลดปี 2065 : <span><?=@$rsReductionTarget[0]->target_value3?>%</span></h4><div class="stat_line"></div></div>				
			</div>
			
			<div class="row">
									<div class="col-md-7"> <div id="container"></div> </div>
									<div class="col-md-5">
										<table class="table table-borderless">
											<tr>
												<td colspan="2"><h4 class="section_title">2022 ปีฐานการปล่อยก๊าซเรือนกระจก</h4></td>
											</tr>
											<tr class="pad-0">
												<td class="text-end"><?=number_format($base_total)?></td>
												<td class="pad-left-5">Base Year</td>
											</tr>
											
											<?php foreach($ar_year as $year=>$item){?>
											<tr>
												<td colspan="2"><h4 class="section_title"><?=$item?> ปีฐานการปล่อยก๊าซเรือนกระจก</h4></td>
											</tr>
												<?php foreach($ar_list as $k=>$item2){?>
												<tr class="pad-0">
													<td class="text-end"><?=@$target[$year][$k]?></td>
													<td class="pad-left-5"><?=$ar_list[$k]?></td>
												</tr>
												<?php }?>
											<?php }?>
										</table>
									</div>
								</div>
		</div>
	</div>

    <script src="<?=base_url('template')?>/vendors/@popperjs/popper.min.js"></script>
    <script src="<?=base_url('template')?>/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url('template')?>/vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="<?=base_url('template')?>/vendors/fontawesome/all.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/modules/accessibility.js"></script>
		<script>

	var x_labels = ['<?=$base_year?>', '2030', '2050', '2065'];
		Highcharts.chart('container', {
			chart: {
				type: 'line'
			},
			title: {
				text: ''
			},
			yAxis: {
				title: {
					text: 'tCO2eq/year'
				},
			},
			xAxis: {
				
			
				labels: {
            formatter: function() {
                return x_labels[this.value];
            }
        },
				 showLastLabel: true,
			},
			credits: {
				enabled: false
			},
			
			
			series: [{
				name: 'กรณีปกติ (Business as Usual: BAU)',
				data: [<?=$Forecast[0]?>, <?=$Forecast[1]?>, <?=$Forecast[2]?>, <?=$Forecast[3]?>]
			},{
				name: 'กรณีดำเนินกิจกรรมลดตามเป้าหมาย (Target Reduction)',
				data: [<?=$Target[0]?>, <?=$Target[1]?>, <?=$Target[2]?>, <?=$Target[3]?>]
			}]
		});
		</script>
  </body>

</html>