<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login : R-SUP | Uniserv</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?=base_url('template/dashboard/')?>assets/css/style.css?v=2">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?=base_url()?>img/logo_uniserv_small.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
<p class="text-center"><img src="https://uniserv.3e.world/img/logo_uniserv.png?v=125615"></p>
              <div class="auth-form-light text-left p-5">
                <h4>กรุณาเข้าสู่ระบบ</h4>
				<?php echo validation_errors(); ?>
                <form class="pt-3" method="post" action="<?=base_url()?>auth/login/" autocomplete="off">
                  <div class="form-group">
                    <input type="text" autocomplete="new-password" class="form-control form-control-lg" id="username" name="username" placeholder="ชื่อผู้ใช้" required>
                  </div>
                  <div class="form-group">
                    <input type="text" autocomplete="new-password" onfocus=' this.type="password" ' class="form-control form-control-lg" id="password" name="password" placeholder="รหัสผ่าน" required>
                  </div>
				   <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="factor" name="factor" placeholder="2Factor">
                  </div>
                  <div class="mt-3">
                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" >เข้าสู่ระบบ</button>
                  </div>

                 
                  <div class="text-center mt-4 font-weight-light"> Uniserv Powered By 3E
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=base_url('template/dashboard/')?>assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?=base_url('template/dashboard/')?>assets/js/off-canvas.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/hoverable-collapse.js"></script>
    <script src="<?=base_url('template/dashboard/')?>assets/js/misc.js"></script>
    <!-- endinject -->
  </body>
</html>
