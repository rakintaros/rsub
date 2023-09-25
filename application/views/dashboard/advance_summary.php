			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php $advance_m = $this->session->userdata('advance_m');?>
			<?php $advance_y = $this->session->userdata('advance_y');?>
			<div class="page-header">
              <h3 class="page-title"> สรุปขอยืมทดลองจ่าย </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">สรุปทดลองจ่าย</li>
                </ol>
              </nav>
            </div>
			<div class="row">
			<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

					<div class="float-left">
					
					<form class="form-inline" method="post" action="<?=base_url('dashboard/post_advance')?>">
						<select class="form-control mb-2 mr-sm-2" id="sel_year" name="sel_year">
							<?php for($y=(date('Y')-2);$y<=date('Y');$y++){?>
								<option value="<?=$y?>" <?=$advance_y==$y?'selected':''?>><?=($y+543)?></option>
							<?php }?>
                        </select>
						<select class="form-control mb-2 mr-sm-2" id="sel_month" name="sel_month">
							<?php for($i=1;$i<=12;$i++){?>
								<option value="<?=$i?>" <?=$advance_m==$i?'selected':''?>><?=getMonth($i)?></option>
							<?php }?>
                        </select>
						<input type="hidden" name="uri" value="advance_summary">
                        <button type="submit" class="btn btn-gradient-primary mb-2"><i class="mdi mdi-refresh"></i></button>
                        <a target="_blank" href="<?=base_url('dashboard/advance_summary/print')?>" class="btn btn-gradient-secondary ml-2 mb-2"><i class="mdi mdi-printer"></i></a>
                        <a target="_blank" href="<?=base_url('dashboard/advance_summary/export')?>" class="btn btn-gradient-success ml-2 mb-2"><i class="mdi mdi-file-excel-box"></i></a>
                    </form>
					</div>
					

					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th> ลำดับ </th>
                          <th> วดป </th>
                          <th> ผู้ทดรองจ่าย </th>
                          <th> ชื่อโครงการ </th>
                          <th> ยอดตั้งเบิก </th>
                          <th> ยอดโอน </th>
                          <th> สถานะทางบัญชี </th>
                          <th> สถานะการอนุมัติ </th>
                          
                        </tr>
                      </thead>
                      <tbody>
						<?php 
						$sum_price_total = 0; 
						$sum_price_total2 = 0; 
						$i=0;
						foreach($rsList as $val){
							$i++;
						$data = json_decode(@$val->advance_detail);
						$advance_detail = (array) @$data;
						$price_total = 0;
						
						if($advance_detail!=null){
							foreach($advance_detail['list'] as $k=>$v){
								$price_total+=rmComma($advance_detail['price'][$k]);
							}
						}
						//$price_total = $price_total-rmComma($val->advance_refunds_price);
						$sum_price_total += $price_total;
						
						$sum_price_total2 += ($price_total-$val->advance_refunds_price);
		
						?>
                        <tr>
                          <td class="text-center"><?=$i?></td>
                          <td><?=ConvertToThaiDateInt($val->advance_createdate)?></td>
                          <td><?=$val->member_name?></td>
                          <td><a href="<?=base_url('dashboard/advance/edit/'.$val->advance_id)?>"><?=$val->advance_project_name?></a></td>
                          <td class="text-right"><?=number_format($price_total,2)?></td>
                          <td class="text-right"><?=number_format($price_total-$val->advance_refunds_price,2)?></td>
                          <td class="text-center">
							<?php 
								if($val->advance_clear_verify_is==1){
									echo '<label class="badge badge-success mr-sm-2"><i class="mdi mdi-check"></i> เคลียร์บัญชีแล้ว</label>';
								}else if($val->advance_verify_is==1){
									echo '<label class="badge badge-info mr-sm-2"><i class="mdi mdi-check"></i> ตรวจสอบแล้ว</label>';
								}else{
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-close"></i> รอตรวจ</label>';
								}
							?>
						  </td>
                          <td class="text-center">
							<?php 
								if($val->advance_clear_approve_is==1){
									echo '<label class="badge badge-success mr-sm-2"><i class="mdi mdi-check"></i> อนุมัติเคลียร์บัญชีแล้ว</label>';
								}else if($val->advance_is_pay==1){
									echo '<label class="badge badge-info mr-sm-2"><i class="mdi mdi-check"></i> อนุมัติจ่ายเงิน</label>';
								}else{
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-close"></i> รอตรวจ</label>';
								}
							?>
						  </td>
                        </tr>
						
						<?php }?>
                        <tr>
							<th colspan="3"></th>
							<th class="text-center"> รวมเป็นเงิน </th>
							<th class="text-right"> <?=number_format($sum_price_total,2)?> </th>
							<th class="text-right"> <?=number_format($sum_price_total2,2)?> </th>
							<th colspan="2"> </th>
						<tr>
                      </tbody>
                    </table>
					</div>
                  </div>
                </div>
              </div>
              </div>

