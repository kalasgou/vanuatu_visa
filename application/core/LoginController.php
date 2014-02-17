<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class LoginController extends CI_Controller {
	
	public $userid = ILLEGAL_USER;
	public $status = ACCOUNT_INACTIVE;
	public $permission = ILLEGAL_USER;
	public $user_info = array();
	
	public function __construct() {
		parent::__construct();
		
		$local_key = trim($this->input->cookie('local_key'));
		
		$this->load->model('user_model', 'user');
		$this->user_info = $this->user->retrieve_cookie($local_key);
		
		if ($this->user_info) {
			$this->userid = $this->user_info['userid'];
			$this->status = $this->user_info['status'];
			$this->permission = $this->user_info['permission'];
		}
	}
}
?>