<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class AdminLoginController extends CI_Controller {
	
	public $userid = ILLEGAL_USER;
	public $permission = ILLEGAL_USER;
	public $status = ACCOUNT_CANCELLED;
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
			
			if ($this->status != ACCOUNT_NORMAL) {
				$msg['tips'] = '帐户未激活。若已验证邮箱，请等待系统管理员激活帐户；未验证邮箱可点击下面链接重新获取验证链接。';
				$link = '/user/send_activation_code/administrator/'.$this->userid;
				$location = '重新发送邮箱验证';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			} else if ($this->permission < SYSTEM_ADMIN || $this->permission > AGENCY_ADMIN) {
				$msg['tips'] = '帐户无效！';
				$link = '/admin_login';
				$location = '返回登录页';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			} 
		} else {
			// not logined yet
			header('Location: '.base_url('admin_login'));
			die();
		}
	}
}
?>