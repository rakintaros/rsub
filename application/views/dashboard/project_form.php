			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				
				//$createAdvancedate = ConvertToThaiDate(date('Y-m-d'),0);
				$project_id = null;
				$project_code = null;
				$project_name = null;
				$project_name_en = null;
				$project_funds = null;
				$project_year = null;
				$project_responsible = null;
				$project_budget = null;
				$project_org = null;
				$project_signdate = null;
				$project_startdate = null;
				$project_enddate = null;
				$project_status_ic  = null;
				$project_status_ic_date  = null;
				$project_status_op  = null;
				$project_status  = null;
				$project_pre  = null;
				$project_doing  = null;
				$project_done  = null;
				$project_status_success  = null;
				$project_status_success_date  = null;
				$project_create_member_username  = $member['m_user'];
				$project_member_permission  = null;
				if($rs!=null){
					$project_id = $rs[0]->project_id;
					$project_code = $rs[0]->project_code;
					$project_name = $rs[0]->project_name;
					$project_name_en = $rs[0]->project_name_en;
					$project_funds = $rs[0]->project_funds;
					$project_year = $rs[0]->project_year;
					$project_responsible = $rs[0]->project_responsible;
					$project_budget = $rs[0]->project_budget;
					$project_org = $rs[0]->project_org;
					$project_signdate = $rs[0]->project_signdate;
					$project_startdate = $rs[0]->project_startdate;
					$project_enddate = $rs[0]->project_enddate;
					$project_status_ic  = $rs[0]->project_status_ic;
					$project_status_ic_date  = $rs[0]->project_status_ic_date;
					$project_status_op  = $rs[0]->project_status_op;
					$project_status  = $rs[0]->project_status;
					$project_status_success  = $rs[0]->project_status_success;
					$project_status_success_date  = $rs[0]->project_status_success_date;
					$project_create_member_username  = $rs[0]->project_create_member_username;
					
					$data = json_decode(@$rs[0]->project_pre);
					$project_pre = (array) @$data;
					
					$data2 = json_decode(@$rs[0]->project_doing);
					$project_doing = (array) @$data2;
					
					$data3 = json_decode(@$rs[0]->project_done);
					$project_done = (array) @$data3;
					
					$data4 = json_decode(@$rs[0]->project_member_permission);
					$project_member_permission = (array) @$data4;
				}
				
				
				function chFileStatus($rsFile, $filename){
					$count = 0;
					foreach($rsFile as $item){
						if (array_search($filename, $item)){
							$count++;
						}
					}
					return $count;
				}
			?>
			<style>
				.nav-tabs a.nav-link{background-color: #16b39d;color:#fff;}
				.nav-tabs .nav-link.active{background-color: #fff;color:#11b19b !important;}
				.tab-content{border-left: 1px solid #ebedf2;border-right: 1px solid #ebedf2;border-bottom: 1px solid #ebedf2;}
				select.form-control{color:#333;}
				.bg_none{background-color:#ff7373;color:#fff;}
				.bg_doing{background-color:#73d2ff;color:#fff;}
				.bg_wait{background-color:#ffd473;color:#fff;}
				.bg_success{background-color:#84f31e;color:#fff;}
			</style>

			<div class="page-header">
              <h3 class="page-title"> หน่วยบริหารและจัดการทุนด้านการพัฒนากำลังคน และทุนด้านการพัฒนาสถาบันอุดมศึกษา การวิจัยและการสร้างนวัตกรรม (บพค.) </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active"><a href="<?=base_url('dashboard/advance')?>">สรุปโครงการ</a></li>
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
									<label for="project_code" class="col-sm-2 col-form-label">รหัสโครงการ</label>
									<div class="col-sm-10">				
										<input type="text" class="form-control input-medium" name="project_code" value="<?=$project_code?>">
									</div>
								</div>	
								<div class="form-group row">
									<label for="project_name" class="col-sm-2 col-form-label">ชื่อโครงการ</label>
									<div class="col-sm-10">				
										<input type="text" class="form-control" name="project_name" placeholder="ภาษาไทย" required value="<?=$project_name?>">
									</div>
								</div>	
								<div class="form-group row">
									<label for="project_name_en" class="col-sm-2 col-form-label"></label>
									<div class="col-sm-10">				
										<input type="text" class="form-control" name="project_name_en" placeholder="ภาษาอังกฤษ" value="<?=$project_name_en?>">
									</div>
								</div>	
								
								<div class="form-group row">
									<label for="project_funds" class="col-sm-2 col-form-label">แหล่งทุน</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" name="project_funds" value="<?=$project_funds?>">
									</div>
									<label for="project_org" class="col-sm-2 col-form-label">ผ่านหน่วยงาน</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" name="project_org" autocomplete="on" value="<?=$project_org?>">
									</div>
								</div>	
								
								<div class="form-group row">
									<label for="project_year" class="col-sm-2 col-form-label">ปีงบประมาณ</label>
									<div class="col-sm-4">	
										<select class="form-control mb-2 mr-sm-2" name="project_year">
											<?php for($y=(date('Y')-10);$y<=(date('Y')+1);$y++){?>
												<option value="<?=$y?>" <?=$project_year==$y?'selected':''?>><?=($y+543)?></option>
											<?php }?>
										</select>	
									</div>
									<label for="project_signdate" class="col-sm-2 col-form-label">วันที่ลงนาม</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="project_signdate" value="<?=encode_date($project_signdate)?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="project_budget" class="col-sm-2 col-form-label">งบประมาณ</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control my-input" name="project_budget" value="<?=$project_budget?>">
									</div>
									<label for="project_startdate" class="col-sm-2 col-form-label">วันที่เริ่มต้น</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="project_startdate" value="<?=encode_date($project_startdate)?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="project_responsible" class="col-sm-2 col-form-label">ผู้รับผิดชอบ</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" name="project_responsible" value="<?=$project_responsible?>">
									</div>
									<label for="project_enddate" class="col-sm-2 col-form-label">วันที่สิ้นสุด</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="project_enddate" value="<?=encode_date($project_enddate)?>">
									</div>
								</div>
								
								<div class="form-group row">
									<label for="project_status_ic" class="col-sm-2 col-form-label">สถานะโครงการวิจัยในระบบ</label>
									<div class="col-sm-4">				
										<select class="form-control" name="project_status_ic">
											<option value="I" <?=$project_status_ic=="I"?'selected':''?>>(I) Inprocess</option>
											<option value="C" <?=$project_status_ic=="C"?'selected':''?>>(C) Completed</option>
										</select>
									</div>
									<label for="project_status_ic_date" class="col-sm-2 col-form-label">วันที่อัพเดทสถานะ</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="project_status_ic_date" value="<?=encode_date($project_status_ic_date)?>">
									</div>
								</div>	

								<div class="form-group row">
									<label for="project_status" class="col-sm-2 col-form-label">สถานะโครงการ</label>
									<div class="col-sm-4">				
										<select class="form-control" name="project_status" required>
											<option value=""> เลือกสถานะโครงการ </option>
											<option value="pre" <?=$project_status=="pre"?'selected':''?>>ระหว่างยื่นข้อเสนอ</option>
											<option value="doing" <?=$project_status=="doing"?'selected':''?>>กำลังดำเนินการ</option>
											<option value="done" <?=$project_status=="done"?'selected':''?>>ดำเนินการเสร็จแล้ว</option>
											<option value="research" <?=$project_status=="research"?'selected':''?>>งานบริการวิชาการ และอื่น ๆ</option>
											<option value="notbudget" <?=$project_status=="notbudget"?'selected':''?>>ไม่ได้รับงบประมาณ</option>
										</select>
									</div>
								</div>
								<?php if($member['m_level']==3){?>
								<div class="form-group row">
									<label for="project_status_success" class="col-sm-2 col-form-label">สถานะการปิดบัญชีโครงการ</label>
									<div class="col-sm-4">				
										<select class="form-control" name="project_status_success">
											<option value=""> เลือกสถานะโครงการ </option>
											<option value="success" <?=$project_status_success=="success"?'selected':''?>>ปิดโครงการ</option>
										</select>
									</div>
									<label for="project_status_success_date" class="col-sm-2 col-form-label">วันที่อัพเดทสถานะ</label>
									<div class="col-sm-4">				
										<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="project_status_success_date" value="<?=encode_date($project_status_success_date)?>">
									</div>
								</div>		
								<?php }?>
								<?php $c = count($memberList);?>
								<div class="form-group row">
									<label for="project_status" class="col-sm-2 col-form-label">พนักงานที่สามารถแก้ไข</label>
									<div class="col-sm-4">				
										<div class="form-group">
											<?php $i=0;foreach($memberList as $mem){$i++;?>
											<?php if($i<=($c/2)){?>
											<div class="form-check">
												<label class="form-check-label">
												<input type="checkbox" class="form-check-input" name="project_member_permission[]" value="<?=$mem->member_username?>" <?=$mem->member_username==$project_create_member_username?'checked onclick="return false;"':''?> <?=$mem->member_level==3?'checked onclick="return false;"':''?> <?=@in_array($mem->member_username,$project_member_permission) ? 'checked':''?>> <?=$mem->member_name?></label>
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
												<input type="checkbox" class="form-check-input" name="project_member_permission[]" value="<?=$mem->member_username?>" <?=$mem->member_username==$project_create_member_username?'checked onclick="return false;"':''?> <?=$mem->member_level==3?'checked onclick="return false;"':''?> <?=@in_array($mem->member_username,$project_member_permission) ? 'checked':''?>> <?=$mem->member_name?> </label>
											</div>
											<?php }?>
										<?php }?>
										</div>
									</div>
								</div>								
								</div>								
								
								<?php if($rs!=null){?>
								<div class="mb-3">
									<h4 class="mb-3" style="color: #11b19b;">ลักษณะการดำเนินงาน</h4>
									<?php $tab_select=$this->session->userdata('tab_select');?>
									<ul class="nav nav-tabs 3e_tabs" role="tablist">
									  <li class="nav-item">
										<a class="p-link nav-link <?=$tab_select==null?'active':''?><?=$tab_select=="before"?'active':''?>" href="#before" role="tab" data-toggle="tab" aria-selected="true">ก่อนเริ่มโครงการ</a>
									  </li>
									  <li class="nav-item">
										<a class="p-link nav-link <?=$tab_select=="doing"?'active':''?>" href="#doing" role="tab" data-toggle="tab">ดำเนินโครงการ</a>
									  </li>
									  <li class="nav-item">
										<a class="p-link nav-link <?=$tab_select=="after"?'active':''?>" href="#after" role="tab" data-toggle="tab">หลังการดำเนินโครงการ</a>
									  </li>
									</ul>
									<input type="hidden" name="tab_select" id="tab_select" value="<?=$tab_select?>">
									<!-- Tab panes -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane <?=$tab_select==null?'active':''?><?=$tab_select=="before"?'active':'fade'?>" id="before">
											<div class="pt-3 pb-3">
											<div class="table-responsive-sm">
											<table class="table">
												<thead>
													<tr class="text-center">
														<th width="">ลำดับ</th>
														<th width="200">ขั้นตอนการดำเนินงาน</th>
														<th width="">ผู้รับผิดชอบ</th>
														<th width="">สถานะการดำเนินงาน</th>
														<th width="">เริ่มต้น</th>
														<th width="">สิ้นสุด</th>
														<th width="">แนบไฟล์</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-center">1.</td>
														<td>ข้อเสนอโครงการ</td>
														<td>
															<select class="form-control" name="pre[pre_1_0_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_1_0_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_1_0_status"]?>" name="pre[pre_1_0_status]">
																<option value="none" <?=@$project_pre["pre_1_0_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_1_0_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_1_0_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_1_0_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_1_0_startdate]" value="<?=@$project_pre["pre_1_0_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_1_0_enddate]" value="<?=@$project_pre["pre_1_0_enddate"]?>"></td>
														<td>
															<?php $fcount = chFileStatus($rsFile, 'pre_1_0')!=0? '('.chFileStatus($rsFile, 'pre_1_0').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_1_0"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center">2.</td>
														<td>ขอรับมอบอำนาจการดำเนินโครงการจากมหาวิทยาลัยฯ</td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<!--
													<tr>
														<td></td>
														<td>โครงการดำเนินการผ่าน</td>
														<td>
															<select class="form-control" name="pre[pre_2_1_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_2_1_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_2_1_status"]?>" name="pre[pre_2_1_status]">
																<option value="none" <?=@$project_pre["pre_2_1_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_2_1_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_2_1_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_2_1_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control date_format" name="pre[pre_2_1_startdate]" value="<?=@$project_pre["pre_2_1_startdate"]?>"></td>
														<td><input type="text" class="form-control date_format" name="pre[pre_2_1_enddate]" value="<?=@$project_pre["pre_2_1_enddate"]?>"></td>
														<td><button type="button" class="btn btn-info btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_2_1"><i class="mdi mdi-upload"></i> แนบไฟล์</button></td>
													</tr>-->
													<tr>
														<td></td>
														<td> - บันทึกข้อความ-ขอยื่นข้อเสนอโครงการ</td>
														<td>
															<select class="form-control" name="pre[pre_2_2_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_2_2_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_2_2_status"]?>" name="pre[pre_2_2_status]">
																<option value="none" <?=@$project_pre["pre_2_2_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_2_2_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_2_2_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_2_2_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_2_startdate]" value="<?=@$project_pre["pre_2_2_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_2_enddate]" value="<?=@$project_pre["pre_2_2_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_2_2')!=0? '('.chFileStatus($rsFile, 'pre_2_2').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_2_2"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td></td>
														<td>  - หนังสือมอบอำนาจ</td>
														<td>
															<select class="form-control" name="pre[pre_2_3_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_2_3_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_2_3_status"]?>" name="pre[pre_2_3_status]">
																<option value="none" <?=@$project_pre["pre_2_3_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_2_3_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_2_3_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_2_3_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_3_startdate]" value="<?=@$project_pre["pre_2_3_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_3_enddate]" value="<?=@$project_pre["pre_2_3_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_2_3')!=0? '('.chFileStatus($rsFile, 'pre_2_3').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_2_3"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td></td>
														<td>  - VAT Form</td>
														<td>
															<select class="form-control" name="pre[pre_2_4_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_2_4_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_2_4_status"]?>" name="pre[pre_2_4_status]">
																<option value="none" <?=@$project_pre["pre_2_4_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_2_4_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_2_4_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_2_4_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_4_startdate]" value="<?=@$project_pre["pre_2_4_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_4_enddate]" value="<?=@$project_pre["pre_2_4_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_2_4')!=0? '('.chFileStatus($rsFile, 'pre_2_4').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_2_4"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td></td>
														<td>  - ข้อเสนอโครงการ (เอกสารแนบ)</td>
														<td>
															<select class="form-control" name="pre[pre_2_5_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_2_5_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_2_5_status"]?>" name="pre[pre_2_5_status]">
																<option value="none" <?=@$project_pre["pre_2_5_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_2_5_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_2_5_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_2_5_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_5_startdate]" value="<?=@$project_pre["pre_2_5_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_2_5_enddate]" value="<?=@$project_pre["pre_2_5_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_2_5')!=0? '('.chFileStatus($rsFile, 'pre_2_5').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_2_5"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center">3.</td>
														<td>เอกสารรับมอบอำนาจจากมหาวิทยาลัยฯ</td>
														<td>
															<select class="form-control" name="pre[pre_3_0_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_3_0_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_3_0_status"]?>" name="pre[pre_3_0_status]">
																<option value="none" <?=@$project_pre["pre_3_0_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_3_0_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_3_0_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_3_0_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_0_startdate]" value="<?=@$project_pre["pre_3_0_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_0_enddate]" value="<?=@$project_pre["pre_3_0_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_3_0')!=0? '('.chFileStatus($rsFile, 'pre_3_0').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_3_0"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center">4.</td>
														<td>นำส่งเอกสารที่ได้รับมอบอำนาจให้กับแหล่งทุน</td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>	
													</tr>
													<tr>
														<td class="text-center"></td>
														<td>- หนังสือตอบรับการเข้าร่วมโครงการ</td>
														<td>
															<select class="form-control" name="pre[pre_3_1_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_3_1_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_3_1_status"]?>" name="pre[pre_3_1_status]">
																<option value="none" <?=@$project_pre["pre_3_1_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_3_1_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_3_1_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_3_1_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_1_startdate]" value="<?=@$project_pre["pre_3_1_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_1_enddate]" value="<?=@$project_pre["pre_3_1_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_3_1')!=0? '('.chFileStatus($rsFile, 'pre_3_1').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_3_1"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center"></td>
														<td>- หนังสือมอบอำนาจและเอกสารของมหาวิทยาลัย <br/>(พ.ร.บ.จัดตั้งมช./สำเนาบัตรอธิการ/สำเนาบช./e-GP/สำเนาจดทะเบียนที่ปรึกษา ฯลฯ)</td>
														<td>
															<select class="form-control" name="pre[pre_3_2_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_3_2_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_3_2_status"]?>" name="pre[pre_3_2_status]">
																<option value="none" <?=@$project_pre["pre_3_2_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_3_2_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_3_2_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_3_2_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_2_startdate]" value="<?=@$project_pre["pre_3_2_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_2_enddate]" value="<?=@$project_pre["pre_3_2_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_3_2')!=0? '('.chFileStatus($rsFile, 'pre_3_2').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_3_2"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center"></td>
														<td>- ข้อเสนอโครงการฯและข้อเสนอราคา</td>
														<td>
															<select class="form-control" name="pre[pre_3_3_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_3_3_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_3_3_status"]?>" name="pre[pre_3_3_status]">
																<option value="none" <?=@$project_pre["pre_3_3_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_3_3_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_3_3_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_3_3_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_3_startdate]" value="<?=@$project_pre["pre_3_3_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_3_3_enddate]" value="<?=@$project_pre["pre_3_3_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_3_3')!=0? '('.chFileStatus($rsFile, 'pre_3_3').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_3_3"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center">5.</td>
														<td>สัญญารับทุนโครงการ</td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
													<tr>
														<td class="text-center"></td>
														<td> - สัญญาดำเนินโครงการฯ ลงนามเรียบร้อยแล้วทุกฝ่าย</td>
														<td>
															<select class="form-control" name="pre[pre_4_1_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_4_1_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_4_1_status"]?>" name="pre[pre_4_1_status]">
																<option value="none" <?=@$project_pre["pre_4_1_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_4_1_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_4_1_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_4_1_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_4_1_startdate]" value="<?=@$project_pre["pre_4_1_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_4_1_enddate]" value="<?=@$project_pre["pre_4_1_enddate"]?>"></td>
														<td>
															<?php $fcount = chFileStatus($rsFile, 'pre_4_1')!=0? '('.chFileStatus($rsFile, 'pre_4_1').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_4_1"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center"></td>
														<td> - บันทึกข้อความ-ขอนำโครงการมาบริหารจัดการเอง</td>
														<td>
															<select class="form-control" name="pre[pre_4_2_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_4_2_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_4_2_status"]?>" name="pre[pre_4_2_status]">
																<option value="none" <?=@$project_pre["pre_4_2_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_4_2_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_4_2_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_4_2_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_4_2_startdate]" value="<?=@$project_pre["pre_4_2_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_4_2_enddate]" value="<?=@$project_pre["pre_4_2_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_4_2')!=0? '('.chFileStatus($rsFile, 'pre_4_2').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_4_2"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
													<tr>
														<td class="text-center"></td>
														<td> - ดำเนินการตีตราสารเสียภาษีอากร (กรณีแหล่งทุนให้ดำเนินการ)</td>
														<td>
															<select class="form-control" name="pre[pre_4_3_person]">
																<option value=""> เลือก</option>
																<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>" <?=@$project_pre["pre_4_3_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																<?php }?>
															</select>
														</td>
														<td>
															<select class="form-control bg_<?=@$project_pre["pre_4_3_status"]?>" name="pre[pre_4_3_status]">
																<option value="none" <?=@$project_pre["pre_4_3_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																<option value="doing" <?=@$project_pre["pre_4_3_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																<option value="wait" <?=@$project_pre["pre_4_3_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																<option value="success" <?=@$project_pre["pre_4_3_status"]=="success"?'selected':''?>>เรียบร้อย</option>
															</select>
														</td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_4_3_startdate]" value="<?=@$project_pre["pre_4_3_startdate"]?>"></td>
														<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="pre[pre_4_3_enddate]" value="<?=@$project_pre["pre_4_3_enddate"]?>"></td>
														<td>
														<?php $fcount = chFileStatus($rsFile, 'pre_4_3')!=0? '('.chFileStatus($rsFile, 'pre_4_3').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="pre_4_3"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
												</tbody>
											</table>
											</div>
											</div>
											
										</div>
										<div role="tabpanel" class="tab-pane <?=$tab_select=="doing"?'active':'fade'?>" id="doing">
											<div class="pt-3 pb-3">
												<input type="hidden" name="doing[signoutz]" id="signoutGetTopicTotal" value="<?=count($project_doing)?>">
												<div class="col-md-12">
													<p class="float-left"><a href="javascript:void(0)" id="btn_addTopic" class="btn btn-info btn-sm"><i class="mdi mdi-plus"></i> เพิ่มขั้นตอน</a></p>
												</div>

												<div class="table-responsive-sm">
													<table class="table" id="tbldoing">
														<thead>
															<tr class="text-center">
																<th width="120">ลำดับ</th>
																<th width="200">ขั้นตอนการดำเนินงาน</th>
																<th width="">ผู้รับผิดชอบ</th>
																<th width="">สถานะการดำเนินงาน</th>
																<th width="">เริ่มต้น</th>
																<th width="">สิ้นสุด</th>
																<th width="">แนบไฟล์</th>
																<th width=""></th>
															</tr>
														</thead>
														<tbody>
														<?php if(@$project_doing['topic_id']!=null){?>
															<?php foreach($project_doing['topic_id'] as $k=>$v){?>
															<tr class="<?=$k?>">
																<td><input type="number" class="form-control" name="doing[topic_id][<?=$k?>]" value="<?=$project_doing['topic_id']->$k?>"></td>
																<td colspan="6"><input type="text" class="form-control" name="doing[topic_name][<?=$k?>]" value="<?=$project_doing['topic_name']->$k?>"></td>
												
																<td>
																	<a href="javascript:void(0)" p_value="<?=$k?>" class="btn_addSubTopic btn btn-sm btn-info"><i class="mdi mdi-plus"></i></a>
																	<a href="javascript:void(0)" p_value="<?=$k?>" class="btn_delTopic btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
																</td>					
															</tr>
															
																<?php if(@$project_doing[$k]->doing_name!=null){?>
																<?php foreach($project_doing[$k]->doing_name as $kk=>$vv){?>
																<tr class="sub_<?=$k?>">
																	<td></td>
																	<td><input type="text" class="form-control" name="doing[<?=$k?>][doing_name][]" value="<?=$project_doing[$k]->doing_name[$kk]?>"></td>
																	<td>
																		<select class="form-control" name="doing[<?=$k?>][doing_person][]">
																			<option value=""> เลือก</option>
																			<?php foreach($memberList as $val){?>
																			<option value="<?=$val->member_username?>" <?=$project_doing[$k]->doing_person[$kk]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																			<?php }?>
																		</select>
																	</td>
																	<td>
																		<select class="form-control bg_<?=@$project_doing[$k]->doing_status[$kk]?>" name="doing[<?=$k?>][doing_status][]">
																			<option value="none" <?=$project_doing[$k]->doing_status[$kk]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																			<option value="doing" <?=$project_doing[$k]->doing_status[$kk]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																			<option value="wait" <?=$project_doing[$k]->doing_status[$kk]=="wait"?'selected':''?>>รออนุมัติ</option>
																			<option value="success" <?=$project_doing[$k]->doing_status[$kk]=="success"?'selected':''?>>เรียบร้อย</option>
																		</select>
																	</td>
																	<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="doing[<?=$k?>][doing_startdate][]" value="<?=$project_doing[$k]->doing_startdate[$kk]?>"></td>
																	<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="doing[<?=$k?>][doing_enddate][]" value="<?=$project_doing[$k]->doing_enddate[$kk]?>"></td>	
																	<td>
																		<?php $fcount = chFileStatus($rsFile, 'doing_'.$k.'_'.$kk)!=0? '('.chFileStatus($rsFile, 'doing_'.$k.'_'.$kk).')':'';?>
																		<?php $btn_class = $fcount!=''?'success':'info'?>
																		<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="doing_<?=$k?>_<?=$kk?>"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																	</td>	
																	<td>
																		<a href="javascript:void(0)" class="btn_delTopic btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
																	</td>					
																</tr>
																<?php }?>
																<?php }?>
																
																
															<?php }?>
														<?php }?>
															
														</tbody>
													</table>
												</div>
											</div>
										
										</div>
										<div role="tabpanel" class="tab-pane <?=$tab_select=="after"?'active':'fade'?>" id="after">
											<div class="pt-3 pb-3">
												<div class="table-responsive-sm">
													<table class="table">
														<thead>
															<tr class="text-center">
																<th width="">ลำดับ</th>
																<th width="200">ขั้นตอนการดำเนินงาน</th>
																<th width="">ผู้รับผิดชอบ</th>
																<th width="">สถานะการดำเนินงาน</th>
																<th width="">เริ่มต้น</th>
																<th width="">สิ้นสุด</th>
																<th width="">แนบไฟล์</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="text-center">1.</td>
																<td>ดำเนินการปิดโครงการกับหน่วยงานต้นสังกัด</td>
																<td>
																	<!--
																	<select class="form-control" name="done[done_1_0_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_1_0_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>-->
																</td>
																<td>
																	<!--
																	<select class="form-control bg_<?=@$project_done["done_1_0_status"]?>" name="done[done_1_0_status]">
																		<option value="none" <?=@$project_done["done_1_0_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_1_0_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_1_0_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_1_0_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>-->
																</td>
																<td><!--<input type="text" class="form-control date_format" name="done[done_1_0_startdate]" value="<?=@$project_done["done_1_0_startdate"]?>">--></td>
																<td><!--<input type="text" class="form-control date_format" name="done[done_1_0_enddate]" value="<?=@$project_done["done_1_0_enddate"]?>">--></td>
																<td><!--<button type="button" class="btn btn-info btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_1_0"><i class="mdi mdi-upload"></i> แนบไฟล์</button>--></td>
															</tr>
															<tr>
																<td class="text-center"></td>
																<td> - บันทึกข้อความ</td>
																<td>
																	<select class="form-control" name="done[done_1_1_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_1_1_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>
																</td>
																<td>
																	<select class="form-control bg_<?=@$project_done["done_1_1_status"]?>" name="done[done_1_1_status]">
																		<option value="none" <?=@$project_done["done_1_1_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_1_1_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_1_1_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_1_1_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>
																</td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_1_1_startdate]" value="<?=@$project_done["done_1_1_startdate"]?>"></td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_1_1_enddate]" value="<?=@$project_done["done_1_1_enddate"]?>"></td>
																<td>
																	<?php $fcount = chFileStatus($rsFile, 'done_1_1')!=0? '('.chFileStatus($rsFile, 'done_1_1').')':'';?>
																	<?php $btn_class = $fcount!=''?'success':'info'?>
																	<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_1_1"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																</td>
															</tr>
															<tr>
																<td class="text-center"></td>
																<td> - หนังสือนำส่งค่าบริหารโครงการ</td>
																<td>
																	<select class="form-control" name="done[done_1_2_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_1_2_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>
																</td>
																<td>
																	<select class="form-control bg_<?=@$project_done["done_1_2_status"]?>" name="done[done_1_2_status]">
																		<option value="none" <?=@$project_done["done_1_2_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_1_2_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_1_2_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_1_2_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>
																</td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_1_2_startdate]" value="<?=@$project_done["done_1_2_startdate"]?>"></td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_1_2_enddate]" value="<?=@$project_done["done_1_2_enddate"]?>"></td>
																<td>
																	<?php $fcount = chFileStatus($rsFile, 'done_1_2')!=0? '('.chFileStatus($rsFile, 'done_1_2').')':'';?>
																	<?php $btn_class = $fcount!=''?'success':'info'?>
																	<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_1_2"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																</td>
															</tr>
															<tr>
																<td class="text-center">2</td>
																<td>ปิดโครงการ</td>
																<td>
																	<!--
																	<select class="form-control" name="done[done_2_0_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_2_0_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>-->
																</td>
																<td>
																	<!--
																	<select class="form-control bg_<?=@$project_done["done_2_0_status"]?>" name="done[done_2_0_status]">
																		<option value="none" <?=@$project_done["done_2_0_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_2_0_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_2_0_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_2_0_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>-->
																</td>
																<td><!--<input type="text" class="form-control date_format" name="done[done_2_0_startdate]" value="<?=@$project_done["done_2_0_startdate"]?>">--></td>
																<td><!--<input type="text" class="form-control date_format" name="done[done_2_0_enddate]" value="<?=@$project_done["done_2_0_enddate"]?>">--></td>
																<td><!--<button type="button" class="btn btn-info btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_2_0"><i class="mdi mdi-upload"></i> แนบไฟล์</button>--></td>
															</tr>
															<tr>
																<td class="text-center"></td>
																<td> - หลักฐานการโอนเงินประกันผลงาน</td>
																<td>
																	<select class="form-control" name="done[done_2_1_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_2_1_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>
																</td>
																<td>
																	<select class="form-control bg_<?=@$project_done["done_2_1_status"]?>" name="done[done_2_1_status]">
																		<option value="none" <?=@$project_done["done_2_1_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_2_1_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_2_1_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_2_1_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>
																</td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_2_1_startdate]" value="<?=@$project_done["done_2_1_startdate"]?>"></td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_2_1_enddate]" value="<?=@$project_done["done_2_1_enddate"]?>"></td>
																<td>
																	<?php $fcount = chFileStatus($rsFile, 'done_2_1')!=0? '('.chFileStatus($rsFile, 'done_2_1').')':'';?>
																	<?php $btn_class = $fcount!=''?'success':'info'?>
																	<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_2_1"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																</td>
															</tr>
															<tr>
																<td class="text-center"></td>
																<td> - ใบเสร็จรับเงินประกันผลงาน</td>
																<td>
																	<select class="form-control" name="done[done_2_2_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_2_2_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>
																</td>
																<td>
																	<select class="form-control bg_<?=@$project_done["done_2_2_status"]?>" name="done[done_2_2_status]">
																		<option value="none" <?=@$project_done["done_2_2_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_2_2_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_2_2_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_2_2_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>
																</td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_2_2_startdate]" value="<?=@$project_done["done_2_2_startdate"]?>"></td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_2_2_enddate]" value="<?=@$project_done["done_2_2_enddate"]?>"></td>
																<td>
																	<?php $fcount = chFileStatus($rsFile, 'done_2_2')!=0? '('.chFileStatus($rsFile, 'done_2_2').')':'';?>
																	<?php $btn_class = $fcount!=''?'success':'info'?>
																	<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_2_2"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																</td>
															</tr>
															<tr>
																<td class="text-center"></td>
																<td> - นำส่งใบเสร็จรับเงินประกันผลงานให้กับแหล่งทุน</td>
																<td>
																	<select class="form-control" name="done[done_2_3_person]">
																		<option value=""> เลือก</option>
																		<?php foreach($memberList as $val){?>
																		<option value="<?=$val->member_username?>" <?=@$project_done["done_2_3_person"]==$val->member_username?'selected':''?>><?=$val->member_name?></option>
																		<?php }?>
																	</select>
																</td>
																<td>
																	<select class="form-control bg_<?=@$project_done["done_2_3_status"]?>" name="done[done_2_3_status]">
																		<option value="none" <?=@$project_done["done_2_3_status"]=="none"?'selected':''?>>ยังไม่ได้ดำเนินการ</option>
																		<option value="doing" <?=@$project_done["done_2_3_status"]=="doing"?'selected':''?>>อยู่ในระหว่างการดำเนินการ</option>
																		<option value="wait" <?=@$project_done["done_2_3_status"]=="wait"?'selected':''?>>รออนุมัติ</option>
																		<option value="success" <?=@$project_done["done_2_3_status"]=="success"?'selected':''?>>เรียบร้อย</option>
																	</select>
																</td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_2_3_startdate]" value="<?=@$project_done["done_2_3_startdate"]?>"></td>
																<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="done[done_2_3_enddate]" value="<?=@$project_done["done_2_3_enddate"]?>"></td>
																<td>
																	<?php $fcount = chFileStatus($rsFile, 'done_2_3')!=0? '('.chFileStatus($rsFile, 'done_2_3').')':'';?>
																	<?php $btn_class = $fcount!=''?'success':'info'?>
																	<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile" p-id="<?=$project_id?>" p-point="done_2_3"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																</td>
															</tr>
															
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									
									
									
								</div>
								<?php }?>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="project_id" value="<?=$project_id?>">
										<input type="hidden" name="project_create_member_username" value="<?=$member['m_user']?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>
			
			<div id="sel_member" style="display:none;">
			<?php foreach($memberList as $val){?>
																<option value="<?=$val->member_username?>"><?=$val->member_name?></option>
																<?php }?>
			</div>