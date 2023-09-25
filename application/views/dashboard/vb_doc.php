			<?php $member = $this->session->userdata('member_logged_in');?>
			<style>
			a.p_link{color:#11b19b;text-decoration: none;}
			a.p_link:hover{color:#d084ff;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> แบบฟอร์มที่เกี่ยวข้อง </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">แบบฟอร์มที่เกี่ยวข้อง</li>
                </ol>
              </nav>
            </div>
			<div class="row">
			<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

					<div class="float-right">
						<p class="float-right"> <a href="<?=base_url('dashboard/vb_doc/add')?>" class="btn btn-gradient-info mb-2"><i class="mdi mdi-plus-circle-outline"></i> เพิ่มแบบฟอร์ม</a></p>
					</div>

					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr class="text-center">
                          
                          <th width="5%"> ลำดับ </th>
                          <th> หัวข้อ / ไฟล์แนบ</th>
						  <th width="15%"> สิทธิ์การเข้าถึง </th>						  
						  <th width="15%"> เพิ่มเอกสาร </th>						  
						  <th width="5%"> แก้ไข </th>						  
						  <th width="5%"> ลบ </th>						  
                        </tr>
                      </thead>
                      <tbody>
						<?php $i=0;foreach($rsList as $item){$i++;?>
						<tr>
							<td class="text-center"><strong><?=$i?></strong></td>
							<td class="text-left"><strong><?=$item['topic_name']?></strong></td>
							<td class="text-center"><i class="mdi mdi-lock-open-outline"></i> <?=count(json_decode($item['topic_permission']))?></td>
							<td class="text-center"><label class="badge badge-info mr-sm-2 btn_vb_addfile_d" t-id="<?=$item['topic_id']?>" d-id="" style="cursor:pointer"><i class="mdi mdi-plus-circle-outline"></i> เพิ่มแบบฟอร์ม [<?php echo count($item['subScope']);?>]</label>	</td>
							<td class="text-center"><a href="<?=base_url('dashboard/vb_doc/edit/'.$item['topic_id'])?>"><label class="badge badge-secondary mr-sm-2" style="cursor:pointer"><i class="mdi mdi-information-outline"></i> แก้ไข</label></a>	</td>
							<td class="text-center"><a href="<?=base_url('dashboard/vb_doc/del/'.$item['topic_id'])?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่');"><label class="badge badge-danger mr-sm-2" style="cursor:pointer"><i class="mdi mdi-delete "></i> </label></a>	</td>
						</tr>
						<?php if($item['subScope']){?>
						<?php foreach($item['subScope'] as $item2){?>
						<tr>
							<td class="text-center"></td>
							<td class="text-left"><i class="mdi mdi-file-tree"></i> <a target="_blank" href="<?=base_url('documents/'.$item2['doc_file'])?>"><?=$item2['doc_name']?></td>
							<td class="text-center"></td>
							<td class="text-center"></td>
							<td class="text-center"><label class="badge badge-secondary mr-sm-2 btn_vb_addfile_d" t-id="<?=$item['topic_id']?>" d-id="<?=$item2['doc_id']?>" style="cursor:pointer"><i class="mdi mdi-information-outline"></i> แก้ไข</label></td>
							<td class="text-center"><a href="<?=base_url('dashboard/vb_doc/deldoc/'.$item2['doc_id'])?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่');"><label class="badge badge-danger mr-sm-2" style="cursor:pointer"><i class="mdi mdi-delete "></i> </label></a>	</td>
						</tr>
						<?php }?>
						<?php }?>
						<?php }?>
                      </tbody>
                    </table>
					</div>
                  </div>
                </div>
              </div>
              </div>