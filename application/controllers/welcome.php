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
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('login', $data);
	}
	
	public function register() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/apply';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('register', $data);
	}
	
	public function admin_login() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/admin';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('admin_login', $data);
	}
	
	public function admin_register() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = 'already logined';
			$link = '/admin';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('admin_register', $data);
	}
	
	public function refresh_captcha() {
		session_start();
		if (!isset($_SESSION['timestamp'])) {
			$_SESSION['timestamp'] = $_SERVER['REQUEST_TIME'];
		}
		if ($_SERVER['REQUEST_TIME'] - $_SESSION['timestamp'] >= 60) {
			$this->load->helper('util');
			$captcha = get_captcha();
			
			$_SESSION['timestamp'] = $_SERVER['REQUEST_TIME'];
			
			$ret['msg'] = 'success';
			$ret['captcha'] = $captcha;
		} else {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */