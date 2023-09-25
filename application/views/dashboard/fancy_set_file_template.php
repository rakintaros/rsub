<?php $member = $this->session->userdata('member_logged_in');?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$this->config->item('title_name')?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/css/style.css">
    <!-- End layout styles -->
	</head>
	<body>
	<?php 
		$set_data = array();
		if($rs){
			$set_data = json_decode($rs[0]->set_data);
		}
	?>
		<div style="min-height:400px;padding:10px 0;">
			<h3>แบบฟอร์มที่เกี่ยวข้อง</h3>
			<div class="alert alert-info">
				คุณสามารถเลือกแบบฟอร์ม ที่มีอยู่ในเมนูแบบฟอร์มที่เกี่ยวข้อง มาไว้ในขึ้นตอนที่ <?=$vb_point?> นี้<br/>
				จากนั้นสมาชิกที่ได้สิทธิ์เข้าถึง จะสามารถเห็นไฟล์ดังกล่าวได้ที่ช่องนี้เลย
			</div>
			<form class="" enctype="multipart/form-data" method="post">
				<?php foreach($rsList as $item){?>
					<p><strong><i class="mdi mdi-view-headline"></i> <?=$item['topic_name']?></strong></p>
					<?php foreach($item['subScope'] as $subItem){?>
						<div style="margin-left:15px;">
						<div class="form-check">
							<label class="form-check-label">
							<input type="checkbox" class="form-check-input" name="set_data[]" value="<?=$subItem['doc_id']?>" <?=@in_array($subItem['doc_id'], $set_data) ? 'checked':''?>/> <?=$subItem['doc_name']?></label>
						</div>
						</div>
					<?php }?>
				<?php }?>

				<p class="text-center">
					<input type="hidden" name="set_source_id" value="<?=$vb_id?>"/>		
					<input type="hidden" name="set_type" value="<?=$vb_type?>"/>		
					<input type="hidden" name="set_point" value="<?=$vb_point?>"/>		
					<button id="upload" type="submiy" class="btn btn-gradient-primary mb-2">บันทึก</button>
				</p>	

			</form>
		</div>
	<script src="<?=base_url('template/dashboard/')?>assets/vendors/js/vendor.bundle.base.js"></script>
	<script src="<?=base_url('template/dashboard/')?>assets/js/off-canvas.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/hoverable-collapse.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/misc.js"></script>	
	</body>
</html>
			