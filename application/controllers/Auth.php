<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	 
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
      	  	}
        }
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
	
	public function index()
	{
		redirect('auth/login');
	}
	
	public function login(){

		$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('factor', 'two-factor', 'trim|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|callback_check_database');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view("auth/login2");
		}else{
			$secret = $this->googleauthenticator->createSecret();
			$this->session->set_userdata('s_secret', $secret);
			
			$m = date('m')*1;
			$this->session->set_userdata('advance_m', $m);
			$this->session->set_userdata('advance_y', date('Y'));
			
			$this->session->set_userdata('project_type', 'all');
			$this->session->set_userdata('project_year', date('Y'));
			$this->session->set_userdata('tab_select', 'before');
			
			$member = $this->session->userdata('member_logged_in');
			$ar = array(
				'log_member_username'	=> $member['m_user'],
				'log_action'			=> 'เข้าสู่ระบบสำเร็จ',
				'log_ua'				=> $this->getUseraAgent(),
				'log_datetime'			=> date('Y-m-d H:i:s')
			);
			$this->do_action($ar);
		
			redirect('dashboard');
		}
	}
	
	public function check_database($password){
		$username = $this->input->post('username');
		$code = $this->input->post('factor');
		
		$result = $this->app_model->login($username, md5(sha1($password)));
		if($result)
		{
			if($result[0]->member_secret){
				$checkResult = $this->googleauthenticator->verifyCode($result[0]->member_secret, $code, 2); // 2factor check
				if($checkResult){
					$sess_array = array();
					foreach($result as $row)
					{
						$sess_array = array(
							'm_user' => $row->member_username,
							'm_name' => $row->member_name,
							'm_position' => $row->member_position,
							'm_img' => $row->member_img,
							'm_level' => $row->member_level,
							'm_email' => $row->member_email,
							'm_factor'	=> 1
						);
						$this->session->set_userdata('member_logged_in', $sess_array);
					}
					return TRUE;
				}else{
					$message='<div class="alert alert-danger"><strong>คำเตือน !</strong> การยืนยันรหัสผ่าน 2 ขั้นตอนไม่ถูกต้อง</div>';
					$this->form_validation->set_message('check_database', $message);
					return false;
				}
			}else{
				foreach($result as $row)
					{
					$sess_array = array(
						'm_user' => $row->member_username,
						'm_name' => $row->member_name,
						'm_position' => $row->member_position,
						'm_img' => $row->member_img,
						'm_level' => $row->member_level,
						'm_email' => $row->member_email,
						'm_factor'	=> 0
					);
					$this->session->set_userdata('member_logged_in', $sess_array);
				}
				return TRUE;
			}
		}else{
			$message='<div class="alert alert-danger"><strong>คำเตือน !</strong> ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง</div>';
			$this->form_validation->set_message('check_database', $message);
			return false;
		}
	}
	
	public function createSecret(){
		$member = $this->session->userdata('member_logged_in');
		$ar = array(
			'log_member_username'	=> $member['m_user'],
			'log_action'			=> 'ขอรหัส 2 factor ใหม่',
			'log_ua'				=> $this->getUseraAgent(),
			'log_datetime'			=> date('Y-m-d H:i:s')
		);
		$this->do_action($ar);
		
		$secret = $this->googleauthenticator->createSecret();
		$this->session->set_userdata('s_secret', $secret);	
		echo $secret;
	}
	
	public function logout() {
		$member = $this->session->userdata('member_logged_in');
		$ar = array(
			'log_member_username'	=> $member['m_user'],
			'log_action'			=> 'ออกจากระบบ',
			'log_ua'				=> $this->getUseraAgent(),
			'log_datetime'			=> date('Y-m-d H:i:s')
		);
		$this->do_action($ar);
		$this->session->unset_userdata('member_logged_in');
		redirect('auth');
		exit();
    }
}
