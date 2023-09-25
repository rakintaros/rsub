			<?php $member = $this->session->userdata('member_logged_in');?>
			<?php $s_tab = $this->session->userdata('sel_type')!=null ? $this->session->userdata('sel_type') : 'tab1';?>
			<?php 

				$account_id = null;
				$account_project_name = null;
				$account_bank = null;
				$account_bank_name = null;
				$account_bank_code = null;
				$tab1_obj = null;
				$tab2_obj = null;
				$tab3_obj = null;
				$tab4_obj = null;
				$tab5_obj = null;
				$account_status_complate_is = null;
				$account_status_complate_date = null;

				
				$account_member_permission = null;
				if($rs!=null){
					$account_id = $rs[0]->account_id;
					$account_project_name = $rs[0]->account_project_name;
					$account_bank = $rs[0]->account_bank;
					$account_bank_name = $rs[0]->account_bank_name;
					$account_bank_code = $rs[0]->account_bank_code;
					$account_status_complate_is = $rs[0]->account_status_complate_is;
					$account_status_complate_date = $rs[0]->account_status_complate_date;
					
					$tab1_data = json_decode(@$rs[0]->tab1_obj);
					$tab2_data = json_decode(@$rs[0]->tab2_obj);
					$tab3_data = json_decode(@$rs[0]->tab3_obj);
					$tab4_data = json_decode(@$rs[0]->tab4_obj);
					$tab5_data = json_decode(@$rs[0]->tab5_obj);

					
					$tab1_obj = (array) @$tab1_data;
					$tab2_obj = (array) @$tab2_data;
					$tab3_obj = (array) @$tab3_data;
					$tab4_obj = (array) @$tab4_data;
					$tab5_obj = (array) @$tab5_data;
					
					$data4 = json_decode(@$rs[0]->account_member_permission);
					$account_member_permission = (array) @$data4;
				}
				
				function chFileStatus($rsFile, $filename){
					$count = 0;
					foreach($rsFile as $item){
						if (array_search($filename, $item)){
							$count++;
						}
					}
					return $count;
				}
			?>
			
			<style>
				.nav-tabs a.nav-link{background-color: #16b39d;color:#fff;border-top-left-radius:0; border-top-right-radius: 0;}
				.nav-tabs .nav-link.active{background-color: #fff;color:#11b19b !important;}
				.tab-content{border-left: 1px solid #ebedf2;border-right: 1px solid #ebedf2;border-bottom: 1px solid #ebedf2;}
				select.form-control{color:#333;}
				.form-control{padding:2px;}
				.form-control-title{padding: 2px;
					height: 30px;
					background: transparent;
					border: 0;
					font-size: 16px;}
				.my-input{text-align:right;}
			</style>
			<div class="page-header">
              <h3 class="page-title"> บัญชีดำเนินโครงการ </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">หน้าแรก</a></li>
                  <li class="breadcrumb-item active"><a href="<?=base_url('dashboard/account')?>">บัญชีดำเนินโครงการ</a></li>
                </ol>
              </nav>
            </div>
			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<form class="forms-sample" method="post">
								<input type="hidden" name="sel_type" id="sel_type" value="<?=$s_tab?>">
								<input type="hidden" name="account_id" value="<?=$account_id?>">
								<div class="mb-3">

									<div class="form-group row">
										<label for="project_name" class="col-sm-2 col-form-label">ชื่อโครงการ</label>
										<div class="col-sm-10">				
											<input type="text" class="form-control" id="advance_project_name" name="account_project_name" placeholder="ภาษาไทย" required value="<?=$account_project_name?>">
										</div>
									</div>	
									
									<div class="form-group row">
										<label for="project_name" class="col-sm-2 col-form-label">ธนาคาร</label>
										<div class="col-sm-4">				
											<select class="form-control" name="account_bank" required>
												<option value=""> เลือกธนาคาร </option>
												<?php $arBank = getBankList();?>
												<?php foreach($arBank as $k=>$v){?>
												<option value="<?=$k?>" <?=$account_bank==$k?'selected':''?>> <?=$v?> </option>
												<?php }?>
											</select>
										</div>
										<div class="col-sm-3">				
											<input type="text" class="form-control" name="account_bank_name" placeholder="ชื่อบัญชี" required value="<?=$account_bank_name?>">
										</div>
										<div class="col-sm-3">				
											<input type="text" class="form-control" name="account_bank_code" placeholder="เลขที่บัญชี" required value="<?=$account_bank_code?>">
										</div>
									</div>
									
									<div class="form-group row">
										<label for="project_name" class="col-sm-2 col-form-label">สถานะโครงการ</label>
										<div class="col-sm-4">				
											<select class="form-control" name="account_status_complate_is" required>
												<option value=""> เลือกสถานะ </option>
												<?php $arStatus = getProjectStatusL();?>
												<?php foreach($arStatus as $k=>$v){?>
												<option value="<?=$k?>" <?=$account_status_complate_is==$k?'selected':''?>> <?=$v?> </option>
												<?php }?>
											</select>
										</div>
									</div>	
									
									<?php if($member['m_level']==3){?>
									<?php $c = count($memberList);?>
									<div class="form-group row">
										<label for="project_status" class="col-sm-2 col-form-label">พนักงานที่สามารถแก้ไข</label>
										<div class="col-sm-4">				
											<div class="form-group">
												<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i<=($c/2)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="account_member_permission[]" value="<?=$mem->member_username?>" <?=$mem->member_username==$member['m_user']?'checked onclick="return false;"':''?> <?=$mem->member_level==3?'checked onclick="return false;"':''?> <?=@in_array($mem->member_username,$account_member_permission) ? 'checked':''?>> <?=$mem->member_name?></label>
												</div>
												<?php }?>
												<?php }?>
											</div>
										</div>
										<label for="project_status" class="col-sm-2 col-form-label"></label>
										<div class="col-sm-4">	
											<div class="form-group">
											<?php $i=0;foreach($memberList as $mem){$i++;?>
												<?php if($i>($c/2)){?>
												<div class="form-check">
													<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="account_member_permission[]" value="<?=$mem->member_username?>" <?=$mem->member_username==$member['m_user']?'checked onclick="return false;"':''?> <?=$mem->member_level==3?'checked onclick="return false;"':''?> <?=@in_array($mem->member_username,$account_member_permission) ? 'checked':''?>> <?=$mem->member_name?> </label>
												</div>
												<?php }?>
											<?php }?>
											</div>
										</div>
									</div>	
									<?php }?>									
								
								</div>

								<div class="mb-5">
									<ul class="nav nav-tabs 3e_tabs" role="tablist">
										<li class="nav-item">
											<a class="nav-link <?=$s_tab=="tab1"?'active':''?> <?=$s_tab==null?'active':''?>" href="#tab1" role="tab" data-toggle="tab" aria-selected="true">งบประมาณตามข้อเสนอโครงการ</a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?=$s_tab=="tab5"?'active':''?>" href="#tab5" role="tab" data-toggle="tab">เงินงวดตามงบประมาณ</a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?=$s_tab=="tab2"?'active':''?>" href="#tab2" role="tab" data-toggle="tab">งบประมาณที่ได้รับ</a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?=$s_tab=="tab3"?'active':''?>" href="#tab3" role="tab" data-toggle="tab">รายจ่ายในการดำเนินโครงการ</a>
										</li>
										<li class="nav-item">
											<a class="nav-link <?=$s_tab=="tab4"?'active':''?>" href="#tab4" role="tab" data-toggle="tab">สรุปรายรับ-รายจ่าย</a>
										</li>
									</ul>
									
									<style>
									.td_sub{display:none;}
									a.btnExplain{text-decoration: none;font-weight: 600;color: #333}
									a.btnExplain2{text-decoration: none;font-weight: 600;color: #333}
    
									</style>
									<div class="tab-content">
										<div role="tabpanel" class="p-3 tab-pane <?=$s_tab=="tab1"?'active':$s_tab==null?'active':'fade'?> " id="tab1">
	
											<table class="table" id="tbl1account">
												<thead>
													<tr class="text-center">
														<th width="10"></th>
														<th colspan="2">รายละเอียด</th>
														<th width="200">จำนวนเงิน</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sum_tab1 = 0;
														if(@$tab1_obj['topic1']!=null){
															foreach($tab1_obj['topic1']->t_text as $k=>$v){
																$sum_tab1 +=rmComma($tab1_obj['topic1']->t_price[$k]);
															}
														}
													?>
													<tr class="topic1">
														<td><a href="javascript:void(0)" id="topic1" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic1" class="btnExplain" aria-expanded="false">1. หมวดค่าตอบแทน</a></td>
														<td class="text-right"><?=number_format($sum_tab1,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic1']!=null){?>
														<?php foreach($tab1_obj['topic1']->t_text as $k=>$v){?>
														<tr class="sub_topic1 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic1][t_text][]" value="<?=$tab1_obj['topic1']->t_text[$k]?>">
															</td>
															<td >
																<input type="text" class="form-control my-input" name="tab1[topic1][t_price][]" value="<?=$tab1_obj['topic1']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<?php
														$sum_tab2 = 0;
														if(@$tab1_obj['topic2']!=null){
															foreach($tab1_obj['topic2']->t_text as $k=>$v){
																$sum_tab2 +=rmComma(@$tab1_obj['topic2']->t_price[$k]);
															}
														}
													?>
													<tr class="topic2">
														<td><a href="javascript:void(0)" id="topic2" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic2" class="btnExplain" aria-expanded="false">2. หมวดค่าจ้าง</a></td>
														<td class="text-right"><?=number_format($sum_tab2,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic2']!=null){?>
														<?php foreach($tab1_obj['topic2']->t_text as $k=>$v){?>
														<tr class="sub_topic2 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic2][t_text][]" value="<?=$tab1_obj['topic2']->t_text[$k]?>">
															</td>
															<td>
																<input type="text" class="form-control my-input" name="tab1[topic2][t_price][]" value="<?=$tab1_obj['topic2']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<?php
														$sum_tab3 = 0;
														if(@$tab1_obj['topic3']!=null){
															foreach($tab1_obj['topic3']->t_text as $k=>$v){
																$sum_tab3 +=rmComma($tab1_obj['topic3']->t_price[$k]);
															}
														}
													?>
													<tr class="topic3">
														<td><a href="javascript:void(0)" id="topic3" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic3" class="btnExplain" aria-expanded="false">3. หมวดค่าวัสดุ</a></td>
														<td class="text-right"><?=number_format($sum_tab3,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic3']!=null){?>
														<?php foreach($tab1_obj['topic3']->t_text as $k=>$v){?>
														<tr class="sub_topic3 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic3][t_text][]" value="<?=$tab1_obj['topic3']->t_text[$k]?>">
															</td>
															<td>
																<input type="text" class="form-control my-input" name="tab1[topic3][t_price][]" value="<?=$tab1_obj['topic3']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<?php
														$sum_tab4 = 0;
														if(@$tab1_obj['topic4']!=null){
															foreach($tab1_obj['topic4']->t_text as $k=>$v){
																if($tab1_obj['topic4']->t_price[$k]!=null){
																$sum_tab4 +=@rmComma($tab1_obj['topic4']->t_price[$k]);
																}
															}
														}
													?>
													<tr class="topic4">
														<td><a href="javascript:void(0)" id="topic4" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic4" class="btnExplain" aria-expanded="false">4. หมวดค่าใช้สอย</a></td>
														<td class="text-right"><?=number_format($sum_tab4,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic4']!=null){?>
														<?php foreach($tab1_obj['topic4']->t_text as $k=>$v){?>
														<tr class="sub_topic4 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic4][t_text][]" value="<?=$tab1_obj['topic4']->t_text[$k]?>">
															</td>
															<td>
																<input type="text" class="form-control my-input" name="tab1[topic4][t_price][]" value="<?=$tab1_obj['topic4']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<?php
														$sum_tab5 = 0;
														if(@$tab1_obj['topic5']!=null){
															foreach($tab1_obj['topic5']->t_text as $k=>$v){
																$sum_tab5+=rmComma($tab1_obj['topic5']->t_price[$k]);
															}
														}
													?>
													<tr class="topic5">
														<td><a href="javascript:void(0)" id="topic5" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic5" class="btnExplain" aria-expanded="false">5. หมวดครุภัณฑ์</a></td>
														<td class="text-right"><?=number_format($sum_tab5,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic5']!=null){?>
														<?php foreach($tab1_obj['topic5']->t_text as $k=>$v){?>
														<tr class="sub_topic5 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic5][t_text][]" value="<?=$tab1_obj['topic5']->t_text[$k]?>">
															</td>
															<td>
																<input type="text" class="form-control my-input" name="tab1[topic5][t_price][]" value="<?=$tab1_obj['topic5']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<?php
														$sum_tab6 = 0;
														if(@$tab1_obj['topic6']!=null){
															foreach($tab1_obj['topic6']->t_text as $k=>$v){
																$sum_tab6+=rmComma($tab1_obj['topic6']->t_price[$k]);
															}
														}
													?>
													<tr class="topic6">
														<td><a href="javascript:void(0)" id="topic6" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic6" class="btnExplain" aria-expanded="false">6. หมวดค่าบำรุงสถาบัน</a></td>
														<td class="text-right"><?=number_format($sum_tab6,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic6']!=null){?>
														<?php foreach($tab1_obj['topic6']->t_text as $k=>$v){?>
														<tr class="sub_topic6 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic6][t_text][]" value="<?=$tab1_obj['topic6']->t_text[$k]?>">
															</td>
															<td>
																<input type="text" class="form-control my-input" name="tab1[topic6][t_price][]" value="<?=$tab1_obj['topic6']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<?php
														$sum_tab7 = 0;
														if(@$tab1_obj['topic7']!=null){
															foreach($tab1_obj['topic7']->t_text as $k=>$v){
																$sum_tab7+=rmComma($tab1_obj['topic7']->t_price[$k]);
															}
														}
													?>
													<tr class="topic7">
														<td><a href="javascript:void(0)" id="topic7" class="btnAddAssetsList btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></td>
														<td colspan="2"><a href="javascript:void(0)" id="topic7" class="btnExplain" aria-expanded="false">7. อื่นๆ</a></td>
														<td class="text-right"><?=number_format($sum_tab7,2)?></td>
													</tr>
													<?php if(@$tab1_obj['topic7']!=null){?>
														<?php foreach($tab1_obj['topic7']->t_text as $k=>$v){?>
														<tr class="sub_topic7 td_sub">
															<td></td>
															<td width="10"><a href="javascript:void(0)" class="btn_delAssets btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td>
																<input type="text" class="form-control" name="tab1[topic7][t_text][]" value="<?=$tab1_obj['topic7']->t_text[$k]?>">
															</td>
															<td>
																<input type="text" class="form-control my-input" name="tab1[topic7][t_price][]" value="<?=$tab1_obj['topic7']->t_price[$k]?>">
															</td>
														</tr>
														<?php }?>
													<?php }?>
													
													<tr class="summary">
														<td></td>
														<td colspan="2"><strong>รวมทั้งหมด</strong></td>
														<td class="text-right"><strong><?=number_format($sum_tab1+$sum_tab2+$sum_tab3+$sum_tab4+$sum_tab5+$sum_tab6+$sum_tab7,2)?></strong></td>
													</tr>
													<tr class="summary">
														<td></td>
														<td colspan="3">
														<?php $fcount = chFileStatus($rsFile, 'budgetFile')!=0? '('.chFileStatus($rsFile, 'budgetFile').')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile_account" a-id="<?=$account_id?>" a-point="budgetFile"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div role="tabpanel" class="p-3 tab-pane <?=$s_tab=="tab2"?'active':'fade'?>" id="tab2">
											<div class="table-responsive mt-2">
											<table class="table table-bordered" id="tbl2account">
												<thead class="text-center">
													<tr class="text-center">
														<th class="align-middle" rowspan="3" width="10"><a href="javascript:void(0)" id="topic1" class="btnAddBudget btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></th>
														<th class="align-middle" rowspan="3" width="100">งวดที่</th>
														<th class="align-middle" rowspan="3" width="150">ร้อยละ</th>
														<th class="align-middle" rowspan="3" >จำนวนเงิน (บาท)</th>
														<th class="align-middle" rowspan="3" >ค่าธรรมเนียม</th>
														<th class="align-middle" rowspan="3" >คงเหลือ</th>
														<th class="align-middle" rowspan="3" >หักเข้าต้นสังกัด</th>
														<th colspan="4">รายละเอียดเข้าต้นสังกัด</th>
														<th class="align-middle" rowspan="3">คงเหลือ</th>
														<th class="align-middle" rowspan="3" width="150">วันที่ได้รับ</th>
														<th class="align-middle" rowspan="3">เอกสาร</th>
													</tr>
													<tr>
														<th rowspan="2">มช (30%)</th>
														<th colspan="3">หน่วยงานต่าง ๆ (70%)</th>
													</tr>
													<tr>
														<th>สถาบัน (50%)</th>
														<th>วิศวะ (20%)</th>
														<th>3E (30%)</th>
													</tr>
												</thead>
												<tbody>
													<?php $s_percent=0; $s_fbudget=0; $s_affiliation=0;$s_balance=0;$s_fullmoney=0;$s_fee=0; $s_30=0; $s2_50=0; $s2_20=0;$s2_30=0;?>
													<?php if($tab2_obj!=null){?>
														<?php foreach($tab2_obj['time'] as $k=>$v){?>
														<?php 
															$affiliation_full = rmComma(@$tab2_obj['affiliation']->$k);
															
															$f_30 = ($affiliation_full*30)/100;
															$f2_50 = ($affiliation_full*0.7*0.5);
															$f2_30 = ($affiliation_full*0.7*0.3);
															$f2_20 = ($affiliation_full*0.7*0.2);
															
															
															$a=0;
															if($tab2_obj['full_money']->$k!=""){
																$a=rmComma($tab2_obj['full_money']->$k);
															}
															$b=0;
															if($tab2_obj['full_fee']->$k!=""){
																$b=rmComma($tab2_obj['full_fee']->$k);
															}
															
															$f_budget = $a - $b;
															
															//$f_budget = rmComma($tab2_obj['full_money']->$k) - rmComma($tab2_obj['full_fee']->$k);
														?>
														<tr>
															<td><a href="javascript:void(0)" class="btn_delBudget btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td><input type="text" name="tab2[time][<?=$k?>]" class="form-control" value="<?=@$tab2_obj['time']->$k?>"></td>
															<td><input type="number" name="tab2[percent][<?=$k?>]" class="form-control" value="<?=@$tab2_obj['percent']->$k?>"></td>
															<td><input type="text" name="tab2[full_money][<?=$k?>]" class="form-control my-input" value="<?=@$tab2_obj['full_money']->$k?>"></td>
															<td><input type="text" name="tab2[full_fee][<?=$k?>]" class="form-control my-input" value="<?=@$tab2_obj['full_fee']->$k?>"></td>
															<td class="text-right"><?=number_format($f_budget)?></td>
															<td><input type="text" name="tab2[affiliation][<?=$k?>]" class="form-control my-input" value="<?=@$tab2_obj['affiliation']->$k?>"></td>
															<td class="text-right"><?=number_format($f_30)?></td>
															<td class="text-right"><?=number_format($f2_50)?></td>
															<td class="text-right"><?=number_format($f2_20)?></td>
															<td class="text-right"><?=number_format($f2_30)?></td>
															<!--<td><input type="text" name="tab2[balance][<?=$k?>]" class="form-control my-input" value="<?=@$tab2_obj['balance']->$k?>"></td>-->
															<td class="text-right"><?=number_format(rmComma($f_budget) - rmComma($tab2_obj['affiliation']->$k))?></td>
															<td class="text-right"><input style="width:120px;" type="text" class="form-control text-center" name="tab2[rc_date][<?=$k?>]" value="<?=@$tab2_obj['rc_date']->$k?>" data-provide="datepicker" data-date-language="th-th"></td>
															<td>
															<?php $fcount = chFileStatus($rsFile, $k)!=0? '('.chFileStatus($rsFile, $k).')':'';?>
															<?php $btn_class = $fcount!=''?'success':'info'?>
															<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile_account" a-id="<?=$account_id?>" a-point="<?=$k?>"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
															</td>
														</tr>
														<?php 
															
															if($tab2_obj['percent']->$k!=null){
															$s_percent+= rmComma($tab2_obj['percent']->$k); 
															}
															$s_fbudget+= rmComma($f_budget); 
															$s_affiliation+= rmComma($tab2_obj['affiliation']->$k);	
															$s_balance+= rmComma($f_budget) - rmComma($tab2_obj['affiliation']->$k);	
															$s_fee+= $tab2_obj['full_fee']->$k!=null? rmComma($tab2_obj['full_fee']->$k):0;	
															$s_fullmoney+= rmComma($tab2_obj['full_money']->$k);	
															
															$s_30+= rmComma($f_30);	
															$s2_30+= rmComma($f2_30);
															$s2_50+= rmComma($f2_50);
															$s2_20+= rmComma($f2_20);
																													
														?>
														<?php }?>
													<?php }?>
													<tr class="tab2_summary">
														<td class="text-center">รวม</td>
														<td></td>
														<td class="text-center"><?=$s_percent?>%</td>
														<td class="text-right"><?=number_format($s_fullmoney)?></td>
														<td class="text-right"><?=number_format($s_fee)?></td>
														<td class="text-right"><?=number_format($s_fbudget)?></td>
														<td class="text-right"><?=number_format($s_affiliation)?></td>
														<td class="text-right"><?=number_format($s_30)?></td>
														<td class="text-right"><?=number_format($s2_50)?></td>
														<td class="text-right"><?=number_format($s2_20)?></td>
														<td class="text-right"><?=number_format($s2_30)?></td>
														<td class="text-right"><?=number_format($s_balance)?></td>
														<td></td>
													</tr>
												</tbody>
											</table>
											</div>
										
										</div>
										<div role="tabpanel" class="p-3 tab-pane <?=$s_tab=="tab3"?'active':'fade'?>" id="tab3">

											<button type="button" class="btn btn-info btn-sm mb-3 AddSection"><i class="mdi mdi-plus"></i> เพิ่มกิจกรรม</button>
											
											
											<?php $fcount = chFileStatus($rsFile, 'att_account')!=0? '('.chFileStatus($rsFile, 'att_account').')':'';?>
											<?php $btn_class = $fcount!=''?'success':'info'?>
											<button type="button" class="btn btn-<?=$btn_class?> btn-sm mb-3 btn_addfile_account" a-id="<?=$account_id?>" a-point="att_account"><i class="mdi mdi-upload"></i> แนบไฟล์รายละเอียดบัญชี <?=$fcount?></button>
											
											<?php $fcount = chFileStatus($rsFile, 'att_account_doc')!=0? '('.chFileStatus($rsFile, 'att_account_doc').')':'';?>
											<?php $btn_class = $fcount!=''?'success':'info'?>
											<button type="button" class="btn btn-<?=$btn_class?> btn-sm mb-3 btn_addfile_account" a-id="<?=$account_id?>" a-point="att_account_doc"><i class="mdi mdi-upload"></i> แนบไฟล์เอกสาร <?=$fcount?></button>
											
											<a target="_blank" href="<?=base_url()?>template/รูปแบบการกรอกข้อมูล.pdf" class="btn btn-danger btn-sm mb-3 float-right ml-2" ><i class="mdi mdi-download"></i> รูปแบบกรอกข้อมูล </a>
											<a target="_blank" href="<?=base_url('dashboard/account/download/'.$account_id)?>" class="btn btn-success btn-sm mb-3 float-right ml-2" ><i class="mdi mdi-file-excel "></i> ดาวน์โหลด </a>
																			
											<?php 
												//echo '<pre>';
												//print_r($tab3_obj);
												//echo '</pre>';

											?>											
											<div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
												<?php if(@$tab3_obj!=null){?>
													<?php foreach($tab3_obj as $kk=>$v){?>
													<div class="card mb-1">
														<div class="card-header" style="background-color: #e2e2e2;" role="tab">
															<div class="row">
																<div class="col-md-9">
																	<input type="text" class="form-control form-control-title" name="tab3[<?=$kk?>][section_name]" value="<?=$v->section_name?>">
																</div>
																<div class="col-md-3">
																	<button type="button" class="btn btn-sm btn-danger btnDelSection float-right" style="margin-left:5px;">
																		<i class="mdi mdi-delete "></i>
																	</button>
																	<button type="button" class="btn btn-sm btn-secondary float-right" style="margin-left:5px;" data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne<?=$kk?>" aria-expanded="true" aria-controls="collapseOne<?=$kk?>">
																		<i class="mdi mdi-arrow-expand"></i>
																	</button>
																</div>
															</div>
														</div>
														<div id="collapseOne<?=$kk?>" class="collapse" role="tabpanel" aria-labelledby="headingOne<?=$kk?>" data-parent="#accordionEx">
															<div class="card-body" style="padding: 10px;border: 1px solid #ebedf2;">
																<button type="button" class="btn btn-sm btn-info mb-2 btnAddSubSection" section_row_value="<?=$kk?>">
																	<i class="mdi mdi-plus-circle-outline float-right"></i> เพิ่มรายละเอียด
																</button>
														
																<table class="table table-bordered" id="tblSection<?=$kk?>">
																	<thead>
																		<tr class="text-center">
																			<th width="10">#</th>
																			<th width="180">หมวดหมู่</th>
																			<th width="150">วดป</th>
																			<th>รายละเอียด</th>
																			
																			<th width="150">เลขที่อ้างอิง</th>
																			<th width="150">จำนวนเงิน</th>
																			<th width="150"></th>
																		</tr>
																	</thead>
																	<tbody>
																	<?php 
			
																	if(@$v->value->date!=null){
																		$ar_list = $v->value->date;
																		foreach($ar_list as $kkk=>$vv){?>
																		<tr>
																			<td><a href="javascript:void(0)" class="btnDelSubSection btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
																			<td>
																				<select class="form-control" name="tab3[<?=$kk?>][value][cat][<?=$kkk?>]" required>
																					<option> เลือกหมวดหมู่ </option>
																					<?php foreach(getAccountCat() as $k=>$item){?>
																					<option value="<?=$k?>" <?=$v->value->cat->$kkk==$k?'selected':''?>> <?=$item?> </option>
																					<?php }?>
																				</select>
																			</td>
																			<td><input type="text" class="form-control text-center" name="tab3[<?=$kk?>][value][date][<?=$kkk?>]" value="<?=$v->value->date->$kkk?>" data-provide="datepicker" data-date-language="th-th" required></td>
																			<td><input type="text" class="form-control" name="tab3[<?=$kk?>][value][detail][<?=$kkk?>]" value="<?=$v->value->detail->$kkk?>" required></td>
																			<td><input type="text" class="form-control" name="tab3[<?=$kk?>][value][ref][<?=$kkk?>]" value="<?=$v->value->ref->$kkk?>" required></td>
																			<td><input type="text" class="form-control my-input" name="tab3[<?=$kk?>][value][money][<?=$kkk?>]" value="<?=$v->value->money->$kkk?>" required></td>
																			<td>
																			<?php $fcount = chFileStatus($rsFile, $kkk)!=0? '('.chFileStatus($rsFile, $kkk).')':'';?>
																			<?php $btn_class = $fcount!=''?'success':'info'?>
																			<button type="button" class="btn btn-<?=$btn_class?> btn-sm btn_addfile_account" a-id="<?=$account_id?>" a-point="<?=$kkk?>"><i class="mdi mdi-upload"></i> แนบไฟล์ <?=$fcount?></button>
																			</td>
																		</tr>
																	<?php }?>
																	<?php }?>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<?php }?>
												<?php }?>
											</div>

										</div>
										<div role="tabpanel" class="p-3 tab-pane <?=$s_tab=="tab4"?'active':'fade'?>" id="tab4">
											<?php 
												$s_rbudget = 0;
												
												$s_pay = $sum_tab1+$sum_tab2+$sum_tab3+$sum_tab4+$sum_tab5+$sum_tab6+$sum_tab7;
											?>
											<div class="row">
												<div class="col-md-6">
												
													<table class="table table-bordered">
														<thead class="text-center" style="background-color: #4e71a5;color: #fff">
															<tr>
																<th>รายรับสุทธิ</th>
																<th width="150">จำนวนเงิน</th>
															</tr>
														</thead>
														<tbody>
														<?php $f_budget_uncut=0;?>
														<?php if($tab2_obj!=null){?>
														<?php foreach($tab2_obj['time'] as $k=>$v){?>
														<?php 
														
															$f_budget_uncut += rmComma($tab2_obj['full_money']->$k);
															
															$a=0;
															if($tab2_obj['full_money']->$k!=""){
																$a=rmComma($tab2_obj['full_money']->$k);
															}
															$b=0;
															if($tab2_obj['full_fee']->$k!=""){
																$b=rmComma($tab2_obj['full_fee']->$k);
															}
															
															$f_budget = $a - $b;
															//$f_budget = rmComma($tab2_obj['full_money']->$k) - rmComma($tab2_obj['full_fee']->$k);
															$s_balance= rmComma($f_budget) - rmComma($tab2_obj['affiliation']->$k);
														?>
															<tr>
																<td> เงินงวดที่ <?=$tab2_obj['time']->$k?></td>
																<td class="text-right"><?=number_format(rmComma($s_balance),2)?></td>
															</tr>
														<?php $s_rbudget+= $s_balance; }?>
														<?php }?>
															<tr>
																<td>รวมรายรับที่ได้</td>
																<td class="text-right"><?=number_format($s_rbudget,2)?></td>
															</tr>
														</tbody> 
													</table>
												</div>
												<div class="col-md-6">
												
													<?php 
													
														$ssum[0]=0;$ssum[1]=0;$ssum[2]=0;$ssum[3]=0;$ssum[4]=0;$ssum[5]=0;$ssum[6]=0;$ssum[7]=0;$ssum[8]=0;$ssum[9]=0;
														foreach($tab3_obj as $key=>$val){
															if(@$val->value->cat!=null){
																foreach($val->value->cat as $skey=>$sval){
																	$ssum[$val->value->cat->$skey] += rmComma($val->value->money->$skey);
																}
															}
														}
														$ssum[8] = 0;
														$ssum_total = $ssum[0]+$ssum[1]+$ssum[2]+$ssum[3]+$ssum[4]+$ssum[5]+$ssum[6]+$ssum[7]+$ssum[8]+$ssum[9];
													?>
													<table class="table table-bordered">
														<thead class="text-center" style="background-color: #ff8484;color: #fff">
															<tr>
																<th>รายจ่ายในการดำเนินโครงการ</th>
																<th width="150">จำนวนเงิน</th>
															</tr>
														</thead>
														<tbody>
															<?php $i=0;foreach(getAccountCat() as $k=>$v){?>
															<?php if($k!=8){$i++;?>
															<tr>
																<td><?=$i?>. <?=$v?></td>
																<td class="text-right"><?=number_format($ssum[$k],2)?></td>
															</tr>
															<?php }?>
															<?php }?>
															<tr>
																<td>รวม</td>
																<td class="text-right"><?=number_format($ssum_total,2)?></td>
															</tr>
														</tbody> 
													</table>
													
												</div>
											</div>
											<br/>
											<?php
											$budget_input =0;
											if(@$tab4_obj['budget_input']!=null){
												$budget_input=$tab4_obj['budget_input'];
											}
											
											$budget_type ='default';
											if(@$tab4_obj['budget_type']!=null){
												$budget_type=$tab4_obj['budget_type'];
											}
											?>
											<table class="table table-bordered">
												<tbody>
													<tr>
														<td>เงินคงเหลือสุทธิ</td>
														<td class="text-right" width="150"><?=number_format($s_rbudget-$ssum_total,2)?></td>
													</tr>
													<tr>
														<td>รายรับคงค้างจากแหล่งทุน</td>
														<td class="text-right" width="150"><?=number_format($s_pay-$f_budget_uncut,2)?></span></td>
													</tr>
													<?php $sss_total = $s_rbudget - ($sum_tab1+$sum_tab2);?>
													<tr>
														<td class="text-right">การคำนวน</td>
														<td class="text-right" width="150">
															<select class="form-control" name="tab4[budget_type]">
																<option value="default" <?=$budget_type=="default"?'selected':''?>>คำนวนจากสูตร</option>
																<option value="manual" <?=$budget_type=="manual"?'selected':''?>>กรอกข้อมูลเอง</option>
															</select>
														</td>
														
													</tr>
													<?php if($budget_type=="default"){?>
													<tr>
														<td class="text-right">งบประมาณดำเนินงาน (หักส่วนค่าตอบแทนและค่าจ้างนักวิจัย) (บาท)</td>
														<td class="text-right" width="150"><?=number_format($sss_total,2)?></td>
														
													</tr>
													<?php }else{?>
													<tr>
														<td class="text-right">งบประมาณดำเนินงาน (หักส่วนค่าตอบแทนและค่าจ้างนักวิจัย) (บาท)</td>
														<td class="text-right" width="150"><input type="text" class="form-control text-right my-input" name="tab4[budget_input]" value="<?=$budget_input?>"></td>
													</tr>
													<?php }?>
													
													<tr>
														<td class="text-right">ค่าใช้จ่ายดำเนินงาน (บาท)</td>
														<td class="text-right" width="150"><?=number_format($ssum_total,2)?></td>
													</tr>
													<?php 
													if($budget_type=="default"){
														$sss_balance = rmComma($sss_total)-rmComma($ssum_total);
													}else{
														$sss_balance = rmComma($budget_input)-rmComma($ssum_total);
													}
													?>
													<tr>
														<td class="text-right">คงเหลือ (บาท)</td>
														<td class="text-right" width="150"><?=number_format($sss_balance,2)?></td>
													</tr>
													<tr>
														<td class="text-right">กำไร (%)</td>
														<?php if($budget_type=="default"){?>
															<td class="text-right" width="150"><?=$sss_total!=0? number_format(($sss_balance*100)/rmComma($sss_total),2):'กรุณาตรวจสอบข้อมูล'?></td>
														<?php }else{?>
															<td class="text-right" width="150"><?=$budget_input!=0? number_format(($sss_balance*100)/rmComma($budget_input),2):'กรุณาตรวจสอบข้อมูล'?></td>
														<?php }?>
														
													</tr>
													<tr>
														<td class="text-right">สถานะการปิดบัญชีโครงการ</td>
														<td class="text-right" width="150">
														<input type="text" class="form-control text-center" data-provide="datepicker" data-date-language="th-th" name="account_status_complate_date" h="<?=@$account_status_complate_date?>" value="<?=@$account_status_complate_date!=null && @$account_status_complate_date!='0000-00-00'? encode_date($account_status_complate_date):''?>">
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div role="tabpanel" class="p-3 tab-pane <?=$s_tab=="tab5"?'active':'fade'?>" id="tab5">
											<table class="table table-bordered" id="tbl2account2">
												<thead class="text-center">
													<tr class="text-center">
														<th class="align-middle" width="10"><a href="javascript:void(0)" id="topic1" class="btnAddBudget2 btn btn-info btn-sm"><i class="mdi mdi-plus"></i></a></th>
														<th class="align-middle" width="100">งวดที่</th>
														<th class="align-middle">จำนวนเงิน (บาท)</th>
														<th class="align-middle">หักเข้าต้นสังกัด</th>
													</tr>
													
												</thead>
												<tbody>
													<?php $f2_money =0; $f2_money2=0;?>
													<?php if($tab5_obj!=null){?>
														<?php foreach($tab5_obj['time'] as $k=>$v){?>
														<?php 
															if($tab5_obj['money']->$k!=null){
																$f2_money+=rmComma($tab5_obj['money']->$k);
															}
															if($tab5_obj['moneydiscount']->$k!=null){
																$f2_money2+=rmComma($tab5_obj['moneydiscount']->$k);
															}
														
														?>
														<tr>
															<td><a href="javascript:void(0)" class="btn_delBudget btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a></td>
															<td><input type="text" name="tab5[time][<?=$k?>]" class="form-control text-center" value="<?=@$tab5_obj['time']->$k?>"></td>
															<td><input type="text" name="tab5[money][<?=$k?>]" class="form-control text-right" value="<?=@$tab5_obj['money']->$k?>"></td>
															<td><input type="text" name="tab5[moneydiscount][<?=$k?>]" class="form-control text-right" value="<?=@$tab5_obj['moneydiscount']->$k?>"></td>
														</tr>
														<?php }?>
													<?php }?>
													<tr class="tab2_summary">
														<td></td>
														<td class="text-center">รวม</td>
														<td class="text-right"><?=number_format($f2_money,2)?></td>
														<td class="text-right"><?=number_format($f2_money2,2)?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12 text-center">
										
										<button type="submit" class="btn btn-gradient-primary mr-2">บันทึก</button>
									</div>
								</div>
								
								
							</form>
						</div>
					</div>
				</div>
            </div>