			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				$user_permissions = array();
				foreach($memberList as $item){
					if(in_array($item->member_username,json_decode($rs[0]->docs))){
						array_push($user_permissions, $item);
					}
				}

				$tver_id=null;
				$tver_project_name=null;
				$tver_year=null;
				$tver_month=null;
				$tver_cv_permission=null;
				$tver_vd_permission=null;
				$tver_cv_obj=null;
				$tver_vd_obj=null;
				if($rsTver!=null){
					$tver_id=$rsTver[0]->tver_id;
					$tver_project_name=$rsTver[0]->tver_project_name;
					$tver_year=$rsTver[0]->tver_year;
					$tver_month=$rsTver[0]->tver_month;
					$tver_cv_obj=json_decode($rsTver[0]->tver_cv_obj);
					$tver_vd_obj=json_decode($rsTver[0]->tver_vd_obj);
					$tver_cv_permission=json_decode($rsTver[0]->tver_cv_permission);
					$tver_vd_permission=json_decode($rsTver[0]->tver_vd_permission);
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
										<label for="topic_name" class="col-sm-10 col-form-label"><?=$tver_project_name?></label>
										
									</div>
									<div class="form-group row">
										<label for="topic_name" class="col-sm-2 col-form-label">ระบุเดือน</label>
										<label for="topic_name" class="col-sm-2 col-form-label"><?=getMonth($tver_month)?></label>
										
										<label for="topic_name" class="col-sm-1 col-form-label">ระบุปี</label>
										<label for="topic_name" class="col-sm-2 col-form-label"><?=$tver_year?></label>

									</div>
									
									<?php if(@in_array($member['m_user'], $tver_cv_permission)){?>
									<div class="form-group row" style="background-color: #d0a4e6;margin: 0;">
										<label for="topic_name" class="col-sm-2 col-form-label"><strong>1. Contract review T-VER</strong></label>
										
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
													<th width="10%">แบบฟอร์ม</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="text-center">1</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_1')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_1]" class="form-control" disabled>
															<option value="">ช่องทางติดต่อ</option>
															<option value="mobile" <?=@$tver_cv_obj->status->CR_1=="mobile"?'selected':''?>>โทรศัพท์</option>
															<option value="email" <?=@$tver_cv_obj->status->CR_1=="email"?'selected':''?>>อีเมลล์</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_1?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_1?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_1?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_1"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_1')>0? getVBFileCount($rsTverFile, 'CR_1') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_1');?></td>
												</tr>
												<tr>
													<td class="text-center">2</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_2')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_2]" class="form-control" disabled>
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_cv_obj->status->CR_2=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_cv_obj->status->CR_2=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_cv_obj->status->CR_2=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_2?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_2?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_2?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_2"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_2')>0? getVBFileCount($rsTverFile, 'CR_2') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_2');?></td>
												</tr>
												<tr>
													<td class="text-center">3</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_3')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_3]" class="form-control" disabled>
															<option value="">ระบุผลการประชุม</option>
															<option value="accept" <?=@$tver_cv_obj->status->CR_3=="accept"?'selected':''?>>รับงาน</option>
															<option value="reject" <?=@$tver_cv_obj->status->CR_3=="reject"?'selected':''?>>ไม่รับงาน</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_3?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_3?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_3?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_3"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_3')>0? getVBFileCount($rsTverFile, 'CR_3') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_3');?></td>
												</tr>
												<?php if(@$tver_cv_obj->status->CR_3=="accept"){?>
												<tr>
													<td class="text-center">4</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_4')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_4]" class="form-control" disabled>
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_cv_obj->status->CR_4=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_cv_obj->status->CR_4=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_cv_obj->status->CR_4=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_4?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_4?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_4?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_4"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_4')>0? getVBFileCount($rsTverFile, 'CR_4') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_4');?></td>
												</tr>
												<tr>
													<td class="text-center">5</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_5')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_5]" class="form-control" disabled>
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_cv_obj->status->CR_5=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_cv_obj->status->CR_5=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_cv_obj->status->CR_5=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_5?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_5?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_5?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_5"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_5')>0? getVBFileCount($rsTverFile, 'CR_5') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_5');?></td>
												</tr>
												<tr>
													<td class="text-center">6</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_6')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_6]" class="form-control" disabled>
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_cv_obj->status->CR_6=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_cv_obj->status->CR_6=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_cv_obj->status->CR_6=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_6?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_6?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_6?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_6"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_6')>0? getVBFileCount($rsTverFile, 'CR_6') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_6');?></td>
												</tr>
												<tr>
													<td class="text-center">7</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_7')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_7]" class="form-control" disabled>
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_cv_obj->status->CR_7=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_cv_obj->status->CR_7=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_cv_obj->status->CR_7=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_7?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_7?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_7?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_7"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_7')>0? getVBFileCount($rsTverFile, 'CR_7') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_7');?></td>
												</tr>
												<tr>
													<td class="text-center">8</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','CR_8')?></div>
													</td>
													<td>
														<select name="tver_cv[status][CR_8]" class="form-control" disabled>
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_cv_obj->status->CR_8=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_cv_obj->status->CR_8=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_cv_obj->status->CR_8=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td class="text-center"><?=@$tver_cv_obj->owner->CR_8?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_start->CR_8?></td>
													<td class="text-center"><?=@$tver_cv_obj->date_end->CR_8?></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="CR_8"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'CR_8')>0? getVBFileCount($rsTverFile, 'CR_8') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'CR_8');?></td>
												</tr>
												<?php }?>
											</tbody>
										</table>
									</div>
									<hr/>
									<?php }?>
									
									<?php if(@in_array($member['m_user'], $tver_vd_permission)){?>
									<?php if(@$tver_cv_obj->status->CR_3=="accept"){?>
									<div class="form-group row" style="background-color: #d0a4e6;margin: 0;">
										<label for="topic_name" class="col-sm-2 col-form-label"><strong>2. Validate/Verify T-VER</strong></label>
										
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
													<th width="10%">แบบฟอร์ม</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="text-center">1</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','VD_1')?></div>
													</td>
													<td>
														<select name="tver_vd[status][VD_1]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_vd_obj->status->VD_1=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_vd_obj->status->VD_1=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_vd_obj->status->VD_1=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="tver_vd[owner][VD_1]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $tver_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$tver_vd_obj->owner->VD_1==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="tver_vd[date_start][VD_1]" value="<?=@$tver_vd_obj->date_start->VD_1?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="tver_vd[date_end][VD_1]" value="<?=@$tver_vd_obj->date_end->VD_1?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="VD_1"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_1')>0? getVBFileCount($rsTverFile, 'VD_1') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'VD_1');?></td>
												</tr>
												<tr>
													<td class="text-center">2</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','VD_2')?></div>
													</td>
													<td>
														<select name="tver_vd[status][VD_2]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_vd_obj->status->VD_2=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_vd_obj->status->VD_2=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_vd_obj->status->VD_2=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="tver_vd[owner][VD_2]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $tver_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$tver_vd_obj->owner->VD_2==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="tver_vd[date_start][VD_2]" value="<?=@$tver_vd_obj->date_start->VD_2?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="tver_vd[date_end][VD_2]" value="<?=@$tver_vd_obj->date_end->VD_2?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="VD_2"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_2')>0? getVBFileCount($rsTverFile, 'VD_2') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'VD_2');?></td>
												</tr>
												<tr>
													<td class="text-center">3</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','VD_3')?></div>
													</td>
													<td>
														<select name="tver_vd[status][VD_3]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_vd_obj->status->VD_3=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_vd_obj->status->VD_3=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_vd_obj->status->VD_3=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="tver_vd[owner][VD_3]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $tver_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$tver_vd_obj->owner->VD_3==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="tver_vd[date_start][VD_3]" value="<?=@$tver_vd_obj->date_start->VD_3?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="tver_vd[date_end][VD_3]" value="<?=@$tver_vd_obj->date_end->VD_3?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="VD_3"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_3')>0? getVBFileCount($rsTverFile, 'VD_3') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'VD_3');?></td>
												</tr>
												<tr>
													<td class="text-center">4</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','VD_4')?></div>
													</td>
													<td>
														<select name="tver_vd[status][VD_4]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_vd_obj->status->VD_4=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_vd_obj->status->VD_4=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_vd_obj->status->VD_4=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="tver_vd[owner][VD_4]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $tver_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$tver_vd_obj->owner->VD_4==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="tver_vd[date_start][VD_4]" value="<?=@$tver_vd_obj->date_start->VD_4?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="tver_vd[date_end][VD_4]" value="<?=@$tver_vd_obj->date_end->VD_4?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="VD_4"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_4')>0? getVBFileCount($rsTverFile, 'VD_4') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'VD_4');?></td>
												</tr>
												<tr>
													<td class="text-center">5</td>
													<td>
														<div class="text-wrap" style="line-height: normal;"><?=VBNamePoint('tver','VD_5')?></div>
													</td>
													<td>
														<select name="tver_vd[status][VD_5]" class="form-control">
															<option value="">ระบุสถานะ</option>
															<option value="wait" <?=@$tver_vd_obj->status->VD_5=="wait"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
															<option value="doing" <?=@$tver_vd_obj->status->VD_5=="doing"?'selected':''?>>อยู่ในระหว่างดำเนินการ</option>
															<option value="done" <?=@$tver_vd_obj->status->VD_5=="done"?'selected':''?>>เรียบร้อย</option>
														</select>
													</td>
													<td>
														<select name="tver_vd[owner][VD_5]" class="form-control">
															<option value="">ผู้ประเมินภายนอก</option>
															<?php foreach($user_permissions as $item){?>
															<?php if(in_array($item->member_username, $tver_vd_permission)){?>
																<option value="<?=$item->member_username?>" <?=$tver_vd_obj->owner->VD_5==$item->member_username ? 'selected':''?>><?=$item->member_name?></option>
															<?php }?>
															<?php }?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="tver_vd[date_start][VD_5]" value="<?=@$tver_vd_obj->date_start->VD_5?>" data-provide="datepicker" data-date-language="th-th"></td>
													<td><input type="text" class="form-control" name="tver_vd[date_end][VD_5]" value="<?=@$tver_vd_obj->date_end->VD_5?>" data-provide="datepicker" data-date-language="th-th"></td>

													<td class="text-center"><button type="button"
															class="btn btn-gradient-success btn-sm btn_vb_addfile" vb_type="tver" vb_id="<?=$tver_id?>" vb_point="VD_5"><i
																class="mdi mdi-upload"></i> <?php echo getVBFileCount($rsTverFile, 'VD_5')>0? getVBFileCount($rsTverFile, 'VD_5') : '';?></button></td>
													<td class="text-center"><?php getVBFileList($rsTverFilePoint,$rsVBFile, 'VD_5');?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php }?>
									<?php }?>
								</div>
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="tver_id" value="<?=$tver_id?>">
										<?php if( @in_array($member['m_user'], $tver_vd_permission) || @in_array($member['m_user'], $tver_cv_permission)){?>
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
										<?php }else{?>
										<a href="<?=base_url('dashboard/tver')?>" class="btn btn-gradient-primary mr-2">กลับหน้าหลัก</a>
										<?php }?>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
