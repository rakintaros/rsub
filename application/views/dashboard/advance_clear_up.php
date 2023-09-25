			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				
				$createAdvancedate = ConvertToThaiDate(date('Y-m-d'),0);
				$advance_project_name = null;
				$advance_central = null;
				$advance_detail = null;
				$advance_refunds_id = null;
				$advance_refunds_price = null;
				$advance_verify_is = null;
				$advance_is_pay = null;
				$price_total = null;
				$advance_id = null;

				$advance_clear_datetime = ConvertToThaiDate(date('Y-m-d'),0);
				$advance_clear_real_money = null;
				$advance_clear_price_total = null;
				$advance_clear_status = null;
				$advance_clear_type = null;
				$advance_clear_type_note = null;
				$advance_clear_verify_is = null;
				$advance_clear_approve_is = null;
				$advance_clear_verify_detail = null;
				
				$advance_is_pay_username = null;
				$advance_is_pay_datetime = null;
				$advance_verrify_username = null;
				$advance_verrify_datetime = null;
				
				$advance_clear_verify_username = null;
				$advance_clear_verify_datetime = null;
				$advance_clear_approve_username = null;
				$advance_clear_approve_datetime = null;
				
				if($rsClear!=null){
					$advance_code= $rsClear[0]->advance_code;
					$createAdvancedate = ConvertToThaiDate($rsClear[0]->advance_createdate,0);
					$advance_project_name = $rsClear[0]->advance_project_name;
					$advance_central = $rsClear[0]->advance_central;
					$advance_refunds_id = $rsClear[0]->advance_refunds_id;
					$advance_refunds_price = $rsClear[0]->advance_refunds_price;
					$advance_verify_is = $rsClear[0]->advance_verify_is;
					$advance_is_pay = $rsClear[0]->advance_is_pay;
					$advance_id = $rsClear[0]->advance_id;
					$data = json_decode(@$rsClear[0]->advance_detail);
					$advance_detail = (array) @$data;
					
					$advance_clear_datetime = ConvertToThaiDate($rsClear[0]->advance_clear_datetime,0);
					$advance_clear_real_money = $rsClear[0]->advance_clear_real_money;
					$advance_clear_price_total = $rsClear[0]->advance_clear_price_total;
					$advance_clear_status = $rsClear[0]->advance_clear_status;
					$advance_clear_type = $rsClear[0]->advance_clear_type;
					$advance_clear_type_note = $rsClear[0]->advance_clear_type_note;
					$advance_clear_verify_is = $rsClear[0]->advance_clear_verify_is;
					$advance_clear_approve_is = $rsClear[0]->advance_clear_approve_is;
					$advance_clear_verify_detail = $rsClear[0]->advance_clear_verify_detail;
					
					$advance_is_pay_username = $rsClear[0]->advance_is_pay_username;
					$advance_is_pay_datetime = $rsClear[0]->advance_is_pay_datetime;
					$advance_verrify_username = $rsClear[0]->advance_verrify_username;
					$advance_verrify_datetime = $rsClear[0]->advance_verrify_datetime;
					
					$advance_clear_verify_username = $rsClear[0]->advance_clear_verify_username;
					$advance_clear_verify_datetime = $rsClear[0]->advance_clear_verify_datetime;
					$advance_clear_approve_username = $rsClear[0]->advance_clear_approve_username;
					$advance_clear_approve_datetime = $rsClear[0]->advance_clear_approve_datetime;
				}
				

			?>
			<!--
			<div class="page-header">
              <h3 class="page-title">  </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard/advance')?>">ทดลองจ่าย</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ขอยืมทดลองจ่าย</li>
                </ol>
              </nav>
            </div>-->
			<div class="row">
				<div class="col-lg-8 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							
								<div class="row mb-3">
									<div class="col-md-12">
									<h3>รายละเอียดขอยืมเงินทดรองจ่าย </h3>
									<hr/>
										<table class="table table-borderless">
											<tr>
												<td width="100">เลขที่</td>
												<td><?php echo $advance_code;?></td>
												<td class="text-right">วันที่ <?php echo $createAdvancedate;?></td>
											</tr>
											<tr>
												<td>ชื่อโครงการ</td>
												<td colspan="2" style="white-space: initial;"><?php echo $advance_project_name;?></td>
											</tr>
											<!--
											<tr>
												<td>ส่วนกลาง 3E</td>
												<td colspan="2"><?php echo $advance_central;?></td>
											</tr>-->
											<tr>
												<td>ผู้ทดรองจ่าย</td>
												<td colspan="2"><?php echo $rs[0]->member_name;?></td>
											</tr>
											<tr>
												<td colspan="3">รายละเอียด</td>
											</tr>
										</table>
										<table class="table table-bordered mb-3">
											<thead class="table-info">
												<tr>
													<th width="50"></th>
													<th colspan="2" class="text-center">รายการ</th>
													<th width="150" class="text-center">จำนวนเงิน</th>
												</tr>
											</thead>
											<tbody>	
												<?php if($advance_detail!=null){?>
												<?php $i=0;foreach($advance_detail['list'] as $k=>$v){$price_total+=rmComma($advance_detail['price'][$k]);$i++;?>
												<tr>
													<td class="text-center"><?=$i?>.</td>
													<td colspan="2" style="white-space: initial;"><?=$advance_detail['list'][$k]?></td>
													<td class="text-right"><?=number_format(rmComma($advance_detail['price'][$k]),2)?></td>
												</tr>
												<?php }?>
												<?php }?>
												<tr>
													<th colspan="3" class="text-right">รวมเป็นเงิน</th>	
													<th class="text-right"><?=number_format($price_total,2)?></th>
												</tr>
												<tr>
													<th colspan="2" class="text-right">เงินคืนขอสำรองจ่ายก่อนจาก เลขที่</th>
													<th><?php echo $advance_refunds_id;?></th>
													<th class="text-right"><?php echo number_format($advance_refunds_price,2);?></th>
												</tr>
												<tr>
													<th colspan="3" class="text-right">ยอดโอน</th>
													<th class="text-right"><?=number_format(($price_total-$advance_refunds_price),2)?></th>
												</tr>
												<tr>
													<th colspan="3" class="text-right">บัญชีตรวจสอบ</th>
													<th>
													
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label" title="<?=$advance_verify_is==1?'('.$advance_verrify_username.')'.$advance_verrify_datetime:''?>">
															<input type="hidden" name="advance_verify_is" value="0">
															<input type="checkbox" name="advance_verify_is" value="1" class="form-check-input" <?=$advance_verify_is==1?'checked':''?> <?=$member['m_level']==1?'disabled':''?> <?=$advance_is_pay==1?'disabled':''?>> เอกสารถูกต้อง<i class="input-helper"></i></label>
														</div>
													</th>
												</tr>
											
												<tr>
													<th colspan="3" class="text-right">อนุมัติการจ่ายเงิน</th>
													<th>
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label" title="<?=$advance_is_pay==1?'('.$advance_is_pay_username.')'.$advance_is_pay_datetime:''?>">
															<input type="hidden" name="advance_is_pay" value="0">
															<input type="checkbox" name="advance_is_pay" value="1" class="form-check-input" <?=$advance_is_pay==1?'checked':''?> <?=$member['m_level']==2||$member['m_level']==1?'disabled':''?>> อนุมัติ<i class="input-helper"></i></label>
														</div>
													</th>
												</tr>

											</tbody>
										</table>
									</div>
								</div>

						</div>
					</div>
				</div>

				
				<div class="col-lg-4 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<h3>การเคลียร์บัญชี 
							
							<span class="float-right"><a href="<?=base_url('dashboard/advance/print_clear/'.$advance_id)?>" title="ปริ้นในเคลียร์บิล"><i class="mdi mdi-printer"></i></a></span>
							
							</h3>
							<hr/>
							
							<form class="forms-sample" method="post">
								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">วันที่</label>
									<label for="advance_central" class="col-sm-7 col-form-label"><?=$advance_clear_datetime?></label>
									
								</div>
								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">ยอดทดรองจ่าย</label>
									<label for="advance_central" class="col-sm-7 col-form-label"><?=number_format($price_total,2)?></label>
								</div>
								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">ยอดจ่ายจริง</label>
									<label for="advance_central" class="col-sm-7 col-form-label"><?=number_format($advance_clear_real_money,2)?></label>
								</div>
								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">เท่ากับ</label>
									<label for="advance_central" class="col-sm-7 col-form-label"><?=number_format(($price_total-$advance_clear_real_money),2)?></label>
								</div>
								<div id="box_plus" <?=$advance_clear_status==1?'':'style="display:none;"'?> <?=$advance_clear_price_total==0?'style="display:none;"':''?>>
									<div class="form-group row">
										<label for="advance_central" class="col-sm-5 col-form-label">ขอคืนเงินคงเหลือ</label>
										<label for="advance_central" class="col-sm-7 col-form-label"><?=number_format($advance_clear_price_total,2)?></label>
									</div>
									<?php $clear = array('','เงินสด','โอนเงิน','สำรองจ่าย');?>
									<div class="form-group row">
										<label for="advance_central" class="col-sm-5 col-form-label">รูปแบบ</label>
										<label for="advance_central" class="col-sm-7 col-form-label"><?=$clear[$advance_clear_type]?></label>
									</div>
									<?php if($advance_clear_type==3){?>
									<div class="form-group row">
										<label for="advance_central" class="col-sm-5 col-form-label">เลขที่</label>
										<label for="advance_central" class="col-sm-7 col-form-label"><?=$advance_clear_type_note?></label>
									</div>
									<?php }?>
								</div>
								<div id="box_minus" <?=$advance_clear_status==0?'':'style="display:none;"'?> <?=$advance_clear_price_total==0?'style="display:none;"':''?>>
									<div class="form-group row">
										<label for="advance_central" class="col-sm-5 col-form-label">เบิกจ่ายเพิ่ม</label>
										<label for="advance_central" class="col-sm-7 col-form-label"><?=number_format(($price_total-$advance_clear_real_money),2)?></label>
									</div>
								</div>
								
								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">รายละเอียด</label>
									<div class="col-sm-7">
										<textarea class="form-control" name="advance_clear_verify_detail" rows="3"><?=$advance_clear_verify_detail?></textarea>
									</div>
								</div>
								
								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">บัญชีตรวจสอบ</label>
									<div class="col-sm-7">
										<div class="form-check form-check-flat form-check-primary">
											<label class="form-check-label" title="<?=$advance_clear_verify_is==1?'('.$advance_clear_verify_username.')'.$advance_clear_verify_datetime:''?>">
											<input type="hidden" name="advance_clear_verify_is" value="0">
											<input type="checkbox" name="advance_clear_verify_is" value="1" class="form-check-input" <?=$advance_clear_verify_is==1?'checked':''?> <?=$member['m_level']==1?'disabled':''?> <?=$advance_clear_approve_is==1?'disabled':''?>> เอกสารถูกต้อง<i class="input-helper"></i></label>
										</div>
														
										
									</div>
								</div>
								
								
								
								

								<div class="form-group row">
									<label for="advance_central" class="col-sm-5 col-form-label">อนุมัติการจ่าย</label>
									<div class="col-sm-7">
										<div class="form-check form-check-flat form-check-primary">
											<label class="form-check-label" title="<?=$advance_clear_approve_is==1?'('.$advance_clear_approve_username.')'.$advance_clear_approve_datetime:''?>">
											<input type="hidden" name="advance_clear_approve_is" value="0">
											<input type="checkbox" name="advance_clear_approve_is" value="1" class="form-check-input" <?=$advance_clear_approve_is==1?'checked':''?> <?=$member['m_level']==2||$member['m_level']==1?'disabled':''?>> อนุมัติ<i class="input-helper"></i></label>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										
										<input type="hidden" name="advance_clear_real_money" value="<?=$advance_clear_real_money?>">
										<input type="hidden" name="advance_clear_datetime" value="<?=date('Y-m-d H:i:s')?>">
										<input type="hidden" id="advance_id" name="advance_id" value="<?=$advance_id?>">
										<?php if($member['m_level']==1){?>
										<a href="<?php echo base_url('dashboard/advance')?>" class="btn btn-gradient-primary mr-2">กลับหน้าหลัก</a>
										<?php }else{?>
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
										<?php }?>
									</div>
								</div>
							  
							
							  
							</form>
							
						</div>
					</div>
				</div>
            </div>