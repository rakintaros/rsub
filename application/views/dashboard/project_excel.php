<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $member = $this->session->userdata('member_logged_in');?>

<?php 
$project_year = $this->session->userdata('project_year');
		$project_type = $this->session->userdata('project_type');
$ar_type = array(
			'all'=>'โครงการทั้งหมด',
			'pre'=>'โครงการที่ระหว่างยื่นข้อเสนอ',
			'doing'=>'โครงการที่กำลังดำเนินการ',
			'done'=>'โครงการที่ดำเนินการเสร็จแล้ว',
			'research'=>'งานบริการวิชาการ และอื่น ๆ',
			'notbudget'=>'โครงการที่ไม่ได้รับงบประมาณ',
		);
		$title =  $ar_type[$project_type].' ปี '.($project_year+543);


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".basename("project-".($project_year+543).".xls")."\"");
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
	<h3><?=$title?></h3>
	
	<table class="table table-bordered db_table">
		<thead >
			<tr style="background-color:#40573b;color:#fff;">
				<th style="width:50px;text-align:center;">ลำดับ</th>
				<th style="width:650px;text-align:center;">ชื่อโครงการวิจัย </th>
				<th style="width:220px;text-align:center;">สถานะโครงการ</th>
				<th style="width:150px;text-align:center;">จำนวนเงิน</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$advance_total = 0;
			$i=0;
			foreach($rsList as $item){
				$i++;
				$advance_total +=$item->project_budget;
		?>	
			<tr>
				<td style="text-align:center"><?=$i?></td>
				<td><?=$item->project_name?></td>
				<td style="text-align:center"><?=$ar_type[$item->project_status]?></td>
				<td style="text-align:right" class="str"><?=number_format($item->project_budget,2)?></td>
			</tr>			

		<?php }?>
		<tr style="background-color:#40573b;color:#fff;">
			<th colspan="3" style="text-align:center;">รวมทั้งหมด</th>
			<th colspan="1" style="text-align:right;"><?=number_format($advance_total,2)?></th>
		</tr>
		</tbody>
	</table>
		
</body>
</html>
