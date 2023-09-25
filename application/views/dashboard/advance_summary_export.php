<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $member = $this->session->userdata('member_logged_in');?>

<?php 

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".basename("advance_summary-".$advance_m."-".$advance_y.".xls")."\"");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style> .str{ mso-number-format:\@; } </style>
</head>
<body>
	<h3>สรุปขอยืมทดลองจ่ายประจำเดือน <?=getMonth($advance_m)?> <?=($advance_y+543)?></h3>
	<table class="table table-bordered db_table">
		<thead >
			<tr style="background-color:#40573b;color:#fff;">
				<th style="width:150px;text-align:center;">เลขที่</th>
				<th style="width:500px;text-align:center;">โครงการ</th>
				<th style="width:150px;text-align:center;">ผู้ตั้งเบิก</th>
				<th style="width:150px;text-align:center;">ยอดตั้งเบิก</th>
				<th style="width:150px;text-align:center;">ยอดโอน</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($rsList as $k=>$v){
			$data = json_decode(@$v->advance_detail);
			$advance_detail = (array) @$data;
			
			$advance_prict = 0;
				
			if($advance_detail!=null){
				foreach($advance_detail['list'] as $kk=>$v2){
					$advance_prict+=rmComma($advance_detail['price'][$kk]);
				}
			}
			$advance_total+=$advance_prict;
			$advance_total2+=$advance_prict-$v->advance_refunds_price;
			
		?>
			<tr>
				<td style="text-align:center"><?=$v->advance_code?></td>
				<td><?=$v->advance_project_name?></td>
				<td style="text-align:center"><?=$v->member_name?></td>
				<td style="text-align:right"><?=number_format($advance_prict,2)?></td>
				<td style="text-align:right"><?=number_format($advance_prict-$v->advance_refunds_price,2)?></td>
			</tr>
		<?php }?>
		<tr style="background-color:#40573b;color:#fff;">
			<th colspan="3" style="text-align:center;"></th>
			<th colspan="1" style="text-align:right;"><?=number_format($advance_total,2)?></th>
			<th colspan="1" style="text-align:right;"><?=number_format($advance_total2,2)?></th>
		</tr>
		</tbody>
	</table>
		
</body>
</html>