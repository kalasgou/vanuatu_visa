<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Simple extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function testMkdir($uuid) {
		$path = SCAN_PATH .substr($uuid, 0, 2) ."/$uuid/";
		var_dump($path);
		var_dump(mkdir($path, 0777, TRUE));
	}
}
?>