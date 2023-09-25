<?php $member = $this->session->userdata('member_logged_in');?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title><?=$meta_title?></title>
	<meta name="description" content="<?=$meta_description?>">
	<meta name="keywords" content="<?=$meta_keyword?>">


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
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
	<script src="<?=base_url('template')?>/js/jquery.min.js?v=<?=date('his')?>"></script>
	<script src="<?=base_url('template')?>/js/jquery-migrate-1.2.1.min.js?v=<?=date('his')?>"></script>
	
	<link rel="stylesheet" href="<?=base_url('template')?>/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<script src="<?=base_url('template')?>/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
  </head>


	<body>
	<style>
	.card-header{
		color: #333;
		background: linear-gradient( 90deg, #dee1e9 0, #dee1e9);
		opacity: 1;
	}
	.fs-6 span{color:#00b1e5;}
	</style>
	

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light sticky-top" data-navbar-on-scroll="data-navbar-on-scroll" style="box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;">
        <div class="container">
			<!--<a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url('template')?>/img/logo.svg" height="50" alt="logo" /></a>-->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class='bx bx-menu'></i></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link" aria-current="page" href="<?=base_url()?>">หน้าหลัก</a></li>
              <li class="nav-item"><a class="nav-link" aria-current="page" href="<?=base_url('#aboutus')?>">ความเป็นมา</a></li>
              <li class="nav-item"><a class="nav-link" aria-current="page" href="<?=base_url('dashboard/seft_assessment')?>">ประเมินสมรรถนะ</a></li>
              <li class="nav-item"><a class="nav-link" aria-current="page" href="<?=base_url('dashboard')?>">ฐานข้อมูล</a></li>
              <li class="nav-item"><a class="nav-link" aria-current="page" href="<?=base_url('#news')?>">ข่าวสาร</a></li>
            </ul>
            <div class="d-flex ms-lg-4">
				<?php if($member!=null){?>
				<div class="dropdown">
				  <button class="btn btn-theme ms-3 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
					<?=$member['member_name']?>
				  </button>
				  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
					<li><a class="dropdown-item" href="<?=base_url('dashboard')?>"><i class='bx bxs-dashboard'></i> หน้าหลัก</a></li>
					<li><a class="dropdown-item" href="<?=base_url('dashboard/info')?>"><i class='bx bx-user-circle' ></i> ข้อมูลทั่วไป</a></li>
					<li><a class="dropdown-item" href="<?=base_url('dashboard/database')?>"><i class='bx bx-data' ></i> ฐานข้อมูล</a></li>
					<li><a class="dropdown-item" href="<?=base_url('dashboard/calculation')?>"><i class='bx bxs-radiation' ></i> คำนวนก๊าซเรือนกระจก</a></li>
					<li><a class="dropdown-item" href="<?=base_url('dashboard/reduction ')?>"><i class='bx bxs-hourglass'></i> กิจกรรมลด</a></li>
					<li><a class="dropdown-item" href="<?=base_url('dashboard/report')?>"><i class='bx bxs-report' ></i> รายงานผล</a></li>
					<li><a class="dropdown-item" href="<?=base_url('dashboard/changepwd')?>"><i class='bx bxs-key' ></i> เปลี่ยนรหัสผ่าน</a></li>
					<li><a class="dropdown-item" href="<?=base_url('auth/logout')?>"><i class='bx bx-log-out-circle'></i> ออกจากระบบ</a></li>
				  </ul>
				</div>
				
				<?php }else{?>
				<a class="btn btn-outline-light" href="<?=base_url('auth/login')?>">Sign in</a>
				<a class="btn btn-theme ms-3" href="<?=base_url('auth/register')?>">Sign up</a>
				<?php }?>
			</div>
          </div>
        </div>
      </nav>

		
		<?php $this->load->view($view);?>
		<style>
		footer{
			background-color: #009aff;
			color:#FFF;
		}
		
		footer h3{color:#FFF;font-weight: 400;}
		footer .footer_logo{padding:20px 0;}
		footer .line{border: 1px solid;width: 20%;color: #fff;margin: 10px 0;}
		footer .copyright{background-color:#435ea8;padding: 10px 0;font-size: 14px;}
		</style>
		<section class="py-0 pt-8">
			<footer>
				<div class="container">
					<div class="py-6">
						<div class="row">
							<div class="col-md-5">
								<div class="footer_logo">
									<!--<img src="<?=base_url('template/img/logo.svg')?>" class="img-fluid">-->
								</div>
							</div>
							<div class="col-md-7">
								<h3 class="mb-0">หน่วยวิจัยเพื่อการจัดการพลังงานและเศรษฐนิเวศ</h3>
								<h3 class="mb-0">สถาบันวิจัยวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยเชียงใหม่</h3>
								<div class="line"></div>
								<p>
								สถานที่ติดต่อ : ชั้น 7 อาคาร 30 ปี คณะวิศวกรรมศาสตร์ มหาวิทยาลัยเชียงใหม่<br/>
								ที่อยู่สำหรับส่งไปรษณีย์ : ตู้ ปณ.200 ปณฝ.มหาวิทยาลัยเชียงใหม่ 50202<br/>
								โทรศัพท์ : 053 942 086
								</p>
							</div>
						</div>
					</div>
				</div><!-- end of .container-->
				<div class="copyright text-center">
					<p class="mb-0">&copy; 2022 โครงการจัดทำแนวทางส่งเสริมการท่องเที่ยวที่ลดผลกระทบต่อสิ่งแวดล้อม ปี 2565 </p>
				</div>
			</footer>
		</section>
      <!-- <section> close ============================-->
      <!-- ============================================-->
	
	
		<input type="hidden" id="alertComplate" value="<?=$this->session->userdata('alert_status')?>">
		<div class="modal fade" id="alertComplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title text-center" id="exampleModalLabel">CF-Hotels.com</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body text-center">
				<h1 style="color: #26b190;font-size: 50px;"><i class='bx bxs-check-circle bx-tada' ></i></h1>
				บันทึกข้อมูลเรียบร้อย
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
			
			  </div>
			</div>
		  </div>
		</div>
		<?php $this->session->unset_userdata('alert_status');?>
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="<?=base_url('template')?>/vendors/@popperjs/popper.min.js"></script>
    <script src="<?=base_url('template')?>/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="<?=base_url('template')?>/vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="<?=base_url('template')?>/vendors/fontawesome/all.min.js"></script>
	<script type="text/javascript" src="<?=base_url('template')?>/js/jquery-validation/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?=base_url('template')?>/js/jquery-validation/js/additional-methods.min.js"></script>
    <script src="<?=base_url('template')?>/js/cleave.min.js?v=<?=date('his')?>"></script>
    <script src="<?=base_url('template')?>/js/theme.js?v=<?=date('his')?>"></script>
    <script src="<?=base_url('template')?>/js/apps.js?v=<?=date('his')?>"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Volkhov:wght@700&amp;display=swap" rel="stylesheet">
	<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	
	</script>
  </body>

</html>