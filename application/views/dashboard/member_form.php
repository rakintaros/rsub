			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
			$member_username=null;
			$member_name=null;
			$member_position=null;
			$member_email=null;
			$member_img=null;
			$member_status=null;
			if($rs!=null){
				$member_username=$rs[0]->member_username;
				$member_name=$rs[0]->member_name;
				$member_position=$rs[0]->member_position;
				$member_email=$rs[0]->member_email;
				$member_img=$rs[0]->member_img;
				$member_status=$rs[0]->member_status;
			}
			
			?>
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
              <h3 class="page-title"> ทีมงาน </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ทีมงาน</li>
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
                        <label for="member_username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_username" name="member_username" placeholder="ชื่อผู้ใช้" value="<?=$member_username?>" <?=$member_username!=null?'readonly':''?>>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="member_name" class="col-sm-3 col-form-label">ชื่อ - นามสกุล</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_name" name="member_name" placeholder="ชื่อ - นามสกุล" value="<?=$member_name?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="member_position" class="col-sm-3 col-form-label">ตำแหน่ง</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_position" name="member_position" placeholder="ตำแหน่ง" value="<?=$member_position?>">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="member_email" class="col-sm-3 col-form-label">อีเมล์</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="member_email" name="member_email" placeholder="อีเมล์" value="<?=$member_email?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">รูปอวตาร</label>
                        <div class="col-sm-9">
							<?php for($i=1; $i<10; $i++){?>
								<a href="#<?=$i?>" class="s_avatar"><img class="avatar <?='avatar_'.$i.'.png'==$member_img?'active':''?>" src="<?=base_url()?>img/avatar/avatar_<?=$i?>.png" width="50"></a>
							<?php }?>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="member_status" class="col-sm-3 col-form-label">สถานะใช้งาน</label>
                        <div class="col-sm-9">
                         
							<div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="member_status" id="member_status1" value="1" <?=$member_status==1?'checked':''?>> ปกติ </label>
                            </div>
							<div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="member_status" id="member_status2" value="0" <?=$member_status==0?'checked':''?>> ระงับ </label>
                            </div>
                        </div>
                      </div>
                      
					  <div class="form-group row">
						<div class="col-sm-9 offset-md-3">
							<input type="hidden" name="member_action" value="<?=$member_username!=null?'update':'add'?>">
							<input type="hidden" name="member_img" id="member_img" value="<?=$member_img?>">
							<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
							<button class="btn btn-light">ยกเลิก</button>
						</div>
					</div>
                      
                    </form>
				  </div>
				</div>
			  </div>
			</div>