<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class ApplyLoginController extends CI_Controller {
	
	public $userid = 0;
	public $user_info = array();
	
	public function __construct() {
		parent::__construct();
		
		$local_key = trim($this->input->cookie('local_key'));
		
		$this->load->model('user_model', 'user');
		$this->user_info = $this->user->retrieve_cookie($local_key);
		
		if ($this->user_info) {
			// already logined
			$this->userid = $this->user_info['userid'];
		} else {
			// not logined yet
			header('Location: '.base_url('login'));
			die();
		}
	}
}
?>