<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	 
	public function __construct()
	{
		parent::__construct();
		$this->load->library('GoogleAuthenticator');
		$this->load->library('form_validation');
		$this->load->helper('security');
		
		$this->load->model('app_model');
		/*check session*/
        if($this->uri->segment(2)!="login"){
        	if($this->session->userdata('member_logged_in')==""){
         		redirect('auth/login');
      	  	}else{
				if($this->uri->segment(2)!="change_pwd"){
					$this->chk_pwd($this->session->userdata('member_logged_in')['m_user']);
				}
			}
        }
	}
	
	public function test_send_message(){
		$to      = 'aunkaffpom@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: webmaster@example.com'       . "\r\n" .
					 'Reply-To: webmaster@3e.world' . "\r\n" .
					 'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	}
	
	function chk_pwd($member_username){
		$rs = $this->app_model->getMemberDetail($member_username);
		if($rs->member_lastlogin=="0000-00-00 00:00:00"){
			echo '<script>alert("การเข้าสู่ระบบครั้งแรก ระบบบังคับให้เปลี่ยนรหัสผ่านเพื่อความปลอดภัยของบัญชีผู้ใช้");window.location="'.base_url('dashboard/change_pwd/').'";</script>';
			exit();
		}
	}
	
	public function index()
	{
		$member = $this->session->userdata('member_logged_in');
		$data = array(
			'menu'	=> 'index',
			'menu_sub'	=> '',
			'view'	=> 'dashboard'
		);

		$this->load->view('dashboard/template_main', $data);
	}
	
	function do_action($ar){
		$rs = $this->app_model->saveActivityLog($ar);
	}
	
	function getUseraAgent(){
		$this->load->library('user_agent');
		if ($this->agent->is_browser()){
			$agent = $this->agent->browser().' '.$this->agent->version();
		}elseif ($this->agent->is_robot()){
			$agent = $this->agent->robot();
		}elseif ($this->agent->is_mobile()){
			$agent = $this->agent->mobile();
		}else{
			$agent = 'Unidentified User Agent';
		}
		return $agent.' '.$this->agent->platform();
	}
	
	public function profile(){
		$member = $this->session->userdata('member_logged_in');
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($member['m_user']==$ar['member_username']){
				$rs = $this->app_model->updateProfile($ar);
				
				$sess_array = array(
					'm_user' => $rs[0]->member_username,
					'm_name' => $rs[0]->member_name,
					'm_position' => $rs[0]->member_position,
					'm_img' => $rs[0]->member_img,
					'm_level' => $rs[0]->member_level,
					'm_email' => $rs[0]->member_email,
					'm_factor'	=> $rs[0]->member_secret!=null? 1 : 0
				);
				$this->session->set_userdata('member_logged_in', $sess_array);
				$this->session->set_userdata('update_status', 1);
				
			
				$ar = array(
					'log_member_username'	=> $member['m_user'],
					'log_action'			=> 'อัพเดท ข้อมูลโปรไฟล์',
					'log_ua'				=> $this->getUseraAgent(),
					'log_datetime'			=> date('Y-m-d H:i:s')
				);
				$this->do_action($ar);
				redirect('dashboard/profile');
			}
		}
		$data = array(
			'view'	=> 'profile'
		);
		$this->load->view('dashboard/template_main', $data);
	}
	
	public function member(){
		$member = $this->session->userdata('member_logged_in');
		if($member['m_level']==3){
			if($this->input->post()!=null){
				$ar = $this->input->post();
				if($ar['member_action']=="update"){
					unset($ar['member_action']);
					$es = $this->app_model->updateMember($ar);
					if($es!=null){
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/member/').'";</script>';
						exit();
					}else{
						echo '<script>alert("เกิดข้อผิดพลาด");window.location="'.base_url('dashboard/member/').'";</script>';
						exit();
					}
				}else{
					unset($ar['member_action']);
					$es = $this->app_model->insertMember($ar);
					if($es!=null){
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/member/').'";</script>';
						exit();
					}else{
						echo '<script>alert("เกิดข้อผิดพลาด");window.location="'.base_url('dashboard/member/').'";</script>';
						exit();
					}
				}
				
			}else{
				$view = 'member';
				$rs = array();
				if($this->uri->segment(3)=="add"){
					$view = 'member_form';
				}else if($this->uri->segment(3)=="edit"){
					$view = 'member_form';
					$rs = $this->app_model->getMemberDetailW($this->uri->segment(4), $this->uri->segment(5));
				}
				$data = array(
					'rsList'	=>$this->app_model->getMemberListAll(),
					'view'		=> $view,
					'rs'		=> $rs,
					'menu'		=> 'member'
				);
				$this->load->view('dashboard/template_main', $data);
			}
		}else{
			redirect('dashboard');
		}
	}
	
	public function change_pwd(){
		$member = $this->session->userdata('member_logged_in');
		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			if($member['m_user']==$ar['member_username']){
				$ar['member_password_o'] = md5(sha1($ar['member_password_o']));
				$ar['member_password_n'] = md5(sha1($ar['member_password_n']));
				unset($ar['member_password_c']);
				$rs = $this->app_model->changePwd($ar);
				if($rs){
					$this->session->set_userdata('update_status', 1);
					$ar = array(
						'log_member_username'	=> $member['m_user'],
						'log_action'			=> 'เปลี่ยนรหัสผ่านสำเร็จ',
						'log_ua'				=> $this->getUseraAgent(),
						'log_datetime'			=> date('Y-m-d H:i:s')
					);
					$this->do_action($ar);
				}else{
					$ar = array(
						'log_member_username'	=> $member['m_user'],
						'log_action'			=> 'เปลี่ยนรหัสผ่านไม่สำเร็จ',
						'log_ua'				=> $this->getUseraAgent(),
						'log_datetime'			=> date('Y-m-d H:i:s')
					);
					$this->do_action($ar);
					$this->session->set_userdata('update_status', 2);
				}
				redirect('dashboard/change_pwd');
			}
		}
		$data = array(
			'view'	=> 'changepwd'
		);
		$this->load->view('dashboard/template_main', $data);
	}
	
	public function two_factor(){
		$member = $this->session->userdata('member_logged_in');

		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			$oneCode = $this->googleauthenticator->getCode($this->session->userdata('s_secret'));
			if($oneCode==$ar['otp']){
				$ar_post = array(
					'member_username' => $member['m_user'],
					'member_secret' => $this->session->userdata('s_secret')
				);
				$rs = $this->app_model->updateProfile($ar_post);
				
				$ar = array(
					'log_member_username'	=> $member['m_user'],
					'log_action'			=> 'เปิดใช้งาน 2 factor สำเร็จแล้ว',
					'log_ua'				=> $this->getUseraAgent(),
					'log_datetime'			=> date('Y-m-d H:i:s')
				);
				$this->do_action($ar);
				
				$sess_array = array(
					'm_user' => $rs[0]->member_username,
					'm_name' => $rs[0]->member_name,
					'm_position' => $rs[0]->member_position,
					'm_img' => $rs[0]->member_img,
					'm_level' => $rs[0]->member_level,
					'm_email' => $rs[0]->member_email,
					'm_factor'	=> $rs[0]->member_secret!=null? 1 : 0
				);
				$this->session->set_userdata('member_logged_in', $sess_array);
				
			}
			
		}
		$data = array(
			'secret'	=> $this->session->userdata('s_secret'),
			'qrcode'	=> $this->googleauthenticator->getQRCodeGoogleUrl('3E', $member['m_user'], $this->session->userdata('s_secret')),
			'view'		=> 'two_factor'
		);
		$this->load->view('dashboard/template_main', $data);
	}
	
	/****************************************************/
	function getMonthName($number){
		$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		return $MONTH[$number];
	}
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function gen3digit($number){
		if($number<10){
			return '00'.$number;
		}else if($number<100){
			return '0'.$number;
		}else{
			return $number;
		}
	}
	
	function rmComma($number){
		return  str_replace(',', '', $number);
	}
	
	function getInsertID(){
		return $this->generateRandomString(4).date('ymdHis').$this->generateRandomString(4);
	}
	
	function convert($number) {
		$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
		$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
		$number = str_replace(",","",$number);
		$number = str_replace(" ","",$number);
		$number = str_replace("บาท","",$number);
		$number = explode(".",$number);
		if(sizeof($number)>2){
			return 'ทศนิยมหลายตัวนะจ๊ะ';
			exit;
		}
		$strlen = strlen($number[0]);
		$convert = '';
		for($i=0;$i<$strlen;$i++){
			$n = substr($number[0], $i,1);
			if($n!=0){
				if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
				elseif($i==($strlen-2) AND $n==2){ $convert .= 'ยี่'; }
				elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
				else{ $convert .= $txtnum1[$n]; }
				$convert .= $txtnum2[$strlen-$i-1];
			}	
		}
		$convert .= 'บาท';
		if($number[1]=='0' OR $number[1]=='00' OR $number[1]==''){
			$convert .= 'ถ้วน';
		}else{
			$strlen = strlen($number[1]);
			for($i=0;$i<$strlen;$i++){
				$n = substr($number[1], $i,1);
				if($n!=0){
					if($i==($strlen-1) AND $n==1){$convert .= 'เอ็ด';}
					elseif($i==($strlen-2) AND $n==2){$convert .= 'ยี่';}
					elseif($i==($strlen-2) AND $n==1){$convert .= '';}
					else{ $convert .= $txtnum1[$n];}
					$convert .= $txtnum2[$strlen-$i-1];
				}
			}
			$convert .= 'สตางค์';
		}
		return $convert;
	}
	
	function send_email($message, $target){
		$this->load->library('email');
		$this->email->from('noreply.33@gmail.com', 'noreply');
		$this->email->to($target);
		$this->email->subject('3E : เอกสารเข้า');
		$this->email->message($message);
		$this->email->send();
	}
	
	public function post_advance(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			$this->session->set_userdata('advance_m', $ar['sel_month']);
			$this->session->set_userdata('advance_y', $ar['sel_year']);
			redirect('dashboard/'.$ar['uri']);
			
		}
	}
	
	public function post_project(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			$this->session->set_userdata('project_type', $ar['sel_type']);
			$this->session->set_userdata('project_year', $ar['sel_year']);
			redirect('dashboard/'.$ar['sel_uri']);
		}
	}
	
	
	
	public function advance(){
		$member = $this->session->userdata('member_logged_in');
		$view = 'advance';
		$advance_code = date('Y-m').'-'.$this->gen3digit(($this->app_model->getAdvanceAmount()+1));
		$advance_id = $this->generateRandomString(4).date('ymdHis').$this->generateRandomString(4);
		$rs = array();
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if(@$ar['advance_id']!=null){ //update
				
				if($member['m_level']==1){ //normal member is check verify
					if(@$ar['member_username']==$member['m_user']){
			
						$ar['advance_member_username'] = $ar['member_username'];
						$ar['advance_updatedate'] = date('Y-m-d H:i:s');	
						$ar['advance_detail'] = @json_encode($ar['advance_detail']);
						$ar['advance_refunds_price'] = $this->rmComma($ar['advance_refunds_price']);
						unset($ar['member_username']);
						$rs = $this->app_model->updateAdvance($ar);
						
						$ar = array(
							'log_member_username'	=> $member['m_user'],
							'log_action'			=> 'แก้ไข ขอยืมทดรองจ่ายใหม่ เลขที่ '.$ar['advance_code'],
							'log_ua'				=> $this->getUseraAgent(),
							'log_datetime'			=> date('Y-m-d H:i:s')
						);
						$this->do_action($ar);
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance/').'";</script>';
						exit();
						
					}else{
						echo '<script>alert("เกิดข้อผิดพลาด ไม่สามารถแก้ไขเอกสารนี้ได้");window.location="'.base_url('dashboard/advance/').'";</script>';
						exit();
					}	
				}else if($member['m_level']==2){
					if(@$ar['member_username']==$member['m_user']){
						$ar['advance_member_username'] = $ar['member_username'];
						$ar['advance_updatedate'] = date('Y-m-d H:i:s');	
						$ar['advance_detail'] = @json_encode($ar['advance_detail']);
						$ar['advance_refunds_price'] = $this->rmComma($ar['advance_refunds_price']);
						unset($ar['member_username']);
						$rs = $this->app_model->updateAdvance($ar);
						
					}
					$ar_post = array(
						'advance_verify_is'=> $ar['advance_verify_is'],
						'advance_verrify_username'=> $ar['advance_member_username'],
						'advance_verrify_datetime'=> date('Y-m-d H:i:s'),
						'advance_id'=> $ar['advance_id'],
						'advance_code'=> $ar['advance_code'],
					);

					$rs = $this->app_model->updateVerifyAdvance($ar_post);
					if($ar['advance_verify_is']==1){
						$ar = array(
							'log_member_username'	=> $member['m_user'],
							'log_action'			=> 'บัญชีตรวจสอบ ขอยืมทดรองจ่ายใหม่ เลขที่ '.$ar['advance_code'],
							'log_ua'				=> $this->getUseraAgent(),
							'log_datetime'			=> date('Y-m-d H:i:s')
						);
						$this->do_action($ar);
					}
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance/').'";</script>';
					exit();
					
				}else if($member['m_level']==3){
					$ar['advance_is_pay_username'] = $ar['member_username'];
					$ar['advance_is_pay_datetime'] = date('Y-m-d H:i:s');	
					unset($ar["member_username"]);
					unset($ar["advance_verify_is"]);
					$rs = $this->app_model->updateVerifyAdvance($ar);
					if(@$ar['advance_approve_is']==1){
						$ar = array(
							'log_member_username'	=> $member['m_user'],
							'log_action'			=> 'อนุมัติจ่ายเงิน ขอยืมทดรองจ่ายใหม่ เลขที่ '.$ar['advance_code'],
							'log_ua'				=> $this->getUseraAgent(),
							'log_datetime'			=> date('Y-m-d H:i:s')
						);
						$this->do_action($ar);
					}
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance/').'";</script>';
					exit();
					
				}
			}else{ //insert
				
				$ar['advance_code'] = $advance_code;
				$ar['advance_member_username'] = $ar['member_username'];
				$ar['advance_createdate'] = date('Y-m-d H:i:s');
				$ar['advance_updatedate'] = date('Y-m-d H:i:s');
				$ar['advance_id'] = $advance_id;
				$ar['advance_detail'] = @json_encode($ar['advance_detail']);
				$ar['advance_member_username'] = $member['m_user'];
				unset($ar['member_username']);
				$rs = $this->app_model->createAdvance($ar);
				if($rs!=null){
					$ar = array(
						'log_member_username'	=> $member['m_user'],
						'log_action'			=> 'สร้าง ขอยืมทดรองจ่ายใหม่ เลขที่ '.$ar['advance_code'],
						'log_ua'				=> $this->getUseraAgent(),
						'log_datetime'			=> date('Y-m-d H:i:s')
					);
					$this->do_action($ar);
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance/').'";</script>';
					exit();
				}
			}		
		}else{
			if($this->uri->segment(3)=="del"){
				$rs = $this->app_model->delAdvance($this->uri->segment(4), $member);
				if($rs!=null){
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance/').'";</script>';
					exit();
				}
			}else if($this->uri->segment(3)=="add"){
				$view = 'advance_form';
			}else if($this->uri->segment(3)=="edit"){
				$view = 'advance_form';
				$rs = $this->app_model->getAdvanceDetail($this->uri->segment(4), $member);
				if($member['m_level']==1){
					
					if($rs[0]->advance_verify_is==1 || $rs[0]->advance_is_pay==1){
						$view = 'advance_form_up';
					//	echo '<script>alert("ไม่สามารถแก้ไข ใบขอยืมทดลองจ่ายได้ เนื่องจากบัญชีตรวจสอบข้อมูลแล้ว");window.location="'.base_url('dashboard/advance/').'";</script>';
					//	exit();
					}
				}else{
					if($rs[0]->advance_is_pay==1){
						$view = 'advance_form_up';
					}else{
						if($rs[0]->advance_member_username==$member['m_user']){
							$view = 'advance_form';
						}else{
							$view = 'advance_form_up';
						}
					}
					
				}
			}else if($this->uri->segment(3)=="print"){
				$rs = $this->app_model->getAdvanceDetail($this->uri->segment(4), $member);
				//if($rs[0]->advance_verify_is==1){
					$this->test_pdf($rs);
				//}else{
				//	echo '<script>alert("ไม่สามารถปริ้น ใบขอยืมทดลองจ่ายได้ เนื่องจากบัญชียังไม่ได้ตรวจสอบข้อมูล");window.location="'.base_url('dashboard/advance/'.$this->uri->segment(4)).'";</script>';
				//	exit();
				//}
			}else if($this->uri->segment(3)=="print_clear"){
				$rs = $this->app_model->getAdvanceClearDetail($this->uri->segment(4), $member);

				if($rs[0]->advance_clear_id){
					$this->advance_clear_pdf($rs);
				}else{
					echo '<script>alert("ไม่สามารถปริ้น เนื่องจากยังไม่ได้เคลียร์บัญชี");window.location="'.base_url('dashboard/advance/'.$this->uri->segment(4)).'";</script>';
					exit();
				}
			}
		}
		$advance_m = $this->session->userdata('advance_m');
		$advance_y = $this->session->userdata('advance_y');
		$data = array(
			'rs'			=> $rs,
			'rsList'		=> $this->app_model->getAdvanceList($member,$advance_m,$advance_y),
			'advance_code'	=> $advance_code,
			'menu'			=> 'advance',
			'menu_sub'		=> 'advance',
			'view'			=> $view
		);

		$this->load->view('dashboard/template_main', $data);
	}
	
	public function advance_summary(){
		$member = $this->session->userdata('member_logged_in');
		if($member['m_level']>1){
			$template = 'template_main';
			$advance_m = $this->session->userdata('advance_m');
			$advance_y = $this->session->userdata('advance_y');
			$data = array(
				'rsList'		=> $this->app_model->getAdvanceList($member,$advance_m,$advance_y),
				'advance_m'		=> $advance_m,
				'advance_y'		=> $advance_y,
				'menu'			=> 'advance',
				'menu_sub'		=> 'advance_summary',
				'view'			=> 'advance_summary'
			);
			if($this->uri->segment(3)=="print"){
				$this->advance_summary_print();
				exit;
			}
			if($this->uri->segment(3)=="export"){
				$template = 'advance_summary_export';
			}
			//advance_summary_print
			$this->load->view('dashboard/'.$template, $data);
		}else{redirect('dashboard');}
	}

	public function advance_clear(){
		$member = $this->session->userdata('member_logged_in');
		if($this->uri->segment(3)!=null){
			$advance_id = $this->uri->segment(3);
			$rs = $this->app_model->getAdvanceDetail($advance_id, $member);
			if($rs!=null){
				if($this->input->post()!=null){
					$ar = $this->input->post();
					
					$ar['advance_clear_real_money'] = rmComma($ar['advance_clear_real_money']);

					$rs=$this->app_model->updateAdvanceClear($ar, $member);
					
					$ar_log = array(
						'log_member_username'	=> $member['m_user'],
						'log_action'			=> 'อัพเดทเคลียร์บัญชี ขอยืมทดรองจ่ายใหม่  ',
						'log_ua'				=> $this->getUseraAgent(),
						'log_datetime'			=> date('Y-m-d H:i:s')
					);
					$this->do_action($ar_log);
						
					if($member['m_level']==2){
						$ar['advance_clear_verify_username'] = $member['m_user'];
						$ar['advance_clear_verify_datetime'] = $ar['advance_clear_datetime'];
						
						unset($ar['advance_clear_datetime']);
						unset($ar['advance_clear_approve_is']);
						
						$rs = $this->app_model->updateVerifyClearAdvance($ar);
						if($ar['advance_clear_verify_is']==1){
							$ar_log = array(
								'log_member_username'	=> $member['m_user'],
								'log_action'			=> 'ตรวจสอบเคลียร์บัญชี ขอยืมทดรองจ่ายใหม่',
								'log_ua'				=> $this->getUseraAgent(),
								'log_datetime'			=> date('Y-m-d H:i:s')
							);
							$this->do_action($ar_log);
						}
		
						
					}else if($member['m_level']==3){
						
						$ar['advance_clear_approve_username'] = $member['m_user'];
						$ar['advance_clear_approve_datetime'] = $ar['advance_clear_datetime'];
						
						unset($ar['advance_clear_datetime']);
						$rs = $this->app_model->updateVerifyClearAdvance($ar);
						if($ar['advance_clear_approve_is']==1){
							$ar_log = array(
								'log_member_username'	=> $member['m_user'],
								'log_action'			=> 'อนุมัติจ่ายเงิน เคลียร์บัญชี ขอยืมทดรองจ่ายใหม่',
								'log_ua'				=> $this->getUseraAgent(),
								'log_datetime'			=> date('Y-m-d H:i:s')
							);
							$this->do_action($ar_log);
						}
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance/').'";</script>';
						exit();
				
					}
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/advance_clear/'.$ar['advance_id']).'";</script>';
					exit();
	
				}else{
					$rsClear = $this->app_model->getAdvanceClearDetail($advance_id,$member);
					
					$view = 'advance_clear';
					if($rsClear[0]->advance_clear_verify_is==1){
						
						$view = 'advance_clear_up';
					}
					
					if($member['m_level']>2){
						$view = 'advance_clear_up';
					}
					
					
					$data = array(
						'rs'			=> $rs,
						'rsClear'		=> $rsClear,
						'menu'			=> 'advance',
						'menu_sub'		=> 'advance',
						'view'			=> $view
					);

					$this->load->view('dashboard/template_main', $data);
				}
			}else{redirect('dashboard/advance');}
		}else{redirect('dashboard/advance');}
	}
	
	public function document_transfer(){
		$member = $this->session->userdata('member_logged_in');
	
		$do = $this->uri->segment(3);
		$rsList = $this->app_model->getDocumentTransfer($do == 'receive' || $do == 'export' ? $do : 'receive');
		$r_receive = (date('Y')+543).'/'.$this->gen3digit($this->app_model->getDocumentTransferCount('receive')+1);
		$r_export = 'พศน. '.(date('Y')+543).'/'.$this->gen3digit($this->app_model->getDocumentTransferCount('export')+1);
		//echo $r_export;
		//exit;
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if(@$ar['transfer_id']!=null){
				//update check user permissions	
				if($member['m_level']==3){ //approve only
				
					$ar_post['transfer_approve_username'] = $member['m_user'];
					$ar_post['transfer_approve_date'] = date('Y-m-d H:i:s');
					$ar_post['transfer_id'] = $ar['transfer_id'];
					$ar_post['transfer_approve'] = $ar['transfer_approve'];
					$transfer_type = $ar['transfer_type'];
					
					$rs = $this->app_model->updateNewDocumentTransfer($ar_post);
					if($ar['transfer_approve']==1){
						$ar = array(
							'log_member_username'	=> $member['m_user'],
							'log_action'			=> 'อนุมัติ เอกสารเข้า/ออก ',
							'log_ua'				=> $this->getUseraAgent(),
							'log_datetime'			=> date('Y-m-d H:i:s')
						);
						$this->do_action($ar);
					}
					//if($rs!=null){transfer_date
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/document_transfer/'.$transfer_type).'";</script>';
						exit();
					//}
				}else if($member['m_level']==2){
					if($ar['transfer_type']=="receive"){
						$ar['transfer_responsible'] = json_encode($ar['transfer_responsible']);
					}
					
					
					$rs = $this->app_model->updateNewDocumentTransfer($ar);
					if ($this->upload_files_doc($ar, $_FILES['transfer_files']) === FALSE) {
						echo 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง อัพไฟล์ pdf|gif|jpg|png|docx เท่านั้น';
						
					}else{
						//echo 'อัพโหลดเรียบร้อย';
					}
					//if($rs!=null){
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/document_transfer/'.$ar['transfer_type']).'";</script>';
						exit();
					//}
				}
			}else{
				//insert new paper
				$ar['transfer_id'] = $this->getInsertID();
				if($ar['transfer_type']=="export"){
					$ar['transfer_code'] = $r_export;
				}else if($ar['transfer_type']=="receive"){
					$ar['transfer_code'] = $r_receive;
				}
				$ar["transfer_member_username"] = $member['m_user'];
				$ar["transfer_createdate"] = date('Y-m-d H:i:s');
				
				$ar['transfer_responsible'] = json_encode($ar['transfer_responsible']);
				$ar['transfer_date'] = decode_date($ar['transfer_date']);
				$memberz = json_decode($ar['transfer_responsible']);
				
				$rs = $this->app_model->insertNewDocumentTransfer($ar);
				if($rs!=null){
					if ($this->upload_files_doc($ar, $_FILES['transfer_files']) === FALSE) {
						echo 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง อัพไฟล์ pdf|gif|jpg|png|docx เท่านั้น';
						
					}else{
						//echo 'อัพโหลดเรียบร้อย';
					}
				}

				$ar_post = array(
					'log_member_username'	=> $member['m_user'],
					'log_action'			=> 'สร้าง เอกสารเข้า/ออก '.$ar['transfer_code'],
					'log_ua'				=> $this->getUseraAgent(),
					'log_datetime'			=> date('Y-m-d H:i:s')
				);
				$this->do_action($ar_post);
					
				if($rs!=null){
					
					if($ar['transfer_type']=="receive"){
						$ar['transfer_code'] = $r_receive;
						$ar_cat = array('','หนังสือแจ้ง/นำส่ง','ใบเสนอราคา', 'ใบแจ้งหนี้', 'ใบเสร็จรับเงิน', 'อื่นๆ');
						foreach($memberz as $val){
							$rsTransfer_responsible = $this->app_model->getMemberEmail($val);
							if($rsTransfer_responsible->member_email!=null){
								$message ='เรียน คุณ<b>'.$rsTransfer_responsible->member_name.'</b><br/><br/>';
								$message .='มีเอกสารเข้า  <b>เลขทะเบียนรับ '.$ar['transfer_code'].'</b> ส่งถึงท่าน รายละเอียด<br/><br/>';
								$message .='<table>';
								$message .='<tbody>';
								$message .='<tr>';
								$message .='<td>เลขทะเบียนรับ</td>';
								$message .='<td>: '.$ar['transfer_code'].'</td>';
								$message .='</tr>';
								
								$message .='<tr>';
								$message .='<td>เลขที่เอกสาร</td>';
								$message .='<td>: '.$ar['transfer_no'].'</td>';
								$message .='</tr>';
								
								$message .='<tr>';
								$message .='<td>เรื่อง</td>';
								$message .='<td>: '.$ar['transfer_title'].'</td>';
								$message .='</tr>';
								
								$message .='<tr>';
								$message .='<td>ประเภทเอกสาร</td>';
								$message .='<td>: '.$ar_cat[$ar['transfer_category_id']].'</td>';
								$message .='</tr>';
								
								$message .='<tr>';
								$message .='<td>จาก</td>';
								$message .='<td>: '.$ar['transfer_form'].'</td>';
								$message .='</tr>';
								
								$message .='<tr>';
								$message .='<td>ถึง</td>';
								$message .='<td>: '.$ar['transfer_to'].'</td>';
								$message .='</tr>';
								
								$message .='</tbody>';
								$message .='</table>';
		
								$message .='<br/><br/><p>***อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบโดยอัตโนมัติ กรุณาอย่าตอบกลับ<br/><i>หน่วยวิจัยเพื่อการจัดการพลังงานและเศรษฐนิเวศ (3E)</i></p>';
	
								//$this->send_email($message, $rsTransfer_responsible->member_email);
							}
						}
						
					}
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/document_transfer/').'";</script>';
					exit();
				}
			}
				
		}else{
				$rs = array();
				$view = 'document_transfer';
				if($do=="del"){
				
				}else if($do=="add"){
					$view = 'document_transfer_form';
				}else if($do=="edit"){
					
				}
				
				$data = array(
					'rs'			=> $rs,
					'rsList'		=> $rsList,
					'rsCat'			=> $this->app_model->getTransfetCategory(),
					'r_receive'		=> $r_receive,
					'r_export'		=> $r_export,
					'memberList'	=> $this->app_model->getMemberList(),
					'menu'			=> 'document_transfer',
					'menu_sub'		=> '',
					'view'			=> $view
				);

				$this->load->view('dashboard/template_main', $data);
		}
	}
	
	public function ajax_history(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			echo json_encode($this->app_model->getActivityLog($member));
		}
		
	}
	
	public function history(){
		$member = $this->session->userdata('member_logged_in');
		$data = array(
			'menu'			=> '',
			'menu_sub'		=> '',
			'view'			=> 'actovity_log',
			'rsList'		=> $this->app_model->getActivityLog($member)
		);
		$this->load->view('dashboard/template_main', $data);
	}
	
	public function project(){
		$member = $this->session->userdata('member_logged_in');
		$project_year = $this->session->userdata('project_year');
		$project_type = $this->session->userdata('project_type');
		$do = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$view = 'project';
		$rs = array();
		$rsFile = array();
		if($this->input->post()!=null){
			$ar = $this->input->post();

	
			if(@$ar['project_signdate']!=null){$ar['project_signdate'] = decode_date(@$ar['project_signdate']);}else{$ar['project_signdate']=date('Y-m-d');}
			if(@$ar['project_enddate']!=null){$ar['project_enddate'] = decode_date(@$ar['project_enddate']);}else{$ar['project_enddate']=date('Y-m-d');}
			if(@$ar['project_startdate']!=null){$ar['project_startdate'] = decode_date(@$ar['project_startdate']);}else{$ar['project_startdate']=date('Y-m-d');}
			if(@$ar['project_status_ic_date']!=null){$ar['project_status_ic_date'] = decode_date(@$ar['project_status_ic_date']);}else{$ar['project_status_ic_date']=date('Y-m-d');}
			if(@$ar['project_status_success_date']!=null){$ar['project_status_success_date'] = decode_date(@$ar['project_status_success_date']);}else{$ar['project_status_success_date']=date('Y-m-d');}
				
		
			if($member['m_level']==3){
				if(@$ar['project_status_success_date']!=null){$ar['project_status_success_date'] = decode_date(@$ar['project_status_success_date']);}else{$ar['project_status_success_date']=date('Y-m-d');;}
			}
			if($ar['project_id']!=null){
				
				$this->session->set_userdata('tab_select', $ar['tab_select']);
				$ar['project_pre'] = json_encode($ar['pre']);
				$ar['project_budget'] = rmComma($ar['project_budget']);
				$ar['project_doing'] = json_encode($ar['doing']);
				$ar['project_done'] = json_encode($ar['done']);
				$ar['project_member_permission'] = json_encode($ar['project_member_permission']);
				unset($ar['pre']);
				unset($ar['doing']);
				unset($ar['tab_select']);
				unset($ar['done']);
				unset($ar['project_create_member_username']);
				
				$rs = $this->app_model->updateProject($ar, $member);

				if($rs!=null){
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/project/edit/'.$ar['project_id']).'";</script>';
					exit();
				}else{
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/project/edit/'.$ar['project_id']).'";</script>';
					exit();
				}
			}else{
				//insert
				$ar['project_id'] = $this->getInsertID();
				$ar['is_active'] = 1;
				$ar['project_createdate'] = date('Y-m-d H:i:s');
				$ar['project_budget'] = rmComma($ar['project_budget']);
				$ar['project_member_permission'] = json_encode($ar['project_member_permission']);
				$rs = $this->app_model->insertProject($ar);
				if($rs!=null){
					echo '<script>window.location="'.base_url('dashboard/project/edit/'.$ar['project_id']).'";</script>';
					exit();
				}
			}
		}else{
			$template = 'template_main';
			if($do=="del"){
				
				$rs = $this->app_model->getProjectDetail($id, $member);
				
				if($rs==null){
					echo '<script>alert("คุณไม่มีสิทธิเข้าถึงไฟล์เอกสารของโครงการนี้  กรุณาติดต่อเจ้าของโครงการ");window.location="'.base_url('dashboard/project/').'";</script>';
					exit();
				}
				
				$del = $this->app_model->delProject($id, $member);
				if($del!=null){
					echo '<script>alert("ลบโครงการเรียบร้อย!");window.location="'.base_url('dashboard/project/').'";</script>';
					exit();
				}else{
					echo '<script>alert("เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง!");window.location="'.base_url('dashboard/project/').'";</script>';
					exit();
				}
			}else if($do=="edit"){
				$rs = $this->app_model->getProjectDetail($id, $member);
				if($rs==null){
					echo '<script>alert("คุณไม่มีสิทธิเข้าถึงไฟล์เอกสารของโครงการนี้  กรุณาติดต่อเจ้าของโครงการ");window.location="'.base_url('dashboard/project/').'";</script>';
					exit();
				}
				$rsFile = $this->app_model->getProjectDetailFile($rs[0]->project_id);
				$view = 'project_form';
			}else if($do=="add"){
				$view = 'project_form_add';
			}else if($do=="print"){
				$this->project_print_pdf();
			}else if($do=="excel"){
				$template = 'project_excel';
			}
		}
		
		$data = array(
			'menu'			=> 'project',
			'memberList'	=> $this->app_model->getMemberList(),
			'rs'			=> $rs,
			'rsFile'		=> $rsFile,
			'menu_sub'		=> '',
			'view'			=> $view,
			'rsList'		=> $this->app_model->getProjectList($project_year, $project_type)
		);
		$this->load->view('dashboard/'.$template, $data);
		
	}
	
	
	public function project_file(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$project_id = $this->input->get('project_id');
			$project_point = $this->input->get('project_point');
			$rs = $this->app_model->getProjectDetail($project_id, $member);
			if(!$rs){
				echo 'คุณไม่มีสิทธิเข้าถึงไฟล์เอกสารของโครงการนี้';
				exit;
			}
			$data = array(
				'rs'			=> $rs,
				'project_id'	=> $project_id,
				'project_point'	=> $project_point,
				'member'		=> $member
			);
			$this->load->view('dashboard/fancy_upload_file', $data);
		}
	}
	
	public function account_file(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$account_id = $this->input->get('account_id');
			$account_point = $this->input->get('account_point');
			$rs = $this->app_model->getAccountDetail($account_id, $member);
			
			//if($member['m_level']==3 || $member['m_user']=="kittiya" || $member['m_user']=="chindamanee" || $member['m_level']==4){
			if (in_array($member['m_user'], json_decode($rs[0]->account_member_permission))) {	
				$data = array(
					'rs'			=> $rs,
					'account_id'	=> $account_id,
					'account_point'	=> $account_point,
					'member'		=> $member
				);
				$this->load->view('dashboard/fancy_upload_file_account', $data);
			}else{
				echo 'คุณไม่มีสิทธิเข้าถึงไฟล์เอกสารของโครงการนี้';
				exit;
			}
			
		}
	}
	
	public function ajax_projectfile(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$p_id = $this->input->get('project_id');
			$p_point = $this->input->get('project_point');
			$rsList = $this->app_model->getProjectFileLists($p_id, $p_point, $member);
			echo json_encode($rsList);
		}
	}
	
	public function ajax_accountfile(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$a_id = $this->input->get('account_id');
			$a_point = $this->input->get('account_point');
			$rsList = $this->app_model->getAccountFileLists($a_id, $a_point, $member);
			echo json_encode($rsList);
		}
	}
	
	public function ajax_projectfile_del(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$f_id = $this->input->post('file_id');
			$p_id = $this->input->post('project_id');
			echo $f_id;
			echo $p_id;
			$rs = $this->app_model->delProjectFile($f_id, $p_id, $member);
		}
	}
	
	public function ajax_accountfile_del(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$f_id = $this->input->post('file_id');
			$p_id = $this->input->post('account_id');
			echo $f_id;
			echo $p_id;
			$rs = $this->app_model->delAccountFile($f_id, $p_id, $member);
		}
	}
	
	private function upload_files_doc($ar_post, $files){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf|gif|jpg|png|docx|doc|xlsx|pptx';
		$config['max_size'] = 200000000;
		$config['encrypt_name'] = TRUE;
		$dir = './uploads/';
		$this->load->library('upload', $config);

		$document_file = array();
		
		foreach ($files['name'] as $key => $file) {
			$_FILES['document_file[]']['name']= $files['name'][$key];
			$_FILES['document_file[]']['type']= $files['type'][$key];
			$_FILES['document_file[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['document_file[]']['error']= $files['error'][$key];
			$_FILES['document_file[]']['size']= $files['size'][$key];

			$file_name =$files['name'][$key];
			$fileName =date('YmdHis').md5(rand(100, 200));
			$config['file_name'] = $fileName;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('document_file[]')) {
				$ar = array(
					'file_transfer_id'		=>$ar_post['transfer_id'],
					'file_name'				=>$file_name,
					'file_path'				=>$this->upload->data('file_name'),
					'file_size'				=>$this->upload->data('file_size'),
					'file_createdate'		=>date('Y-m-d H:i:s')
				);

				$id = $this->app_model->addDocumentFile($ar);
			} else {
				return false;
			}
			
		}
	}
		
	private function upload_files($ar_post, $member, $files){
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf|gif|jpg|png|docx|doc|zip|rar|xlsx|pptx';
		$config['max_size'] = 2000000000;
		$config['encrypt_name'] = TRUE;
		$dir = './uploads/';
		$this->load->library('upload', $config);

		$document_file = array();
		
		foreach ($files['name'] as $key => $file) {
			$_FILES['document_file[]']['name']= $files['name'][$key];
			$_FILES['document_file[]']['type']= $files['type'][$key];
			$_FILES['document_file[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['document_file[]']['error']= $files['error'][$key];
			$_FILES['document_file[]']['size']= $files['size'][$key];

			$file_name =$files['name'][$key];
			$fileName =date('YmdHis').md5(rand(100, 200));
			$config['file_name'] = $fileName;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('document_file[]')) {
				$ar = array(
					'file_project_id'		=>$ar_post['project_id'],
					'file_preject_point'	=>$ar_post['project_point'],
					'file_name'				=>$file_name,
					'file_path'				=>$this->upload->data('file_name'),
					'file_size'				=>$this->upload->data('file_size'),
					'file_member_username'	=>$member['m_user'],
					'file_createdate'		=>date('Y-m-d H:i:s')
				);

				$id = $this->app_model->addProjectFile($ar);
			} else {
				return false;
			}
			
		}
			
    }
	
	private function upload_files2($ar_post, $member, $files){
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf|gif|jpg|png|docx|doc|xlsx|xls|zip|rar|pptx';
		$config['max_size'] = 200000000;
		$config['encrypt_name'] = TRUE;
		$dir = './uploads/';
		$this->load->library('upload', $config);

		$document_file = array();
		
		foreach ($files['name'] as $key => $file) {
			$_FILES['document_file[]']['name']= $files['name'][$key];
			$_FILES['document_file[]']['type']= $files['type'][$key];
			$_FILES['document_file[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['document_file[]']['error']= $files['error'][$key];
			$_FILES['document_file[]']['size']= $files['size'][$key];

			$file_name =$files['name'][$key];
			$fileName =date('YmdHis').md5(rand(100, 200));
			$config['file_name'] = $fileName;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('document_file[]')) {
				$ar = array(
					'file_account_id'		=>$ar_post['account_id'],
					'file_account_point'	=>$ar_post['account_point'],
					'file_name'				=>$file_name,
					'file_path'				=>$this->upload->data('file_name'),
					'file_size'				=>$this->upload->data('file_size'),
					'file_member_username'	=>$member['m_user'],
					'file_createdate'		=>date('Y-m-d H:i:s')
				);

				$id = $this->app_model->addAccountFile($ar);
			} else {
				return false;
			}
			
		}
			
    }
	
	public function project_ajax_uploads(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$ar = $this->input->post();
			if ($this->upload_files($ar, $member, $_FILES['files']) === FALSE) {
				echo 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง อัพไฟล์ pdf|gif|jpg|png|docx|zip|rar เท่านั้น';
			}else{
				echo 'อัพโหลดเรียบร้อย';
			}
		}
	}
	
	public function account_ajax_uploads(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$ar = $this->input->post();
			if ($this->upload_files2($ar, $member, $_FILES['files']) === FALSE) {
				echo 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง อัพไฟล์ pdf|gif|jpg|png|docx เท่านั้น';
			}else{
				echo 'อัพโหลดเรียบร้อย';
			}
		}
	}
	
	public function testprint(){
		$this->load->library('pdf');
	}
	
	function project_print_pdf(){
		$project_year = $this->session->userdata('project_year');
		$project_type = $this->session->userdata('project_type');
		$rsList = $this->app_model->getProjectList($project_year, $project_type);
		$ar_type = array(
			'all'=>'โครงการทั้งหมด',
			'pre'=>'โครงการที่ระหว่างยื่นข้อเสนอ',
			'doing'=>'โครงการที่กำลังดำเนินการ',
			'done'=>'โครงการที่ดำเนินการเสร็จแล้ว',
			'research'=>'งานบริการวิชาการ และอื่น ๆ',
			'notbudget'=>'โครงการที่ไม่ได้รับงบประมาณ',
		);
		$title =  $ar_type[$project_type].' ปี '.($project_year+543);
		
		$this->load->library('pdf');
		
			$this->pdf=new FPDF('L','mm','A4');
				
			$this->pdf->AddPage();
			$this->pdf->SetMargins( 20,30,20 );
			$this->pdf->AddFont('THSarabunNew','','THSarabunNew.php');
			$this->pdf->AddFont('THSarabunNew Bold','B','THSarabunNew Bold.php');
			$this->pdf->SetFont('THSarabunNew Bold','B',16);

			$this->pdf->Cell( 0, 10, iconv( 'UTF-8','cp874' , $title  ), 0,0, 'C' );
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->SetFont('THSarabunNew','',11);

			$h = $this->pdf->GetY();
			$h2 = $this->pdf->GetY();
			$i=0;
			$advance_total = 0;
			foreach($rsList as $item){
				$advance_total+=rmComma($item->project_budget);

				$i++;
				if($h2>$h){$h=$h2;}
				$this->pdf->setXY( 10, $h );
				$this->pdf->Cell( 10, 5, iconv( 'UTF-8','cp874' , $i.'. '), 0, 1, 'C');
				$this->pdf->setXY( 20, $h );
				$this->pdf->MultiCell( 180, 5, iconv( 'UTF-8','cp874' , $item->project_name), 0, 1);
				$h2 = $this->pdf->GetY();
				$this->pdf->setXY( 200, $h );
				$this->pdf->Cell( 40, 5, iconv( 'UTF-8','cp874' , $ar_type[$item->project_status]), 0, 1, 'L');
				$this->pdf->setXY( 240, $h );
				$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , number_format($item->project_budget,2)), 0, 1, 'R');
			}
			$this->pdf->SetFont('THSarabunNew Bold','B',11);
			$h3 = $this->pdf->GetY();
			$this->pdf->setXY( 240, $h3 );
			$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , number_format($advance_total,2)), 0, 1, 'R');
			$this->pdf->Output();
	}
	
	function test_pdf($rs){

		$advance_code = $rs[0]->advance_code;
		$advance_name = $rs[0]->member_name;
		$advance_project_name = $rs[0]->advance_project_name;
		$advance_refunds_id = $rs[0]->advance_refunds_id;
		$advance_refunds_price = $rs[0]->advance_refunds_price!=null?$rs[0]->advance_refunds_price:0;
		
		$data = json_decode(@$rs[0]->advance_detail);
		$advance_detail = (array) @$data;
		
		$advance_prict = 0;
		if($advance_detail!=null){
			foreach($advance_detail['list'] as $k=>$v){
				$advance_prict+=$this->rmComma($advance_detail['price'][$k]);
			}
		}

		$this->load->library('pdf');
		
		$this->pdf=new FPDF('P','mm','A4');
			
		$this->pdf->AddPage();
		$this->pdf->SetMargins( 20,30,20 );
		$this->pdf->AddFont('THSarabunNew','','THSarabunNew.php');
		$this->pdf->AddFont('THSarabunNew Bold','B','THSarabunNew Bold.php');
		$this->pdf->SetFont('THSarabunNew','',18);
		$this->pdf->Image('https://apps.3e.world/img/advance_bg2.jpg?v=122', 0, 0, 210, 297, 'JPG');
		
		
		$this->pdf->Cell( 0, 15, '', 0,0, 'C' );
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Cell( 0, 15, iconv( 'UTF-8','cp874' , 'แบบขอยืมเงินทดรองจ่าย' ), 0,0, 'C' );
		$this->pdf->Ln();
		
		$message = '(- '.$this->convert(number_format($advance_prict,2)).' -) เพื่อใช้จ่ายในโครงการ '.$advance_project_name;
		
		
		$this->pdf->SetFont('THSarabunNew','',14);
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , 'เลขที่ '.$advance_code ), 0, 0, 'L' );
		$this->pdf->Ln();
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , ConvertToThaiDate_pdf(date('Y-m-d'),0) ), 0, 0, 'R' );
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , '               ข้าพเจ้า นาย/นาง/นาวสาว    '.$advance_name.'   ขอยืมทดรองจ่ายใหม่เป็นเงิน   '.number_format($advance_prict,2).'  บาท' ), 0, 1, 'L' );
		//$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , '(- '.$this->convert(number_format($advance_prict,2)).' -) เพื่อใช้จ่ายในโครงการ'), 0, 1, 'L' );
		
		$this->pdf->MultiCell( 170, 7, iconv( 'UTF-8','cp874' , $message), 0, 1);
		
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , '               โดยมีรายละเอียดดังต่อไปนี้'), 0, 1, 'L' );
		$h = $this->pdf->GetY();
		$h2 = $this->pdf->GetY();
		$i=0;
		$total = 0;
		foreach($advance_detail['list'] as $k=>$v){
			$total += $this->rmComma($advance_detail['price'][$k]);
			$i++;
			if($h2>$h){$h=$h2;}
			$this->pdf->setXY( 35, $h );
			$this->pdf->MultiCell( 5, 7, iconv( 'UTF-8','cp874' , $i.'. '), 0, 1);
			$this->pdf->setXY( 40, $h );
			$this->pdf->MultiCell( 120, 7, iconv( 'UTF-8','cp874' , $advance_detail['list'][$k]), 0, 1);
			$h2 = $this->pdf->GetY();
			$this->pdf->setXY( 160, $h );
			$this->pdf->Cell( 30, 7, iconv( 'UTF-8','cp874' , number_format($this->rmComma($advance_detail['price'][$k]),2)), 0, 1, 'R');
		}
		$this->pdf->Ln();
		
		$this->pdf->setXY( 35, $h2 );
		$this->pdf->Cell( 120, 7, iconv( 'UTF-8','cp874' , 'รวมเป็นเงิน'), 0, 1, 'R');
		$this->pdf->setXY( 160, $h2 );
		$this->pdf->Cell( 30, 7, iconv( 'UTF-8','cp874' , number_format($total,2)), 0, 1, 'R');
		
		$this->pdf->setXY( 35, ($h2+7) );
		$this->pdf->Cell( 120, 7, iconv( 'UTF-8','cp874' , 'เงินคืนขอสำรองจ่ายก่อนจาก เลขที่ '.$advance_refunds_id), 0, 1, 'R');
		$this->pdf->setXY( 160, ($h2+7) );
		$this->pdf->Cell( 30, 7, iconv( 'UTF-8','cp874' , number_format($advance_refunds_price,2)), 0, 1, 'R');
		
		$this->pdf->setXY( 35, ($h2+14) );
		$this->pdf->Cell( 120, 7, iconv( 'UTF-8','cp874' , 'ยอดโอน'), 0, 1, 'R');
		$this->pdf->setXY( 160, ($h2+14) );
		$this->pdf->Cell( 30, 7, iconv( 'UTF-8','cp874' , number_format($total-$advance_refunds_price,2)), 0, 1, 'R');
		
		$this->pdf->Ln();
		

		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , '               โดยข้าพเจ้าจะนำใบเสร็จทั้งหมดส่งคืนภายในกำหนด'), 0, 1, 'L' );
		$this->pdf->Ln();
		$this->pdf->Ln();
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 20, $h );
		$this->pdf->MultiCell( 50, 7, iconv( 'UTF-8','cp874' , 'ลงชื่อ.................................................'), 0, 1);
		$this->pdf->setXY( 80, $h );
		$this->pdf->MultiCell( 50, 7, iconv( 'UTF-8','cp874' , 'ลงชื่อ.................................................'), 0, 1);
		$this->pdf->setXY( 140, $h );
		$this->pdf->MultiCell( 50, 7, iconv( 'UTF-8','cp874' , 'ลงชื่อ.................................................'), 0, 1);
		//$this->pdf->Ln();
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 20, $h );
		$this->pdf->Cell( 50, 7, iconv( 'UTF-8','cp874' , 'ผู้ขอยืมเงินทดรองจ่าย' ), 0,0, 'C' );
		$this->pdf->setXY( 80, $h );
		$this->pdf->Cell( 50, 7, iconv( 'UTF-8','cp874' , 'ผู้ตรวจเอกสาร' ), 0,0, 'C' );
		$this->pdf->setXY( 140, $h );
		$this->pdf->Cell( 50, 7, iconv( 'UTF-8','cp874' , 'ผู้อนุมัติ' ), 0,0, 'C' );

		$this->pdf->Output();
	}
	
	
	function advance_summary_print(){
		$member = $this->session->userdata('member_logged_in');
		if($member['m_level']>1){
			$advance_m = $this->session->userdata('advance_m');
			$advance_y = $this->session->userdata('advance_y');
			$rs = $this->app_model->getAdvanceList($member,$advance_m,$advance_y);
			
			$this->load->library('pdf');
		
			$this->pdf=new FPDF('L','mm','A4');
				
			$this->pdf->AddPage();
			$this->pdf->SetMargins( 20,30,20 );
			$this->pdf->AddFont('THSarabunNew','','THSarabunNew.php');
			$this->pdf->AddFont('THSarabunNew Bold','B','THSarabunNew Bold.php');
			$this->pdf->SetFont('THSarabunNew Bold','B',16);

			$this->pdf->Cell( 0, 10, iconv( 'UTF-8','cp874' , 'สรุปขอยืมทดลองจ่ายประจำเดือน '.$this->getMonthName($advance_m).' '.($advance_y+543)  ), 0,0, 'C' );
			$this->pdf->Ln();
			$this->pdf->Ln();


			$h = $this->pdf->GetY();
			$h2 = $this->pdf->GetY();
			$i=0;
			$advance_total = 0;
			$advance_total2 = 0;
			

			
			$this->pdf->SetFont('THSarabunNew Bold','B',13);
			if($h2>$h){$h=$h2;}
				$this->pdf->setXY( 10, $h );
				$this->pdf->Cell( 20, 5, iconv( 'UTF-8','cp874' , 'เลขที่'), 0, 0, 'C');
				$this->pdf->setXY( 30, $h );
				$this->pdf->Cell( 150, 5, iconv( 'UTF-8','cp874' , 'โครงการ'), 0, 0, 'C');
				$h2 = $this->pdf->GetY();
				$this->pdf->setXY( 180, $h );
				$this->pdf->Cell( 40, 5, iconv( 'UTF-8','cp874' , 'ผู้ตั้งเบิก'), 0, 0, 'C');
				$this->pdf->setXY( 220, $h );
				$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , 'ยอดตั้งเบิก'), 0, 0, 'C');
				$this->pdf->setXY( 250, $h );
				$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , 'ยอดโอน'), 0, 0, 'C');
			$this->pdf->SetFont('THSarabunNew','',11);
			$this->pdf->Line(10, $h+6, 280, $h+6);			
			$h+=7;
			foreach($rs as $k=>$v){
				
				$data = json_decode(@$v->advance_detail);
				$advance_detail = (array) @$data;
				
				$advance_prict = 0;
				
				if($advance_detail!=null){
					foreach($advance_detail['list'] as $k=>$v2){
						$advance_prict+=$this->rmComma($advance_detail['price'][$k]);
					}
				}
				$advance_total+=$advance_prict;
				$advance_total2+=$advance_prict-$v->advance_refunds_price;
				
		
				$i++;
				if($h2>$h){$h=$h2;}
				if($h>172){
					$this->pdf->AddPage();
					$h = $this->pdf->GetY();
					$h2 = $this->pdf->GetY();
					$this->pdf->SetFont('THSarabunNew','',11);
				}
				$this->pdf->setXY( 10, $h );
				$this->pdf->Cell( 20, 5, iconv( 'UTF-8','cp874' , $v->advance_code.'. '), 0, 1, 'C');
				$this->pdf->setXY( 30, $h );
				$this->pdf->MultiCell( 150, 5, iconv( 'UTF-8','cp874' , $v->advance_project_name), 0, 1);
				$h2 = $this->pdf->GetY();
				$this->pdf->setXY( 180, $h );
				$this->pdf->Cell( 40, 5, iconv( 'UTF-8','cp874' , $v->member_name), 0, 1, 'C');
				$this->pdf->setXY( 220, $h );
				$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , number_format($advance_prict,2)), 0, 1, 'R');
				$this->pdf->setXY( 250, $h );
				$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , number_format($advance_prict-$v->advance_refunds_price,2)), 0, 1, 'R');
				//$this->pdf->Line(10, $h, 280, $h);		
			}
		
			$this->pdf->SetFont('THSarabunNew Bold','B',11);
			$h3 = $this->pdf->GetY();
			$this->pdf->Line(10, $h3, 280, $h3);		
			$h3 +=5;
			$this->pdf->setXY( 220, $h3 );
			$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , number_format($advance_total,2)), 0, 1, 'R');
			$this->pdf->setXY( 250, $h3 );
			$this->pdf->Cell( 30, 5, iconv( 'UTF-8','cp874' , number_format($advance_total2,2)), 0, 1, 'R');
			$this->pdf->Output();
		
		}else{redirect('dashboard');}
	}
	
	function advance_clear_pdf($rs){
		$data = json_decode(@$rs[0]->advance_detail);
		$advance_detail = (array) @$data;
		
		$advance_prict = 0;
		if($advance_detail!=null){
			foreach($advance_detail['list'] as $k=>$v){
				$advance_prict+=$this->rmComma($advance_detail['price'][$k]);
			}
		}

		$advance_code = $rs[0]->advance_code;
		$advance_name = $rs[0]->member_name;
		$advance_clear_real = $rs[0]->advance_clear_real_money;
		$advance_clear_price_total = $rs[0]->advance_clear_price_total;
		$advance_clear_verify_detail = $rs[0]->advance_clear_verify_detail;
		
		if($rs[0]->advance_clear_type==1){
			$advance_clear_type = 'เงินสด';
		}else if($rs[0]->advance_clear_type==2){
			$advance_clear_type = 'โอนเงิน';
		}else if($rs[0]->advance_clear_type==3){
			$advance_clear_type = 'สำรองจ่าย เลขที่ '.$rs[0]->advance_clear_type_note;
		}
		
		
		$message= 'โครงการ '.$rs[0]->advance_project_name;
		$this->load->library('pdf');
		
		$this->pdf=new FPDF('P','mm','A4');
			
		$this->pdf->AddPage();
		$this->pdf->SetMargins( 20,30,20 );
		$this->pdf->AddFont('THSarabunNew','','THSarabunNew.php');
		$this->pdf->AddFont('THSarabunNew Bold','B','THSarabunNew Bold.php');
		$this->pdf->SetFont('THSarabunNew','',18);
		$this->pdf->Image('https://www.cmuccdc.org/advance_bg.jpg?v=4', 0, 0, 210, 297, 'JPG');
		
		
		
		$this->pdf->Cell( 0, 15, '', 0,0, 'C' );
		$this->pdf->Ln();
		$this->pdf->Ln();
		$this->pdf->Cell( 0, 15, iconv( 'UTF-8','cp874' , 'แบบเคลียร์เงินทดรองจ่าย' ), 0,0, 'C' );
		$this->pdf->Ln();
		
		$this->pdf->SetFont('THSarabunNew','',14);
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , ConvertToThaiDate_pdf(date('Y-m-d'),0) ), 0, 0, 'R' );
		$this->pdf->Ln();
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , 'เลขที่ทดรองจ่าย '.$advance_code), 0, 0, 'L' );
		$this->pdf->Ln();
		$this->pdf->Ln();
		
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , '               ตามที่ข้าพเจ้า นาย/นาง/นาวสาว    '.$advance_name.'   ได้ทดรองจ่ายเป็นเงิน   '.number_format($advance_prict,2).'  บาท' ), 0, 1, 'L' );
		$this->pdf->MultiCell( 170, 7, iconv( 'UTF-8','cp874' , $message), 0, 1);
		$this->pdf->Cell( 0, 7, iconv( 'UTF-8','cp874' , '               มีรายละเอียดการเคลียร์เงินดังนี้'), 0, 1, 'L' );
		
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 36, $h );
		$this->pdf->MultiCell( 100, 7, iconv( 'UTF-8','cp874' , '- ยอดทดรองจ่าย'), 0, 1);
		$this->pdf->setXY( 136, $h );
		$this->pdf->Cell( 40, 7, iconv( 'UTF-8','cp874' , number_format($advance_prict,2)), 0, 1, 'R');
		$this->pdf->setXY( 176, $h );
		$this->pdf->MultiCell( 20, 7, iconv( 'UTF-8','cp874' , 'บาท'), 0, 1);
		
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 36, $h );
		$this->pdf->MultiCell( 100, 7, iconv( 'UTF-8','cp874' , '- ยอดจ่ายจริง'), 0, 1);
		$this->pdf->setXY( 136, $h );
		$this->pdf->Cell( 40, 7, iconv( 'UTF-8','cp874' , number_format($advance_clear_real,2)), 0, 1, 'R');
		$this->pdf->setXY( 176, $h );
		$this->pdf->MultiCell( 20, 7, iconv( 'UTF-8','cp874' , 'บาท'), 0, 1);
		
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 36, $h );
		$this->pdf->MultiCell( 100, 7, iconv( 'UTF-8','cp874' , '- เท่ากับ'), 0, 1);
		$this->pdf->setXY( 136, $h );
		$this->pdf->Cell( 40, 7, iconv( 'UTF-8','cp874' , number_format($advance_clear_price_total,2)), 0, 1, 'R');
		$this->pdf->setXY( 176, $h );
		$this->pdf->MultiCell( 20, 7, iconv( 'UTF-8','cp874' , 'บาท'), 0, 1);
		
		if($advance_clear_price_total<0){
			$h = $this->pdf->GetY();
			$this->pdf->setXY( 36, $h );
			$this->pdf->MultiCell( 100, 7, iconv( 'UTF-8','cp874' , '- เบิกจ่ายเพิ่ม'), 0, 1);
			$this->pdf->setXY( 136, $h );
			$this->pdf->Cell( 40, 7, iconv( 'UTF-8','cp874' , number_format($advance_clear_price_total,2)), 0, 1, 'R');
			$this->pdf->setXY( 176, $h );
			$this->pdf->MultiCell( 20, 7, iconv( 'UTF-8','cp874' , 'บาท'), 0, 1);
		}
		
		if($advance_clear_price_total>0){
			$h = $this->pdf->GetY();
			$this->pdf->setXY( 36, $h );
			$this->pdf->MultiCell( 100, 7, iconv( 'UTF-8','cp874' , '- ขอคืนเงินคงเหลือ'), 0, 1);
			$this->pdf->setXY( 136, $h );
			$this->pdf->Cell( 40, 7, iconv( 'UTF-8','cp874' , number_format($advance_clear_price_total,2)), 0, 1, 'R');
			$this->pdf->setXY( 176, $h );
			$this->pdf->MultiCell( 20, 7, iconv( 'UTF-8','cp874' , 'บาท'), 0, 1);
			
			$h = $this->pdf->GetY();
			$this->pdf->setXY( 36, $h );
			$this->pdf->MultiCell( 100, 7, iconv( 'UTF-8','cp874' , '- รูปแบบ '.$advance_clear_type), 0, 1);
			//$this->pdf->setXY( 136, $h );
			//$this->pdf->Cell( 40, 7, iconv( 'UTF-8','cp874' , $advance_clear_type), 0, 1, 'R');
			
		
		}
		
		$this->pdf->Ln();
		if($advance_clear_verify_detail!=null){
				$h = $this->pdf->GetY();
				$this->pdf->setXY( 36, $h );
				$this->pdf->MultiCell( 140, 7, iconv( 'UTF-8','cp874' , 'หมายเหตุ*'), 0, 1);
				$h = $this->pdf->GetY();
				$this->pdf->setXY( 36, $h );
				$this->pdf->MultiCell( 140, 7, iconv( 'UTF-8','cp874' , $advance_clear_verify_detail), 0, 1);
		}
		
		$this->pdf->Ln();
		$this->pdf->Ln();
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 20, $h );
		$this->pdf->MultiCell( 50, 7, iconv( 'UTF-8','cp874' , 'ลงชื่อ.................................................'), 0, 1);
		$this->pdf->setXY( 80, $h );
		$this->pdf->MultiCell( 50, 7, iconv( 'UTF-8','cp874' , 'ลงชื่อ.................................................'), 0, 1);
		$this->pdf->setXY( 140, $h );
		$this->pdf->MultiCell( 50, 7, iconv( 'UTF-8','cp874' , 'ลงชื่อ.................................................'), 0, 1);
		//$this->pdf->Ln();
		$h = $this->pdf->GetY();
		$this->pdf->setXY( 20, $h );
		$this->pdf->Cell( 50, 7, iconv( 'UTF-8','cp874' , 'ผู้เคลียร์เงิน' ), 0,0, 'C' );
		$this->pdf->setXY( 80, $h );
		$this->pdf->Cell( 50, 7, iconv( 'UTF-8','cp874' , 'ผู้ตรวจเอกสาร' ), 0,0, 'C' );
		$this->pdf->setXY( 140, $h );
		$this->pdf->Cell( 50, 7, iconv( 'UTF-8','cp874' , 'ผู้อนุมัติ' ), 0,0, 'C' );
		
		$this->pdf->Output();
	}
	
	function createTempFileAccount($file,$data){
		if($file){
		$handle = fopen('/var/www/eee/domains/3e.world/public_html/apps/temp/'.$file,'w+');
		fwrite($handle,$data);
		fclose($handle);
				
		chmod('/var/www/eee/domains/3e.world/public_html/apps/temp/'.$file, 0777);
		}
	}
	
	public function account(){
		$template='template_main';
		$member = $this->session->userdata('member_logged_in');
		$project_year = $this->session->userdata('project_year');
		$project_type = $this->session->userdata('project_type');
		$do = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		//if($member['m_level']==3 || $member['m_level']==4 || $member['m_user']=="chindamanee" || $member['m_user']=="kittiya"){
			if($this->input->post()!=null){
				$ar = $this->input->post();
		
				if($ar['account_id']!=null){
					
					if($member['m_level']==3){
						$ar['account_member_permission'] = json_encode($ar['account_member_permission']);
					}else{
						unset($ar['account_member_permission']);
					}
			
					$this->session->set_userdata('sel_type', $ar['sel_type']);
					
					if(@$ar['sel_type']=="tab1"){
						$ar['tab1_obj'] = json_encode(@$ar['tab1']);
						$this->createTempFileAccount($ar['account_id'].'_'.$member['m_user'].'tab1_'.date('YmdHis').'.txt',$ar['tab1_obj']);
					}
					
					if(@$ar['sel_type']=="tab2"){
						$ar['tab2_obj'] = json_encode(@$ar['tab2']);
						$this->createTempFileAccount($ar['account_id'].'_'.$member['m_user'].'tab2_'.date('YmdHis').'.txt',$ar['tab2_obj']);
					}
					
					if(@$ar['sel_type']=="tab3"){
						$ar['tab3_obj'] = json_encode(@$ar['tab3']);
						$this->createTempFileAccount($ar['account_id'].'_'.$member['m_user'].'_tap3_'.date('YmdHis').'.txt',$ar['tab3_obj']);
					}
					
					if(@$ar['sel_type']=="tab4"){
						$ar['tab4_obj'] = json_encode(@$ar['tab4']);
						$this->createTempFileAccount($ar['account_id'].'_'.$member['m_user'].'tab4_'.date('YmdHis').'.txt',$ar['tab4_obj']);
					}
					
					if(@$ar['sel_type']=="tab5"){
						$ar['tab5_obj'] = json_encode(@$ar['tab5']);
						$this->createTempFileAccount($ar['account_id'].'_'.$member['m_user'].'tab5_'.date('YmdHis').'.txt',$ar['tab5_obj']);
					}
					
					$ar['account_status_complate_date'] = decode_date($ar['account_status_complate_date']);
					
					unset($ar['tab1']);
					unset($ar['tab2']);
					unset($ar['tab3']);
					unset($ar['tab4']);
					unset($ar['tab5']);
					unset($ar['sel_type']);
					
					$rs = $this->app_model->updateAccount($ar, $member);
				
					echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/account/info/'.$ar['account_id']).'";</script>';
					exit();
				}else{
					if($member['m_level']==3){
						$ar['account_member_permission'] = json_encode($ar['account_member_permission']);
					}else{
						unset($ar['account_member_permission']);
					}

					$ar['account_id'] = $this->getInsertID();
					$ar['account_member_username'] = $member['m_user'];
					$ar['account_year'] = (date('Y')-543);
					$ar['account_createdate'] = date('Y-m-d H:i:s');
					$ar['account_status_complate_date'] = null;
					$rs = $this->app_model->insertAccount($ar);
					if($rs!=null){
						echo '<script>alert("บันทึกข้อมูลเรียบร้อย");window.location="'.base_url('dashboard/account/info/'.$ar['account_id']).'";</script>';
						exit();
					}
				}
				
			}else{
				
				$rs = array();
				$rsFile = array();
				$view = 'account';
				if($do=="del"){
				
				}else if($do=="check"){
					$rs = $this->app_model->checkAccountDetail($id,$member);
					if($rs!=null){
						redirect(site_url('dashboard/account/info/'.$rs[0]->account_id));
					}else{
						redirect(site_url('dashboard/account/add/'.$id));
					}
				}else if($do=="info"){
					$view = 'account_form_edit';
					$rs = $this->app_model->getAccountDetail($id,$member);
					if($rs==null){
						echo '<script>alert("ท่านไม่มีสิทธิ์เข้าถึงบัญชีของโครงการนี้ กรุณาติดต่อ RK");window.location="'.base_url('dashboard/account/').'";</script>';
						exit();
					}
					
					$rsFile = $this->app_model->getAccountDetailFile($rs[0]->account_id);
				}else if($do=="add"){
					$view = 'account_form';
					$rs = $this->app_model->getProjectDetail($id,$member);
					if($rs==null){
						echo '<script>alert("ยังไม่ได้เปิดบัญชี กรุณาติดต่อ RK เพื่อทำการเปิดบัญชีและกำหนดสิทธิ์การเข้าถึง");window.location="'.base_url('dashboard/account/').'";</script>';
						exit();
						//redirect(site_url('dashboard/account'));
					}
				}else if($do=="download"){
					$rs = $this->app_model->getAccountDetail($id, $member);
					
					$template='account_excel';
				}else if($do=="excel"){
				
					
					$template='account_excel_all';
				}
			}
			
			$data = array(
				'menu'			=> 'account',
				'memberList'	=> $this->app_model->getMemberList(),
				'rs'			=> $rs,
				'rsFile'		=> $rsFile,
				'menu_sub'		=> '',
				'view'			=> $view,
				'rsList'		=> $this->app_model->getProjectList($project_year, $project_type)
			);
			$this->load->view('dashboard/'.$template, $data);

		//}else{redirect('dashboard');}
	}
	
	////////////////V/VB////////////
	public function getPermission(){
		$rs = array(
			'main' 	=> array('test','kittiya'),
			'cfo'	=> array(
				'head'	=> array('test','RK','ekkaporn'),
				'cv' 	=> array('test','RK','ekkaporn'), //kittiya
				'vf' 	=> array('test','RK','ekkaporn'), //kittiya, RK
			),
			'tver'	=> array(
				'head'	=> array('test','ekkaporn'),
				'cv' 	=> array('test','ekkaporn'), //kittiya
				'vf' 	=> array('test','ekkaporn'), //kittiya, ekkaporn
			),
			'docs'	=> array(
				'head'	=> array('test', 'ekkaporn', 'RK')
			),
			'request'	=> array(
				'head'	=> array('test', 'ekkaporn', 'RK')
			),
		);
		return json_encode($rs);
	}
	
	public function ckPermission($type, $member){
		$get= $this->getPermission();
		$s_permissions = json_decode($get);
		$s_permissions = $s_permissions->$type->head;
		if(!in_array($member, $s_permissions)){
			$rs = $this->app_model->getVBPermissions();
			$ck = json_decode($rs[0]->$type);
			if(in_array($member, $ck)){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	
	public function setpermissions(){
		$member = $this->session->userdata('member_logged_in');
		$get= $this->getPermission();
		$s_permissions = json_decode($get);
		$s_permissions = $s_permissions->main;
		if(!in_array($member['m_user'], $s_permissions)){
			redirect('/dashboard');
		}
		$template 	= 'template_main';
		$view 		= 'vb_setpermission';
		if($this->input->post()){
			$ar = $this->input->post();
			if($ar['cfo']){$ar['cfo']=json_encode($ar['cfo']);}else{$ar['cfo']='';}
			if($ar['tver']){$ar['tver']=json_encode($ar['tver']);}else{$ar['tver']='';}
			if($ar['docs']){$ar['docs']=json_encode($ar['docs']);}else{$ar['docs']='';}
			if($ar['request']){$ar['request']=json_encode($ar['request']);}else{$ar['request']='';}
	
			$rs = $this->app_model->setVBPermissions($ar);
			redirect('dashboard/setpermissions');
		}
		
		$data = array(
			'menu'			=> 'set',
			'memberList'	=> $this->app_model->getMemberList(),
			'rs'			=> $this->app_model->getVBPermissions(),
			'menu_sub'		=> '',
			'view'			=> $view,
		);
		$this->load->view('dashboard/'.$template, $data);
	}
	
	
	public function vb_cfo(){
		$member = $this->session->userdata('member_logged_in');
		if(!$this->ckPermission('cfo',$member['m_user'])){
			echo '<script>alert("ไม่สามารถเข้าใช้ Functions นี้ได้");window.location="'.base_url('dashboard').'";</script>';
			exit();
		}
		$rsTverFilePoint = array();
		
		$template 	= 'template_main';
		$view 		= 'vb_cfo';
		$do = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		if($this->input->post()){
			$ar = $this->input->post();

			if($ar['cfo_cv']){
				$ar['cfo_cv_obj'] = json_encode($ar['cfo_cv']);
			}
			if($ar['cfo_vd']){
				$ar['cfo_vd_obj'] = json_encode($ar['cfo_vd']);
			}
			unset($ar['cfo_cv']);
			unset($ar['cfo_vd']);
			
			if(@$ar['cfo_cv_permission']){$ar['cfo_cv_permission'] = json_encode($ar['cfo_cv_permission']);}else{$ar['cfo_cv_permission'] = '';}
			if(@$ar['cfo_vd_permission']){$ar['cfo_vd_permission'] = json_encode($ar['cfo_vd_permission']);}else{$ar['cfo_vd_permission'] = '';}
			
			$jsonData = $this->getPermission();
			$s_permissions = json_decode($jsonData);
			$s_permissions = $s_permissions->cfo->head;
			if (!in_array($member['m_user'], $s_permissions)) {
				unset($ar['cfo_cv_permission']);
				unset($ar['cfo_vd_permission']);
			}
			
			
			if($ar['cfo_id']!=null){
				$query = $this->app_model->updateVBCFO($ar);
				echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_cfo/edit/'.$ar['cfo_id']).'";</script>';
				exit;
			}else{
				$ar['cfo_id'] = $this->generateRandomString(4).date('ymdHis').$this->generateRandomString(4);
				$query = $this->app_model->insertVBCFO($ar);
				echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_cfo/edit/'.$ar['cfo_id']).'";</script>';	
				exit;
			}
		}else{
			$rsCFO = array();
			$rsTverFile = array();
			if($do=="add"){
				$view 	= 'vb_cfo_form_init';
			}else if($do=="edit"){
				$view 	= 'vb_cfo_form';	
				$rsCFO = $this->app_model->getVBCFODetail($id);
				$rsTverFile = $this->app_model->getVBTverFileLists($id);
				$rsTverFilePoint = $this->app_model->getVBFilePoint($id);
			}else if($do=="del"){
				$rsDel = $this->app_model->delVBCFO($id);
				echo '<script>alert("ลบข้อมูลเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_cfo/').'";</script>';	
				exit;
			}
		}
		
		$jsonData = $this->getPermission();
		$s_permissions = json_decode($jsonData);
		$s_permissions = $s_permissions->cfo->head;
		if (!in_array($member['m_user'], $s_permissions)) {
			if($do!="edit"){
				$view = 'vb_cfo_guest';
			}else{
				$view 	= 'vb_cfo_form_guest';	
			}
		}

		$data = array(
			'menu'			=> 'vb',
			'memberList'	=> $this->app_model->getMemberList(),
			'rs'			=> $this->app_model->getVBPermissions(),
			'rsCFO'			=> $rsCFO,
			'rsTverFile'	=> $rsTverFile,
			'rsTverFilePoint'=> $rsTverFilePoint,
			'rsVBFile'		=> $this->app_model->getVBFileStore(),
			'rsList'		=> $this->app_model->getVBCFOLists(),
			'menu_sub'		=> 'vb_cfo',
			'view'			=> $view,
		);
		$this->load->view('dashboard/'.$template, $data);
		
	}
	public function vb_tver(){
		$member = $this->session->userdata('member_logged_in');
		if(!$this->ckPermission('tver',$member['m_user'])){
			echo '<script>alert("ไม่สามารถเข้าใช้ Functions นี้ได้");window.location="'.base_url('dashboard').'";</script>';
			exit();
		}
		$template 	= 'template_main';
		$view 		= 'vb_tver';
		$do = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		if($this->input->post()){
			$ar = $this->input->post();
			
			if($ar['tver_cv']){
				$ar['tver_cv_obj'] = json_encode($ar['tver_cv']);
			}
			if($ar['tver_vd']){
				$ar['tver_vd_obj'] = json_encode($ar['tver_vd']);
			}
			unset($ar['tver_cv']);
			unset($ar['tver_vd']);
			
			if(@$ar['tver_cv_permission']){$ar['tver_cv_permission'] = json_encode($ar['tver_cv_permission']);}else{$ar['tver_cv_permission'] = '';}
			if(@$ar['tver_vd_permission']){$ar['tver_vd_permission'] = json_encode($ar['tver_vd_permission']);}else{$ar['tver_vd_permission'] = '';}
			
			$jsonData = $this->getPermission();
			$s_permissions = json_decode($jsonData);
			$s_permissions = $s_permissions->tver->head;
			if (!in_array($member['m_user'], $s_permissions)) {
				unset($ar['tver_cv_permission']);
				unset($ar['tver_vd_permission']);
				
			}
			if($ar['tver_id']!=null){
				$query = $this->app_model->updateVBTver($ar);
				echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_tver/edit/'.$ar['tver_id']).'";</script>';
				exit;
			}else{
				$ar['tver_id'] = $this->generateRandomString(4).date('ymdHis').$this->generateRandomString(4);
				$query = $this->app_model->insertVBTver($ar);
				echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_tver/edit/'.$ar['tver_id']).'";</script>';	
				exit;
			}
		}else{
			$rsTver = array();
			$rsTverFile = array();
			$rsTverFilePoint = array();
			if($do=="add"){
				$view 	= 'vb_tver_form_init';
			}else if($do=="edit"){
				$view 	= 'vb_tver_form';	
				$rsTver = $this->app_model->getVBTverDetail($id);
				$rsTverFile = $this->app_model->getVBTverFileLists($id);
				$rsTverFilePoint = $this->app_model->getVBFilePoint($id);
			}else if($do=="del"){
				$rsDel = $this->app_model->delVBTver($id);
				echo '<script>alert("ลบข้อมูลเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_tver/').'";</script>';	
				exit;
			}

		}
		
		$jsonData = $this->getPermission();
		$s_permissions = json_decode($jsonData);
		$s_permissions = $s_permissions->tver->head;
		if (!in_array($member['m_user'], $s_permissions)) {
			if($do!="edit"){
				$view = 'vb_tver_guest';
			}else{
				$view 	= 'vb_tver_form_guest';	
			}
		}

		$data = array(
			'menu'			=> 'vb',
			'memberList'	=> $this->app_model->getMemberList(),
			'rs'			=> $this->app_model->getVBPermissions(),
			'rsTver'		=> $rsTver,
			'rsTverFile'	=> $rsTverFile,
			'rsTverFilePoint'=> $rsTverFilePoint,
			'rsVBFile'		=> $this->app_model->getVBFileStore(),
			'rsList'		=> $this->app_model->getVBTverLists(),
			'menu_sub'		=> 'vb_tver',
			'view'			=> $view,
		);
		$this->load->view('dashboard/'.$template, $data);
	}
	
	public function vb_request(){
		$member = $this->session->userdata('member_logged_in');
		if(!$this->ckPermission('request',$member['m_user'])){
			echo '<script>alert("ไม่สามารถเข้าใช้ Functions นี้ได้");window.location="'.base_url('dashboard').'";</script>';
			exit();
		}
		$rsTopic = '';
		$template 	= 'template_main';
		$view 		= 'vb_request';
		$do = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$jsonData = $this->getPermission();
		$s_permissions = json_decode($jsonData);
		$s_permissions = $s_permissions->request->head;
		if($this->input->post()){
			if (!in_array($member['m_user'], $s_permissions)) {redirect('dashboard');}
			$ar = $this->input->post();
			if(@$ar['topic_permission']){$ar['topic_permission'] = json_encode($ar['topic_permission']);}else{$ar['topic_permission'] = '';}
			if($ar['topic_id']!=null){
				$rs = $this->app_model->updateVBTopic($ar);
			}else{
				//insert
				$rs = $this->app_model->insertVBTopic($ar);
			}
			echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_request/').'";</script>';
			exit();
		}else{
			if($do=="add"){
				$view 		= 'vb_request_form';
			}else if($do=="edit"){
				$view 		= 'vb_request_form';
				$rsTopic	= $this->app_model->getVBTopicDetail($id);
			}else if($do=="del"){
				$rsTopic	= $this->app_model->delVBTopicDetail($id);
				echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_request/').'";</script>';
				exit();
			}else if($do=="deldoc"){
				$rsTopic	= $this->app_model->delVBDocumentDetail($id);
				echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_request/').'";</script>';
				exit();
			}
		}
		if (!in_array($member['m_user'], $s_permissions)) {$view = 'vb_request_guest';}
		
		$data = array(
			'menu'			=> 'vb',
			'memberList'	=> $this->app_model->getMemberList(),
			'rs'			=> $this->app_model->getVBPermissions(),
			'rsTopic'		=> $rsTopic,
			'rsList'		=> $this->app_model->getVBDocument(2),
			'menu_sub'		=> 'vb_request',
			'view'			=> $view,
		);
		$this->load->view('dashboard/'.$template, $data);
	}
	
	public function vb_doc(){
		$member = $this->session->userdata('member_logged_in');
		if(!$this->ckPermission('docs',$member['m_user'])){
			echo '<script>alert("ไม่สามารถเข้าใช้ Functions นี้ได้");window.location="'.base_url('dashboard').'";</script>';
			exit();
		}
		$rsTopic = '';
		$template 	= 'template_main';
		$view 		= 'vb_doc';
		$do = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		
		$jsonData = $this->getPermission();
		$s_permissions = json_decode($jsonData);
		$s_permissions = $s_permissions->docs->head;
		
		if($this->input->post()){
			if (!in_array($member['m_user'], $s_permissions)) {redirect('dashboard');}
			$ar = $this->input->post();
			if(@$ar['topic_permission']){$ar['topic_permission'] = json_encode($ar['topic_permission']);}else{$ar['topic_permission'] = '';}
			if($ar['topic_id']!=null){
				$rs = $this->app_model->updateVBTopic($ar);
			}else{
				//insert
				$rs = $this->app_model->insertVBTopic($ar);
			}
			echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_doc/').'";</script>';
			exit();
		}else{
			
			if($do=="add"){
				$view 		= 'vb_doc_form';
			}else if($do=="edit"){
				$view 		= 'vb_doc_form';
				$rsTopic	= $this->app_model->getVBTopicDetail($id);
			}else if($do=="del"){
				$rsTopic	= $this->app_model->delVBTopicDetail($id);
				echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_doc/').'";</script>';
				exit();
			}else if($do=="deldoc"){
				$rsTopic	= $this->app_model->delVBDocumentDetail($id);
				echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/vb_doc/').'";</script>';
				exit();
			}else if($do=="addfile"){
				echo 'ทำถึงตรงนี้';
				exit;
			}
		}
		
		if (!in_array($member['m_user'], $s_permissions)) {$view = 'vb_doc_guest';}
		
		$data = array(
			'menu'			=> 'vb',
			'memberList'	=> $this->app_model->getMemberList(),
			'rs'			=> $this->app_model->getVBPermissions(),
			'rsTopic'		=> $rsTopic,
			'rsList'		=> $this->app_model->getVBDocument(1),
			'menu_sub'		=> 'vb_doc',
			'view'			=> $view,
		);
		$this->load->view('dashboard/'.$template, $data);
	}
	
	public function vb_addfile(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$topic_id = $this->input->get('topic_id');
			$doc_id = $this->input->get('doc_id');
			
			$rs = $this->app_model->getVBDocumentId($topic_id);
			if($doc_id!=null){
				$rsDoc = $this->app_model->getVBDocumentDetail($doc_id);
			}
			
			$jsonData = $this->getPermission();
			$s_permissions = json_decode($jsonData);
			$s_permissions = $s_permissions->docs->head;
		
			if (in_array($member['m_user'], $s_permissions)) {
				if($this->input->post()){
					$ar = $this->input->post();
					$ar['createdate'] = date('Y-m-d H:i:s');
					if($_FILES['doc_file']){

						$config['upload_path'] = './documents/';
						$config['allowed_types'] = 'pdf|xlsx|xls|docx|doc|pptx';
						$config['max_size'] = 200000000;
						$config['encrypt_name'] = FALSE;

						$this->load->library('upload', $config);

						$fileName =date('YmdHis').md5(rand(100, 200));
						//$config['file_name'] = 'vb_'.$fileName;
						$this->upload->initialize($config);	
						if ($this->upload->do_upload('doc_file')) {
							$ar['doc_file'] = $this->upload->data('file_name');
						}else{
							echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .pdf, .xlsx, xls เท่านั้น");window.location="'.base_url('dashboard/vb_addfile?topic_id='.$topic_id).'";</script>';
						}
					}

					if($ar['doc_id']!=null){
						$rss = $this->app_model->updateVBDocumentFiles($ar);
						$doc_id = $ar['doc_id'];
					}else{
						$rss = $this->app_model->insertVBDocumentFiles($ar);
						$doc_id = $rss;
					}		
					redirect('/dashboard/vb_addfile?topic_id='.$topic_id.'&doc_id='.$doc_id);
				}
				$data = array(
					'rs'			=> $rs,
					'topic_id'		=> $topic_id,
					'rsDoc'			=> $rsDoc,
					'member'		=> $member
				);
				$this->load->view('dashboard/fancy_upload_file_doc', $data);
			}else{
				echo 'คุณไม่มีสิทธิเข้าถึงระบบนี้';
				exit;
			}
			
		}
	}

	public function vb_setfile(){
		$member = $this->session->userdata('member_logged_in');
		if(!$this->ckPermission('tver',$member['m_user'])){
			redirect('dashboard');
		}
		if($this->input->post()){
			$ar = $this->input->post();
			if($ar['set_data']!=null){$ar['set_data']=json_encode($ar['set_data']);}else{$ar['set_data']=null;}
			$rsSetFile = $this->app_model->setVBFilesTemplate($ar);
		}
		$vb_id = $this->input->get('vb_id');
		$vb_point = $this->input->get('vb_point');
		$vb_type = $this->input->get('vb_type');
		$rs = $this->app_model->getVBFilesTemplate($vb_id, $vb_type, $vb_point);
		$data = array(
			'vb_id'			=> $vb_id,
			'vb_point'		=> $vb_point,
			'vb_type'		=> $vb_type,
			'rs'			=> $rs,
			'rsList'		=> $this->app_model->getVBDocument(1),
		);
		$this->load->view('dashboard/fancy_set_file_template', $data);
	}
	
	public function vb_uploadfile(){
		$member = $this->session->userdata('member_logged_in');
		
		if(!$this->ckPermission($this->input->get('vb_type'),$member['m_user'])){
			redirect('dashboard');
		}
		if($member!=null){
			$vb_id = $this->input->get('vb_id');
			$vb_point = $this->input->get('vb_point');
			$vb_type = $this->input->get('vb_type');
			$rs = $this->app_model->getVBFilesUploads($vb_id, $vb_point, $vb_type);	

			
			$data = array(
				'rs'			=> $rs,
				'vb_id'			=> $vb_id,
				'vb_point'		=> $vb_point,
				'vb_type'		=> $vb_type,
				'member'		=> $member
			);
			$this->load->view('dashboard/fancy_upload_file_vb', $data);
		}
	}
	
	public function ajax_vbfile(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$file_source_id = $this->input->get('file_source_id');
			$file_type = $this->input->get('file_type');
			$file_point = $this->input->get('file_point');
			$rs = $this->app_model->getVBFilesUploads($file_source_id, $file_point, $file_type);	
			echo json_encode($rs);
		}
	}
	
	public function project_ajax_vbuploads(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$ar = $this->input->post();
			if ($this->upload_filesvb($ar, $member, $_FILES['files']) === FALSE) {
				echo 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง อัพไฟล์ pdf|xls|xlsx|docx|jpg เท่านั้น';
			}else{
				echo 'อัพโหลดเรียบร้อย';
			}
		}
	}
	
	private function upload_filesvb($ar_post, $member, $files){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'pdf|xls|xlsx|docx|jpg';
		$config['max_size'] = 1000000;
		$config['encrypt_name'] = TRUE;
		$dir = './uploads/';
		$this->load->library('upload', $config);

		$document_file = array();
		
		foreach ($files['name'] as $key => $file) {
			$_FILES['document_file[]']['name']= $files['name'][$key];
			$_FILES['document_file[]']['type']= $files['type'][$key];
			$_FILES['document_file[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['document_file[]']['error']= $files['error'][$key];
			$_FILES['document_file[]']['size']= $files['size'][$key];

			$file_name =$files['name'][$key];
			$fileName =date('YmdHis').md5(rand(100, 200));
			$config['file_name'] = $fileName;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('document_file[]')) {
				$ar = array(
					'file_source_id'		=>$ar_post['file_source_id'],
					'file_point'			=>$ar_post['file_point'],
					'file_type'				=>$ar_post['file_type'],
					'file_name'				=>$file_name,
					'file_path'				=>$this->upload->data('file_name'),
					'file_size'				=>$this->upload->data('file_size'),
					'file_member_username'	=>$member['m_user'],
					'file_createdate'		=>date('Y-m-d H:i:s')
				);

				$id = $this->app_model->addProjectFileVB($ar);
			} else {
				return false;
			}
		}
    }
	
	public function ajax_vbfile_del(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
	
			$f_id = $this->input->post('file_id');
			$file_source_id = $this->input->post('file_source_id');
			$rs = $this->app_model->delVBFile($f_id, $file_source_id, $member);
		}
	}
	
	
	//THESIS
	public function thesis_file(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$thesis_id = $this->input->get('thesis_id');
			$rs = $this->app_model->getThesisFilesUploads($thesis_id);	

			
			$data = array(
				'rs'			=> $rs,
				'file_thesis_id'		=> $thesis_id,
				'member'		=> $member
			);
			$this->load->view('dashboard/fancy_upload_file_thesis', $data);
		}
	}
	public function ajax_thesisfile(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$file_thesis_id = $this->input->get('file_thesis_id');
		
			$rs = $this->app_model->getThesisFilesUploads($file_thesis_id);	
			echo json_encode($rs);
		}
	}
	
	public function thesis_ajax_uploads(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$ar = $this->input->post();
			if ($this->upload_filesthesis($ar, $member, $_FILES['files']) === FALSE) {
				echo 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง อัพไฟล์ pdf|docx เท่านั้น';
			}else{
				echo 'อัพโหลดเรียบร้อย';
			}
		}
	}
	
	private function upload_filesthesis($ar_post, $member, $files){
		$config['upload_path'] = './uploads/thesis/';
		$config['allowed_types'] = 'pdf|docx';
		$config['max_size'] = 1000000;
		$config['encrypt_name'] = FALSE;
		$dir = './uploads/thesis/';
		$this->load->library('upload', $config);

		$document_file = array();
		
		foreach ($files['name'] as $key => $file) {
			$_FILES['document_file[]']['name']= $files['name'][$key];
			$_FILES['document_file[]']['type']= $files['type'][$key];
			$_FILES['document_file[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['document_file[]']['error']= $files['error'][$key];
			$_FILES['document_file[]']['size']= $files['size'][$key];

			$file_name =$files['name'][$key];
			$fileName =date('YmdHis').md5(rand(100, 200));
			$config['file_name'] = $ar_post['file_thesis_id'].'_'.$file_name;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('document_file[]')) {
				$ar = array(
					'file_thesis_id'		=>$ar_post['file_thesis_id'],
					'file_name'				=>$file_name,
					'file_path'				=>$this->upload->data('file_name'),
					'file_size'				=>$this->upload->data('file_size'),
					'createdate'		=>date('Y-m-d H:i:s')
				);

				$id = $this->app_model->addThesisFileuploads($ar);
			} else {
				return false;
			}
		}
    }
	
	public function ajax_thesisfile_del(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$file_id = $this->input->post('file_id');
			$file_thesis_id = $this->input->post('file_thesis_id');
			$rs = $this->app_model->delThesisFile($file_id, $file_thesis_id);
		}
	}
	
	public function download_thesis(){
		$thesis_id = $this->uri->segment(3);
		$rsFile = $this->app_model->getThesisFilesUploads($thesis_id);
		if($rsFile!=null){
			$this->load->library('zip');
			foreach($rsFile as $item){
				$name = $item->file_path;
				$data = $item->file_name;
				$this->zip->add_data($name, $data);
			}
			
			$this->zip->archive('/var/www/eee/domains/3e.world/public_html/apps/uploads/thesis/download.zip');

			$this->zip->download('download.zip');
		}
	}
	
	public function thesis_bcl(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$rs = array();
			$thesis_class =1;
			$rsList = $this->app_model->getThesisLists($thesis_class);
			if($this->input->get('search_type')!=null && $this->input->get('search_txt')!=null){
				$rsList = $this->app_model->getThesisListsSearch($this->input->get('search_type'), $this->input->get('search_txt'));
			}
			$view = 'thesis';
			$do = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			
			if($this->input->post()!=null){
				$ar = $this->input->post();
				if($ar['thesis_id']!=null){
					$rs = $this->app_model->updateThesis($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_bcl/edit/'.$ar['thesis_id']).'";</script>';
					exit();
				}else{
					$rs = $this->app_model->insertThesis($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_bcl/edit/'.$rs).'";</script>';
					exit();
				}
			}else{
				
				if($do=="add"){
					$view 		= 'thesis_form';
				}else if($do=="edit"){
					$view 		= 'thesis_form';
					$rs	= $this->app_model->getThesisDetail($id);
				}else if($do=="del"){
					$rs	= $this->app_model->delThesis($id);
					echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_bcl/').'";</script>';
					exit();
				}
				
				$data = array(
					'rs'			=> $rs,
					'rsList'		=> $rsList,
					'thesis_class'		=> $thesis_class,
					'menu'			=> 'thesis',
					'menu_sub'		=> 'thesis_bcl',
					'view'			=> $view
				);

				$this->load->view('dashboard/template_main', $data);
			}
		}
	}
	
	public function thesis_mas(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$rs = array();
			$thesis_class =2;
			$rsList = $this->app_model->getThesisLists($thesis_class);
			if($this->input->get('search_type')!=null && $this->input->get('search_txt')!=null){
				$rsList = $this->app_model->getThesisListsSearch($this->input->get('search_type'), $this->input->get('search_txt'));
			}
			$view = 'thesis';
			$do = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			
			if($this->input->post()!=null){
				$ar = $this->input->post();
				if($ar['thesis_id']!=null){
					$rs = $this->app_model->updateThesis($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_mas/edit/'.$ar['thesis_id']).'";</script>';
					exit();
				}else{
					$rs = $this->app_model->insertThesis($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_mas/edit/'.$rs).'";</script>';
					exit();
				}
			}else{
				
				if($do=="add"){
					$view 		= 'thesis_form';
				}else if($do=="edit"){
					$view 		= 'thesis_form';
					$rs	= $this->app_model->getThesisDetail($id);
				}else if($do=="del"){
					$rs	= $this->app_model->delThesis($id);
					echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_mas/').'";</script>';
					exit();
				}
				
				$data = array(
					'rs'			=> $rs,
					'rsList'		=> $rsList,
					'thesis_class'		=> $thesis_class,
					'menu'			=> 'thesis',
					'menu_sub'		=> 'thesis_mas',
					'view'			=> $view
				);

				$this->load->view('dashboard/template_main', $data);
			}
		}
	}
	
	public function thesis_phd(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$rs = array();
			$thesis_class =3;
			$rsList = $this->app_model->getThesisLists($thesis_class);
			if($this->input->get('search_type')!=null && $this->input->get('search_txt')!=null){
				$rsList = $this->app_model->getThesisListsSearch($this->input->get('search_type'), $this->input->get('search_txt'));
			}
			$view = 'thesis';
			$do = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			
			if($this->input->post()!=null){
				$ar = $this->input->post();
				if($ar['thesis_id']!=null){
					$rs = $this->app_model->updateThesis($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_phd/edit/'.$ar['thesis_id']).'";</script>';
					exit();
				}else{
					$rs = $this->app_model->insertThesis($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_phd/edit/'.$rs).'";</script>';
					exit();
				}
			}else{
				
				if($do=="add"){
					$view 		= 'thesis_form';
				}else if($do=="edit"){
					$view 		= 'thesis_form';
					$rs	= $this->app_model->getThesisDetail($id);
				}else if($do=="del"){
					$rs	= $this->app_model->delThesis($id);
					echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/thesis_phd/').'";</script>';
					exit();
				}
				
				$data = array(
					'rs'			=> $rs,
					'rsList'		=> $rsList,
					'thesis_class'		=> $thesis_class,
					'menu'			=> 'thesis',
					'menu_sub'		=> 'thesis_phd',
					'view'			=> $view
				);

				$this->load->view('dashboard/template_main', $data);
			}
		}
	}
	
	public function research(){
		$member = $this->session->userdata('member_logged_in');
		if($member!=null){
			$rs = array();
			$thesis_class =3;
			$rsList = $this->app_model->getResearchLists();	
			if($this->input->get('search_type')!=null && $this->input->get('search_txt')!=null){
				$rsList = $this->app_model->getResearchListsSearch($this->input->get('search_type'), $this->input->get('search_txt'));
			}
			$view = 'research';
			$do = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			
			if($this->input->post()!=null){
				$ar = $this->input->post();
				if($_FILES['research_file']){
					$config['upload_path'] = './uploads/research/';
					$config['allowed_types'] = 'pdf';
					$config['max_size'] = 1000000;
					$config['encrypt_name'] = FALSE;

					$this->load->library('upload', $config);

					$fileName =date('YmdHis').md5(rand(100, 200));
					
					$this->upload->initialize($config);	
					if ($this->upload->do_upload('research_file')) {
						$ar['research_file'] = $this->upload->data('file_name');
					}else{
						echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .pdf, .xlsx, xls เท่านั้น");window.location="'.base_url('dashboard/research/').'";</script>';
					}
				}
				
				if($ar['research_id']!=null){
					$rs = $this->app_model->updateResearch($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/research/edit/'.$ar['research_id']).'";</script>';
					exit();
				}else{
					$rs = $this->app_model->insertResearch($ar);
					echo '<script>alert("บันทึกหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/research/edit/'.$rs).'";</script>';
					exit();
				}

			}else{
				if($do=="add"){
					$view 		= 'research_form';
				}else if($do=="edit"){
					$view 		= 'research_form';
					$rs	= $this->app_model->getResearchDetail($id);
				}else if($do=="del"){
					$rs	= $this->app_model->delResearch($id);
					echo '<script>alert("ลบหัวข้อเรียบร้อยแล้ว");window.location="'.base_url('dashboard/research/').'";</script>';
					exit();
				}
				
				$data = array(
					'rs'			=> $rs,
					'rsList'		=> $rsList,
					'menu'			=> 'research',
					'menu_sub'		=> '',
					'view'			=> $view
				);

				$this->load->view('dashboard/template_main', $data);
			}
		}
	}

}
