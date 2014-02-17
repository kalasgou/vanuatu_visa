<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class UserController extends LoginController {
	
	public function __construct() {
		parent::__construct();
		
		if ($this->status != ACCOUNT_NORMAL) {
			$msg['tips'] = '帐户未激活。';
			$link = '/user/activation/'.$this->userid;
			$location = '请求开通此帐户操作权限';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		} else {
			header('Location: '.base_url('/login'));
			exit('Not Logined Yet');
		}
	}
}
?>