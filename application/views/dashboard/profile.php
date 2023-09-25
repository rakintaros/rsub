			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php if($this->session->userdata('update_status')==1){?>
				<div class="alert alert-success fadstatus">
					อัพเดทโปรไฟล์เรียบร้อย !
				</div>
			<?php }?>
			<?php $this->session->unset_userdata('update_status');?>	
		
			<style>
			.s_avatar img.active{border: 2px solid #72f96e;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> โปรไฟล์ </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">โปรไฟล์</li>
                </ol>
              </nav>
            </div>
			<div class="row">
              <div class="col-md-12 grid-margin stretch-card">
				<div class="card">
                  <div class="card-body">
                    <h4 class="card-title">ข้อมูลทั่วไป</h4>
					
					<form class="forms-sample" method="post">
                      <div class="form-group row">
                        <label for="member_name" class="col-sm-3 col-form-label">ชื่อ - นามสกุล</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_name" name="member_name" placeholder="ชื่อ - นามสกุล" value="<?=$member['m_name']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="member_position" class="col-sm-3 col-form-label">ตำแหน่ง</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_position" name="member_position" placeholder="ตำแหน่ง" value="<?=$member['m_position']?>">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="member_email" class="col-sm-3 col-form-label">อีเมล์</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_email" name="member_email" placeholder="อีเมล์" value="<?=$member['m_email']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">รูปอวตาร</label>
                        <div class="col-sm-9">
							<?php for($i=1; $i<10; $i++){?>
								<a href="#<?=$i?>" class="s_avatar"><img class="avatar <?='avatar_'.$i.'.png'==$member['m_img']?'active':''?>" src="<?=base_url()?>img/avatar/avatar_<?=$i?>.png" width="50"></a>
							<?php }?>
                        </div>
                      </div>
                      
					  <div class="form-group row">
						<div class="col-sm-9 offset-md-3">
							<input type="hidden" name="member_img" id="member_img" value="<?=$member['m_img']?>">
							<input type="hidden" name="member_username" id="member_username" value="<?=$member['m_user']?>">
							<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
							<button class="btn btn-light">ยกเลิก</button>
						</div>
					</div>
                      
                    </form>
				  </div>
				</div>
			  </div>
			</div>