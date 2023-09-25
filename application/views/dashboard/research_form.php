			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php 

				$research_id = null;
				$research_title = null;
				$research_journal = null;
				$research_year = null;
				$research_author = null;
				$research_status = null;
				$research_tags = null;
				$research_member_username = null;
				$createdate = date('Y-m-d H:i:s');
	

				if($rs!=null){
					$research_id = $rs[0]->research_id;		
					$research_title = $rs[0]->research_title;		
					$research_journal = $rs[0]->research_journal;		
					$research_year = $rs[0]->research_year;		
					$research_author = $rs[0]->research_author;			
					$research_status = $rs[0]->research_status;			
					$research_tags = $rs[0]->research_tags;			
					$research_member_username = $rs[0]->research_member_username;			
				}
				
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
              <h3 class="page-title"> การตีพิมพ์ผลงานวิจัย </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active" aria-current="page">การตีพิมพ์ผลงานวิจัย</li>
                </ol>
              </nav>
            </div>
			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">

							<form class="forms-sample" method="post" enctype="multipart/form-data">
								<div class="mb-5">

									<div class="form-group row">
										<label for="thesis_title" class="col-sm-2 col-form-label">ชื่อผลงาน</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="research_title" name="research_title" placeholder="ชื่อผลงาน" required value="<?=$research_title?>">
										</div>
									</div>	
									
									<div class="form-group row">
										<label for="research_journal" class="col-sm-2 col-form-label">ชื่อวารสาร</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="research_journal" name="research_journal" placeholder="ชื่อวารสาร" required value="<?=$research_journal?>">
										</div>
									</div>	
									
									<div class="form-group row">
										<label for="research_year" class="col-sm-2 col-form-label">ปี</label>
										<div class="col-sm-4">				
											<input type="text" class="form-control" id="research_year" name="research_year" placeholder="ปี" required value="<?=$research_year?>">
										</div>
										<label for="research_author" class="col-sm-2 col-form-label">ผู้เขียน</label>
										<div class="col-sm-4">				
											<input type="text" class="form-control" id="research_author" name="research_author" placeholder="ผู้เขียน" required value="<?=$research_author?>">
										</div>
									</div>
									
									<div class="form-group row">
										<label for="research_status" class="col-sm-2 col-form-label">สถานะการเคลมผลงาน</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="research_status" name="research_status" placeholder="สถานะการเคลมผลงาน" required value="<?=$research_status?>">
										</div>
									</div>	
									
									<div class="form-group row">
										<label for="research_tags" class="col-sm-2 col-form-label">คำค้น</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="research_tags" name="research_tags" placeholder="คำค้น" required value="<?=$research_tags?>" data-role="tagsinput">
											<small id="emailHelp" class="form-text text-muted">ใช้เครื่องหมาย , ขั้นระหว่างคำ ตัวอย่าง(ก๊าซเรื่อนกระจก, ท่องเที่ยวยืนยืน, การดูดกลับ)</small>
										</div>
									</div>
									
									<div class="form-group row">
										<label for="thesis_tags" class="col-sm-2 col-form-label">ไฟล์เอกสาร</label>
										<div class="col-sm-10">
											<input type="file" name="research_file"/><br/><br/>
											<?php if($research_tags!=null){?>
											<a target="_blank" class="btn btn-secondary btn-sm" href="<?=base_url('uplodas/research/'.$research_tags)?>"/><i class="mdi mdi-file-pdf-box"></i> <?=$research_tags?></a>
											<?php }else{?>
											<small id="emailHelp" class="form-text text-muted">ไฟล์ .pdf เท่านั้น</small>
											<?php }?>
										</div>
									</div>
									
									
									
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										<input type="hidden" name="research_id" value="<?=$research_id?>">
										<input type="hidden" name="research_member_username" value="<?=$member['m_user']?>">
										<input type="hidden" name="createdate" value="<?=$createdate?>">
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>