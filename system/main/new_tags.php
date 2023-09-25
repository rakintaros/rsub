				<section class="pt-5">

			<div class="container">
				<h1 class="fw-bold fs-6 mb-3">#<?=$this->input->get('tag')?></h1>
				<div class="mb-6">
				<nav aria-label="breadcrumb">
					 <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">หน้าหลัก</a></li>
						<li class="breadcrumb-item active" aria-current="page">คำค้นหา</li>
					</ol>
				</nav>
				</div>
				<div class="row">
					<?php foreach($rsList as $item){?>
					<div class="col-md-4 mb-4">
						<div class="card" style="border:0">
							<img class="card-img-top" src="<?=base_url('uploads/timthumb.php?src='.base_url('uploads/images/'.$item->post_img).'&w=400&h=300')?>" alt="">
							<div class="card-body ps-0">
								<p class="text-secondary"><?=ConvertToThaiDate($item->createdate,0)?> | <span class="ms-1"><?=number_format($item->viewcounts)?> views</span></p>
								<h3 class="fw-bold"><a href="<?=base_url('post/'.$item->post_id)?>"><?=$item->post_title?></a></h3>
							</div>
						</div>
					</div>
					<?php }?>
				</div>
			</div><!-- end of .container-->

		</section>
		
		