			<?php $member = $this->session->userdata('member_logged_in');?>
			<style>
			  a.p_link {
			    color: #11b19b;
			    text-decoration: none;
			  }

			  a.p_link:hover {
			    color: #d084ff;
			  }
			</style>
			<div class="page-header">
			  <h3 class="page-title"> CFO </h3>
			  <nav aria-label="breadcrumb">
			    <ol class="breadcrumb">
			      <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
			      <li class="breadcrumb-item active" aria-current="page">CFO</li>
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
			                <th> โครงการที่ขอรับบริการ</th>

			                <th width="10%"> เดือน </th>
			                <th width="10%"> ปี </th>
			                <th width="5%">  </th>
			
			              </tr>
			            </thead>
			            <tbody>
			              <?php $i=0;foreach($rsList as $item){$i++;?>
                      <tr>
                        <td class="text-center"><?=$i?></td>
                        <td><?=$item->cfo_project_name?></td>
                        <td class="text-center"><?=getMonth($item->cfo_month)?></td>
                        <td class="text-center"><?=$item->cfo_year?></td>
                        <td class="text-center"><a title="แก้ไขข้อมูล" href="<?=base_url('dashboard/vb_cfo/edit/'.$item->cfo_id)?>"><label class="badge badge-secondary mr-sm-2" style="cursor:pointer"><i class="mdi mdi-information-outline "></i> </label></a></td>
                      </tr>
			              <?php }?>
			            </tbody>
			          </table>
			        </div>
			      </div>
			    </div>
			  </div>