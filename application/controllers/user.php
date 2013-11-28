<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require APPPATH .'core/LoginController.php'

class User extends CI_Controller {
	
	public function register() {
		$user_type = trim($this->input->post('user_type', TRUE));
		$data['email'] = trim($this->input->post('email', TRUE));
		$data['password'] = trim($this->input->post('password', TRUE));
		
		switch ($user_type) {
			case 'applicant':
				$data['nickname'] = trim($this->input->post('nickname', TRUE));
				$data['realname'] = trim($this->input->post('realname', TRUE));
				$data['phone'] = trim($this->input->post('phone', TRUE));
				break;
			case 'administrator':
				$data['name'] = trim($this->input->post('name', TRUE));
				$data['permission'] = trim($this->input->post('permission', TRUE));
				$data['province_id'] = trim($this->input->post('province_id', TRUE));
				break;
			default :
				echo 'error'; die();
		}
		
		$this->load->helper('util');
		if (!check_parameters($data)) {
			$msg['tips'] = 'parameters not enough';
			$this->load->view('simple_msg_page', $msg);
			die();
		}
		
		if (!email_verify($data['email'])) {
			$msg['tips'] = 'email incorrect';
			$this->load->view('simple_msg_page', $msg);
			die();
		}
		
		require '../application/third_party/pass/PasswordHash.php';
		$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
		$data['password'] = $hasher->HashPassword($data['password']);
		if (strlen($data['password']) < 20) {
			log_message('error', 'hash too short');
			die();
		}
		
		$this->load->model('user_model', 'user');
		$func_name = $user_type.'_register';
		
		if ($this->user->$func_name($data) > 0) {
			$this->load->view('');
		} else {
			$this->load->view('');
		}
		
		exit(0);
	}
	
	public function login() {
		$user_type = trim($this->input->get('user_type', TRUE));
		$data['email'] = trim($this->input->get('email', TRUE));
		$data['password'] = trim($this->input->get('password', TRUE));
		
		$this->load->helper('util');
		if (!check_parameters($data)) {
			$msg['tips'] = 'parameters not enough';
			$this->load->view('simple_msg_page', $msg);
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
				echo 'success';
			} else {
				echo 'password error';
			}
			$this->load->view('');
		} else {
			$this->load->view('');
		}
		
		exit(0);
	}
	
	public function logout() {
		//$userid = $this->userid;
		$local_key = trim($this->input->cookie('local_key'));
		$this->load->model('user_model', 'user');
		$this->user->pop_cookie($local_key);
		
		$this->load->view('');
		
		exit(0);
	}
}

/* End of file */