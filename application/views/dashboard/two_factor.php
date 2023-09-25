			<?php $member = $this->session->userdata('member_logged_in');?>

			<div class="page-header">
              <h3 class="page-title"> การยืนยัน 2 ขั้นตอน </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">2 Factor</li>
                </ol>
              </nav>
            </div>
			<div class="row">
              <div class="col-md-8 grid-margin stretch-card">
				<div class="card">
                  <div class="card-body">
                    <h4 class="card-title">2-factor authentication คืออะไร</h4>
					
					<p>2FA เป็นการดำเนินการเข้าสู่ระบบที่ผู้ใช้จะต้องยืนยันตัวตนผ่านสองขั้นตอน ซึ่งมากกว่าแค่การใส่ชื่อผู้ใช้และรหัสผ่าน คุณจำเป็นต้องใส่รหัสที่ถูกส่งไปยังโทรศัพท์มือถือของคุณ ด้วยแอพพลิเคชั่น Google Authenticator หรือว่า Authy ซึ่งรหัสนี้จะเป็นรหัสที่เป็นเอกลักษณ์ โดยจะถูกสุ่มขึ้นมา และเปลี่ยนไปเรื่อยๆ จึงเป็นเรื่องยากที่จะถูกโจรกรรมข้อมูลได้</p>
					<p>การใช้ 2FA สำหรับบัญชีของคุณ เป็นการป้องกันเมื่อมีใครบางคนพยายามจะเข้าถึงบัญชีของคุณโดยการขโมยรหัสผ่านปกติของคุณ 2FA จะทำหน้าที่เป็นปราการด่านที่สอง ระบบนี้จะทำให้การโจรกรรมเป็นไปได้ยากขึ้น เพราะจำเป็นต้องใส่รหัสผ่านที่เข้าถึงได้เฉพาะมือถือคุณเท่านั้น ซึ่งมีโอกาสน้อยมากที่คนโจรกรรมจะมีมือถือของคุณอยู่ด้วย บัญชีของคุณก็จะปลอดภัยมากขึ้น</p>
				  
					คุณสามารถโหลด Google Authenticate ได้ที่  
					<a target="_blank" href="https://apps.apple.com/th/app/google-authenticator/id388497605">iOS</a> และ 
					<a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=th">Android</a>.
					
					<div class="template-demo mt-2">
                          <a class="btn btn-outline-dark btn-icon-text" target="_blank" href="https://apps.apple.com/th/app/google-authenticator/id388497605">
                            <i class="mdi mdi-apple btn-icon-prepend mdi-36px"></i>
                            <span class="d-inline-block text-left">
                              <small class="font-weight-light d-block">Google Authenticator</small> App Store </span>
                          </a>
                          <a class="btn btn-outline-dark btn-icon-text" target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=th">
                            <i class="mdi mdi-android-debug-bridge btn-icon-prepend mdi-36px"></i>
                            <span class="d-inline-block text-left">
                              <small class="font-weight-light d-block">Google Authenticator</small> Google Play </span>
                          </a>
                        </div>
				  
				  </div>
				</div>
			  </div>
			  <div class="col-md-4 grid-margin stretch-card">
				<div class="card">
                  <div class="card-body">
					<center>
						<?php if($member['m_factor']==1){?>
							<img src="<?=base_url('img/2fa.jpg')?>" width="150">
							<p>Two step verification</p>
							
							<p class="text-success"><i class="mdi mdi-check-circle mdi-48px"></i> </p>
							<p class="text-success">Verification Success!</p>
						<?php }else{?>
						Secret ของคุณคือ 
						<div class="form-group">
						  <div class="input-group">
							<input type="text" class="form-control" value="<?=$secret?>">
							<div class="input-group-append">
							  <button class="btn btn-sm btn-info" type="button" id="createNewSecret">
								<i class="mdi mdi-refresh "></i>
							  </button>
							</div>
						  </div>
						</div>
						<img src="<?=$qrcode?>" class="img-fluid mb-3">
						
						<form method="post">
						<div class="form-group">
							<input type="hidden" name="secret" value="<?=$secret?>">
							<input type="text" class="form-control" name="otp" placeholder="กรอกรหัสผ่านเพื่อยืนยันเปิดใช้งาน" style="text-align:center" required autocomplete="off">
						</div>
						<button type="submit" class="btn btn-gradient-primary mb-2">ยืนยัน</button>
						</form>
						<?php }?>
					</center>

				  </div>
				</div>
			  </div>
			</div>