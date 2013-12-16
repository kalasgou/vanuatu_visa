<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Interval extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			/*if (!$this->input->is_cli_request()) {
				die('forbidden');
			}*/
		}
		
		public function regt_noti($uuid) {
			$this->load->model('interval_model', 'ivm');
			var_dump($this->ivm->combined_info($uuid));
		}
		
		public function pswd_noti() {
		}
		
		public function pass_noti() {
		}
		
		public function fail_noti() {
		}
		
		public function paid_noti() {
		}
		
		public function visa_noti() {
		}
		
		public function oops_noti() {
		}
		
		public function lost_noti() {
		}
		
		public function best_noti() {
		}
	}
?>