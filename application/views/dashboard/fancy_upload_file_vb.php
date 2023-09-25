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
			<h3><?=VBNamePoint($vb_type,$vb_point)?></h3>
			<hr/>
			<form class="form-inline" enctype="multipart/form-data" action="#" method="post">
				<input type="file" id="multiFiles" name="files[]" class=" mb-2 mr-sm-2" multiple="multiple"/>
				<input type="hidden" name="file_source_id" id="file_source_id" value="<?=$vb_id?>">
				<input type="hidden" name="file_point" id="file_point" value="<?=$vb_point?>">
				<input type="hidden" name="file_type" id="file_type" value="<?=$vb_type?>">
				<button id="upload" type="button" class="btn btn-gradient-primary mb-2">อัพโหลด</button>
			</form>
			<div id="msgLoad" style="display:none;"><img src="/img/loader.gif"></div>			
			<div id="msg"></div>
			<div id="dataTable"></div>
		</div>
	<script src="<?=base_url('template/dashboard/')?>assets/vendors/js/vendor.bundle.base.js"></script>
	<script src="<?=base_url('template/dashboard/')?>assets/js/off-canvas.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/hoverable-collapse.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/misc.js"></script>	
	<script>
	$(function() {
		function loadTable(){
			var table_header = '<table class="table"><thead class="bg-secondary"><tr><td>#</td><td>File Name</td><td>Size</td><td>By</td><td></td></tr></thead><tbody>';
			var table_footer = '</tbody></table>';
			var table_body = '';
			$.getJSON( "<?=base_url('dashboard/ajax_vbfile')?>", { file_source_id: '<?=$vb_id?>', file_point: '<?=$vb_point?>', file_type: '<?=$vb_type?>' } ).done(function( data ) {
				var i=0;
				console.log(data);
			
				$.each( data, function( key, val ) {
					
					i++;
					table_body +='<tr>';
					table_body +='	<td>'+i+'</td>';
					table_body +='	<td><a href="<?=base_url()?>document/'+val.file_path+'/'+val.file_name+'" target="_blank">'+val.file_name+'</a></td>';
					table_body +='	<td>'+val.file_size+'</td>';
					table_body +='	<td>'+val.file_member_username+'</td>';
					table_body +='	<td><button class="btn btn-danger btn-sm del_file" fsource="'+val.file_source_id+'" file="'+val.file_id+'"><i class="mdi mdi-delete"></i></button></td>';
					table_body +='</tr>';
					
				});
				$('#dataTable').html(table_header+table_body+table_footer); 
			});
		}
		loadTable();
		
		$("#upload").on("click", function () {
			var ins = document.getElementById("multiFiles").files.length;
			if (ins == 0) {
				alert("กรุณาเลือกไฟล์");
				return false;
			}
			$("#msgLoad").show();
			var form_data = new FormData();

			for (var x = 0; x < ins; x++) {
				form_data.append("files[]", document.getElementById("multiFiles").files[x]);
			}
			form_data.append("file_source_id", $("#file_source_id").val());
			form_data.append("file_type", $("#file_type").val());
			form_data.append("file_point", $("#file_point").val());
			$.ajax({
				url: '<?=base_url("dashboard/project_ajax_vbuploads")?>', // point to server-side PHP script
				dataType: "text", // what to expect back from the PHP script
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: "post",
				success: function (response) {
					console.log(response);
					$("#msg").html(response); // display success response from the PHP script
					$("#msgLoad").hide();
					loadTable();
				},
				error: function (response) {
					$("#msg").html(response); // display error response from the PHP script
					$("#msgLoad").hide();
					loadTable();
				},
			});
		});

		$(document).on("click", ".del_file", function (e) {
			if (confirm("ยืนยันการลยรายการ?")) {
				var f_id = $(this).attr("file");
				var s_id = $(this).attr("fsource");
				$.post("<?=base_url('dashboard/ajax_vbfile_del')?>", { file_source_id: s_id, file_id: f_id }).done(function (data) {
					console.log(data);
					loadTable();
				});
			}
		});

	});
	</script>
	</body>
</html>
			