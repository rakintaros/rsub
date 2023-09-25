<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {

	 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('app_model');
		/*check session*/
        if($this->uri->segment(2)!="login"){
        	if($this->session->userdata('member_logged_in')==""){
         		redirect('auth/login');
      	  	}
        }
	}
	
	function download_file($path, $name){
		if(is_file($path)){	
			$this->load->helper('file');

			header('Content-Type: '.get_mime_by_extension($path));  
			header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path)); // provide file size
			header('Connection: close');
			readfile($path); 
			die();
		}
	}

	

	public function index($file)
	{
		echo 'develop';
		//echo $file;
		//echo '<br/>';
		//echo $name;
		exit;
		$this->download_file('uploads/'.$file, $file);
	}
	
	
	public function index2($file, $name)
	{
		$this->download_file('uploads/'.$file, $name);
	}

}
