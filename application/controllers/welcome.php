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
	
	public function account() {
		if ($this->userid === 0 || $this->status != 1) {
			$msg['tips'] = '请登录后再进行此操作！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$user = $this->user_info;
		
		$provinces = array('1' => '北京', '2' => '广州', '3' => '上海');
		$permissions = array('1' => '系统管理员', '2' => '大使馆管理员', '3' => '办事处管理员', '10000' => '普通用户');
		$accounts = array('-1' => '已失效', '0' => '未激活', '1' => '正常');
		
		if (isset($user['province_id'])) {
			$user['province_str'] = $provinces[$user['province_id']];
		}
		$user['permission_str'] = $permissions[$user['permission']];
		$user['status_str'] = $accounts[$user['status']];
		
		$this->load->helper('util');
		$user['captcha'] = get_captcha();
		
		$this->load->view('account', $user);
	}
	
	public function password() {
		if ($this->userid === 0 || $this->status != 1) {
			$msg['tips'] = '请登录后再进行此操作！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$data['permission'] = $this->user_info['permission'];
		$this->load->view('password', $data);
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