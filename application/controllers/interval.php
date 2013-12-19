<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Interval extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			/*if (!$this->input->is_cli_request()) {
				die('forbidden');
			}*/
			$this->load->helper('util');
		}
		
		public function regt_noti() {
			$subject = 'Visa2Vanuatu帐号激活';
			
			$prefix = '<p>新注册帐号激活链接</p>';
			
			$tips = '<p>链接有效期为注册后一小时内，若链接失效可前往系统登录帐户后根据提示重新发送激活链接。</p>';
			
			$suffix['applicant'] = $tips;
			$suffix['administrator'] = $tips.'<p>管理员帐户邮箱激活后还需待系统管理员开启管理操作权限方可正式使用。</p>';
			
			//while (TRUE) {
				$info = json_decode(pop_email_queue('register_notification'), TRUE);
				if ($info !== NULL) {
					$link = base_url('user/activate/'.$info['hash_key']);
					$data = array();
					$data['email'] = $info['email'];
					$data['user'] = '';
					$data['subject'] = $subject;
					$data['content'] = $prefix.$link.$suffix[$info['user_type']];
					
					send_email($data);
					
					unset($info);
					unset($data);
				} else {
					sleep(6);
				}
			//}
		}
		
		public function pswd_noti() {
		}
		
		public function pass_noti() {
			$this->load->model('interval_model', 'ivm');
			
			while (TRUE) {
				$uuid = pop_email_queue('pass_nitification');
				if ($uuid) {
				}
				$info = $this->ivm->combined_info($uuid);
			}
			
			
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