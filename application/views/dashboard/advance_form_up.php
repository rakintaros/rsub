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
				$advance_status = null;
				
				$advance_verrify_username = null;
				$advance_verrify_datetime = null;
				
				$advance_is_pay_username = null;
				$advance_is_pay_datetime = null;

				if($rs!=null){
					$advance_code= $rs[0]->advance_code;
					$createAdvancedate = ConvertToThaiDate($rs[0]->advance_createdate,0);
					$advance_project_name = $rs[0]->advance_project_name;
					$advance_central = $rs[0]->advance_central;
					$advance_refunds_id = $rs[0]->advance_refunds_id;
					$advance_refunds_price = $rs[0]->advance_refunds_price;
					$advance_verify_is = $rs[0]->advance_verify_is;
					$advance_is_pay = $rs[0]->advance_is_pay;
					$advance_id = $rs[0]->advance_id;
					$advance_status = $rs[0]->advance_status;
					$data = json_decode(@$rs[0]->advance_detail);
					$advance_detail = (array) @$data;
					
					$advance_verrify_username = $rs[0]->advance_verrify_username;
					$advance_verrify_datetime = $rs[0]->advance_verrify_datetime;
					
					$advance_is_pay_username = $rs[0]->advance_is_pay_username;
					$advance_is_pay_datetime = $rs[0]->advance_is_pay_datetime;
				}
				
			?>
			<div class="page-header">
              <h3 class="page-title"> รายละเอียดขอยืมเงินทดรองจ่าย </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard/advance')?>">ทดลองจ่าย</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ขอยืมทดลองจ่าย</li>
                </ol>
              </nav>
            </div>
			<div class="row">
			
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<form class="forms-sample" method="post">
								<div class="row mb-3">
									<div class="col-md-12">
									<?php if($advance_verify_is==1){?>
										<p class="float-right"><a class="btn btn-success btn-sm" href="<?=base_url('dashboard/advance/print/'.$advance_id)?>"><i class="mdi mdi-printer"></i> ปริ้นใบขอทอรองจ่าย</a></p>
									<?php }?>
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
												<td>ผู้ทดลองจ่าย</td>
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
													<th colspan="3" class="text-right">แสดงใบขอยืมทดรองจ่าย</th>
													<th>
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label">
															
															<input type="checkbox" name="advance_status" value="1" class="form-check-input" <?=$advance_status==1?'checked':''?> <?=$member['m_level']==2||$member['m_level']==1?'disabled':''?> <?=$advance_is_pay==1?'disabled':''?>> แสดง<i class="input-helper"></i></label>
														</div>
													</th>
												</tr>
		
												<tr>
													<th colspan="3" class="text-right">บัญชีตรวจสอบ</th>
													<th>
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label" title="<?=$advance_verify_is==1?'('.$advance_verrify_username.')'.$advance_verrify_datetime:''?>">
															<input type="hidden" name="advance_verify_is" value="0">
															<input type="checkbox" name="advance_verify_is" value="1" class="form-check-input" <?=$advance_verify_is==1?'checked':''?> <?=$member['m_level']==3||$member['m_level']==1?'disabled':''?> <?=$advance_is_pay==1?'disabled':''?>> เอกสารถูกต้อง<i class="input-helper"></i></label>
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
			
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="member_username" value="<?=$member['m_user']?>">
										<input type="hidden" name="advance_id" value="<?=$advance_id?>">
										<input type="hidden" name="advance_code" value="<?=$advance_code?>">
										<?php if($advance_is_pay==1){?>
										<a href="<?=base_url('dashboard/advance_clear/'.$advance_id)?>" class="btn btn-gradient-primary mr-2">เคลียร์บัญชี</a>
										<?php }else{?>
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึกใบขอยืมทดรองจ่าย</button>
										<?php }?>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>