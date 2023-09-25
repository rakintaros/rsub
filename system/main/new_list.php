
		<style>
		.div_title{height:45px;overflow:hidden;}
		.link_title{font-weight:500;font-size: 1.2rem;}
		.div_text{height: 100px;overflow: hidden;padding-bottom: 10px;}
		.btn_more{border-bottom: 2px solid #00b1e5;}
		.btn_more h5{color:#00b1e5 !important;}
		</style>
		
		<section class="pt-5">

			<div class="container">
				<h1 class="fw-bold fs-6 mb-3">ข่าวสาร</h1>
				<div class="mb-6">
				<nav aria-label="breadcrumb">
					 <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">หน้าหลัก</a></li>
						<li class="breadcrumb-item active" aria-current="page">ข่าวสาร</li>
					</ol>
				</nav>
				</div>
				<div class="row">
					<?php foreach($rsList as $item){?>
					<div class="col-md-4 mb-4">
						<div class="card" style="border:0;"><img class="card-img-top" src="<?=base_url('uploads/timthumb.php?src='.base_url('uploads/images/'.$item->post_img).'&w=400&h=250')?>" alt="" />
							<div class="card-body ps-0">
								<div class="div_title mb-3">
									<h3 class="link_title"><a href="<?=base_url('post/'.$item->post_id)?>"><?=$item->post_title?></a></h3>
								</div>
								<p class="text-secondary">
									<a class="text-decoration-none me-1" href="#"><i class='bx bx-purchase-tag' ></i> <?=$item->category_name?></a>|<span class="ms-1"><i class='bx bx-calendar' ></i> <?=ConvertToThaiDate($item->createdate,0)?></span>
								</p>
								<div class="div_text">
									<p><?=txtDescription($item->post_detail,150)?></p>
								</div>
								<div class="btn_more text-end">
									<h5 class="mt-3 mb-3"><a href="<?=base_url('post/'.$item->post_id)?>">Read more...</a></h5>
								</div>
							</div>
						  </div>
					</div>
					<?php }?>
				</div>
			</div><!-- end of .container-->

		</section>
		

		