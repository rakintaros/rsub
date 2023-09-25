			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php $advance_m = $this->session->userdata('advance_m');?>
			<?php $advance_y = $this->session->userdata('advance_y');?>
			<div class="page-header">
              <h3 class="page-title"> ขอยืมทดรองจ่าย </h3>
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
						<input type="hidden" name="uri" value="advance">
                      <button type="submit" class="btn btn-gradient-primary mb-2"><i class="mdi mdi-refresh"></i></button>
                    </form>
					</div>
					<div class="float-right">
						<p class="float-right"> <a href="<?=base_url('dashboard/advance/add')?>" class="btn btn-gradient-info mb-2"><i class="mdi mdi-plus-circle-outline"></i> ขอยืมทดรองจ่ายใหม่</a></p>
					</div>

					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="d-none d-lg-table-cell"> ชื่อผู้ใช้ </th>
                          <th> เลขที่ </th>
                          <th> ชื่อโครงการ </th>
                          <th class="d-none d-lg-table-cell"> วันที่ </th>
                          <th> สถานะตั้งเบิก </th>
                          <th> การเคลียร์บัญชี </th>
                          <th>  </th>
                          
                        </tr>
                      </thead>
                      <tbody>
						<?php foreach($rsList as $val){?>
                        <tr>
                          <td class="py-1 d-none d-lg-table-cell">
                            <img src="<?=base_url('img/avatar/'.$val->member_img)?>" alt="image">
							<?=$val->member_name?>
                          </td>
                          <td><a href="<?=base_url('dashboard/advance/edit/'.$val->advance_id)?>" ><?=$val->advance_code?></a></td>
                          <td><?=$val->advance_project_name?></td>
                          <td class="d-none d-lg-table-cell"><?=ConvertToThaiDate($val->advance_createdate,1)?></td>
                          <td>
							<?php
								if($val->advance_is_pay==1){
									echo '<label class="badge badge-success mr-sm-2"><i class="mdi mdi-check"></i> อนุมัติจ่ายเงิน</label>';
								}else if($val->advance_verify_is==1){
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-check"></i> รออนุมัติจ่ายเงิน</label>';
								}else if($val->advance_status==1){
									echo '<label class="badge badge-info mr-sm-2"><i class="mdi mdi-check"></i> รอบัญชีตรวจสอบ</label>';
								}else{
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-check"></i> ฉบับร่าง</label>' ;
								}
							?>
						  </td>  
						  <td>
							<?php
								if($val->advance_clear_approve_is==1){
									echo '<label class="badge badge-success mr-sm-2"><i class="mdi mdi-check"></i> อนุมัติจ่ายเงิน</label>';
								}else if($val->advance_clear_verify_is==1){
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-check"></i> รออนุมัติจ่ายเงิน</label>';
								}else if($val->advance_clear_id){
									echo '<label class="badge badge-info mr-sm-2"><i class="mdi mdi-check"></i> เคลียร์แล้ว</label>';
								}else{
									echo '<label class="badge badge-secondary mr-sm-2"><i class="mdi mdi-check"></i> ค้างเคลียร์</label>' ;
								}
							?>
						  </td>
						  <td>
							<a href="<?=base_url('dashboard/advance/edit/'.$val->advance_id)?>" ><label class="badge badge-info mr-sm-2" style="cursor:pointer"><i class="mdi mdi-information-outline"></i> ตรวจสอบข้อมูล</label></a>
							<?php if($val->advance_is_pay==0 && $val->advance_verify_is==0 && $val->advance_member_username==$member['m_user']){?>
							<a href="<?=base_url('dashboard/advance/del/'.$val->advance_id)?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่');"><label class="badge badge-danger mr-sm-2" style="cursor:pointer"><i class="mdi mdi-delete "></i> </label></a>	
							<?php }?>
							<?php if($member['m_level']==3){?>
							<a href="<?=base_url('dashboard/advance/del/'.$val->advance_id)?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่');"><label class="badge badge-danger mr-sm-2" style="cursor:pointer"><i class="mdi mdi-delete "></i> </label></a>	
							<?php }?>
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
