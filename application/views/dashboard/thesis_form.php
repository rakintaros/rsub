			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 

				$thesis_id = null;
				$thesis_title = null;
				$thesis_year = null;
				$thesis_owner = null;
				$thesis_tags = null;
				$thesis_member_username = null;
				$createdate = date('Y-m-d H:i:s');
	

				if($rs!=null){
					$thesis_id = $rs[0]->thesis_id;		
					$thesis_title = $rs[0]->thesis_title;		
					$thesis_year = $rs[0]->thesis_year;		
					$thesis_owner = $rs[0]->thesis_owner;		
					$thesis_tags = $rs[0]->thesis_tags;		
					$thesis_member_username = $rs[0]->thesis_member_username;			
				}
				
				$ar_name = array(
					'thesis_bcl'	=> 'วิทยานิพนธ์(ปริญญาตรี)',
					'thesis_mas'	=> 'วิทยานิพนธ์(ปริญญาโท)',
					'thesis_phd'	=> 'วิทยานิพนธ์(ปริญญาเอก)',
				);
			?>

			<style>
			.label-info, .badge-info {
		background-color: #57b5e3;
		background-image: none !important;
	}
	.bootstrap-tagsinput .tag {padding:2px;}
	.bootstrap-tagsinput {
		display: block;
		width: 100%;
		height: 2.875rem;
		padding: 0.94rem 1.375rem;
		font-size: 0.8125rem;
		font-weight: 400;
		line-height: 1;
		color: #495057;
		background-color: #ffffff;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: 2px;
		-webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
		transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
		transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
		transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
	}
			</style>
			<div class="page-header">
              <h3 class="page-title"> <?=$ar_name[$menu_sub]?> </h3>
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

							<form class="forms-sample" method="post">
								<div class="mb-5">

									<div class="form-group row">
										<label for="thesis_title" class="col-sm-2 col-form-label">ชื่อเรื่อง</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="thesis_title" name="thesis_title" placeholder="ชื่อเรื่อง" required value="<?=$thesis_title?>">
										</div>
									</div>	
									
									<div class="form-group row">
										<label for="thesis_year" class="col-sm-2 col-form-label">ปี</label>
										<div class="col-sm-4">				
											<input type="text" class="form-control" id="thesis_year" name="thesis_year" placeholder="ปี" required value="<?=$thesis_year?>">
										</div>
										<label for="thesis_owner" class="col-sm-2 col-form-label">เจ้าของผลงาน</label>
										<div class="col-sm-4">				
											<input type="text" class="form-control" id="thesis_owner" name="thesis_owner" placeholder="เจ้าของผลงาน" required value="<?=$thesis_owner?>">
										</div>
									</div>
									
									<div class="form-group row">
										<label for="thesis_tags" class="col-sm-2 col-form-label">คำค้น</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="thesis_tags" name="thesis_tags" placeholder="คำค้น" required value="<?=$thesis_tags?>" data-role="tagsinput">
											<small id="emailHelp" class="form-text text-muted">ใช้เครื่องหมาย , ขั้นระหว่างคำ ตัวอย่าง(ก๊าซเรื่อนกระจก, ท่องเที่ยวยืนยืน, การดูดกลับ)</small>
										</div>
									</div>
									
									<div class="form-group row">
										<label for="thesis_tags" class="col-sm-2 col-form-label">ไฟล์เอกสาร</label>
										<div class="col-sm-10">
											<?php if($thesis_id!=null){?>
											<button type="button" class="btn btn-info btn-sm btn_addfile_thesis" thesis-id="<?=$thesis_id?>"><i class="mdi mdi-upload"></i> แนบไฟล์ </button>
											<?php }else{?>
												<div class="alert alert-info">หลังจากกดบันทึกจะแสดงปุ่มอัพไฟล์เอกสาร</div>
											<?php }?>
										</div>
									</div>
									
									
									
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="thesis_class" value="<?=$thesis_class?>">
										<input type="hidden" name="thesis_id" value="<?=$thesis_id?>">
										<input type="hidden" name="thesis_member_username" value="<?=$member['m_user']?>">
										<input type="hidden" name="createdate" value="<?=$createdate?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>