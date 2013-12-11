<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/AdminLoginController.php';

class Admin extends AdminLoginController {

	public function index() {
		switch (intval($this->permission)) {
			case 3: header('Location: '. base_url('/admin/audit')); break;
			case 2: header('Location: '. base_url('/admin/approve')); break;
			case 1: header('Location: '. base_url('/admin/permit')); break;
			default : 
				$msg['tips'] = 'account forbidden';
				$link = '/admin_login';
				$location = 'index page';
				$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
				show_error($msg);
		}
	}
	
	public function audit($page = 1) {
		if ($this->user_info['permission'] != 3) {
			$msg['tips'] = 'account forbidden';
			$link = '/admin_login';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['province_id'] = $this->user_info['province_id'];
		$data['page'] = $page - 1;
		
		$status = trim($this->input->get('cur_status', TRUE));
		$data['status'] = text2status(($status === '' ? 'wait' : $status));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/audit/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_applications($data);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		if (count($_GET) > 0) {
			$config['suffix'] = '?'.http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'1?'.http_build_query($_GET, '', "&");
		}
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['records'] = $this->adm->get_applications($data);
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = status2text($one['status']);
		}
		
		$this->load->view('admin_audit', $data);
	}
	
	public function approve($page = 1) {
		if ($this->user_info['permission'] != 2) {
			$msg['tips'] = 'account forbidden';
			$link = '/admin_login';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['province_id'] = $this->user_info['province_id'];
		$data['page'] = $page - 1;
		
		$status = trim($this->input->get('cur_status', TRUE));
		$data['status'] = text2status(($status === '' ? 'paid' : $status));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/approve/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_applications($data);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		if (count($_GET) > 0) {
			$config['suffix'] = '?'.http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'1?'.http_build_query($_GET, '', "&");
		}
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['records'] = $this->adm->get_applications($data);
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = status2text($one['status']);
		}
		
		$this->load->view('admin_approve', $data);
	}
	
	public function permit($page = 1) {
		if ($this->user_info['permission'] != 1) {
			$msg['tips'] = 'account forbidden';
			$link = '/admin_login';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['page'] = $page - 1;
		$data['status'] = intval($this->input->get('account_status', TRUE));
		$data['province_id'] = intval($this->input->get('province_id', TRUE));
		
		$this->load->model('user_model', 'user');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/permit/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->user->sum_administrator($data['status']);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		if (count($_GET) > 0) {
			$config['suffix'] = '?'.http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'1?'.http_build_query($_GET, '', "&");
		}
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['users'] = $this->user->get_administrators($data);
		
		$provinces = array('1' => '北京', '2' => '广州', '3' => '上海');
		$permissions = array('1' => '系统管理员', '2' => '大使馆管理员', '3' => '办事处管理员');
		$accounts = array('-1' => '已失效', '0' => '正常', '1' => '未激活');
		foreach ($data['users'] as &$one) {
			$one['status_str'] = $accounts[$one['status']];
			$one['province_str'] = $provinces[$one['province_id']];
			$one['permission_str'] = $permissions[$one['permission']];
		}
		
		$this->load->view('admin_permit', $data);
	}
	
	public function ordinary($page = 1) {
		if ($this->user_info['permission'] != 1) {
			$msg['tips'] = 'account forbidden';
			$link = '/admin_login';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['page'] = $page - 1;
		$data['status'] = intval($this->input->get('account_status', TRUE));
		$data['email'] = trim($this->input->get('email', TRUE));
		
		$this->load->model('user_model', 'user');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/ordinary/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->user->sum_applicant($data['status']);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		if (count($_GET) > 0) {
			$config['suffix'] = '?'.http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].'1?'.http_build_query($_GET, '', "&");
		}
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['users'] = $this->user->get_applicants($data);
		
		$accounts = array('-1' => '已失效', '0' => '正常', '1' => '未激活');
		foreach ($data['users'] as &$one) {
			$one['status_str'] = $accounts[$one['status']];
		}
		
		$this->load->view('admin_ordinary', $data);
	}
	
	public function total_preview($uuid = '') {
		if ($uuid === '') {
			show_error('uuid empty error');
			die();
		}
		
		$attributes = '*';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $this->user_info['province_id'], $attributes);
		
		if ($info) {
			if ($info['status'] >= 41) {
				$info['photo_pic'] = SCAN_DOMAIN .$uuid .'/photo';
				$info['passport_pic'] = SCAN_DOMAIN .$uuid .'/passport';
				$info['identity_pic'] = SCAN_DOMAIN .$uuid .'/identity';
				$info['ticket_pic'] = SCAN_DOMAIN .$uuid .'/ticket';
				$info['deposition_pic'] = SCAN_DOMAIN .$uuid .'/deposition';
			}
			
			$info['user'] = $this->user_info;
			$this->load->view('admin_view', $info);
		} else {
			show_error('no application available');
		}
	}
	
