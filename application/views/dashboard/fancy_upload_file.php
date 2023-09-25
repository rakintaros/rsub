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
			<h3><?=getTopicFile($project_point)?></h3>

			<form class="form-inline" enctype="multipart/form-data" action="#" method="post">
				<input type="file" id="multiFiles" name="files[]" class=" mb-2 mr-sm-2" multiple="multiple"/>
				<input type="hidden" name="project_point" id="project_point" value="<?=$project_point?>">
				<input type="hidden" name="project_id" id="project_id" value="<?=$project_id?>">
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
		$(document).on('click','.add_more', function(e) {
			var data = '<tr><td><a href="javascript:void(0)" class="btn-delFileList btn btn-gradient-danger btn-sm"><i class="mdi mdi-delete"></i></a></td><td><input type="file" name="files[]"></td></tr>';
			$(this).closest('tr').after(data);
		});
		$(document).on('click','.btn-delFileList', function(e) {
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().eq(0).remove();
			}	
		});
		
		$(document).on('click','.del_file', function(e) {
			if (confirm('ยืนยันการลยรายการ?')) {
				var f_id = $(this).attr("file");
				var p_id = $(this).attr("fproject");
				$.post( "<?=base_url('dashboard/ajax_projectfile_del')?>", { project_id: p_id, file_id: f_id }).done(function( data ) {
					console.log(data);
					loadTable();
				});
			}	
		});
		
		function loadTable(){
			var table_header = '<table class="table"><thead class="bg-secondary"><tr><td>#</td><td>File Name</td><td>Size</td><td>By</td><td></td></tr></thead><tbody>';
			var table_footer = '</tbody></table>';
			var table_body = '';
			$.getJSON( "<?=base_url('dashboard/ajax_projectfile')?>", { project_id: '<?=$project_id?>', project_point: '<?=$project_point?>' } ).done(function( data ) {
				var i=0;
				console.log(data);
				$.each( data, function( key, val ) {
					
					i++;
					table_body +='<tr>';
					table_body +='	<td>'+i+'</td>';
					table_body +='	<td><a href="<?=base_url()?>document/'+val.file_path+'/'+val.file_name+'" target="_blank">'+val.file_name+'</a></td>';
					table_body +='	<td>'+val.file_size+'</td>';
					table_body +='	<td>'+val.file_member_username+'</td>';
					table_body +='	<td><button class="btn btn-danger btn-sm del_file" fproject="'+val.file_project_id+'" file="'+val.file_id+'"><i class="mdi mdi-delete"></i></button></td>';
					table_body +='</tr>';
				});
				$('#dataTable').html(table_header+table_body+table_footer); 
			});
			
			
		}
		loadTable();
		
		$('#upload').on('click', function () {
			var ins = document.getElementById('multiFiles').files.length;
			if(ins==0){
						alert('กรุณาเลือกไฟล์');
						return false;
					}
			$('#msgLoad').show();
                    var form_data = new FormData();
                  
                    for (var x = 0; x < ins; x++) {
                        form_data.append("files[]", document.getElementById('multiFiles').files[x]);
                        
                    }
					form_data.append("project_id", $('#project_id').val());
					form_data.append("project_point", $('#project_point').val());
                    $.ajax({
                        url: '<?=base_url("dashboard/project_ajax_uploads")?>', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
							console.log(response);
                            $('#msg').html(response); // display success response from the PHP script
							$('#msgLoad').hide();
							loadTable();
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the PHP script
							$('#msgLoad').hide();
							loadTable();
                        }
                    });
                });
			
	});
	</script>
	
	
	
	</body>
</html>
			