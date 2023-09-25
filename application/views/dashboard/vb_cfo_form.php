			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				$user_permissions = array();
				foreach($memberList as $item){
					if(in_array($item->member_username,json_decode($rs[0]->cfo))){
						array_push($user_permissions, $item);
					}
				}

				$cfo_id=null;
				$cfo_project_name=null;
				$cfo_year=null;
				$cfo_month=null;
				$cfo_cv_permission=null;
				$cfo_vd_permission=null;
				$cfo_cv_obj=null;
				$cfo_vd_obj=null;
				if($rsCFO!=null){
					$cfo_id=$rsCFO[0]->cfo_id;
					$cfo_project_name=$rsCFO[0]->cfo_project_name;
					$cfo_year=$rsCFO[0]->cfo_year;
					$cfo_month=$rsCFO[0]->cfo_month;
					$cfo_cv_obj=json_decode($rsCFO[0]->cfo_cv_obj);
					$cfo_vd_obj=json_decode($rsCFO[0]->cfo_vd_obj);
					$cfo_cv_permission=json_decode($rsCFO[0]->cfo_cv_permission);
					$cfo_vd_permission=json_decode($rsCFO[0]->cfo_vd_permission);
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
				<h3 class="page-title"> CFO </h3>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
						<li class="breadcrumb-item active" aria-current="page">CFO</li>
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
											<input type="text" class="form-control" name="cfo_project_name"value="<?=$cfo_project_name?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="topic_name" class="col-sm-2 col-form-label">ระบุเดือน</label>
										<div class="col-sm-2">
											<select class="form-control mb-2 mr-sm-2" id="cfo_month" name="cfo_month">
												<?php for($i=1;$i<=12;$i++){?>
												<option value="<?=$i?>" <?=$cfo_month==$i?'selected':''?>><?=getMonth($i)?>
												</option>
												<?php }?>
											</select>
										</div>
										<label for="topic_name" class="col-sm-1 col-form-label">ระบุปี</label>
										<div class="col-sm-1">
											<select class="form-control mb-2 mr-sm-2" id="cfo_year" name="cfo_year">
												<?php for($y=(date('Y')-2);$y<=(date('Y')+1);$y++){?>
												<option value="<?=($y+543)?>" <?=$cfo_year==($y+543)?'selected':''?>>
													<?=($y+543)?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<div class="form-group row" style="background-color: #d0a4e6;margin: 0;">
										<label for="topic_name" class="col-sm-2 col-form-label"><strong>1. Contract review CFO</strong></label>
										<div class="col-sm-10">
											<?php foreach($user_permissions as $item){?>
											<div class="form-check form-check-inline" style="display: inline-flex !important;">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="cfo_cv_permission[]"
														value="<?=$item->member_username?>" <?=@in_array($item->member_username, $cfo_cv_permission) ? 'checked':''?>> <?=$item->member_name?></label>
											</div>
											<?php }?>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-striped">
											<thead class="text-center">
												<tr style="background-color: #ecd6f7;">
													<th width="3%">#</th>
													<th style="width:250px;">กระบวนการ</th>
													<th width="13%">สถานะ</th>
													<th width="13%">ผู้รับผิดชอบ</th>
													<th width="12%">เริ่มต้น</th>
													<th width="12%">สิ้นสุด</th>
													<th width="5%">แนบไฟล์</th>
													<th width="5%">แบบฟอร์ม</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="text-center">1</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_1')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_1]" class="form-control">
															<option value="">ช่องทางติดต่อ</option>
															<option value="mobile" <?=@$cfo_cv_obj->status->CR_1=="mobile"?'selected':''?>>โทรศัพท์</option>
															<option value="email" <?=@$cfo_cv_obj->status->CR_1=="email"?'selected':''?>>อีเมลล์</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_1]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_1==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_1]" value="<?=@$cfo_cv_obj->date_start->CR_1?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_1]" value="<?=@$cfo_cv_obj->date_end->CR_1?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_1"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_1')>0? getVBFileCount($rsTverFile, 'CR_1') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_1"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">2</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_2')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_2]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_cv_obj->status->CR_2=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_cv_obj->status->CR_2=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_cv_obj->status->CR_2=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_2]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_2==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_2]" value="<?=@$cfo_cv_obj->date_start->CR_2?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_2]" value="<?=@$cfo_cv_obj->date_end->CR_2?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_2"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_2')>0? getVBFileCount($rsTverFile, 'CR_2') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_2"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">3</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_3')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_3]" class="form-control">
															<option value="">ระบุผลการประชุม</option>
															<option value="accept" <?=@$cfo_cv_obj->status->CR_3=="accept"?'selected':''?>>รับงาน</option>
															<option value="reject" <?=@$cfo_cv_obj->status->CR_3=="reject"?'selected':''?>>ไม่รับงาน</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_3]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_3==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_3]" value="<?=@$cfo_cv_obj->date_start->CR_3?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_3]" value="<?=@$cfo_cv_obj->date_end->CR_3?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_3"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_3')>0? getVBFileCount($rsTverFile, 'CR_3') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_3"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<?php if(@$cfo_cv_obj->status->CR_3=="accept"){?>
												<tr>
													<td class="text-center">4</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_4')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_4]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_cv_obj->status->CR_4=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_cv_obj->status->CR_4=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_cv_obj->status->CR_4=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_4]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_4==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_4]" value="<?=@$cfo_cv_obj->date_start->CR_4?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_4]" value="<?=@$cfo_cv_obj->date_end->CR_4?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_4"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_4')>0? getVBFileCount($rsTverFile, 'CR_4') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_4"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">5</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_5')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_5]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_cv_obj->status->CR_5=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_cv_obj->status->CR_5=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_cv_obj->status->CR_5=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_5]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_5==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_5]" value="<?=@$cfo_cv_obj->date_start->CR_5?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_5]" value="<?=@$cfo_cv_obj->date_end->CR_5?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_5"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_5')>0? getVBFileCount($rsTverFile, 'CR_5') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_5"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">6</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_6')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_6]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_cv_obj->status->CR_6=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_cv_obj->status->CR_6=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_cv_obj->status->CR_6=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_6]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_6==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_6]" value="<?=@$cfo_cv_obj->date_start->CR_6?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_6]" value="<?=@$cfo_cv_obj->date_end->CR_6?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_6"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_6')>0? getVBFileCount($rsTverFile, 'CR_6') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_6"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">7</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_7')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_7]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_cv_obj->status->CR_7=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_cv_obj->status->CR_7=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_cv_obj->status->CR_7=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_7]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_7==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_7]" value="<?=@$cfo_cv_obj->date_start->CR_7?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_7]" value="<?=@$cfo_cv_obj->date_end->CR_7?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_7"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_7')>0? getVBFileCount($rsTverFile, 'CR_7') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_7"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">8</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','CR_8')?></div>
													</td>
													<td>
														<select name="cfo_cv[status][CR_8]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_cv_obj->status->CR_8=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_cv_obj->status->CR_8=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_cv_obj->status->CR_8=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_cv[owner][CR_8]" class="form-control">
															<option value="">ผู้ประเมิน</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_cv_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_cv_obj->owner->CR_8==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_cv[date_start][CR_8]" value="<?=@$cfo_cv_obj->date_start->CR_8?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_cv[date_end][CR_8]" value="<?=@$cfo_cv_obj->date_end->CR_8?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_8"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_8')>0? getVBFileCount($rsTverFile, 'CR_8') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="CR_8"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
									
									<hr/>
									<?php if(@$cfo_cv_obj->status->CR_3=="accept"){?>
									<div class="form-group row" style="background-color: #d0a4e6;margin: 0;">
										<label for="topic_name" class="col-sm-2 col-form-label"><strong>2. Verify</strong></label>
										<div class="col-sm-10">
											<?php foreach($user_permissions as $item){?>
											<div class="form-check form-check-inline" style="display: inline-flex !important;">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="cfo_vd_permission[]"
														value="<?=$item->member_username?>" <?=@in_array($item->member_username, $cfo_vd_permission) ? 'checked':''?>> <?=$item->member_name?></label>
											</div>
											<?php }?>
										</div>
									</div>
									
									<div class="table-responsive">
										<table class="table table-striped">
											<thead class="text-center">
												<tr style="background-color: #ecd6f7;">
													<th width="3%">#</th>
													<th style="width:250px;">กระบวนการ</th>
													<th width="13%">สถานะ</th>
													<th width="13%">ผู้รับผิดชอบ</th>
													<th width="12%">เริ่มต้น</th>
													<th width="12%">สิ้นสุด</th>
													<th width="5%">แนบไฟล์</th>
													<th width="5%">แบบฟอร์ม</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="text-center">1</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','VD_1')?></div>
													</td>
													<td>
														<select name="cfo_vd[status][VD_1]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_vd_obj->status->VD_1=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_vd_obj->status->VD_1=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_vd_obj->status->VD_1=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_vd[owner][VD_1]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_vd_obj->owner->VD_1==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_vd[date_start][VD_1]" value="<?=@$cfo_vd_obj->date_start->VD_1?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_vd[date_end][VD_1]" value="<?=@$cfo_vd_obj->date_end->VD_1?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_1"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_1')>0? getVBFileCount($rsTverFile, 'VD_1') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_1"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">2</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','VD_2')?></div>
													</td>
													<td>
														<select name="cfo_vd[status][VD_2]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_vd_obj->status->VD_2=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_vd_obj->status->VD_2=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_vd_obj->status->VD_2=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_vd[owner][VD_2]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_vd_obj->owner->VD_2==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_vd[date_start][VD_2]" value="<?=@$cfo_vd_obj->date_start->VD_2?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_vd[date_end][VD_2]" value="<?=@$cfo_vd_obj->date_end->VD_2?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_2"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_2')>0? getVBFileCount($rsTverFile, 'VD_2') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_2"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">3</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','VD_3')?></div>
													</td>
													<td>
														<select name="cfo_vd[status][VD_3]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_vd_obj->status->VD_3=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_vd_obj->status->VD_3=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_vd_obj->status->VD_3=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_vd[owner][VD_3]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_vd_obj->owner->VD_3==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_vd[date_start][VD_3]" value="<?=@$cfo_vd_obj->date_start->VD_3?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_vd[date_end][VD_3]" value="<?=@$cfo_vd_obj->date_end->VD_3?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_3"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_3')>0? getVBFileCount($rsTverFile, 'VD_3') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_3"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">4</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','VD_4')?></div>
													</td>
													<td>
														<select name="cfo_vd[status][VD_4]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_vd_obj->status->VD_4=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_vd_obj->status->VD_4=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_vd_obj->status->VD_4=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_vd[owner][VD_4]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_vd_obj->owner->VD_4==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_vd[date_start][VD_4]" value="<?=@$cfo_vd_obj->date_start->VD_4?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_vd[date_end][VD_4]" value="<?=@$cfo_vd_obj->date_end->VD_4?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_4"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_4')>0? getVBFileCount($rsTverFile, 'VD_4') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_4"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
												<tr>
													<td class="text-center">5</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('cfo','VD_5')?></div>
													</td>
													<td>
														<select name="cfo_vd[status][VD_5]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$cfo_vd_obj->status->VD_5=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$cfo_vd_obj->status->VD_5=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$cfo_vd_obj->status->VD_5=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="cfo_vd[owner][VD_5]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $cfo_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$cfo_vd_obj->owner->VD_5==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="cfo_vd[date_start][VD_5]" value="<?=@$cfo_vd_obj->date_start->VD_5?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="cfo_vd[date_end][VD_5]" value="<?=@$cfo_vd_obj->date_end->VD_5?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_5"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_5')>0? getVBFileCount($rsTverFile, 'VD_5') : '';?></button></td>
													<td class="text-center"><button type="button" class="btn btn-gradient-info btn-sm btn_vb_setfile" vb_type="cfo" vb_id="<?=$cfo_id?>" vb_point="VD_5"><i
																class="mdi mdi-settings"></i></button></td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php }?>
								</div>
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="cfo_id" value="<?=$cfo_id?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>