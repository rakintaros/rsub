			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php $project_type = $this->session->userdata('project_type');?>
			<?php $project_year = $this->session->userdata('project_year');?>
			<style>
			a.p_link{color:#11b19b;text-decoration: none;}
			a.p_link:hover{color:#d084ff;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> หน่วยบริหารและจัดการทุนด้านการพัฒนากำลังคน และทุนด้านการพัฒนาสถาบันอุดมศึกษา การวิจัยและการสร้างนวัตกรรม (บพค.)  </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">สรุปโครงการ</li>
                </ol>
              </nav>
            </div>
			<div class="row">
			<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

					<div class="float-left">
					
					<form class="form-inline" method="post" action="<?=base_url('dashboard/post_project')?>">
						<select class="form-control mb-2 mr-sm-2" id="sel_year" name="sel_year">
							<?php for($y=(date('Y')-10);$y<=(date('Y')+1);$y++){?>
								<option value="<?=$y?>" <?=$project_year==$y?'selected':''?>><?=($y+543)?></option>
							<?php }?>
                        </select>
						<select class="form-control mb-2 mr-sm-2" id="sel_type" name="sel_type">
							
							<option value="all" <?=$project_type=="all"?'selected':''?>>โครงการทั้งหมด</option>
							<option value="pre" <?=$project_type=="pre"?'selected':''?>>โครงการที่อยู่ระหว่างการยื่นข้อเสนอโครงการหรือรออนุมัติ</option>
							<option value="doing" <?=$project_type=="doing"?'selected':''?>>โครงการที่กำลังดำเนินการ</option>
							<option value="done" <?=$project_type=="done"?'selected':''?>>โครงการที่ดำเนินการเสร็จแล้ว</option>
							<option value="research" <?=$project_type=="research"?'selected':''?>>งานบริการวิชาการ และอื่น ๆ</option>
							<option value="notbudget" <?=$project_type=="notbudget"?'selected':''?>>ไม่ได้รับงบประมาณ</option>
							
                        </select>
						<input type="hidden" name="sel_uri" value="project">
                        <button type="submit" class="btn btn-gradient-primary mb-2"><i class="mdi mdi-refresh"></i></button>
						<a target="_blank" href="<?=base_url('dashboard/project/print')?>" class="btn btn-gradient-success ml-2 mb-2"><i class="mdi mdi-printer"></i></a>
						<a target="_blank" href="<?=base_url('dashboard/project/excel')?>" class="btn btn-gradient-success ml-2 mb-2"><i class="mdi mdi-file-excel"></i></a>
                    </form>
					
					</div>
					<div class="float-right">
						<p class="float-right"> <a href="<?=base_url('dashboard/project/add')?>" class="btn btn-gradient-info mb-2"><i class="mdi mdi-plus-circle-outline"></i> เพิ่มโครงการ</a></p>
					</div>

					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr class="text-center">
                          
                          <th width="5%"> ลำดับ </th>
                          <th width="5%"> รหัสโครงการ </th>
                          <th width="20%"> ชื่อโครงการวิจัย </th>
                          <th width="10%"> ผู้รับผิดชอบ </th>
                          <th width="10%"> ปีงบประมาณ </th>
                          <th width="10%"> แหล่งทุน </th>
                          <th width="10%"> งบประมาณ </th>
                          <th width="10%"> ผ่านหน่วยงาน </th>
                          <th width="10%"> สถานะในระบบ </th>
                          <th width="10%"> สถานะการดำเนินงาน </th>       
						  <th width="5%"> ลบ </th>						  
                        </tr>
                      </thead>
                      <tbody>
						<?php $i=0;foreach($rsList as $item){$i++;?>
						<tr>
							<td class="text-center"><?=$i?></td>
							<td class="text-center"><?=$item->project_code?></td>
							<td><a class="p_link" href="<?=base_url('dashboard/project/edit/'.$item->project_id)?>"><?=$item->project_name?></a></td>
							<td><?=$item->project_responsible?></td>
							<td class="text-center"><?=($item->project_year+543)?></td>
							<td><?=$item->project_funds?></td>
							<td><?=number_format($item->project_budget)?></td>
							<td><?=$item->project_org?></td>
							<td class="text-center"><?=$item->project_status_ic?></td>
							<td><?=getProjectStatus($item->project_status)?></td>
							<td class="text-center"><a href="<?=base_url('dashboard/project/del/'.$item->project_id)?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่');"><label class="badge badge-danger mr-sm-2" style="cursor:pointer"><i class="mdi mdi-delete "></i> </label></a>	</td>
							
						</tr>
						<?php }?>
                      </tbody>
                    </table>
					</div>
                  </div>
                </div>
              </div>
              </div>