		<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
		<?php $action = $this->session->userdata('noti_action');?>
		<div class="page-title-area jarallax">
            <div class="container">
                <div class="page-title-content">
                    <ul>
                        <li><a href="<?=base_url()?>">หน้าหลัก</a></li>
                        <li>ติดต่อเรา</li>
                    </ul>
                    <h2>ติดต่อเรา</h2>
                </div>
            </div>
        </div>

		<section class="contact-info-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box mb-30">
                            <div class="icon">
                                <i class="bx bx-envelope"></i>
                            </div>

                            <h3>อีเมล์โครงการ</h3>
                            <p><a href="mailto:hello@raque.com">hello@raque.com</a></p>
                            <p><a href="mailto:raque@hello.com">raque@hello.com</a></p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info-box mb-30">
                            <div class="icon">
                                <i class="bx bx-map"></i>
                            </div>

                            <h3>ที่อยู่ที่สามารถติดต่อได้</h3>
                            <p><a href="https://goo.gl/maps/Mii9keyeqXeNH4347" target="_blank">2750 Quadra Street Victoria Road, New York, USA</a></p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                        <div class="contact-info-box mb-30">
                            <div class="icon">
                                <i class="bx bx-phone-call"></i>
                            </div>

                            <h3>หมายเลขโทรศัพท์</h3>
                            <p><a href="tel:1234567890">+123 456 7890</a></p>
                            <p><a href="tel:2414524526">+241 452 4526</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="particles-js-circle-bubble-2"><canvas class="particles-js-canvas-el" style="width: 100%; height: 100%;" width="1903" height="438"></canvas></div>
        </section>
		
		<section class="contact-area pb-100" style="padding-top:10px;">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title">ติดต่อเรา</span>
                    <h2>แบบฟอร์มติดต่อเรา</h2>
                    <p>ท่านสามารถกรอกข้อมูลตามแบบฟอร์มนี้ เพื่อติดต่อเจ้าหน้าที่ดูแลเว็บไซต์</p>
                </div>

                <div class="contact-form">
					<?php if($action['dialog_view']=="dialog_success"){?>
								
									<div class="text-center alert alert-success">
										<h3>Success!</h3> The message has been sent
										<p><a href="<?=base_url()?>">back to homepage</a></p>
									</div>
								
							<?php }else{?>
                    <form id="contactForm" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="contact_name" id="contact_name" class="form-control" required placeholder="ชื่อ - นามสกุล">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="email" name="contact_email" id="contact_email" class="form-control" required placeholder="อีเมล์สำหรับติดต่อกลับ">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" name="contact_subject" id="contact_subject" required class="form-control" placeholder="หัวข้อการติดต่อ">
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="contact_message" class="form-control" id="contact_message"  rows="5" require placeholder="รายละเอียด"></textarea>
                                </div>
                            </div>
							
							<div class="col-lg-6 col-md-12">
                                <div class="form-group has-error">
                                   <div class="g-recaptcha" data-sitekey="6LctcV8UAAAAAMLFuMra0lGAGSP2Qn3Q60DmAd5I"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 text-end">
                                <button type="submit" class="default-btn" style="pointer-events: all; cursor: pointer;"><i class="bx bx-paper-plane icon-arrow before"></i><span class="label">ส่งข้อความติดต่อ</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
							<?php }?>
                </div>
            </div>

            <div id="particles-js-circle-bubble-3"><canvas class="particles-js-canvas-el" style="width: 100%; height: 100%;" width="1903" height="815"></canvas></div>
            <div class="contact-bg-image"><img src="/template/img/map.png" alt="image"></div>
        </section>
		
		<div id="map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3776.8559032218704!2d98.955106!3d18.804574!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd393197b614f8352!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiK4Li14Lii4LiH4LmD4Lir4Lih4LmI!5e0!3m2!1sth!2sth!4v1645412223293!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
		</div>
		<?php $this->session->unset_userdata('noti_action');?>