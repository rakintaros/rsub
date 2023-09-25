			<?php $member = $this->session->userdata('member_logged_in');?>
		
			<style>
			.modal-lg {
				max-width: 80% !important;
			}
			</style>
			<div class="page-header">
              <h3 class="page-title"> สรุปขอยืมทดลองจ่าย </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ทดลองจ่าย</li>
                </ol>
              </nav>
            </div>
			<div class="row">
			<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
					<div class="float-left">
					<?php $do =$this->uri->segment(3);?>
					<form class="form-inline">
						<select class="form-control mb-2 mr-sm-2" id="sel_type">
							<option value="receive" <?=$do=='receive'?'selected':''?> <?=$do==''?'selected':''?>>เอกสารเข้า</option>
							<option value="export" <?=$do=='export'?'selected':''?>>เอกสารออก</option>
                        </select>
                      <button type="button" id="btn_document" class="btn btn-gradient-primary mb-2"><i class="mdi mdi-refresh"></i></button>
                    </form>
					</div>
					<div class="float-right">
						<p class="float-right"> 
	
						
						<div class="btn-group">
						 
						  <button type="button" class="btn btn-gradient-info mb-2 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="mdi mdi-plus-circle-outline"></i> เอกสาร <span class="sr-only">Toggle Dropdown</span>
						  </button>
							  <div class="dropdown-menu">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#document_receive"> เอกสารเข้า</a>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#document_export"> เอกสารออก</a>
							  </div>
							</div>
						</p>
					</div>

					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th width="150"> เลขทะเบียน<?=$do=="export"?'ออก':'รับ'?></th>
						  <?php if($do=="receive"){?>
						  <th width="150"> เลขที่เอกสาร </th>
						  <?php }?>
                          <th width="150"> ลงวันที่ </th>
                          <th width="150"> จาก </th>
                          <th width="150"> ถึง </th>
                          <th width="150"> ประเภทเอกสาร </th>
                          <th> เรื่อง </th>
						  <?php if($do=="receive"){?>
                          <th width="150"> ผู้รับผิดชอบ </th>
						  <?php }else{?>
						  <th width="150"> ผู้ปฏิบัติ </th>
						  <?php }?>
                          <th width="100"> อนุมัติ </th>   
                        </tr>
                      </thead>
                      <tbody>
						<?php foreach($rsList as $val){?>
							<tr>
								<td>
								<?php if($member['m_level']==2){?>
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#m_edit<?=$val['transfer_id']?>">
									<?=$val['transfer_code']?>
								</button>
								<div class="modal fade" id="m_edit<?=$val['transfer_id']?>" tabindex="-1" role="dialog" aria-labelledby="<?=$val['transfer_id']?>Label" aria-hidden="true">
								  <div class="modal-dialog modal-lg" role="document">
									<form class="forms-sample" method="post" enctype="multipart/form-data">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title" id="<?=$val['transfer_id']?>Label"><?=$val['transfer_title']?></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
										
										<table class="table">
											<tbody>
												<tr>
													<td>เลขทะเบียน<?=$val['transfer_type']=="receive"?'รับ':'ออก'?></td>
													<td><?=$val['transfer_code']?></td>
												</tr>
												<?php if($val['transfer_type']=="receive"){?>
												<tr>
													<td>เลขที่เอกสาร</td>
													<td><input type="text" class="form-control" name="transfer_no" value="<?=$val['transfer_no']?>" required></td>
												</tr>
												<?php }?>
												<tr>
													<td>ลงวันที่</td>
													<td><input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="transfer_date" value="<?=encode_date($val['transfer_date'])?>" required></td>
												</tr>
												<tr>
													<td>จาก</td>
													<td><input type="text" class="form-control" name="transfer_form" value="<?=$val['transfer_form']?>" required></td>
												</tr>
												<tr>
													<td>ถึง</td>
													<td><input type="text" class="form-control" name="transfer_to" value="<?=$val['transfer_to']?>" required></td>
												</tr>
												<tr>
													<td>เรื่อง</td>
													<td><input type="text" class="form-control" name="transfer_title" value="<?=$val['transfer_title']?>" required></td>
												</tr>
												<tr>
													<td>ประเภทเอกสาร</td>
													<td>
														<select class="form-control transfer_category_id" name="transfer_category_id" id="transfer_category_id" required>
															<option value=""> เลือกประเภทเอกสาร </option>
															<?php foreach($rsCat as $item){?>
															<option value="<?=$item->category_id?>" <?=$val['transfer_category_id']==$item->category_id?'selected':''?>><?=$item->category_name?></option>
															<?php }?>
														</select>
													</td>
												</tr>
												<tr class="cf_cat" style="display:none;">
													<td>ประเภทเอกสาร</td>
													<td>
														<input type="text" class="form-control" name="transfer_category_name" value="<?=$val->transfer_category_name?>" placeholder="ระบุประเภทเอกสาร">
													</td>
												</tr>
												<?php if($val['transfer_type']=="receive"){?>
												<tr>
													<td><?=$val['transfer_type']=="receive"?'ผู้รับผิดชอบ':'ผู้ปฏิบัติ'?></td>
													<td>
													
													<?php 
														$person = json_decode($val['transfer_responsible']);
														$transfer_responsible = (array) @$person;
														$c = count($memberList);
													?>
													<div class="form-group row">
														<div class="col-sm-4">				
															<div class="form-group">
																<?php $i=0;foreach($memberList as $mem){$i++;?>
																<?php if($i<($c/3)){?>
																<div class="form-check">
																	<label class="form-check-label">
																	<input type="checkbox" class="form-check-input" name="transfer_responsible[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,$transfer_responsible) ? 'checked':''?>> <?=$mem->member_name?></label>
																</div>
																<?php }?>
																<?php }?>
															</div>
														</div>
														
														<div class="col-sm-4">				
															<div class="form-group">
																<?php $i=0;foreach($memberList as $mem){$i++;?>
																<?php if($i>=($c/3) && $i<(($c/3)*2)){?>
																<div class="form-check">
																	<label class="form-check-label">
																	<input type="checkbox" class="form-check-input" name="transfer_responsible[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,$transfer_responsible) ? 'checked':''?>> <?=$mem->member_name?></label>
																</div>
																<?php }?>
																<?php }?>
															</div>
														</div>
													
														<div class="col-sm-4">	
															<div class="form-group">
															<?php $i=0;foreach($memberList as $mem){$i++;?>
																<?php if($i>(($c/3)*2)){?>
																<div class="form-check">
																	<label class="form-check-label">
																	<input type="checkbox" class="form-check-input" name="transfer_responsible[]" value="<?=$mem->member_username?>" <?=@in_array($mem->member_username,$transfer_responsible) ? 'checked':''?>> <?=$mem->member_name?> </label>
																</div>
																<?php }?>
															<?php }?>
															</div>
														</div>
													</div>	<!--end-->
													
													</td>
												</tr>
												
												<?php }else{?>
												
												<tr>
													<td><?=$val['transfer_type']=="receive"?'ผู้รับผิดชอบ':'ผู้ปฏิบัติ'?></td>
													<td><?=$val['transfer_responsible']=="other"? $val['transfer_responsible_other']:$val['transfer_responsible']?></td>
												</tr>
												<?php }?>
												<tr>
													<td>ไฟล์เอกสาร</td>
													<td>
													<input type="file" class="mb-3" multiple name="transfer_files[]"><br/>
													<?php foreach($val['subScope'] as $item){?>
														<a class="btn btn-info btn-sm mb-2"href="<?=base_url('uploads/'.$item['file_path'])?>"><?=$item['file_name']?></a><br/>
													<?php }?>
													</td>
												</tr>
												<?php if($member['m_level']==3){?>
												<tr>
													<td>อนุมัติเอกสาร</td>
													<td>
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label">
															<input type="hidden" name="transfer_approve" value="0">
															
															<input type="checkbox" name="transfer_approve" value="1" <?=$val['transfer_approve']==1?'checked':''?>class="form-check-input"> อนุมัติ<i class="input-helper"></i></label>
														</div>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>

						
									  </div>
									  <div class="modal-footer">
									    <?php if($member['m_level']!=1){?>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
										<input type="hidden" name="transfer_id" value="<?=$val['transfer_id']?>">
										<input type="hidden" name="transfer_type" value="<?=$val['transfer_type']?>">
										
										<button type="submit" class="btn btn-primary">บันทึก</button>
										<?php }?>
									  </div>
									</div>
									</form>
								  </div>
								</div>
								<?php }else{?>
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#m<?=$val['transfer_id']?>">
									<?=$val['transfer_code']?>
								</button>
								<div class="modal fade" id="m<?=$val['transfer_id']?>" tabindex="-1" role="dialog" aria-labelledby="<?=$val['transfer_id']?>Label" aria-hidden="true">
								  <div class="modal-dialog modal-lg" role="document">
									<form class="forms-sample" method="post" enctype="multipart/form-data">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title" id="<?=$val['transfer_id']?>Label"><?=$val['transfer_title']?></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
										<table class="table">
											<tbody>
												<tr>
													<td>เลขทะเบียน<?=$val['transfer_type']=="receive"?'รับ':'ออก'?></td>
													<td><?=$val['transfer_code']?></td>
												</tr>
												<?php if($val['transfer_type']=="receive"){?>
												<tr>
													<td>เลขที่เอกสาร</td>
													<td><?=$val['transfer_no']?></td>
												</tr>
												<?php }?>
												<tr>
													<td>ลงวันที่</td>
													<td><?=ConvertToThaiDate($val['transfer_date'],0)?></td>
												</tr>
												<tr>
													<td>จาก</td>
													<td><?=$val['transfer_form']?></td>
												</tr>
												<tr>
													<td>ถึง</td>
													<td><?=$val['transfer_to']?></td>
												</tr>
												<tr>
													<td>ประเภทเอกสาร</td>
													<td><?=$val['transfer_category_id']==5? $val['transfer_category_name']:$val['category_name']?></td>
												</tr>
												<tr>
													<td><?=$val['transfer_type']=="receive"?'ผู้รับผิดชอบ':'ผู้ปฏิบัติ'?></td>
													<td><?=$val['transfer_responsible']=="other"? $val['transfer_responsible_other']:$val['transfer_responsible']?></td>
												</tr>
												<tr>
													<td>ไฟล์เอกสาร</td>
													<td>
													<input type="file" class="mb-3" multiple name="transfer_files[]"><br/>
													<?php foreach($val['subScope'] as $item){?>
														<a class="btn btn-info btn-sm mb-2" href="<?=base_url('uploads/'.$item['file_path'])?>"><?=$item['file_name']?></a><br/>
													<?php }?>
													</td>
												</tr>
												<?php if($member['m_level']==3){?>
												<tr>
													<td>อนุมัติเอกสาร</td>
													<td>
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label">
															<input type="hidden" name="transfer_approve" value="0">
															<input type="checkbox" name="transfer_approve" value="1" <?=$val['transfer_approve']==1?'checked':''?>class="form-check-input"> อนุมัติ<i class="input-helper"></i></label>
														</div>
													</td>
												</tr>
												<?php }?>
											</tbody>
										</table>

						
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
										<?php if($member['m_level']==3){?>
										<input type="hidden" name="transfer_type" value="<?=$val['transfer_type']?>">
										<input type="hidden" name="transfer_id" value="<?=$val['transfer_id']?>">
										<button type="submit" class="btn btn-primary">บันทึก</button>
										<?php }?>
									  </div>
									</div>
									</form>
								  </div>
								</div>
								<?php }?>
								</td>
								<?php if($do=="receive"){?>
								<td><?=$val['transfer_no']?></td>
								<?php }?>
								<td><?=ConvertToThaiDateInt($val['transfer_date'])?></td>
								<td><?=$val['transfer_form']?></td>
								<td><?=$val['transfer_to']?></td>
								<td><?=$val['transfer_category_id']==5? $val['transfer_category_name']:$val['category_name']?></td>
								<td><?=$val['transfer_title']?></td>
								<td><?=$val['transfer_responsible']=="other"? $val['transfer_responsible_other']:$val['transfer_responsible']?></td>
								<td>
								<?php 
								if($val['transfer_approve']==1){
									echo '<label class="badge badge-success mr-sm-2" title="'.$val['transfer_approve_username'].'"><i class="mdi mdi-check"></i> อนุมัติ</label>';
								}else{
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-close"></i> รออนุมัติ</label>';
								}
								?>
								</td>
								
							</tr>
						
						<?php }?>
                        
                      </tbody>
                    </table>
					</div>
                  </div>
                </div>
              </div>
              </div>

			  
				<div class="modal fade" id="document_receive" tabindex="-1" role="dialog" aria-labelledby="document_receiveLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<form class="forms-sample" method="post" enctype="multipart/form-data">
					  <div class="modal-header">
						<h5 class="modal-title" id="document_receiveLabel">เพิ่มรายการเอกสารเข้า</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
							<div class="form-group row">
								<label for="transfer_code" class="col-sm-4 col-form-label">เลขทะเบียนรับ</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_code" required value="<?=$r_receive?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_no" class="col-sm-4 col-form-label">เลขที่เอกสาร</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_no" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_code" class="col-sm-4 col-form-label">ประเภทเอกสาร</label>
								<div class="col-sm-8">
									<select class="form-control transfer_category_id" name="transfer_category_id" id="transfer_category_id" required>
										<option value=""> เลือกประเภทเอกสาร </option>
										<?php foreach($rsCat as $item){?>
										<option value="<?=$item->category_id?>"><?=$item->category_name?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="cf_cat" style="display:none;">
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_category_name" placeholder="ระบุประเภทเอกสาร">
								</div>
							</div>
							</div>
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label">วันที่</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="transfer_date" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label">จาก</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_form" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_to" class="col-sm-4 col-form-label">ถึง</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_to" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_title" class="col-sm-4 col-form-label">เรื่อง</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_title" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_responsible" class="col-sm-4 col-form-label">ผู้รับผิดชอบ</label>
								<div class="col-sm-8">
									<?php $c = count($memberList);?>
									<div class="form-group row">
										<div class="col-sm-4">				
											<div class="form-group">
												<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i<($c/3)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="transfer_responsible[]" value="<?=$mem->member_username?>" > <?=$mem->member_name?></label>
												</div>
												<?php }?>
												<?php }?>
											</div>
										</div>
										
										<div class="col-sm-4">				
											<div class="form-group">
												<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i>=($c/3) && $i<(($c/3)*2)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="transfer_responsible[]" value="<?=$mem->member_username?>" > <?=$mem->member_name?></label>
												</div>
												<?php }?>
												<?php }?>
											</div>
										</div>
									
										<div class="col-sm-4">	
											<div class="form-group">
											<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i>(($c/3)*2)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="transfer_responsible[]" value="<?=$mem->member_username?>" > <?=$mem->member_name?> </label>
												</div>
												<?php }?>
											<?php }?>
											</div>
										</div>
									</div>	<!--end-->			
								</div>
							</div>
							<div class="cf_responsible" style="display:none;">
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_category_name" placeholder="ระบุ">
								</div>
							</div>
							</div>
							<div class="form-group row">
								<label for="transfer_to" class="col-sm-4 col-form-label">แนบไฟล์</label>
								<div class="col-sm-8">
									<input type="file" multiple name="transfer_files[]">
								</div>
							</div>
					  </div>
					  <div class="modal-footer">
					    <input type="hidden" name="transfer_date" value="<?=encode_date(date('Y-m-d'))?>">
						<input type="hidden" name="transfer_type" value="receive">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary">บันทึก</button>
					  </div>
					  </form>
					</div>
				  </div>
				</div>
				
				<div class="modal fade" id="document_export" tabindex="-1" role="dialog" aria-labelledby="document_exportLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<form class="forms-sample" method="post" enctype="multipart/form-data">
					  <div class="modal-header">
						<h5 class="modal-title" id="document_exportLabel">เพิ่มรายการเอกสารออก</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
							<div class="form-group row">
								<label for="transfer_code" class="col-sm-4 col-form-label">เลขทะเบียนออก</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_code" required value="<?=$r_export?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_code" class="col-sm-4 col-form-label">ประเภทเอกสาร</label>
								<div class="col-sm-8">
									<select class="form-control transfer_category_id" name="transfer_category_id" id="transfer_category_id" required>
										<option value=""> เลือกประเภทเอกสาร </option>
										<?php foreach($rsCat as $item){?>
										<option value="<?=$item->category_id?>"><?=$item->category_name?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="cf_cat" style="display:none;">
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_category_name" placeholder="ระบุประเภทเอกสาร">
								</div>
							</div>
							</div>
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label">วันที่</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" data-provide="datepicker" data-date-language="th-th" name="transfer_date" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label">จาก</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_form" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_to" class="col-sm-4 col-form-label">ถึง</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_to" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_to" class="col-sm-4 col-form-label">เรื่อง</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_title" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="transfer_to" class="col-sm-4 col-form-label">ผู้รับปฏิบัติ</label>
								<div class="col-sm-8">
									<select class="form-control transfer_responsible" name="transfer_responsible"required>
										<option value=""> เลือก</option>
										<?php foreach($memberList as $val){?>
										<option value="<?=$val->member_username?>"><?=$val->member_name?></option>
										<?php }?>
										<option value="other">อื่นๆ</option>
									</select>
								</div>
							</div>
							<div class="cf_responsible" style="display:none;">
							<div class="form-group row">
								<label for="transfer_form" class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="transfer_responsible_other" placeholder="ระบุ">
								</div>
							</div>
							</div>
							
							<div class="form-group row">
								<label for="transfer_to" class="col-sm-4 col-form-label">แนบไฟล์</label>
								<div class="col-sm-8">
									<input type="file" multiple name="transfer_files[]">
								</div>
							</div>
					  </div>
					  <div class="modal-footer">
						<input type="hidden" name="transfer_date" value="<?=encode_date(date('Y-m-d'))?>">
						<input type="hidden" name="transfer_type" value="export">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary">บันทึก</button>
					  </div>
					  </form>
					</div>
				  </div>
				</div>