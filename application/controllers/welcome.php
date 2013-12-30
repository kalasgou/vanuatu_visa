<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/LoginController.php';

class Welcome extends LoginController {
	
	public function index() {
		$this->load->view('welcome');
	}
	
	public function login() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = '已经登录无需重复登录！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('login', $data);
	}
	
	public function register() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = '已经登录，若需注册请先登出帐户！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('register', $data);
	}
	
	public function admin_login() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = '已经登录无需重复登录！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('admin_login', $data);
	}
	
	public function admin_register() {
		if ($this->userid > 0 && $this->status == 1) {
			$msg['tips'] = '已经登录，若需注册请先登出帐户！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('admin_register', $data);
	}
	
	public function change_password() {
		if ($this->userid === 0 || $this->status != 1) {
			$msg['tips'] = '请登录后再进行此操作！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('change_password', $data);
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