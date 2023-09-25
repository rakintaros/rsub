<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	 
	public function __construct()
	{
		parent::__construct();
		$this->load->library('GoogleAuthenticator');
	
	}
	
	public function index()
	{
		// generates the secret code
		$secret = $this->googleauthenticator->createSecret();

		// generates the QR code for the link the user's phone with the service
		$qrCodeUrl = $this->googleauthenticator->getQRCodeGoogleUrl('Service Name', 'user@email.com', $secret);

		// also, you can get a code to test the service
		$oneCode = $this->googleauthenticator->getCode($secret);
		
		//$checkResult = $this->googleauthenticator->verifyCode($secret, $code, 2); // 2 = 2*30sec clock tolerance

		//if ($checkResult) {
		//	echo 'OK';
		//} else {
		//	echo 'FAILED';
		//}

		$this->load->view('welcome_message');
	}
}
