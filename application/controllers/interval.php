<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Interval extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			if (!$this->input->is_cli_request()) {
				die('forbidden');
			}
			$this->load->helper('util');
		}
		
		public function regt_noti() {
			$subject = 'VanuatuVisa帐户邮箱验证邮件';
			
			$prefix = '<p>新注册帐号激活（验证）链接</p>';
			
			$tips = '<p>链接有效期为注册后一小时内，若链接失效可前往系统登录帐户后根据提示重新发送激活链接。</p>';
			
			$suffix['applicant'] = $tips;
			$suffix['administrator'] = $tips.'<p>管理员帐户邮箱验证后还需待系统管理员开启管理操作权限方可正式使用。</p>';
			
			while (TRUE) {
				$info = json_decode(pop_email_queue('register_notification'), TRUE);
				if ($info !== NULL) {
					$link = base_url('/activation_confirm/'.$info['hash_key']);
					$data = array();
					$data['email'] = $info['email'];
					$data['user'] = '';
					$data['subject'] = $subject;
					$data['content'] = $prefix.'<a href="'.$link.'">'.$link.'</a>'.$suffix[$info['user_type']];
					
					send_email($data);
					
					unset($info);
					unset($data);
				} else {
					sleep(6);
				}
			}
		}
		
		public function pswd_noti() {
		}
		
		public function pass_noti() {
			$this->load->model('interval_model', 'ivm');
			
			$subject = 	'VanuatuVisa签证申请进度';
			$remark = 	'<p>所需证明文件包括：</p>'.
						'<p>（1）签证申请表格打印版；</p>'.
						'<p>（2）两张白底的签证照片；</p>'.
						'<p>（3）护照（要求六个月以上有效期）原件，复印件一份（复印主页信息即可）；</p>'.
						'<p>（4）个人身份证复印件（正反两面）；</p>'.
						'<p>（5）往返机票打印件；</p>'.
						'<p>（6）每人五万元人民币的银行存款证明原件。</p>';
			
			while (TRUE) {
				$uuid = pop_email_queue('pass_notification');
				if ($uuid) {
					$info = $this->ivm->combined_info($uuid);
					$greeting = '<p>尊敬的<b>'.$info['first_name'].' '.$info['last_name'].'</b>'.($info['gender'] == 1 ? '先生' : ($info['gender'] == 2 ? '女士' : '小姐')).'：</p>';
					$notification = '<p>你申请号<b>'.$uuid.'</b>的签证申请已通过初步审核，请在15天内带备相关证明及签证费用前往办事处作进一步确认。</p>';
					
					$data = array();
					$data['email'] = $info['email'];
					$data['user'] = $info['name_cn'];
					$data['subject'] = $subject;
					$data['content'] = $greeting.$notification.$remark;
					
					send_email($data);
					
					unset($info);
					unset($data);
				} else {
					sleep(20);
				}
			}
		}
		
		public function fail_noti() {
		}
		
		public function paid_noti() {
		}
		
		public function visa_noti() {
			$this->load->model('interval_model', 'ivm');
			
			$subject = 	'VanuatuVisa签证申请进度';
			$remark = 	'请下载签证文件（见附件）自行打印。';
			
			while (TRUE) {
				$uuid = pop_email_queue('visa_notification');
				if ($uuid) {
					$info = $this->ivm->combined_info($uuid);
					$greeting = '<p>尊敬的<b>'.$info['first_name'].' '.$info['last_name'].'</b>'.($info['gender'] == 1 ? '先生' : ($info['gender'] == 2 ? '女士' : '小姐')).'：</p>';
					$notification = '<p>你申请号<b>'.$uuid.'</b>的签证申请已成功通过全部审核并获得即日起30天有效期的Vanuatu签证（对应护照编号为<b>'.$info['passport_number'].'</b>），签证编号为<b>'.$info['visa_no'].'</b>。</p>';
					
					$data = array();
					$data['email'] = $info['email'];
					$data['user'] = $info['name_cn'];
					$data['subject'] = $subject;
					$data['content'] = $greeting.$notification.$remark;
					$data['visa_file'] = VISA_PATH .$uuid .'/' .$info['visa_no'] .'.docx';
					
					send_email($data);
					
					unset($info);
					unset($data);
				} else {
					sleep(60);
				}
			}
		}
		
		public function oops_noti() {
		}
		
		public function lost_noti() {
		}
		
		public function best_noti() {
			$this->load->model('interval_model', 'ivm');
			$uuids = $this->ivm->find_expiring_visa();
			
			if (count($uuids) > 0) {
				$this->ivm->set_visa_expired($uuids);
			}
		}
	}
?>