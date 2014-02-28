<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/LoginController.php';

class Welcome extends LoginController {
	
	public function index() {
		$this->load->view('visa_verify');
	}
	
	public function login() {
		if ($this->userid > ILLEGAL_USER && $this->status == ACCOUNT_NORMAL) {
			$msg['tips'] = '已经登录无需重复登录！';
			$link = '/user/index';
			$location = '返回用户主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('login', $data);
	}
	
	public function register() {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->view('register');
	}
	
	public function partner() {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->view('province_city_agency');
	}
	
	/*public function register() {
		if ($this->userid > ILLEGAL_USER && $this->status == ACCOUNT_NORMAL) {
			$msg['tips'] = '已经登录，若需注册请先登出帐户！';
			$link = '/apply/index';
			$location = '返回用户主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('register', $data);
	}
	
	public function admin_login() {
		if ($this->userid > ILLEGAL_USER && $this->status == ACCOUNT_NORMAL) {
			$msg['tips'] = '已经登录无需重复登录！';
			$link = '/admin/index';
			$location = '返回用户主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('admin_login', $data);
	}
	
	public function admin_register() {
		if ($this->userid > ILLEGAL_USER && $this->status == ACCOUNT_NORMAL) {
			$msg['tips'] = '已经登录，若需注册请先登出帐户！';
			$link = '/admin/index';
			$location = '返回用户主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		$data['captcha'] = get_captcha();
		$this->load->view('admin_register', $data);
	}
	
	public function activation_confirm($hash_key = '') {
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		
		if (($info = json_decode($redis->get($hash_key), TRUE)) !== NULL) {
			switch ($info['user_type']) {
				case 'applicant': 
					$info['tips'] = '请核对帐户信息无误后再激活帐户。'; break;
				case 'administrator': 
					$info['tips'] = '管理员帐号通过邮箱验证后须待系统管理员激活后才可正常使用，激活情况将会以电子邮件形式通知。'; break;
			}
			
			$this->load->view('activation_confirm', $info);
		} else {
			$msg['tips'] = '激活链接无效或已过期，请先登录帐户后根据提示重新获取！';
			$link = '/index.php';
			$location = '返回网站主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}*/
	
	public function account() {
		if ($this->userid == ILLEGAL_USER || $this->status != ACCOUNT_NORMAL) {
			$msg['tips'] = '请登录后再进行此操作！';
			$link = '/login';
			$location = '点击登录';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$user = $this->user_info;
		
		$this->load->model('user_model', 'user');
		$extra_info = $this->user->extra_info($user['city_id']);
		
		$user['city_str'] = $extra_info['city_cn'];
		$user['province_str'] = $extra_info['province_cn'];
		$user['permission_str'] = $this->config->item($user['permission'], 'account_type');
		$user['status_str'] = $this->config->config['account_status'][$user['status']];
		
		//$this->load->helper('util');
		//$user['captcha'] = get_captcha();
		
		$this->load->view('account', $user);
	}
	
	public function password() {
		if ($this->userid == ILLEGAL_USER || $this->status != ACCOUNT_NORMAL) {
			$msg['tips'] = '请登录后再进行此操作！';
			$link = '/login';
			$location = '点击登录';
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
			$_SESSION['timestamp'] = $_SERVER['REQUEST_TIME'] - 61;
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
	
	public function visa_verify() {
		$this->load->view('visa_verify');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */