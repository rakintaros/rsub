			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php $project_type = $this->session->userdata('project_type');?>
			<?php $project_year = $this->session->userdata('project_year');?>
			<style>
			a.p_link{color:#11b19b;text-decoration: none;}
			a.p_link:hover{color:#d084ff;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> บัญชีดำเนินโครงการ </h3>
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
							
                        </select>
						<input type="hidden" name="sel_uri" value="account">
                        <button type="submit" class="btn btn-gradient-primary mb-2"><i class="mdi mdi-refresh"></i></button>
						<a target="_blank" href="<?=base_url('dashboard/account/excel')?>" class="btn btn-gradient-success ml-2 mb-2"><i class="mdi mdi-file-excel"></i></a>
						
                    </form>
					</div>


					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr class="text-center">
                          <th width="5%"> ลำดับ </th>
                          <th width=""> ชื่อโครงการวิจัย </th>
                          <th width="10%"> สถานะ </th>                          
                        </tr>
                      </thead>
                      <tbody>
						<?php $i=0;foreach($rsList as $item){$i++;?>
						<tr>
							<td class="text-center"><?=$i?></td>
							<td><a href="<?=base_url('dashboard/account/check/'.$item->project_id)?>"><?=$item->project_name?></a></td>
							<td><?=getProjectStatus($item->project_status)?></td>
							<td></td>
						</tr>
						<?php }?>
                      </tbody>
                    </table>
					</div>
                  </div>
                </div>
              </div>
              </div>