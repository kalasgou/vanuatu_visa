<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/LoginController.php';

class User extends LoginController {
	
	protected $goto_page = array(
							'applicant' => array('apply', 'login', 'register'),
							'administrator' => array('admin', 'admin_login', 'admin_register'),
							);
	
	public function register() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$captcha = trim($this->input->post('captcha', TRUE));
		$data['email'] = trim($this->input->post('email', TRUE));
		$data['password'] = trim($this->input->post('password', TRUE));
		$data['realname'] = trim($this->input->post('realname', TRUE));
		
		switch ($user_type) {
			case 'applicant':
				$data['nickname'] = trim($this->input->post('nickname', TRUE));
				$data['phone'] = trim($this->input->post('phone', TRUE));
				$data['status'] = 0;
				break;
			case 'administrator':
				$data['permission'] = trim($this->input->post('permission', TRUE));
				$data['province_id'] = trim($this->input->post('province_id', TRUE));
				$data['status'] = -1;
				break;
			default :
				show_error('非法操作！');
		}
		
		$this->load->helper('util');
		
		if (!check_captcha($captcha)) {
			$msg['tips'] = '验证码错误，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if (!check_parameters($data)) {
			$msg['tips'] = '所需填写信息不全，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if (!email_verify($data['email'])) {
			$msg['tips'] = '电子邮箱格式不正确，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_email_available';
		
		if ($this->user->$func_name($data['email']) > 0) {
			$msg['tips'] = '所填邮箱已被他人使用，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['reg_ip'] = ip2long($this->input->ip_address());
		$data['reg_time'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		
		require '../application/third_party/pass/PasswordHash.php';
		$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
		$data['password'] = $hasher->HashPassword($data['password']);
		if (strlen($data['password']) < 20) {
			show_error('password hash too short');
		}
		
		$func_name = $user_type.'_register';
		
		if (($userid = $this->user->$func_name($data)) > 0) {
			// account activation
			$this->load->library('RedisDB');
			$redis = $this->redisdb->instance(REDIS_DEFAULT);
			
			$hash_key = md5($userid.'_'.$data['email'].'_'.$data['reg_time']);
			$info['userid'] = $userid;
			$info['user_type'] = $user_type;
			$redis->setex($hash_key, 3600, json_encode($info));
			
			$info['hash_key'] = $hash_key;
			$info['email'] = $data['email'];
			push_email_queue('register_notification', json_encode($info));
			
			$msg['tips'] = '注册成功，帐户激活链接会在三分钟内发送到你的注册邮箱。';
			$link = '/user/send_activation_code/'.$user_type.'/'.$userid;
			$location = '重新发送邮箱验证';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		} else {
			$msg['tips'] = '注册失败，请稍候再试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function login() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$captcha = trim($this->input->post('captcha', TRUE));
		$data['email'] = trim($this->input->post('email', TRUE));
		$data['password'] = trim($this->input->post('password', TRUE));
		
		$this->load->helper('util');
		
		if (!check_captcha($captcha)) {
			$msg['tips'] = '验证码错误，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if (!check_parameters($data)) {
			$msg['tips'] = '所需填写信息不全，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_login';
		
		if (($user = $this->user->$func_name($data['email']))) {
			require '../application/third_party/pass/PasswordHash.php';
			$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
			$chk_lower = $hasher->CheckPassword(strtolower($data['password']), $user['password']);
			$chk_upper = $hasher->CheckPassword(strtoupper($data['password']), $user['password']);
			
			if ($chk_lower || $chk_upper) {
				$this->user->push_cookie($user);
				header('Location: ' .base_url() .$this->goto_page[$user_type]['0']);
			} else {
				$msg['tips'] = '密码不正确，请返回重新输入！';
				$link = 'javascript:history.go(-1);';
				$location = '返回上一步';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			}
		} else {
			$msg['tips'] = '该帐户不存在，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function logout() {
		$local_key = trim($this->input->cookie('local_key'));
		$this->load->model('user_model', 'user');
		$this->user->pop_cookie($local_key);
		
		$msg['tips'] = '帐户已安全登出！';
		$link = '/';
		$location = '返回网站主页';
		$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
		show_error($msg);
	}
	
	/*public function update() {
		$user_type = trim($this->input->post('user_type', TRUE));
	}*/
	
	public function change_password() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$captcha = trim($this->input->post('captcha', TRUE));
		$old_pswd = trim($this->input->post('old_password', TRUE));
		$new_pswd = trim($this->input->post('new_password', TRUE));
		
		$this->load->helper('util');
		
		if (!check_captcha($captcha)) {
			$ret['msg'] = 'captcha';
			echo json_encode($ret);
			die();
		}
		
		if (($user = $this->user_info)) {
			require '../application/third_party/pass/PasswordHash.php';
			$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
			$chk_lower = $hasher->CheckPassword(strtolower($old_pswd), $user['password']);
			$chk_upper = $hasher->CheckPassword(strtoupper($old_pswd), $user['password']);
			
			if ($chk_lower || $chk_upper) {
				$data['user_type'] = trim($this->input->post('user_type', TRUE));
				$data['userid'] = $this->userid;
				$data['password'] = $hasher->HashPassword($new_pswd);
				
				$this->load->model('user_model', 'user');
				if ($this->user->update_password($data) > 0) {
					$ret['msg'] = 'success';
					$local_key = trim($this->input->cookie('local_key'));
					$this->user->pop_cookie($local_key);
				} else {
					$ret['msg'] = 'fail';
				}
			} else {
				$ret['msg'] = 'different';
			}
		} else {
			$ret['msg'] = 'forbidden';
		}
		
		echo json_encode($ret);
	}
	
	public function check_email() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$email = trim($this->input->post('email', TRUE));
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_email_available';
		
		$ret['msg'] = 'success';
		
		if ($this->user->$func_name($email) > 0) {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
	
	public function check_nickname() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$nickname = trim($this->input->post('nickname', TRUE));
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_nickname_available';
		
		$ret['msg'] = 'success';
		
		if ($this->user->$func_name($nickname) > 0) {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
	
	public function activate($hash_key = '') {
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		
		if (($info = json_decode($redis->get($hash_key), TRUE)) !== NULL) {
			switch ($info['user_type']) {
				case 'applicant': $info['status'] = 1; break;
				case 'administrator': $info['status'] = 0; break;
				default : $info['status'] = 0;
			}
			
			$this->load->model('user_model', 'user');
			if ($this->user->change_account_status($info) > 0) {
				$redis->del($hash_key);
				
				$msg['tips'] = '帐户成功激活！';
				$link = '/'.$this->goto_page[$info['user_type']]['1'];
				$location = '点击登录';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			} else {
				$msg['tips'] = '帐户已激活，无需重复操作！';
				$link = '/'.$this->goto_page[$info['user_type']]['1'];
				$location = '点击登录';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			}
		} else {
			$msg['tips'] = '激活链接无效或已过期，请重新获取！';
			$link = '/user/send_activation_code/'.$info['user_type'].'/'.$info['userid'];
			$location = '重新发送邮箱验证';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function send_activation_code($user_type = '', $userid = '') {
		if ($user_type !== '' && $userid !== '') {
			$this->load->helper('util');
			$this->load->model('user_model', 'user');
			$func_name = $user_type.'_info';
			
			$user = array();
			$user = $this->user->$func_name($userid);
			
			if ($user && $user['status'] == 0) {
				$ret['msg'] = 'success';
				
				$this->load->library('RedisDB');
				$redis = $this->redisdb->instance(REDIS_DEFAULT);
				
				$hash_key = md5($user['userid'].'_'.$user['email'].'_'.$_SERVER['REQUEST_TIME']);
				$info = array();
				$info['userid'] = $user['userid'];
				$info['user_type'] = $user_type;
				$redis->setex($hash_key, 3600, json_encode($info));
				
				$info['hash_key'] = $hash_key;
				$info['email'] = $user['email'];
				push_email_queue('register_notification', json_encode($info));
			} else {
				$ret['msg'] = 'empty';
			}
		} else {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
}

/* End of file */