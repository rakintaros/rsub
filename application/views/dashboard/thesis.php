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
			<?php 
			$ar_name = array(
				'thesis_bcl'	=> 'วิทยานิพนธ์(ปริญญาตรี)',
				'thesis_mas'	=> 'วิทยานิพนธ์(ปริญญาโท)',
				'thesis_phd'	=> 'วิทยานิพนธ์(ปริญญาเอก)',
			);
			?>
			<div class="page-header">
			  <h3 class="page-title"> <?=$ar_name[$menu_sub]?></h3>
			  <nav aria-label="breadcrumb">
			    <ol class="breadcrumb">
			      <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
			      <li class="breadcrumb-item active" aria-current="page">วิทยานิพนธ์</li>
			    </ol>
			  </nav>
			</div>
			<div class="row">
			  <div class="col-lg-12 grid-margin stretch-card">
			    <div class="card">
			      <div class="card-body">
					
					
						<form class="form-inline" method="get">
							
							<select class="form-control form-control mb-2 mr-sm-2" name="search_type">
								<option value="thesis_title" <?=$this->input->get('search_type')=='thesis_title'? 'selected':''?>>Title</option>
								<option value="thesis_owner" <?=$this->input->get('search_type')=='thesis_owner'? 'selected':''?>>Author</option>
								<option value="thesis_tags" <?=$this->input->get('search_type')=='thesis_tags'? 'selected':''?>>Keywords</option>
							</select>
							
							<input type="text" class="form-control mb-2 mr-sm-2" name="search_txt" value="<?=$this->input->get('search_txt')?>" placeholder="ระบคำที่ต้องการค้นหา..">
						 
							<button type="submit" class="btn btn-gradient-primary mb-2 mr-sm-2"><i class="mdi mdi-filter-outline"></i> Filter</button>
							<?php if($member['m_user']=="RK" || $member['m_user']=="test" || $member['m_user']=="kittiya"){?>
							<a href="<?=base_url('dashboard/thesis_bcl/add')?>" class="btn btn-gradient-light btn-fw mb-2 mr-sm-2"><i class="mdi mdi-plus-circle-outline"></i> เพิ่ม</a>
							<?php }?>
						</form>
					
			      </div>
			    </div>
			  </div>
			</div>
			
			<?php if($rsList!=null){?>
			<?php foreach($rsList as $item){?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
					  <div class="card-body">
						<div class="row">
							<div class="col-md-3">
								<img src="https://via.placeholder.com/250x300.png?text=<?=$item->thesis_id?>">
							</div>
							<div class="col-md-9">
								<h3 class="mb-5"><?=str_replace($this->input->get('search_txt'),'<mark class="bg-warning text-white">'.$this->input->get('search_txt').'</mark>',$item->thesis_title)?></h3>
								<div class="row">
									<div class="col-md-2"><p class="card-description"> ปี</p></div>
									<div class="col-md-10"><?=$item->thesis_year?></div>
								</div>
								<div class="row">
									<div class="col-md-2"><p class="card-description">เจ้าของผลงาน</p></div>
									<div class="col-md-10"><?=str_replace($this->input->get('search_txt'),'<mark class="bg-warning text-white">'.$this->input->get('search_txt').'</mark>',$item->thesis_owner)?></div>
								</div>
								<div class="row">
									<div class="col-md-2"><p class="card-description">คำค้นหา</p></div>
									<div class="col-md-10"><?=str_replace($this->input->get('search_txt'),'<mark class="bg-warning text-white">'.$this->input->get('search_txt').'</mark>',$item->thesis_tags)?></div>
								</div>
								<div class="row">
									<div class="col-md-12">
						
										<a target="_blank" class="btn btn-inverse-primary btn-fw" href="<?=base_url('dashboard/download_thesis/'.$item->thesis_id)?>"><i class="mdi mdi-briefcase-download"></i> ดาวน์โหลดเอกสาร</a>
										<?php if($member['m_user']=="RK" || $member['m_user']=="test" || $member['m_user']=="kittiya"){?>
										<a href="<?=base_url('dashboard/thesis_bcl/edit/'.$item->thesis_id)?>" class="btn btn-inverse-info btn-fw"><i class="mdi mdi-tooltip-edit"></i> แก้ไข</a>
										<a href="<?=base_url('dashboard/thesis_bcl/del/'.$item->thesis_id)?>" class="btn btn-inverse-danger btn-fw" onclick="return confirm('คุณต้องการลบใช่หรือไม่');" ><i class="mdi mdi-delete "></i> ลบ</a>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
						
						
						<!--<p> It is a long <mark class="bg-warning text-white">established</mark> fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution </p>-->
					  </div>
					</div>
				</div>
			</div>
			<?php }?>
			<?php }else{?>
			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
					<div class="card">
					  <div class="card-body">
						<p class="text-center">ยังไม่มีข้อมูล</p>
					  </div>
					</div>
				</div>
			</div>
					
			<?php }?>
			
			