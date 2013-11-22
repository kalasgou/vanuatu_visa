<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class LoginController extends CI_Controller {
	
	public $userid = 0;
	public $user_info = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model', 'user');
		$this->user_info = $this->user->getCurrentUserInfo();
		
		if ($this->user_info) {
			// already logined
			$this->userid = $this->user_info['userid'];
		} else {
			// not logined yet
			$this->goto_login();
		}
	}
	
	protected function goto_login() {
		
	}
	
	protected function goto_logout() {
		
	}
	
	protected function check_permission() {
		
	}
}
?>