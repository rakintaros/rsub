			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				$user_permissions = array();
				foreach($memberList as $item){
					if(in_array($item->member_username,json_decode($rs[0]->request))){
						array_push($user_permissions, $item);
					}
				}
				$topic_id=null;
				$topic_name=null;
				if($rsTopic!=null){
					$topic_id = $rsTopic[0]->topic_id;
					$topic_name = $rsTopic[0]->topic_name;
				}
	
			?>
			<style>
			a.p_link{color:#11b19b;text-decoration: none;}
			a.p_link:hover{color:#d084ff;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> คำร้องขอดำเนินการเอกสาร </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">คำร้องขอดำเนินการเอกสาร</li>
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
										<label for="topic_name" class="col-sm-2 col-form-label">หัวข้อหลัก</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" name="topic_name" value="<?=$topic_name?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="topic_name" class="col-sm-2 col-form-label">สิทธิ์การเข้าถึง</label>
										<div class="col-sm-10">				
										<?php foreach($user_permissions as $item){?>
											<div class="form-check">
												<label class="form-check-label">
												<input type="checkbox" checked class="form-check-input" name="topic_permission[]" value="<?=$item->member_username?>" <?=@in_array($item->member_username,json_decode($rsTopic[0]->topic_permission)) ? 'checked':''?>> <?=$item->member_name?></label>
											</div>
										<?php }?>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="topic_group" value="2">
										<input type="hidden" name="topic_id" value="<?=$topic_id?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
							</form>
							
						</div>
					</div>
                </div>
             </div>
            