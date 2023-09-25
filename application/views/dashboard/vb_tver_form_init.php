			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				$user_permissions = array();
				foreach($memberList as $item){
					if(in_array($item->member_username,json_decode($rs[0]->tver))){
						array_push($user_permissions, $item);
					}
				}
			?>
			<style>
				a.p_link {
					color: #11b19b;
					text-decoration: none;
				}

				a.p_link:hover {
					color: #d084ff;
				}
			</style>
			<div class="page-header">
				<h3 class="page-title"> T-VER </h3>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
						<li class="breadcrumb-item active" aria-current="page">T-VER</li>
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
										<label for="topic_name" class="col-sm-2 col-form-label">ชื่อโครงการ</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="tver_project_name" value="">
										</div>
									</div>
									<div class="form-group row">
										<label for="topic_name" class="col-sm-2 col-form-label">ระบุเดือน</label>
										<div class="col-sm-2">
											<select class="form-control mb-2 mr-sm-2" id="tver_month" name="tver_month">
												<?php for($i=1;$i<=12;$i++){?>
												<option value="<?=$i?>"><?=getMonth($i)?></option>
												<?php }?>
											</select>
										</div>
										<label for="topic_name" class="col-sm-1 col-form-label">ระบุปี</label>
										<div class="col-sm-1">
											<select class="form-control mb-2 mr-sm-2" id="tver_year" name="tver_year">
												<?php for($y=(date('Y')-2);$y<=(date('Y')+1);$y++){?>
												<option value="<?=($y+543)?>"><?=($y+543)?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="topic_name" class="col-sm-2 col-form-label">Contract review T-VER</label>
										<div class="col-sm-10">
											<?php foreach($user_permissions as $item){?>
											<div class="form-check form-check-inline" style="display: inline-flex !important;">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="tver_cv_permission[]"
														value="<?=$item->member_username?>"> <?=$item->member_name?></label>
											</div>
											<?php }?>
										</div>
									</div>
									
								</div>
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="tver_id" value="">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>