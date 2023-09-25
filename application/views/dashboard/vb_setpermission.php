			<?php $member = $this->session->userdata('member_logged_in');?>

			<div class="page-header">
              <h3 class="page-title"> กำหนดสิทธิ์การเข้าถึง </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">กำหนดสิทธิ์</li>
                </ol>
              </nav>
            </div>
			<div class="row">
              <div class="col-md-8 grid-margin stretch-card">
				<div class="card">
                  <div class="card-body">
                    <form class="forms-sample" method="post">
						<div class="mb-5">

							<?php echo $rs[0]->cfo!=null?'<i class="mdi mdi-lock-open"></i>':'<i class="mdi mdi-lock"></i>'?> CFO
							<div class="form-group row">
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i<=4){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="cfo[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->cfo)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>4 && $i<=7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="cfo[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->cfo)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>	
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="cfo[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->cfo)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>												
							</div>
							<hr/>
							<?php echo $rs[0]->tver!=null?'<i class="mdi mdi-lock-open"></i>':'<i class="mdi mdi-lock"></i>'?> T-VER						
							<div class="form-group row">
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i<=4){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="tver[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->tver)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>4 && $i<=7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="tver[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->tver)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>	
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="tver[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->tver)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>												
							</div>
							<hr/>
							<?php echo $rs[0]->docs!=null?'<i class="mdi mdi-lock-open"></i>':'<i class="mdi mdi-lock"></i>'?> แบบฟอร์มที่เกี่ยวข้อง						
							<div class="form-group row">
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i<=4){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="docs[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->docs)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>4 && $i<=7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="docs[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->docs)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>	
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="docs[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->docs)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>												
							</div>
							<hr/>
							<?php echo $rs[0]->request!=null?'<i class="mdi mdi-lock-open"></i>':'<i class="mdi mdi-lock"></i>'?> คำร้องขอดำเนินการเอกสาร						
							<div class="form-group row">
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i<=4){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="request[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->request)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>4 && $i<=7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="request[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->request)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>	
								<div class="col-sm-4">				
									<div class="form-group">
										<?php $i=0;foreach($memberList as $mem){$i++;?>
										<?php if($i>7){?>
										<div class="form-check">
											<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="request[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,json_decode($rs[0]->request)) ? 'checked':''?>> <?=$mem->member_name?></label>
										</div>
										<?php }?>
										<?php }?>
									</div>
								</div>												
							</div>
							
						</div>
						<div class="form-group row">
							<div class="col-sm-12 text-center">
							<input type="hidden" name="id" value="1">
								<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
							</div>
						</div>
					</form>	
					
				  
				  </div>
				</div>
			  </div>
			  <div class="col-md-4 grid-margin stretch-card">
				<div class="card">
                  <div class="card-body">
					<h4 class="card-title"><i class="mdi mdi-lock"></i>  กำหนดสิทธิ์การเข้าถึง</h4>
					
					<p>คุณจะเป็นผู้กำหนดสิทธิ์การเข้าถึงระบบ <b>V/VB</b></p>
					<p>::: ซึ่งจะประกอบไปด้วย <b>CFO, T-VER, แบบฟอร์มที่เกี่ยวข้อง และ คำร้องขอดำเนินการเอกสาร</b></p>
					<p>คุณสามารถกำหนดสิทธิ์ให้เข้าถึงแต่ละส่วน โดยเลือกจากสมาชิกที่มีอยู่แล้ว เมื่อกำหนดสิทธิ์เสร็จแล้ว สมาชิกดังกล่าวจะสามารถมองเห็นเมนูการใช้งานของระบบ</p>

				  </div>
				</div>
			  </div>
			</div>