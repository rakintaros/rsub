			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php if($this->session->userdata('update_status')==1){?>
				<div class="alert alert-success fadstatus">
					เปลี่ยนรหัสผ่านเรียบร้อย !
				</div>
			<?php }else if($this->session->userdata('update_status')==2){?>
				<div class="alert alert-warning fadstatus">
					เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง !
				</div>
			<?php }?>
			<?php $this->session->unset_userdata('update_status');?>	
			<style>
			.containerz{display:none;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> เปลี่ยนรหัสผ่าน </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">เปลี่ยนรหัสผ่าน</li>
                </ol>
              </nav>
            </div>
			<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
				<div class="card">
                  <div class="card-body">
                    <h4 class="card-title">ข้อมูลการเข้าใช้งาน</h4>
					<div class="containerz col-md-9 offset-md-3 alert alert-danger">
						<h4>กรุณาป้อนข้อมูลต่อไปนี้ให้ถูกต้องครบถ้วน</h4>
						<ol></ol>
					</div>
					<form class="forms-sample" method="post" id="form_changepwd">
                      <div class="form-group row">
                        <label for="member_username" class="col-sm-3 col-form-label">ชื่อผู้ใช้</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_username" name="member_username" placeholder="ชื่อผู้ใช้" value="<?=$member['m_user']?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="member_password_o" class="col-sm-3 col-form-label">รหัสผ่านเดิม</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="member_password_o" name="member_password_o" placeholder="รหัสผ่านเดิม" required title="รหัสผ่านเดิม">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="member_password_n" class="col-sm-3 col-form-label">รหัสผ่านใหม่</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="member_password_n" name="member_password_n" placeholder="รหัสผ่านใหม่" required title="รหัสผ่านใหม่">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="member_password_c" class="col-sm-3 col-form-label">ยืนยันรหัสผ่านใหม่</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="member_password_c" name="member_password_c" placeholder="ยืนยันรหัสผ่านใหม่" required title="ยืนยันรหัสผ่านใหม่">
                        </div>
                      </div>

					  <div class="form-group row">
						<div class="col-sm-9 offset-md-3">
							<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
							<button class="btn btn-light">ยกเลิก</button>
						</div>
						</div>
                      
                    </form>
				  </div>
				</div>
			  </div>
			</div>