<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $member = $this->session->userdata('member_logged_in');?>
<?php $project_type = $this->session->userdata('project_type');?>
<?php $project_year = $this->session->userdata('project_year');?>
<?php 

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".basename("account-".($project_year+543).".xls")."\"");
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
	<h3>บัญชีดำเนินโครงการ <?=$project_year+543?></h3>
	
	<table class="table table-bordered db_table">
		<thead >
			<tr style="background-color:#40573b;color:#fff;">
				<th style="width:50px;text-align:center;">ลำดับ</th>
				<th style="width:650px;text-align:center;">ชื่อโครงการวิจัย </th>
				<th style="width:150px;text-align:center;">จำนวนเงิน</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$i=0;
			foreach($rsList as $item){
				$i++;
		?>	
			<tr>
				<td style="text-align:center"><?=$i?></td>
				<td><?=$item->project_name?></td>
				<td style="text-align:center"><?=getProjectStatus($item->project_status)?></td>
			</tr>			

		<?php }?>

		</tbody>
	</table>
		
</body>
</html>
