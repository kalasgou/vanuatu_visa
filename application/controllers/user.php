<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/LoginController.php';

class User extends LoginController {
	
	protected $goto_page = array(
							'applicant' => array('apply', 'login', 'register'),
							'administrator' => array('admin', 'admin_login', 'admin_register'),
							);
	
	public function register() {
		$user_type = trim($this->input->post('user_type', TRUE));
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
				show_error('forbidden');
		}
		
		$this->load->helper('util');
		if (!check_parameters($data)) {
			show_error('parameters not enough');
		}
		
		if (!email_verify($data['email'])) {
			show_error('email incorrect');
		}
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_email_available';
		
		if ($this->user->$func_name($data['email']) > 0) {
			show_error('email not available');
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
			$msg['tips'] = 'register success';
			$msg['link'] = '/'.$this->goto_page[$user_type]['1'];
			$msg['location'] = 'index page';
			$this->load->view('simple_msg_page', $msg);
			
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
		} else {
			$msg['tips'] = 'register fail';
			$msg['link'] = '/'.$this->goto_page[$user_type]['2'];
			$msg['location'] = 'index page';
			$this->load->view('simple_msg_page', $msg);
		}
	}
	
	public function login() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$data['email'] = trim($this->input->post('email', TRUE));
		$data['password'] = trim($this->input->post('password', TRUE));
		
		$this->load->helper('util');
		if (!check_parameters($data)) {
			show_error('parameters not enough');
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
				$msg['tips'] = 'password error';
				$msg['link'] = '/'.$this->goto_page[$user_type]['1'];
				$msg['location'] = 'index page';
				$this->load->view('simple_msg_page', $msg);
			}
		} else {
			$msg['tips'] = 'this account not existed';
			$msg['link'] = '/'.$this->goto_page[$user_type]['1'];
			$msg['location'] = 'index page';
			$this->load->view('simple_msg_page', $msg);
		}
	}
	
	public function logout() {
		$local_key = trim($this->input->cookie('local_key'));
		$this->load->model('user_model', 'user');
		$this->user->pop_cookie($local_key);
		
		$msg['tips'] = 'signed out successful';
		$msg['link'] = '/';
		$msg['location'] = 'index page';
		$this->load->view('simple_msg_page', $msg);
	}
	
	public function account() {
		$user = $this->user_info;
		
		$provinces = array('1' => '北京', '2' => '广州', '3' => '上海');
		$permissions = array('1' => '系统管理员', '2' => '大使馆管理员', '3' => '办事处管理员', '10000' => '普通用户');
		$accounts = array('-1' => '已失效', '0' => '未激活', '1' => '正常');
		
		if (isset($user['province_id'])) {
			$user['province_str'] = $provinces[$user['province_id']];
		}
		$user['permission_str'] = $permissions[$user['permission']];
		$user['status_str'] = $accounts[$user['status']];
		
		$this->load->view('account', $user);
	}
	
	public function update() {
		$user_type = trim($this->input->post('user_type', TRUE));
	}
	
	public function password() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$data['old_pswd'] = trim($this->input->post('old_password', TRUE));
		$data['new_pswd'] = trim($this->input->post('new_password', TRUE));
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
				
				$msg['tips'] = 'Account Activated';
				$msg['link'] = '/'.$this->goto_page[$info['user_type']]['1'];
				$msg['location'] = 'index page';
				$this->load->view('simple_msg_page', $msg);
			} else {
				show_error('activation error');
			}
		} else {
			show_error('Link expired or not existed!');
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