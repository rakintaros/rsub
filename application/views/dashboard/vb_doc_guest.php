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

				

					<div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr class="text-center">
                          
                          <th width="5%"> ลำดับ </th>
                          <th> หัวข้อ / ไฟล์แนบ</th>
						  			  
                        </tr>
                      </thead>
                      <tbody>
						<?php $i=0;foreach($rsList as $item){$i++;?>
						<tr>
							<td class="text-center"><strong><?=$i?></strong></td>
							<td class="text-left"><strong><?=$item['topic_name']?></strong></td>
						</tr>
						<?php if($item['subScope']){?>
						<?php foreach($item['subScope'] as $item2){?>
						<tr>
							<td class="text-center"></td>
							<td class="text-left"><i class="mdi mdi-file-tree"></i> <a target="_blank" href="<?=base_url('documents/'.$item2['doc_file'])?>"><?=$item2['doc_name']?></td>
							
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