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

		<div style="min-height:400px;">
			<h3><?=$rs[0]->topic_name?></h3>
			<p><?=$rsDoc[0]->doc_name?></p>
			<hr/>

			<form class="forms-sample" enctype="multipart/form-data" action="#" method="post">
				<div class="form-group row">
					<label for="project_name" class="col-sm-2 col-form-label">ชื่อไฟล์</label>
					<div class="col-sm-10">				
						<input type="text" class="form-control" id="doc_name" name="doc_name" value="<?=@$rsDoc[0]->doc_name?>">
					</div>
				</div>	
				<div class="form-group row">
					<label for="project_name" class="col-sm-2 col-form-label">ไฟล์แนบ</label>
					<div class="col-sm-10">				
						<input type="file" name="doc_file" class=" mb-2 mr-sm-2"/>
						<hr/>
						<a href="/documents/<?=$rsDoc[0]->doc_file?>"><?=$rsDoc[0]->doc_name?></a>
					</div>
				</div>	
				<div class="form-group row">
					<label for="project_name" class="col-sm-2 col-form-label"></label>
					<div class="col-sm-10">				
						<input type="hidden" name="doc_id" value="<?=$rsDoc[0]->doc_id?>"/>
						<input type="hidden" name="doc_topic_id" value="<?=$topic_id?>"/>
						<button type="submit" class="btn btn-gradient-primary mb-2">อัพโหลด</button>
					</div>
				</div>	
				
			</form>
			
		</div>
	<script src="<?=base_url('template/dashboard/')?>assets/vendors/js/vendor.bundle.base.js"></script>
	<script src="<?=base_url('template/dashboard/')?>assets/js/off-canvas.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/hoverable-collapse.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/misc.js"></script>	
	</body>
</html>
			