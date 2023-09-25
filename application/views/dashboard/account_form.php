			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 

				$account_id = null;
				$account_project_id = null;

				if($rs!=null){
					$account_project_id = $rs[0]->project_id;		
				}

			?>


			<div class="page-header">
              <h3 class="page-title"> บัญชีดำเนินโครงการ </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active"><a href="<?=base_url('dashboard/account')?>">บัญชีดำเนินโครงการ</a></li>
                </ol>
              </nav>
            </div>
			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">

							<form class="forms-sample" method="post">
								<div class="mb-5">

									<div class="form-group row">
										<label for="project_name" class="col-sm-2 col-form-label">ชื่อโครงการ</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="advance_project_name" name="account_project_name" placeholder="ภาษาไทย" required value="<?=$rs[0]->project_name?>" readonly>
										</div>
									</div>	
									
									<div class="form-group row">
										<label for="project_name" class="col-sm-2 col-form-label">ธนาคาร</label>
										<div class="col-sm-4">				
											<select class="form-control" name="account_bank" required>
												<option value=""> เลือกธนาคาร </option>
												<?php $arBank = getBankList();?>
												<?php foreach($arBank as $k=>$v){?>
												<option value="<?=$k?>"> <?=$v?> </option>
												<?php }?>
											</select>
										</div>
										<div class="col-sm-3">				
											<input type="text" class="form-control" name="account_bank_name" placeholder="ชื่อบัญชี" required>
										</div>
										<div class="col-sm-3">				
											<input type="text" class="form-control" name="account_bank_code" placeholder="เลขที่บัญชี" required>
										</div>
									</div>
									
									<div class="form-group row">
										<label for="project_name" class="col-sm-2 col-form-label">สถานะโครงการ</label>
										<div class="col-sm-4">				
											<select class="form-control" name="account_status_complate_is" required>
												<option value=""> เลือกสถานะ </option>
												<?php $arStatus = getProjectStatusL();?>
												<?php foreach($arStatus as $k=>$v){?>
												<option value="<?=$k?>"> <?=$v?> </option>
												<?php }?>

											</select>
										</div>
									</div>	
									<?php if($member['m_level']==3){?>
									<?php $c = count($memberList);?>
									<div class="form-group row">
										<label for="project_status" class="col-sm-2 col-form-label">พนักงานที่สามารถแก้ไข</label>
										<div class="col-sm-4">				
											<div class="form-group">
												<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i<=($c/2)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="account_member_permission[]" value="<?=$mem->member_username?>" <?=$mem->member_level==3?'checked onclick="return false;"':''?>> <?=$mem->member_name?></label>
												</div>
												<?php }?>
												<?php }?>
											</div>
										</div>
										<label for="project_status" class="col-sm-2 col-form-label"></label>
										<div class="col-sm-4">	
											<div class="form-group">
											<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i>($c/2)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="account_member_permission[]" value="<?=$mem->member_username?>" <?=$mem->member_level==3?'checked onclick="return false;"':''?>> <?=$mem->member_name?> </label>
												</div>
												<?php }?>
											<?php }?>
											</div>
										</div>
									</div>	
									<?php }?>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="account_project_id" value="<?=$account_project_id?>">
										<input type="hidden" name="account_id" value="<?=$account_id?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>