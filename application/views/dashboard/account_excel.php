<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $member = $this->session->userdata('member_logged_in');?>

<?php 
$tab3_obj = null;
$project_name='';
$account_id='';
$total=0;
if($rs!=null){
	$tab3_data = json_decode(@$rs[0]->tab3_obj);
	$tab3_obj = (array) @$tab3_data;
	$project_name = $rs[0]->account_project_name;
	$account_id = $rs[0]->account_id;
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".basename("A-".$account_id.".xls")."\"");
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
	<h3><?=$project_name?></h3>
	<p>รายจ่ายในการดำเนินโครงการ</p>
	<table class="table table-bordered db_table">
		<thead >
			<tr style="background-color:#40573b;color:#fff;">
				<th style="width:50px;text-align:center;">ลำดับ</th>
				<th style="width:150px;text-align:center;">หมวดหมู่</th>
				<th style="width:150px;text-align:center;">วดป</th>
				<th style="width:500px;text-align:center;">รายละเอียด</th>
				<th style="width:150px;text-align:center;">เลขที่อ้างอิง</th>
				<th style="width:150px;text-align:center;">จำนวนเงิน</th>
			</tr>
		</thead>
	<?php if(@$tab3_obj!=null){?>
	<?php foreach($tab3_obj as $kk=>$v){?>
			<tr style="background-color:#9cc693;">
				<td colspan="6" style="text-align:left;"><?=$v->section_name?></td>
			</tr>
			<?php 
				if(@$v->value->date!=null){
					$ar_list = $v->value->date;
					$i=0;
					foreach($ar_list as $kkk=>$vv){$i++;?>
					<tr>
						<td style="text-align:center"><?=$i?></td>
						<td style="text-align:left"><?=getAccountCat($v->value->cat->$kkk)?></td>
						<td class="str" style="text-align:center"><?=$v->value->date->$kkk?></td>
						<td style="text-align:left"><?=$v->value->detail->$kkk?></td>
						<td style="text-align:left"><?=$v->value->ref->$kkk?></td>
						<td style="text-align:right"><?=number_format(rmComma($v->value->money->$kkk),2)?></td>
					</tr>
					<?php $total += rmComma($v->value->money->$kkk);?>
					<?php }?>
				<?php }?>

		<?php }?>
	<?php }?>
		<tr style="background-color:#40573b;color:#fff;">
			<th colspan="5" style="text-align:center;">รวมทั้งหมด</th>
			<th colspan="1" style="text-align:right;"><?=number_format($total,2)?></th>
		</tr>
	</table>
		
</body>
</html>