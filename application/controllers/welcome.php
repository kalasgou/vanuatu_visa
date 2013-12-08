<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/LoginController.php';

class Welcome extends LoginController {
	
	public function index() {
		$this->load->view('welcome');
	}
	
	public function login() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/apply';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->view('login');
	}
	
	public function register() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/apply';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->view('register');
	}
	
	public function admin_login() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/admin';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->view('admin_login');
	}
	
	public function admin_register() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/admin';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->view('admin_register');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */