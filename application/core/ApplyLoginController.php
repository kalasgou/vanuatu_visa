<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class ApplyLoginController extends CI_Controller {
	
	public $userid = 0;
	public $permission = 0;
	public $status = -1;
	public $user_info = array();
	
	public function __construct() {
		parent::__construct();
		
		$local_key = trim($this->input->cookie('local_key'));
		
		$this->load->model('user_model', 'user');
		$this->user_info = $this->user->retrieve_cookie($local_key);
		
		if ($this->user_info) {
			// already logined
			$this->userid = $this->user_info['userid'];
			$this->permission = $this->user_info['permission'];
			$this->status = $this->user_info['status'];
			
			if ($this->status != 1) {
				$msg['tips'] = 'account not verified';
				$link = '/login';
				$location = 'index page';
				$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
				show_error($msg);
			} else if ($this->permission != 10000) {
				$msg['tips'] = 'account forbidden';
				$link = '/login';
				$location = 'index page';
				$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
				show_error($msg);
			} 
		} else {
			// not logined yet
			header('Location: '.base_url('login'));
			die();
		}
	}
}
?>