			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 
				
				$createAdvancedate = ConvertToThaiDate(date('Y-m-d'),0);
				$advance_project_name = null;
				$advance_central = null;
				$advance_detail = null;
				$advance_refunds_id = null;
				$advance_refunds_price = null;
				$advance_status = null;
				$price_total = null;
				$advance_id = null;
				$advance_verify_is = null;
				$advance_is_pay = null;

				if($rs!=null){
					$advance_code= $rs[0]->advance_code;
					$createAdvancedate = ConvertToThaiDate($rs[0]->advance_createdate,0);
					$advance_project_name = $rs[0]->advance_project_name;
					$advance_central = $rs[0]->advance_central;
					$advance_refunds_id = $rs[0]->advance_refunds_id;
					$advance_refunds_price = $rs[0]->advance_refunds_price;
					$advance_status = $rs[0]->advance_status;
					$advance_id = $rs[0]->advance_id;
					$advance_verify_is = $rs[0]->advance_verify_is;
					$advance_is_pay = $rs[0]->advance_is_pay;
					$data = json_decode(@$rs[0]->advance_detail);
					$advance_detail = (array) @$data;
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
					<?php if($advance_id!=null){?>
							
		
								<p class="float-right mt-3">
									<a class="btn btn-success btn-sm" href="<?=base_url('dashboard/advance/print/'.$advance_id)?>"><i class="mdi mdi-printer"></i> ปริ้นใบขอทอรองจ่าย</a>
								</p>
							
							
							<?php }?>
						<div class="card-body">
						
							
							<form class="forms-sample" method="post">
								<div class="form-group row">
									<label for="advance_code" class="col-sm-2 col-form-label">เลขที่</label>
									<div class="col-sm-4">
										<input type="text" class="form-control input-medium" id="advance_code" name="advance_code" value="<?php echo $advance_code;?>" readonly>
									</div>
									<label class="col-sm-3 col-form-label label-r">วันที่</label>
									<div class="col-sm-3">
										<input type="text" class="form-control input-medium float-right"  value="<?php echo $createAdvancedate;?>" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label for="advance_project_name" class="col-sm-2 col-form-label">ชื่อโครงการ</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="advance_project_name" name="advance_project_name" value="<?php echo $advance_project_name;?>" placeholder="ชื่อโครงการ">
									</div>
								</div>
								<!--
								<div class="form-group row">
									<label for="advance_central" class="col-sm-2 col-form-label">ส่วนกลาง 3E</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="advance_central" name="advance_central" value="<?php echo $advance_central;?>" placeholder="ระบุรายละเอียด">
									</div>
								</div>-->
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">ผู้ทดลองจ่าย</label>
									<div class="col-sm-10">				
										<input type="text" class="form-control input-medium" value="<?php echo $member['m_name'];?>" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">รายละเอียด</label>
									<div class="col-sm-10">				
										<table class="table" id="tblAdvance">
											<thead class="table-info">
												<tr>
													<th width="5%"></th>
													<th colspan="2" class="text-center">รายการ</th>
													<th width="20%" class="text-center">จำนวนเงิน</th>
												</tr>
											</thead>
											<tbody>
												<tr class="ad_list"><td><a href="javascript:void(0)" id="btn-addAdvanceList" class="btn btn-gradient-info btn-sm"><i class="mdi mdi-note-plus-outline"></i> Add</a></td></tr>
												<?php if($advance_detail!=null){?>
												<?php foreach($advance_detail['list'] as $k=>$v){$price_total+=rmComma($advance_detail['price'][$k]);?>
												<tr class="ad_list">
													<td><a href="javascript:void(0)" class="btn-delAdvanceList btn btn-gradient-danger btn-sm"><i class="mdi mdi-delete"></i> Del</a></td>
													<td colspan="2"><input type="text" class="form-control" name="advance_detail[list][]" required value="<?=$advance_detail['list'][$k]?>"></td>
													<td class="text-right"><input type="text" class="form-control my-input text-right price_list" name="advance_detail[price][]" required value="<?=$advance_detail['price'][$k]?>"></td>
												</tr>
												<?php }?>
												<?php }?>
												
												
												<tr>
													<th></th>
													<th class="text-right">รวมเป็นเงิน</th>
													<th></th>
													<th class="text-right"><input type="text" class="form-control my-input text-right" id="list_summary" readonly value="<?=$price_total?>"></th>
												</tr>
												<tr>
													<th></th>
													<th class="text-right">เงินคืนขอสำรองจ่ายก่อนจาก เลขที่</th>
													<th><input type="text" class="form-control" placeholder="ให้กรอกเลขใบตั้งยืม" name="advance_refunds_id" value="<?php echo $advance_refunds_id;?>"></th>
													<th class="text-right"><input type="text" class="form-control my-input text-right" name="advance_refunds_price" id="advance_refunds_price" placeholder="ให้กรอกจำนวนเงิน" value="<?php echo $advance_refunds_price;?>"></th>
												</tr>
												<tr>
													<th></th>
													<th class="text-right">ยอดโอน</th>
													<th ></th>
													<th class="text-right"><input type="text" class="form-control my-input text-right" id="result_summary" readonly value="<?=($price_total-$advance_refunds_price)?>"></th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th ></th>
													<th >
													<div class="form-check form-check-flat form-check-primary">
														<label class="form-check-label">
														
														  <input type="checkbox" name="advance_status" value="1" class="form-check-input" checked onclick="return false;"> แสดงใบขอยืมทดรองจ่าย<i class="input-helper"></i></label>
													  </div>
													</th>
												</tr>
												<?php if($member['m_level']==2){?>
												<tr>
													<th colspan="3" class="text-right">บัญชีตรวจสอบ</th>
													<th>
														<div class="form-check form-check-flat form-check-primary">
															<label class="form-check-label">
															<input type="hidden" name="advance_verify_is" value="0">
															<input type="checkbox" name="advance_verify_is" value="1" class="form-check-input" <?=$advance_verify_is==1?'checked':''?> <?=$member['m_level']==3||$member['m_level']==1?'disabled':''?> <?=$advance_is_pay==1?'disabled':''?>> เอกสารถูกต้อง<i class="input-helper"></i></label>
														</div>
													</th>
												</tr>
												<?php }?>
											</tbody>
										</table>
										<hr/>
										
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="member_username" value="<?=$member['m_user']?>">
										<input type="hidden" name="advance_id" value="<?=$advance_id?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึกใบขอยืมทดลองจ่าย</button>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>