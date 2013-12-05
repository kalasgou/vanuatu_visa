<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends LoginController {
	
	protected $goto_page = array(
							'applicant' => array('apply', 'login', 'register'),
							'administrator' => array('admin', 'admin_login', 'admin_register'),
							);
	
	public function register() {
		if ($this->userid > 0) {
			$msg['tips'] = 'already logined';
			$link = '/admin_login';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$user_type = trim($this->input->post('user_type', TRUE));
		$data['email'] = trim($this->input->post('email', TRUE));
		$data['password'] = trim($this->input->post('password', TRUE));
		$data['realname'] = trim($this->input->post('realname', TRUE));
		
		switch ($user_type) {
			case 'applicant':
				$data['nickname'] = trim($this->input->post('nickname', TRUE));
				$data['phone'] = trim($this->input->post('phone', TRUE));
				break;
			case 'administrator':
				$data['permission'] = trim($this->input->post('permission', TRUE));
				$data['province_id'] = trim($this->input->post('province_id', TRUE));
				break;
			default :
				show_error('forbidden', 500);
				die();
		}
		
		$this->load->helper('util');
		if (!check_parameters($data)) {
			show_error('parameters not enough', 500);
			die();
		}
		
		if (!email_verify($data['email'])) {
			show_error('email incorrect', 500);
			die();
		}
		
		$data['reg_ip'] = ip2long($this->input->ip_address());
		$data['reg_time'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		$data['status'] = 0;
		
		require '../application/third_party/pass/PasswordHash.php';
		$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
		$data['password'] = $hasher->HashPassword($data['password']);
		if (strlen($data['password']) < 20) {
			show_error('password hash too short', 500);
			die();
		}
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_register';
		
		if ($this->user->$func_name($data) > 0) {
			$msg['tips'] = 'register success';
			$msg['link'] = '/'.$this->goto_page[$user_type]['1'];
			$msg['location'] = 'index page';
			$this->load->view('simple_msg_page', $msg);
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
			die();
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
				$msg['tips'] = 'this account not existed';
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
		//$userid = $this->userid;
		$local_key = trim($this->input->cookie('local_key'));
		$this->load->model('user_model', 'user');
		$this->user->pop_cookie($local_key);
		
		$msg['tips'] = 'signed out successful';
		$msg['link'] = '/';
		$msg['location'] = 'index page';
		$this->load->view('simple_msg_page', $msg);
	}
	
	public function account() {
		$user = $this->user;
		$this->load->view('account', $user);
	}
}

/* End of file */