		<section class="pt-5">

			<div class="container">
				<h1 class="fw-bold fs-6 mb-3"><?=$rs[0]->post_title?></h1>
				<div class="mb-6">
				<nav aria-label="breadcrumb">
					 <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">หน้าหลัก</a></li>
						<li class="breadcrumb-item active" aria-current="page">ข่าวสาร</li>
					</ol>
				</nav>
				</div>
				<div class="row">
					<?php $item = $rs[0];?>
					<div class="col-md-12">
						<div class="clearfix mb-3">
						<ul class="list-inline" style="font-weight: 500;">
							<li class="list-inline-item"><i class="bx bx-folder-open"></i> <?=$item->category_name?> / </li>
							<li class="list-inline-item"><i class="bx bx-group"></i> <?=number_format($item->viewcounts)?> / </li>
							<li class="list-inline-item"><i class="bx bx-calendar"></i> <?=ConvertToThaiDate($item->createdate,0)?></li>
						</ul>
						</div>
						
						<div class="clearfix mb-3">
							<p><?=$item->post_detail?></p>
						</div>
						<div class="clearfix mb-3">
							
                                <div class="float-start">
                                    <span><i class="bx bx-purchase-tag"></i></span>
									<?php if($item->post_tags!=null){?>
										<?php $tags = explode(",", $item->post_tags);?>
											<?php $i=0;foreach($tags as $tag){$i++;?>
											<?=$i>1?', ':''?><a href="<?=site_url()?>news_tag/?tag=<?=$tag?>">#<?=$tag?></a>
											<?php }?>
									<?php }?>
                                </div>

                                <div class="float-end">
									<div class="addthis_toolbox addthis_default_style addthis_32x32_style float-end">
										<a class="addthis_button_facebook"></a>
										<a class="addthis_button_twitter"></a>
										<a class="addthis_button_email"></a>
										<a class="addthis_button_compact"></a>
									</div>
                                   
                                </div>
                            </div>
						</div>
					</div>
					
				</div>
			</div><!-- end of .container-->

		</section>
		
		
		<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fdc05233895bf13"></script>