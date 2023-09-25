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
			  <h3 class="page-title"> T-VER </h3>
			  <nav aria-label="breadcrumb">
			    <ol class="breadcrumb">
			      <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
			      <li class="breadcrumb-item active" aria-current="page">t-ver</li>
			    </ol>
			  </nav>
			</div>
			<div class="row">
			  <div class="col-lg-12 grid-margin stretch-card">
			    <div class="card">
			      <div class="card-body">
			        <div class="float-right">
			          <p class="float-right"> <a href="<?=base_url('dashboard/vb_tver/add')?>"
			              class="btn btn-gradient-info mb-2"><i class="mdi mdi-plus-circle-outline"></i> เพิ่มโครงการ</a></p>
			        </div>

			        <div class="table-responsive">
			          <table class="table table-striped">
			            <thead>
			              <tr class="text-center">
			                <th width="5%"> ลำดับ </th>
			                <th> โครงการที่ขอรับบริการ</th>

			                <th width="10%"> เดือน </th>
			                <th width="10%"> ปี </th>
			                <th width="5%"> อัพเดท </th>
			                <th width="5%"> ลบ </th>
			              </tr>
			            </thead>
			            <tbody>
			              <?php $i=0;foreach($rsList as $item){$i++;?>
                      <tr>
                        <td class="text-center"><?=$i?></td>
                        <td><?=$item->tver_project_name?></td>
                        <td class="text-center"><?=getMonth($item->tver_month)?></td>
                        <td class="text-center"><?=$item->tver_year?></td>
                        <td class="text-center"><a title="แก้ไขข้อมูล" href="<?=base_url('dashboard/vb_tver/edit/'.$item->tver_id)?>"><label class="badge badge-secondary mr-sm-2" style="cursor:pointer"><i class="mdi mdi-information-outline "></i> </label></a></td>
                        <td class="text-center"><a title="ลบ" href="<?=base_url('dashboard/vb_tver/del/'.$item->tver_id)?>" onclick="return confirm('คุณต้องการลบใช่หรือไม่');"><label class="badge badge-danger mr-sm-2" style="cursor:pointer"><i class="mdi mdi-delete "></i> </label></a></td>
                      </tr>
			              <?php }?>
			            </tbody>
			          </table>
			        </div>
			      </div>
			    </div>
			  </div>