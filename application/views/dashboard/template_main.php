<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $member = $this->session->userdata('member_logged_in');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Uniserv : <?=$this->config->item('title_name')?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datetimepicker/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap-datepicker/datepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/tagsinput/bootstrap-tagsinput.css"/>
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/css/style.css?v=<?=date('His')?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?=base_url()?>img/logo_uniserv_small.png" />
	<style>
	select.form-control{color:#333;}
	</style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="<?=base_url('dashboard')?>"><img src="<?=base_url('img/logo_uniserv.png')?>?v=<?=date('His')?>" alt="logo" height="50"/></a>
          <a class="navbar-brand brand-logo-mini" href="<?=base_url('dashboard')?>"><img src="<?=base_url('img/logo_uniserv_small.png')?>?v=<?=date('His')?>" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav navbar-nav-right">
            
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
			<li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="<?=base_url('img/avatar/'.$member['m_img'])?>" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?=$member['m_name']?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="<?=base_url('dashboard/profile')?>"> <i class="mdi mdi-account mr-2 text-success"></i> โปรไฟล์ </a>
                <a class="dropdown-item" href="<?=base_url('dashboard/two_factor')?>"> <i class="mdi mdi-security mr-2 text-success"></i> ความปลอดภัย </a>
                <a class="dropdown-item" href="<?=base_url('dashboard/change_pwd')?>"> <i class="mdi mdi-key mr-2 text-success"></i> เปลี่ยนรหัสผ่าน </a>
                <a class="dropdown-item" href="<?=base_url('dashboard/history')?>"> <i class="mdi mdi-history mr-2 text-success"></i> ประวัติการใช้งาน </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?=base_url('auth/logout')?>"> <i class="mdi mdi-logout mr-2 text-primary"></i> ออกจากระบบ </a>
              </div>
            </li>
          </ul>

        </div>
      </nav>
	  
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="<?=base_url('img/avatar/'.$member['m_img'])?>" alt="profile">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
				 
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?=$member['m_name']?></span>
                  <span class="text-secondary text-small"><?=$member['m_position']?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item <?=@$menu=="index"?'active':''?>">
              <a class="nav-link" href="<?=base_url('dashboard')?>">
                <span class="menu-title">หน้าหลัก </span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
			
			
			<li class="nav-item <?=@$menu=="project"?'active':''?>">
              <a class="nav-link" href="<?=base_url('dashboard/project')?>">
                <span class="menu-title">สรุปโครงการ</span>
                <i class="mdi mdi-star menu-icon"></i>
              </a>
            </li>
			<?php if($member['m_level']==3){?>
			<li class="nav-item <?=@$menu=="member"?'active':''?>">
              <a class="nav-link" href="<?=base_url('dashboard/member')?>">
                <span class="menu-title">ทีมงาน</span>
                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
              </a>
            </li>
			<?php }?>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
			<?php if($member['m_factor']!=1 && $member['m_level']!=1){?>
			<div class="row" id="proBanner">
              <div class="col-12">
                <span class="d-flex align-items-center purchase-popup">
                  <p class="text-danger">ดูเหมือนว่าคุณยังไม่ได้ยืนยัน Two-Factor Authentication (การยืนยันตัวตนผ่านสองขั้นตอน)</p>
                  <a href="<?=base_url('dashboard/two_factor')?>" class="btn ml-auto purchase-button">Enable Two-Factor</a>
				  <i class="mdi mdi-close" id="bannerClose"></i>
                </span>	
              </div>
            </div>
			<?php }?>
			
			<?php $this->load->view('dashboard/'.$view);?>

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019 <a href="https://www.3e.world/" target="_blank">3e.world</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">สำนักบริการวิชาการ มหาวิทยาลัยเชียงใหม่</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=base_url('template/dashboard/')?>assets/vendors/js/vendor.bundle.base.js?v=1"></script>
	
	
	<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?=base_url('template/dashboard/')?>assets/js/off-canvas.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/hoverable-collapse.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/misc.js?v=1"></script>
    <script src="<?=base_url()?>assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/cleave/cleave.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/tagsinput/bootstrap-tagsinput.min.js" ></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
	
	<script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker-thai.js"></script>
    <script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.th.js"></script>

	<script>
	$(function() {
		var container= $("div.containerz");
		
		$('.my-input').toArray().forEach(function (field) {
			var inpControl = new Cleave(field, {
				numeral: true,
				numeralDecimalScale: 4
			});

			$.valHooks['.my-input'] = {
				get: function (el) {
					return inpControl.getRawValue();
				},
				set: function (el, val) {
					$(el).html(val);
				}
			};
		});
		
		
		function rmComma(str){
			if(str){;
				return str.split(",").join("");
			}
		}
		
		function addCommas(nStr) {
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
		
		$(document).on('click', '.s_avatar', function(e) {
			var id = $(this).attr("href").substring(1);
			$( "img.avatar" ).removeClass( "active" );
			$(this).find('img').addClass( "active" );
			$('#member_img').val('avatar_'+id+'.png');
		});

		$(".fadstatus").fadeOut(3000);
		
		$("#form_changepwd").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: "li",
			meta: "validate",
			rules: {
				member_password_n : {
                    minlength : 6
                },
                member_password_c : {
                    minlength : 6,
                    equalTo : "#member_password_n"
                }
			},
			messages: {
				member_password_n : {
                    minlength : 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว'
                },
                member_password_c : {
                    minlength : 'กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว',
                    equalTo : "ยืนยันรหัสผ่านไม่ถูกต้อง"
                }
			},
			submitHandler: function( form ) { form.submit(); }
		});
		
		$(document).on('click', '#createNewSecret', function(e) {
			$.get( "<?=base_url()?>auth/createSecret", function( data ) {
				location.reload();
			});
		});
		
		$(document).on('click','#btn-addAdvanceList', function(e) {
			var data = '<tr class="ad_list"><td><a href="javascript:void(0)" class="btn-delAdvanceList btn btn-gradient-danger btn-sm"><i class="mdi mdi-delete"></i> Del</a></td><td colspan="2"><input type="text" class="form-control" name="advance_detail[list][]" required></td><td class="text-right"><input type="text" class="form-control my-input text-right price_list" name="advance_detail[price][]" required></td></tr>';
			$('#tblAdvance tr.ad_list:last').after(data);
		});
		$(document).on('click','.btn-delAdvanceList', function(e) {
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().eq(0).remove();
			}	
		});
		

		$("form").attr('autocomplete', 'off');
		
		var factor = document.getElementById('bannerClose');
		if(factor){
		  factor.addEventListener('click', swapper_factor, false);
		}
		
		function swapper_factor(){
			document.querySelector('#proBanner').classList.add('d-none');
		}
		
		$( "#advance_project_name" ).autocomplete({
			source: '<?=base_url()?>assets/getProjectName.php',
			select: function( event, ui ) { 
				$('#advance_project_name').val(ui.item.name);
			}
		});
		
		$( "#advance_refunds_price" ).keyup(function() {
			if($(this).val()){
				calAdvance($('#list_summary').val(), $(this).val());
			}else{
				calAdvance($('#list_summary').val(), '');
			}
		});
		
		function calAdvance(a, b){
			a = (a == '') ? 0 :a ;
			b = (b == '') ? 0 :b ;
			a+='';
			b+='';
			if(b==0){var c = a;
			}else{var c = rmComma(a) - rmComma(b);}
			$('#result_summary').val(addCommas(c));
			
		}
		

		 $(".price_list").live('keyup', function(){
			var sum=null;
			$(".price_list").each(function () {     
				sum+=parseFloat(rmComma($(this).val()));
			});
			$('#list_summary').val(addCommas(sum));
			
			if($( "#advance_refunds_price" ).val()){
				calAdvance(sum, $( "#advance_refunds_price" ).val());
			}else{
				$('#result_summary').val((sum));
			}
		});
		
		$( "#advance_clear_real_money" ).keyup(function() {
			var p_total = $('#clear_price_total').val();
			if($(this).val()){
				p_total=parseFloat(rmComma(p_total)) - parseFloat(rmComma($(this).val()));
				$('#price_result').val(p_total.toFixed(2));
				if(p_total!=0){
					if(p_total>0){
						$('#box_plus').show();
						$('#box_minus').hide();
						$('#result_balance').val(p_total.toFixed(2));
						$('#advance_clear_status').val(1);
					}else{
						$('#box_plus').hide();
						$('#box_minus').show();
						$('#result_add').val(p_total.toFixed(2));
						$('#advance_clear_status').val(0);
					}
				}else{
					$('#box_plus').hide();
					$('#box_minus').hide();
					$('#advance_clear_status').val(null);
				}
				$('#advance_clear_price_total').val(p_total.toFixed(2));
			}
		});
		
		$('.transfer_category_id').on('change', function() {
			var cat = this.value;
			console.log(cat)
			if(cat==5){
				$('.cf_cat').show();
			}else{
				$('.cf_cat').hide();
			}
		});
		
		$('.transfer_responsible').on('change', function() {
			var cat = this.value;
			console.log(cat)
			if(cat=="other"){
				$('.cf_responsible').show();
			}else{
				$('.cf_responsible').hide();
			}
		});
		
		$(window).on('shown.bs.modal', function() { 
			$(".transfer_category_id").val($(".transfer_category_id option:first").val());
			$(".transfer_responsible").val($(".transfer_responsible option:first").val());
			$('.cf_cat').hide();
			$('.cf_responsible').hide();
		});
		
		$(document).on('click', '#btn_document', function(e) {
			
			document.location.href = '/dashboard/document_transfer/'+ $('#sel_type').val();
		});
		

		function rt_log(){
			if ($('#div_log').length) {
				var table_header = '<table class="table table-striped"><thead><tr><th width="150">ชื่อผู้ใช้</th><th>การดำเนินงาน</th><th width="300">อุปกรณ์</th><th width="150">เวลา</th></tr></thead><tbody>';
				var table_body = '';
				var table_footer = '</tbody></table>';
				$.getJSON( "/dashboard/ajax_history", function( data ) {
					$.each( data, function( key, val ) {
						table_body +='<tr>';
						table_body +='<td><img src="/img/avatar/'+val.member_img+'" alt="image">'+val.member_name+'</td>';
						table_body +='<td>'+val.log_action+'</td>';
						table_body +='<td>'+val.log_ua+'</td>';
						table_body +='<td>'+val.log_datetime+'</td>';
						table_body +='</tr>';
					});
					$('#div_log').html(table_header+table_body+table_footer);
				});
			}	
		}		
		
		setInterval(rt_log, 5000);
		
		$.datetimepicker.setLocale('th');
		 
		$(".date_format").datetimepicker({  
			timepicker:false,  
			format:'Y-m-d',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000              
			lang:'th',  // แสดงภาษาไทย  
			scrollMonth : false,
			scrollInput : false
			//closeOnDateSelect:true,  
		}); 
		

     
		
		
		$('.btn_addfile').on('click',function(){
			var project_id = $(this).attr('p-id');
			var project_point = $(this).attr('p-point');
			var url = '<?=base_url("dashboard/project_file")?>?project_id='+project_id+'&project_point='+project_point;
				if(project_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : 800,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						}
					});
				}
			
		});
		
		$('.btn_addfile_account').on('click',function(){
			var account_id = $(this).attr('a-id');
			var account_point = $(this).attr('a-point');
			var url = '<?=base_url("dashboard/account_file")?>?account_id='+account_id+'&account_point='+account_point;
				if(account_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : 800,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						}
					});
				}
		});
		
		$('.btn_vb_addfile_d').on('click',function(){
			var topic_id = $(this).attr('t-id');
			var doc_id = $(this).attr('d-id');
			var url = '<?=base_url("dashboard/vb_addfile")?>?topic_id='+topic_id+'&doc_id='+doc_id;
			console.log(url)
				if(topic_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : 800,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						},
						afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
							parent.location.reload(true);
						}
					});
				}
			
		});
		
		$('.btn_vb_setfile').on('click', function(){
			var vb_type  = $(this).attr('vb_type');
			var vb_id  = $(this).attr('vb_id');
			var vb_point  = $(this).attr('vb_point');
			var url = '<?=base_url("dashboard/vb_setfile")?>?vb_type='+vb_type+'&vb_id='+vb_id+'&vb_point='+vb_point;
				if(vb_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : 800,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						},
						afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
							parent.location.reload(true);
						}
					});
				}
		});

		$('.btn_vb_addfile').on('click', function(){
			var vb_type  = $(this).attr('vb_type');
			var vb_id  = $(this).attr('vb_id');
			var vb_point  = $(this).attr('vb_point');
			var url = '<?=base_url("dashboard/vb_uploadfile")?>?vb_type='+vb_type+'&vb_id='+vb_id+'&vb_point='+vb_point;
			console.log(url);
				if(vb_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : 800,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						},
						afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
							parent.location.reload(true);
						}
					});
				}
		});
		
		var topic_total = $('#signoutGetTopicTotal').val();
		
		$(document).on('click','.btn_addSubTopic', function(e) {
			var point = $(this).attr("p_value");
			var sel_member = $('#sel_member').html();
			var c = makeid(20);
			var data = '<tr class="sub_'+point+'"> <td></td><td> <input type="text" class="form-control" name="doing['+point+'][doing_name][]"> </td><td> <select class="form-control" name="doing['+point+'][doing_person][]"> <option value=""> เลือก</option> '+sel_member+'</select> </td><td> <select class="form-control" name="doing['+point+'][doing_status][]"> <option value="none">ยังไม่ได้ดำเนินการ</option> <option value="doing">อยู่ในระหว่างการดำเนินการ</option> <option value="wait">รออนุมัติ</option> <option value="success">เรียบร้อย</option> </select> </td><td> <input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="doing['+point+'][doing_startdate][]"> </td><td> <input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="doing['+point+'][doing_enddate][]"> </td><td></td><td><a href="javascript:void(0)" class="btn_delTopic btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td></tr>';
			if($('#tbldoing tr.sub_'+point+'').val()!=null){
				$('#tbldoing tr.sub_'+point+':last').after(data);
				
			}else{
				$('#tbldoing tr.'+point+':last').after(data);
			}
		});
		
		$(document).on('click','#btn_addTopic', function(e) {
			topic_total++;
			var c = makeid(10)+'_'+topic_total;
			
			var data = '<tr><td><input type="number" class="form-control" name="doing[topic_id][t_'+c+']" required></td><td><input type="text" class="form-control" name="doing[topic_name][t_'+c+']" required></td><td></td><td></td><td></td><td></td><td></td><td><a href="javascript:void(0)" class="btn_delTopic btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td></tr>';
			$('#tbldoing tr:last').after(data);
		});
		$(document).on('click','.btn_delTopic', function(e) {
			
			console.log( $(this).attr("p_value") );
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().eq(0).remove();
				$('.sub_'+$(this).attr("p_value")).remove();
			}	
		});
		
		$(document).on('click','.btnAddAssetsList3', function(e) {
			var point = $(this).attr("id");
			var data = '<tr class="td_sub sub_'+point+'"><td></td><td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td><input type="text" class="form-control" name="tab1['+point+'][t_text][]"></td><td><input type="text" class="form-control my-input" name="tab1['+point+'][t_price][]"></td></tr>';	
			var data = '<tr class="td_sub sub_'+point+'"> <td></td><td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td> <input type="text" class="form-control" name="tab3['+point+'][t_text][]"> </td><td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="tab3['+point+'][t_date][]"></td><td><input type="text" class="form-control" name="tab3['+point+'][t_code][]"></td><td><input type="text" class="form-control my-input" name="tab3['+point+'][t_price][]"></td></tr>';
			
			if($('#tbl3account tr.sub_'+point+'').val()!=null){
				$('#tbl3account tr.sub_'+point+':last').after(data);	
			}else{
				$('#tbl3account tr.'+point+':last').after(data);
			}
			$('#tbl3account tr.td_sub').hide();
			$('#tbl3account tr.sub_'+point+'').show();
		});
		
		$(document).on('click','.btnAddAssetsList', function(e) {
			var point = $(this).attr("id");
			var data = '<tr class="td_sub sub_'+point+'"><td></td><td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td><input type="text" class="form-control" name="tab1['+point+'][t_text][]"></td><td><input type="text" class="form-control my-input" name="tab1['+point+'][t_price][]"></td></tr>';	
			if($('#tbl1account tr.sub_'+point+'').val()!=null){
				$('#tbl1account tr.sub_'+point+':last').after(data);	
			}else{
				$('#tbl1account tr.'+point+':last').after(data);
			}
			$('#tbl1account tr.td_sub').hide();
			$('#tbl1account tr.sub_'+point+'').show();
		});
		$(document).on('click','.btn_delAssets', function(e) {	
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().eq(0).remove();
			}	
		});
		
		$(document).on('click','.btnExplain', function(e) {
			var point = $(this).attr("id");
			//var st = $(this).attr("aria-expanded");
			$('#tbl1account tr.td_sub').hide();
			$('#tbl1account tr.sub_'+point+'').show();
		});
		
		$(document).on('click','.btnExplain2', function(e) {
			var point = $(this).attr("id");
			//var st = $(this).attr("aria-expanded");
			$('#tbl3account tr.td_sub').hide();
			$('#tbl3account tr.sub_'+point+'').show();
		});
		
		$(document).on('click','.btnAddBudget', function(e) {
			var point = 'b'+makeid(5);
			var data = '<tr> <td><a href="javascript:void(0)" class="btn_delBudget btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td> <input type="text" name="tab2[time]['+point+']" class="form-control"> </td><td> <input type="number" name="tab2[percent]['+point+']" class="form-control"> </td><td> <input type="text" name="tab2[full_budget]['+point+']" class="form-control"> </td><td> <input type="text" name="tab2[affiliation]['+point+']" class="form-control"> </td><td></td><td></td><td></td><td></td><td>  </td><td></td></tr>';
			var data ='<tr> <td><a href="javascript:void(0)" class="btn_delBudget btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td> <input type="text" name="tab2[time]['+point+']" class="form-control"> </td><td> <input type="number" name="tab2[percent]['+point+']" class="form-control"> </td><td> <input type="text" name="tab2[full_money]['+point+']" class="form-control"> </td><td> <input type="text" name="tab2[full_fee]['+point+']" class="form-control"> </td><td></td><td> <input type="text" name="tab2[affiliation]['+point+']" class="form-control"> </td><td></td><td></td><td></td><td></td><td> </td><td><input style="width:120px;" type="text" class="form-control text-center" name="tab2[rc_date]['+point+']" data-provide="datepicker" data-date-language="th-th"> </td><td></td></tr>';
			$('#tbl2account tr.tab2_summary').before(data);
		});
		$(document).on('click','.btnAddBudget2', function(e) {
			var point = 'b2'+makeid(5);
			var data ='<tr> <td><a href="javascript:void(0)" class="btn_delBudget btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td><input type="text" name="tab5[time]['+point+']" class="form-control"> </td><td><input type="number" name="tab5[money]['+point+']" class="form-control"> </td><td><input type="text" name="tab5[moneydiscount]['+point+']" class="form-control"> </td></tr>';
			$('#tbl2account2 tr.tab2_summary').before(data);
		});
		$(document).on('click','.btn_delBudget', function(e) {	
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().eq(0).remove();
			}	
		});
		
		
		$(document).on('click','.nav-link', function(e) {	
			var s_tab = $(this).attr("href").slice(1, $(this).attr("href").length);
			$('#sel_type').val(s_tab);
		});
		
		
		$(document).on('click','.p-link', function(e) {	
			var s_tab = $(this).attr("href").slice(1, $(this).attr("href").length);
			$('#tab_select').val(s_tab)
		});
		
		
		
		function makeid(length) {
		   var result           = '';
		   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		   var charactersLength = characters.length;
		   for ( var i = 0; i < length; i++ ) {
			  result += characters.charAt(Math.floor(Math.random() * charactersLength));
		   }
		   return result;
		}

		/*
		document.querySelector('#bannerClose').addEventListener('click',function() {
		  document.querySelector('#proBanner').classList.add('d-none');
		});
*/

		$(document).on('click','.btnDelSection', function(e) {
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().parent().parent().eq(0).remove();
			}	
		});
		
		$(document).on('click','.btnDelSubSection', function(e) {
			if (confirm('ยืนยันการลยรายการ?')) {
				$(this).parent().parent().eq(0).remove();
			}	
		});
		
		$(document).on('click','.AddSection', function(e) {
			var row='<div class="card mb-3"><div class="card-header" role="tab"><div class="row"><div class="col-md-10"><input type="text" placeholder="กรอกชื่อกิจกรรม" class="form-control form-control-title" name="tab3[][section_name]"></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger btnDelSection float-right"><i class="mdi mdi-delete float-right"></i></button></div></div></div></div>';
			$('#accordionEx').append(row);
		});
		
		$(document).on('click','.btnAddSubSection', function(e) {
			var section_row= $(this).attr("section_row_value");
			var k = 'sc'+makeid(10);
			console.log(section_row);
			var row='<tr> <td><a href="javascript:void(0)" class="btnDelSubSection btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td><td> <select class="form-control" name="tab3['+section_row+'][value][cat]['+k+']" required=""> <option> เลือกหมวดหมู่ </option> <option value="1"> ค่าตอบแทน </option> <option value="2"> ค่าจ้าง </option> <option value="3"> ค่าวัสดุ </option> <option value="4"> ค่าเดินทาง </option> <option value="5"> ค่าที่พัก </option> <option value="6"> ค่าอาหาร </option> <option value="7"> ค่าครุภัณฑ์ </option> <option value="8"> ค่าบำรุงสถาบัน </option> <option value="9"> อื่น ๆ </option> </select> </td><td> <input type="text" class="form-control text-center" name="tab3['+section_row+'][value][date]['+k+']" data-provide="datepicker" data-date-language="th-th" required=""> </td><td> <input type="text" class="form-control" name="tab3['+section_row+'][value][detail]['+k+']" required=""> </td><td> <input type="text" class="form-control" name="tab3['+section_row+'][value][ref]['+k+']" required=""> </td><td> <input type="text" class="form-control my-input" name="tab3['+section_row+'][value][money]['+k+']" required=""> </td><td></td></tr>';
			$('#tblSection'+section_row+' tbody').append(row);
			
		});
		
		
		//thesis
		$('.btn_addfile_thesis').on('click',function(){
			var thesis_id = $(this).attr('thesis-id');
			var url = '<?=base_url("dashboard/thesis_file")?>?thesis_id='+thesis_id;
				if(thesis_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : 800,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						}
					});
				}
		});
    });

	</script>
  </body>
</html>