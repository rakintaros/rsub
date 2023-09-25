			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php $project_type = $this->session->userdata('project_type');?>
			<?php $project_year = $this->session->userdata('project_year');?>
			<style>
			a.p_link{color:#11b19b;text-decoration: none;}
			a.p_link:hover{color:#d084ff;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> ทีมงาน </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ทีมงาน</li>
                </ol>
              </nav>
            </div>

			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">

							<div class="float-right">
								<p class="float-right"> <a href="<?=base_url('dashboard/member/add')?>" class="btn btn-gradient-info mb-2"><i class="mdi mdi-plus-circle-outline"></i> เพิ่มทีมงาน</a></p>
							</div>
							
							<div class="table-responsive-sm">
							<table class="table table-striped">
								<thead class="text-center">
									<tr>
										<th width="150"></th>
										<th width="150">ชื่อผู้ใช้</th>
										<th>ตำแหน่ง</th>
										<th>อีเมล์</th>
										<th width="150">ใช้งานล่าสุด</th>
										<th width="150">สถานะ</th>
										<th width="150"></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($rsList as $val){?>
									<tr>
										<td>
										   <img src="<?=base_url('img/avatar/'.$val->member_img)?>" alt="image"> <?=$val->member_name?>
										</td>
										<td><?=$val->member_username?></td>
										<td><?=$val->member_position?></td>
										<td><?=$val->member_email?></td>
										<td><?=$val->member_lastlogin?></td>
										<td class="text-center"><?=$val->member_status==1?'<i class="mdi mdi-check"></i>':''?></td>
										<td class="text-center">
											<a href="<?=base_url('dashboard/member/edit/'.$val->member_username.'/'.$val->member_password)?>" class="btn btn-sm btn-info"><i class="mdi mdi-settings"></i></a>
											
										
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