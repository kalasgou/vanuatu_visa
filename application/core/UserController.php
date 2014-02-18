<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/LoginController.php';

abstract class UserController extends LoginController {
	
	public function __construct() {
		parent::__construct();
		
		if ($this->userid == ILLEGAL_USER || $this->status != ACCOUNT_NORMAL) {
			header('Location: '.base_url('/login'));
			exit('Not Logined Yet');
		}
	}
}
?>