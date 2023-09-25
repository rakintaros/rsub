<div class="page-header">
              <h3 class="page-title"> ประวัติการใช้งาน </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">ประวัติการใช้งาน</li>
                </ol>
              </nav>
            </div>

			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<div id="div_log">
							<div class="table-responsive-sm">
							<table class="table table-striped">
								<thead>
									<tr>
										<th width="150">ชื่อผู้ใช้</th>
										<th>การดำเนินงาน</th>
										<th width="300">อุปกรณ์</th>
										<th width="150">เวลา</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($rsList as $val){?>
									<tr>
										<td>
										   <img src="<?=base_url('img/avatar/'.$val['member_img'])?>" alt="image"> <?=$val['member_name']?>
										</td>
										<td><?=$val['log_action']?></td>
										<td><?=$val['log_ua']?></td>
										<td><?=$val['log_datetime']?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>