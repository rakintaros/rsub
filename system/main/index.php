		
		<style>.map_box{border:0;height:680px;left:0;position:relative;top:0;width:100%}.leaflet-control-container{display:none!important}#map{width:100%;height:100%;background:0 0}.run_number{font-size:50px;color:#5fc6cd}h3.odometer{color:#fff;font-size:35px}#home_tootls{z-index:999;position:absolute;top:0;width:500px}.mapData{background-color:#3fc7fc;opacity:.8;height:680px;width:100%}.mapData h2{color:#fff;font-weight:400}.frm_search{position:relative}.icon_search{position:absolute;color:#fff;font-size:1.6rem;top:0}.input_search{background:0 0;border:0;border-bottom:1px solid #fff;width:100%;color:#fff;padding-left:30px;padding-bottom:5px;font-size:1.1rem}.input_search:focus{outline:0!important}#hotel_list{height:590px;overflow-y:auto;padding:0 6px}#hotel_list::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3);background-color:#f5f5f5}#hotel_list::-webkit-scrollbar{width:10px;background-color:#f5f5f5}#hotel_list::-webkit-scrollbar-thumb{background-color:#009aff;background-image:-webkit-linear-gradient(45deg,rgba(255,255,255,.2) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.2) 50%,rgba(255,255,255,.2) 75%,transparent 75%,transparent)}.card{border:0}.hotel_items{background-color:#fff;border-radius:10px;padding:10px;box-shadow:rgb(0 0 0 / 25%) 2.95px 2.95px 3.6px}.item_value{color:#00b0e2;font-size:1.2rem;height:25px;line-height:normal;overflow:hidden}.scoreData{z-index:999;position:absolute;bottom:30px;right:30px;width:720px;opacity:.9;background-color:#fff;border-radius:5px;padding:5px 10px}.scoreData .score{display:flex}.score_items:first-child{border-top-left-radius:10px;border-bottom-left-radius:10px}.score_items:last-child{border-top-right-radius:10px;border-bottom-right-radius:10px}.score_items{width:120px;padding:2px 20px;font-size:13px;color:#fff;font-weight:500}.sectorData{z-index:999;position:absolute;top:30px;right:30px}.sector_item{background-color:#fff;border-radius:10px;width:60px;height:60px;box-shadow:rgb(0 0 0 / 25%) 2.95px 2.95px 3.6px;margin-bottom:10px}.sector_item:hover{background-color:#009bff}.figure{position:relative;width:360px;max-width:100%}.figure img.image-hover{position:absolute;top:0;right:0;left:0;bottom:0;object-fit:contain;opacity:0;transition:opacity .2s}.figure:hover img.image-hover{opacity:1}.pin{position:absolute;border-radius:50% 50% 50% 0;width:20px;height:20px;transform:rotate(-45deg)}.pin::after{position:absolute;content:'';width:10px;height:10px;border-radius:50%;top:50%;left:50%;margin-left:-5px;margin-top:-5px}.pin0{border:4px solid #c1c1c1}.pin0:after{background-color:#c1c1c1}.pin1{border:4px solid #00c9ff}.pin1:after{background-color:#00c9ff}.pin2{border:4px solid #00ba00}.pin2:after{background-color:#00ba00}.pin3{border:4px solid #ffbb64}.pin3:after{background-color:#ffbb64}.pin4{border:4px solid #ff728d}.pin4:after{background-color:#ff728d}.pin5{border:4px solid #8d76ff}.pin5:after{background-color:#8d76ff}#feature{background-color:#fff}#feature h2{color:#009aff;font-size:3.5rem;font-family:monospace;margin:0}#feature .stat_line{border:1px solid;width:30%;color:#333;margin:10px 0}#feature h3{color:#333}#aboutus{background-color:#f4f9fa}.calendar{border:1px solid #00b9e2;font-weight:600}.date{color:#009cff;padding-top:10px;text-align:center;font-size:2rem}.month{color:#333;text-align:center;padding-top:5px;font-size:1.5rem}.event_list h4 a{color:#00a2ff}.about_line{border:1px solid;width:20%;color:#00b1e4;margin:20px 0}.div_title{height:45px;overflow:hidden}.link_title{font-weight:500;font-size:1.2rem}.div_text{height:100px;overflow:hidden;padding-bottom:10px}.btn_more{border-bottom:2px solid #00b1e5}.btn_more h5{color:#00b1e5!important}</style>
		<!-- Start Courses Categories Area -->

		<section class="pt-7" style="padding:0 !important;">
			<div class="map_box">
				<div id="map"></div>
					<div id="home_tootls">
						<div class="mapData">
							<div class="container">
								<div class="row pt-3 mb-3">
									<div class="col-md-7">
										<div class="frm_search">
											<div class="icon_search"><i class='bx bx-search' ></i></div>
											<input type="text" class="input_search" id="txt_search" onkeyup="filter()">
										</div>
									</div>
									<div class="col-md-5 text-center">
										<h2><i class='bx bxs-star'></i> Ranking</h2>
									</div>
								</div>
								<div id="hotel_list"></div>
							</div>
						</div>
						
						
					</div>
					
					<div class="sectorData">
						<div class="sector_item">
							<a class="sw_type active" data-type="exam" style="cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="left" title="สมรรถนะ">
								<div class="figure">
									<img class="image-main img-fluid" src="<?=base_url('template/img/icon/type1.png')?>" >
									<img class="image-hover img-fluid" src="<?=base_url('template/img/icon/type1_1.png')?>">
								</div>
							</a>
						</div>
						
						<div class="sector_item">
							<a class="sw_type" data-type="reduce" style="cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="left" title="ก๊าซเรือนกระจก">
								<div class="figure">
									<img class="image-main img-fluid" src="<?=base_url('template/img/icon/type3.png')?>" >
									<img class="image-hover img-fluid" src="<?=base_url('template/img/icon/type3_1.png')?>">
								</div>
							</a>
						</div>
						
						<div class="sector_item">
							<a id="btnType3" href="<?=base_url('dashboard')?>" data-bs-toggle="tooltip" data-bs-placement="left" title="เครื่องมือคำนวนก๊าซเรือนกระจก">
								<div class="figure">
									<img class="image-main img-fluid" src="<?=base_url('template/img/icon/type2.png')?>" >
									<img class="image-hover img-fluid" src="<?=base_url('template/img/icon/type2_1.png')?>">
								</div>
							</a>
						</div>
					</div>
					<div class="scoreData">
						<div class="score">
							<div class="score_items text-center" style="background: #00c9ff;">0%-20%</div>
							<div class="score_items text-center" style="background: #00ba00;">21%-40%</div>
							<div class="score_items text-center" style="background: #ffbb64;">41%-60%</div>
							<div class="score_items text-center" style="background: #ff728d;">61%-80%</div>
							<div class="score_items text-center" style="background: #8d76ff;">81%-100%</div>
							<div class="score_items text-center" style="background: #c1c1c1;">ไม่พบข้อมูล</div>
						</div>
					</div>
				</div>
			</div>
			
		</section>
		
		
		<section class="py-6" id="feature">
			<div class="container">
			
				<div class="row">
					<div class="col-lg-4 col-md-4 col-12">
				
						<div class="row">
							<div class="col-md-3" style="padding-right: 0;">
								<div class="d-flex justify-content-center align-items-center" style="height:170px;">
									<img src="<?=base_url('template/img/icon-2/hotel.png?v=1')?>" class="img-fluid"/>
								</div>
							</div>
							<div class="col-md-9">
								<h2 class="odometer" data-count="<?=$rsMemberCount?>">  </h2>
								<div class="stat_line"></div>
								<h3>โรงแรม</h3>
							</div>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-4 col-12">
						<div class="row">
							<div class="col-md-3" style="padding-right: 0;">
								<div class="d-flex justify-content-center align-items-center" style="height:170px;">
								<img src="<?=base_url('template/img/icon-2/greenhouse.png?v=1')?>" class="img-fluid"/>
								</div>
							</div>
							<div class="col-md-9">
								<h2 class="odometer" data-count="<?=$rsMemberCal?>">  </h2>
								<div class="stat_line"></div>
								<h3>ก๊าซเรือนกระจก<br/>(tCo<sub>2</sub>eq)</h3>
							</div>
						</div>
					</div>
					
					<div class="col-lg-4 col-md-4 col-12">
						<div class="row">
							<div class="col-md-3" style="padding-right: 0;">
								<div class="d-flex justify-content-center align-items-center" style="height:170px;">
								<img src="<?=base_url('template/img/icon-2/reduce.png?v=1')?>" class="img-fluid"/>
								</div>
							</div>
							<div class="col-md-9">
								<h2 class="odometer" data-count="<?=$rsMemberRe?>">  </h2>
								<div class="stat_line"></div>
								<h3>ลดก๊าซเรือนกระจก<br/>(tCo<sub>2</sub>eq)</h3>
							</div>
						</div>
					</div>
					
					
				</div>
			</div><!-- end of .container-->
		</section>

		<section class="py-9" id="aboutus">

			<div class="container">
			  <div class="row justify-content-center">
				<div class="col-lg-8 ">
					<h1 class="fw-bold mb-2 fs-6">เกี่ยวกับ <span>เรา</span></h1>
					<div class="about_line"></div>
					<p class="mb-5 text-info fw-medium">ปัจจุบันการพัฒนาการท่องเที่ยวในหลายประเทศทั่วโลก ได้ให้ความสำคัญกับผลกระทบต่อสิ่งแวดล้อมที่เกิดจากพฤติกรรมการบริโภคของนักท่องเที่ยวและจากการดำเนินงานของธุรกิจท่องเที่ยว โดยเฉพาะกิจกรรมหลักในการท่องเที่ยว ได้แก่ การขนส่ง โรงแรม ที่พัก และสิ่งอำนวยความสะดวกต่าง ๆ ในแหล่งท่องเที่ยว ที่ก่อให้เกิดก๊าซเรือนกระจก (Greenhouse gas: GHG) อันเป็นต้นเหตุสำคัญของภาวะโลกร้อน </p>
					<p class="mb-5 text-info fw-medium">การท่องเที่ยวแห่งประเทศไทย (ททท.) ได้ตระหนักถึงความสำคัญของผลกระทบจากกิจกรรมการท่องเที่ยวต่อสิ่งแวดล้อม และต้องการผลักดันทั้งในระดับนโยบายและการปฏิบัติการเพื่อให้เกิดการปรับเปลี่ยนพฤติกรรมการดำเนินธุรกิจของผู้ประกอบการในการผลิตและการให้บริการที่เป็นมิตรกับสิ่งแวดล้อม รวมทั้งการเพิ่มโอกาสการเข้าถึงและขยายตลาดสินค้าและบริการที่เป็นมิตรกับสิ่งแวดล้อมให้แก่นักท่องเที่ยว และที่สำคัญสามารถลดต้นทุนของผู้ประกอบการจากการใช้ทรัพยากรและพลังงานอย่างคุ้มค่าและมีประสิทธิภาพ</p>
					<p>
						<a href="<?=base_url('aboutus')?>" class="btn btn-light btn-sm">Read more   <i class='bx bxs-chevrons-right bx-flashing' ></i></a>
						<!--<a class="btn btn-link text-warning fw-medium" href="#!" role="button" data-bs-toggle="modal" data-bs-target="#popupVideo"><span class="fas fa-play me-2"></span>Watch the video </a>-->
					</p>
				</div>
				<div class="col-lg-4 ">
					<h1 class="fw-bold mb-2 fs-6">กิจกรรม<span> กำลังมาถึง</span></h1>
					<div class="about_line"></div>
					<div class="event_listz owl-carouselz owl-arrow-style">
						<div class="item">
							<div class="row mb-3 rows_event">
								<div class="col-4">
									<div class="calendar">
										<div class="date">25</div>
										<div class="month">APR</div>
									</div>
								</div>
								<div class="col-8">
									<h4 class="mb-1"><a href="#">หมดเขตรับสมัครโรงแรมเข้าร่วมโครงการ</a></h4>
									<p><i class='bx bx-map-pin' ></i> มหาวิทยาลัยเชียงใหม่</p>
								</div>
							</div>
							
							<div class="row mb-3 rows_event">
								<div class="col-4">
									<div class="calendar">
										<div class="date">27 </div>
										<div class="month">APR</div>
									</div>
								</div>
								<div class="col-8">
									<h4 class="mb-1"><a href="#">ประกาศผลโรงแรมที่ได้รับการคัดเลือก</a></h4>
									<p><i class='bx bx-map-pin' ></i> มหาวิทยาลัยเชียงใหม่</p>
								</div>
							</div>
							
							<div class="row mb-3 rows_event">
								<div class="col-4">
									<div class="calendar">
										<div class="date">5 </div>
										<div class="month">MAY</div>
									</div>
								</div>
								<div class="col-8">
									<h4 class="mb-1"><a href="#">จัดอบรมเชิงปฏิบัติการให้กับโรงแรมที่เข้าร่วมโครงการ </a></h4>
									<p><i class='bx bx-map-pin' ></i> ณ ห้องแกรนด์บอลรูม ชั้น 2 โรงแรมเลอ เมอริเดียน เชียงใหม่</p>
								</div>
							</div>
						</div>

						
					</div>
				</div>
			  </div>
			</div><!-- end of .container-->

		</section>

		<section class="pt-9 pb-0" id="news">

			<div class="container">
				<h1 class="fw-bold fs-6 mb-3 text-center">ข่าวสาร <span>ล่าสุด</span></h1>
				<div class="about_line mb-4" style="margin:0 auto;"></div>
				<p class="mb-6 text-secondary text-center">อัพเดทข่าวสาร เกี่ยวกับ โรงแรม การท่องเที่ยว สามารถดูทั้งหมดได้ <a href="<?=base_url('news')?>">ที่นี่</a></p>
				<div class="row">
				<div class="new_list owl-carousel owl-arrow-style">
				<?php foreach($rsList as $item){?>
					<item>
						<div class="mb-4">
						  <div class="card"><img class="card-img-top" src="<?=base_url('uploads/timthumb.php?src='.base_url('uploads/images/'.$item->post_img).'&w=400&h=250')?>" alt="" />
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
					</item>
				<?php }?>
				</div>
				</div>
			</div><!-- end of .container-->

		</section>
		
		<div class="modal fade" id="popupVideo" tabindex="-1" aria-labelledby="popupVideo" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
			  <iframe class="rounded" style="width:100%;height:500px;" src="https://www.youtube.com/embed/_lhdhL4UDIo" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		  </div>
		</div>
		

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
		
		<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" crossorigin=""></script>
		
		<style>
			
		</style>
		<link rel="stylesheet" href="<?=base_url()?>template/css/odometer.min.css" crossorigin=""/>
		<link rel="stylesheet" href="<?=base_url()?>template/css/owl.carousel.min.css" crossorigin=""/>
		
		<script src="<?=base_url()?>template/js/jquery.appear.min.js" crossorigin=""></script>
		<script src="<?=base_url()?>template/js/odometer.min.js" crossorigin=""></script>
		<script src="<?=base_url()?>template/js/owl.carousel.min.js" crossorigin=""></script>
		<script>
		
			
			
			var map = new L.map("map", {
				center: [18.7896195, 98.9727520],
				zoom: 9,
				attributionControl: !1,
				maxZoom: 17,
				minZoom: 9,
				fullscreenControl: true,
				});
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);
			
			var markers = L.layerGroup();
			var currentMember = null;
			
			function loadMarker(){
					
				var sw_type =  $( ".sectorData" ).find( ".active" ).attr("data-type");
				if(sw_type=="reduce"){
					$(".mapData").fadeOut(400);
					$(".scoreData").fadeOut(400);
					

				}else{
					
					$(".mapData").fadeIn(400);
					$(".scoreData").fadeIn(400);
				}
				
				markers.clearLayers();
				var uri = '<?=base_url("main/getMarker/")?>'+sw_type;
				var rows_data = '';
				$.getJSON(uri, function(data) {
					if(data){
						
						for (let index = 0; index < data.length; index++) {
							
							if(index>0){
								if(data[index].member_score == data[(index-1)].member_score){
									
								}else{
									var rank = (index+1);
								}
							}else{
								var rank = (index+1);
							}
							rows_data +='<div class="hotel_items mb-3">';
							rows_data +='		<div class="row">';
							rows_data +='			<div class="col-md-2">';
							rows_data +='				<p class="m-0">อันดับ</p>';
							rows_data +='				<div class="item_value">'+(rank)+'</div>';
							rows_data +='			</div>';
							rows_data +='			<div class="col-md-7">';
							rows_data +='				<p class="m-0">โรงแรม</p>';
							rows_data +='				<div class="item_value">'+data[index].member_name+'</div>';
							rows_data +='			</div>';
							rows_data +='			<div class="col-md-3">';
							rows_data +='				<p class="m-0">คะแนน(%)</p>';
							rows_data +='				<div class="item_value">'+data[index].member_score+'</div>';
							rows_data +='			</div>';
							rows_data +='		</div>';
							rows_data +='	</div>';
							if(data[index].member_lat!=null && data[index].member_lon!=null){
								const marker = L.marker([data[index].member_lat, data[index].member_lon], {
									icon: L.divIcon({
										className: "my-custom-pin",
										iconSize: [35, 35],
										iconAnchor: [0, 0],
										labelAnchor: [0, 0],
										popupAnchor: [17, 0],
										html: '<div class="pin '+getColor(data[index].member_score)+'"></div>'
									})
								});
								marker.on("click", () => {
									currentMember = data[index];
									showDisplayPopup();
								});
								markers.addLayer(marker);	
								markers.addTo(map);
							}
						}
						$("#hotel_list").fadeOut(400, function() {
							$(this).html(rows_data).fadeIn(400);
						});
						//$('#hotel_list').html(rows_data);
					}
				});
			}
			
			function getColor(number){
				var color ='';
				if(number<=0){
					color = 'pin0';
				}else if(number>0 && number<=20){
					color = 'pin1';
				}else if(number>20 && number<=40){
					color = 'pin2';
				}else if(number>40 && number<=60){
					color = 'pin3';
				}else if(number>60 && number<=80){
					color = 'pin4';
				}else if(number>80 && number<=100){
					color = 'pin5';
				}
				return color;
			}
	
			function showDisplayPopup(){
				var sw_type =  $( ".sectorData" ).find( ".active" ).attr("data-type");
				var url = '<?=base_url()?>main/radarChart?sw_type='+sw_type+'&member_id='+currentMember.member_id;
				if(currentMember.member_id){
					$.fancybox.open({
						href : url,
						type : 'iframe',
						width : sw_type=='exam'?550:900,
						autoSize: true,
						helpers   : { 
						   overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
						}
					});
				}
				
			}

			$(function () {
				
				var event_list = $('.event_list');
					if (event_list.children().length > 1) {
					event_list.owlCarousel({
						items: 1,
						loop: true,
						margin: 30,
						dots:false,
						nav:false,
						navText:['<i class="lnr lnr-arrow-left"></i>','<i class="lnr lnr-arrow-right"></i>'],
						autoplay: true,
						stagePadding: 0,
						smartSpeed: 700,
						autoplayTimeout:10000
					});
				}
				
				var new_list = $('.new_list');
					if (new_list.children().length > 1) {
					new_list.owlCarousel({
						items: 3,
						loop: true,
						margin: 30,
						dots:false,
						nav:false,
						navText:['<i class="lnr lnr-arrow-left"></i>','<i class="lnr lnr-arrow-right"></i>'],
						autoplay: true,
						stagePadding: 0,
						smartSpeed: 900,
						autoplayTimeout:2000
					});
				}
		
				$('.odometer').each(function () {
				  var $this = $(this);
				  jQuery({ Counter: 0 }).animate({ Counter: $(this).attr("data-count") }, {
					duration: 3000,
					easing: 'swing',
					step: function () {
						$this.text(Math.ceil(this.Counter));
					}
				  });
				});

				loadMarker();
				
				$('.sw_type').on('click',function(){
					$('.sw_type').removeClass("active")
					$(this).addClass("active");
					loadMarker();
				});
			});
			
		</script>