	public function auditing($uuid = '', $opt = '') {
		$data['userid'] = $this->userid;
		$data['uuid'] = $uuid;
		$data['message'] = trim($this->input->post('message', TRUE));
		$data['fee'] = trim($this->input->post('fee', TRUE));
		
		$this->load->helper('util');
		$data['status'] = text2status($opt);
		
		if ($data['uuid'] === '') {
			show_error('uuid empty error');
		}
		
		$this->load->model('admin_model', 'adm');
		if ($this->adm->auditing_application($data)) {
			$ret['msg'] = 'success';
			
			update_status($data['uuid'], $data['status']);
			push_email_queue($opt.'_notification', $data['uuid']);
		} else {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
	
	public function approving($uuid = '', $opt = '') {
		$data['uuid'] = $uuid;
		$data['userid'] = $this->userid;
		$data['visa_no'] = '';
		$data['message'] = '';
		
		if ($data['uuid'] === '') {
			show_error('uuid empty error');
		}
		
		$this->load->helper('util');
		$data['status'] = text2status($opt);
		
		$this->load->model('admin_model', 'adm');
		
		if ($data['status'] === '101') {
			$data['start_time'] = strtotime('today');
			$data['end_time'] = $data['start_time'] + 86400 * 60;
			
			$attributes = '*';
			$info = $this->adm->retrieve_some_info($uuid, $this->user_info['province_id'], $attributes);
			
			if (!$info) {
				$msg['tips'] = 'forbidden';
				$link = '/admin/approve';
				$location = 'index page';
				$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
				show_error($msg);
			}
			
			if (($id = $this->adm->final_audit($data))) {
				$data['visa_no'] = gen_visa_number($id);
				$this->adm->update_visa_number($id, $data['visa_no']);
				$data['message'] = 'Application '.$data['uuid'].' Got Visa '.$data['visa_no'];
				
				require '../application/third_party/PHPWord/PHPWord.php';
				$PHPWord = new PHPWord();

				$document = $PHPWord->loadTemplate(VISA_TEMPLATE);

				$document->setValue('name', $info['name_en'].'/'.$info['name_cn']);
				$document->setValue('visa_no', $data['visa_no']);
				$document->setValue('date_of_issue_v', date('j M, Y', $data['start_time']));
				$document->setValue('date_of_expiry_v', date('j M, Y', $data['end_time']));
				$document->setValue('sex', ($info['gender'] > 1 ? 'Female' : 'Male'));
				$document->setValue('place_of_birth', $info['birth_place']);
				$document->setValue('passport_no', $info['passport_number']);
				$document->setValue('date_of_birth', date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day'])));
				$document->setValue('type', 'P');
				$document->setValue('place_of_issue_p', $info['passport_place']);
				$document->setValue('date_of_issue_p', date('j M, Y', $info['passport_date']));
				$document->setValue('date_of_expiry_p', date('j M, Y', $info['passport_expiry']));
				$document->setValue('visa_fee', 'RMB'.$info['fee']);
				
				$path = VISA_PATH .$uuid.'/';
				if (file_exists($path) === FALSE) {
					mkdir($path, 0777);
				}

				$document->save($path.$data['visa_no'].'.docx');
				
				update_status($data['uuid'], $data['status']);
				push_email_queue($opt.'_notification', $data['uuid']);
			}
		} else if ($data['status'] === '91') {
			$data['visa_no'] = 'Refused';
			$data['message'] = 'Application Refused for Visa';
			
			update_status($data['uuid'], $data['status']);
			push_email_queue($opt.'_notification', $data['uuid']);
		} else {
			$ret['msg'] = 'fail';
		}
		
		$ret['msg'] = 'success';
		echo json_encode($ret);
		
		$this->adm->auditing_application($data);
	}
	
	public function batch_approving() {
		
	}
	
	public function scan_upload($uuid = '') {
		$uuid = $uuid;
		if ($uuid === '') {
			show_error('uuid empty error');
		}
		
		$user = $this->user_info;
		$attributes = '*';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $user['province_id'], $attributes);
		
		if ($info) {
			$this->load->view('audit_upload', $info);
		} else {
			show_error('no application available');
		}
	}
	
	private function upload_pics($uuid, $filename) {
		if (($_FILES[$filename]['type'] == 'image/png') || ($_FILES[$filename]['type'] == 'image/jpeg') ||
			($_FILES[$filename]['type'] == 'image/pjpeg') || ($_FILES[$filename]['type'] == 'image/gif')) {
			if ($_FILES[$filename]['error'] > 0) {
				return FALSE;
			} else {
				$path = SCAN_PATH .$uuid .'/';
				if (file_exists($path) === FALSE) {
					mkdir($path, 0777);
				}
				$destination = $path.$filename;
				if (move_uploaded_file($_FILES[$filename]['tmp_name'], $destination)) {
					return TRUE;
				}
			}
		} else {
			return FALSE;
		}
	}
	
	public function upload_now($uuid = '') {
		$scan_files = array('photo', 'passport', 'identity', 'ticket', 'deposition');
		foreach ($scan_files as $val) {
			if (!$this->upload_pics($uuid, $val)) {
				show_error('upload failed');
			}
		}
		
		header('Location: /admin/total_preview/'.$uuid);
	}
	
	public function download_excel() {
	}
	
}

/* End of file */