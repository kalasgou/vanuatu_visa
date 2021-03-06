<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/UserController.php';

class Admin extends UserController {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		switch (intval($this->permission)) {
			case OFFICE_ADMIN: header('Location: '. base_url('/admin/audit')); break;
			case EMBASSY_ADMIN: header('Location: '. base_url('/admin/approve')); break;
			case SYSTEM_ADMIN: header('Location: '. base_url('/admin/account')); break;
			default : 
				$msg['tips'] = '你的帐户无此操作权限！';
				$link = 'javascript:history.go(-1);';
				$location = '返回上一页';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
		}
	}
	
	public function present($uuid = '') {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => '',
					'userid' => $this->userid,
					'province_id' => $this->user_info['province_id'],
					'city_id' => $this->user_info['city_id'],
					'agency_id' => $this->user_info['agency_id'],
					'first_name' => '',
					'last_name' => '',
					'gender' => '',
					'family' => '',
					'nationality' => '',
					'birth_day' => '',
					'birth_month' => '',
					'birth_year' => '',
					'birth_place' => '',
					'occupation_info' => array(
						'occupation' => '',
						'employer' => '',
						'employer_tel' => '',
						'employer_addr' => '',
						),
					'home_info' => array(
						'home_addr' => '',
						'home_tel' => '',
						),
					'passport_number' => '',
					'passport_place' => '',
					'passport_date' => '',
					'passport_expiry' => '',
					'purpose' => '',
					'other_purpose' => '',
					'destination' => '',
					'relative_info' => array(
						'relative_name' => '',
						'relative_addr' => '',
						),
					'detail_info' => array(
						'arrival_number' => '',
						'arrival_date' => '',
						'return_number' => '',
						'return_date' => '',
						'duration' => '',
						'financial_source' => '',
						),
					'children_info' => array(
						array (
							'child_name' => '',
							'child_sex' => '',
							'child_date' => '',
							'child_place' => '',
							),
						array (
							'child_name' => '',
							'child_sex' => '',
							'child_date' => '',
							'child_place' => '',
							),
						array (
							'child_name' => '',
							'child_sex' => '',
							'child_date' => '',
							'child_place' => '',
							),
						),
					'behaviour_info' => array(
						'criminal' => '',
						'crime_country' => '',
						'deported' => '',
						'deport_country' => '',
						'visited' => '',
						'applied' => '',
						'apply_date' => '',
						'refused' => '',
						'refuse_date' => '',
						),
					'fee' => '',
				);
		
		$attributes = '*';
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $attributes);
		
		if ($info) {
			$data = $info;
			$data['passport_date'] = $info['passport_date'] == 0 ? '' : date('Y-m-d', $info['passport_date']);
			$data['passport_expiry'] = $info['passport_expiry'] == 0 ? '' : date('Y-m-d', $info['passport_expiry']);
			$data['occupation_info'] = json_decode($info['occupation_info'], TRUE);
			$data['home_info'] = json_decode($info['home_info'], TRUE);
			$data['relative_info'] = json_decode($info['relative_info'], TRUE);
			$data['detail_info'] = json_decode($info['detail_info'], TRUE);
			$data['children_info'] = json_decode($info['children_info'], TRUE);
			$data['behaviour_info'] = json_decode($info['behaviour_info'], TRUE);
		}
		
		$data['user'] = $this->user_info;
		
		$this->load->view('offline_present_form', $data);
	}
	
	public function submit_present() {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['agency_id'] = $this->user_info['agency_id'];
		$data['status'] = APPLY_WAITING;
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		// Basic Info
		$data['first_name'] = trim($this->input->post('first_name', TRUE));
		$data['last_name'] = trim($this->input->post('last_name', TRUE));
		$data['gender'] = trim($this->input->post('gender', TRUE));
		$data['nationality'] = trim($this->input->post('nationality', TRUE));
		$data['birth_day'] = trim($this->input->post('birth_day', TRUE));
		$data['birth_month'] = trim($this->input->post('birth_month', TRUE));
		$data['birth_year'] = trim($this->input->post('birth_year', TRUE));
		$data['birth_place'] = trim($this->input->post('birth_place', TRUE));
		
		// Passport Info
		$data['passport_number'] = trim($this->input->post('passport_number', TRUE));
		$data['passport_place'] = trim($this->input->post('passport_place', TRUE));
		$data['passport_date'] = trim($this->input->post('passport_date', TRUE));
		$data['passport_expiry'] = trim($this->input->post('passport_expiry', TRUE));
		
		if (!check_parameters($data)) {
			$msg['tips'] = '所需填写信息不全，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if (!$this->alm->check_passport_available($data['uuid'], $data['passport_number'])) {
			$msg['tips'] = '对于护照号'.$data['passport_number'].'，由于存在审核中的申请或未过期的签证记录，故申请无法继续进行！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['family'] = trim($this->input->post('family', TRUE));
		$data['occupation'] = trim($this->input->post('occupation', TRUE));
		$data['employer'] = trim($this->input->post('employer', TRUE));
		$data['employer_tel'] = trim($this->input->post('employer_tel', TRUE));
		$data['employer_addr'] = trim($this->input->post('employer_addr', TRUE));
		$data['home_addr'] = trim($this->input->post('home_addr', TRUE));
		$data['home_tel'] = trim($this->input->post('home_tel', TRUE));
		
		// Travel Info
		$data['purpose'] = trim($this->input->post('purpose', TRUE));
		$data['other_purpose'] = trim($this->input->post('other_purpose', TRUE));
		$data['destination'] = trim($this->input->post('destination', TRUE));
		$data['relative_name'] = trim($this->input->post('relative_name', TRUE));
		$data['relative_addr'] = trim($this->input->post('relative_addr', TRUE));
		$data['arrival_number'] = trim($this->input->post('arrival_number', TRUE));
		$data['arrival_date'] = trim($this->input->post('arrival_date', TRUE));
		$data['return_number'] = trim($this->input->post('return_number', TRUE));
		$data['return_date'] = trim($this->input->post('return_date', TRUE));
		$data['duration'] = trim($this->input->post('duration', TRUE));
		$data['financial_source'] = trim($this->input->post('financial_source', TRUE));
		
		// Complement Info
		$data['child_name'] = $this->input->post('child_name', TRUE);
		$data['child_sex'] = $this->input->post('child_sex', TRUE);
		$data['child_date'] = $this->input->post('child_date', TRUE);
		$data['child_place'] = $this->input->post('child_place', TRUE);
		$data['criminal'] = trim($this->input->post('criminal', TRUE));
		$data['crime_country'] = trim($this->input->post('crime_country', TRUE));
		$data['deported'] = trim($this->input->post('deported', TRUE));
		$data['deport_country'] = trim($this->input->post('deport_country', TRUE));
		$data['visited'] = trim($this->input->post('visited', TRUE));
		$data['applied'] = trim($this->input->post('applied', TRUE));
		$data['apply_date'] = trim($this->input->post('apply_date', TRUE));
		$data['refused'] = trim($this->input->post('refused', TRUE));
		$data['refuse_date'] = trim($this->input->post('refuse_date', TRUE));
		
		// Fee Payment
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		$data['fee'] = $redis->get('visa_fee');
		
		$this->load->model('admin_model', 'adm');
		if ($this->adm->update_application($data) > 0) {
			update_status($data['uuid'], APPLY_WAITING);
			header('Location: '.base_url('/admin/present_upload/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function present_upload($uuid = '') {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$data = array(
					'uuid' => $uuid,
					'passport_pic' => SCAN_DOMAIN .substr($uuid, 0, 2) ."/$uuid/passport",
				);
		$data['user'] = $this->user_info;
		
		$this->load->view('offline_present_upload', $data);
	}
	
	private function upload_pics($uuid, $filename) {
		if (($_FILES[$filename]['type'] == 'image/png') || ($_FILES[$filename]['type'] == 'image/jpeg') ||
			($_FILES[$filename]['type'] == 'image/pjpeg') || ($_FILES[$filename]['type'] == 'image/gif')) {
			if ($_FILES[$filename]['error'] > 0) {
				return FALSE;
			} else {
				$path = SCAN_PATH .substr($uuid, 0, 2) ."/$uuid/";
				if (file_exists($path) === FALSE) {
					mkdir($path, 0777, TRUE);
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
	
	public function upload_scan_file() {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		$scan_files = array('passport');
		foreach ($scan_files as $val) {
			if (!$this->upload_pics($data['uuid'], $val)) {
				$msg['tips'] = '上传失败，请返回重新操作！';
				$link = 'javascript:history.go(-1);';
				$location = '返回上一步';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			}
		}
		
		header('Location: '.base_url('/admin/audit?orderby=2&apply_id='.$data['uuid']));
	}
	
	public function audit($page = 1) {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['userids'] = array();
		$data['permission'] = $this->permission;
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['page'] = $page - 1;
		
		$data['orderby'] = intval($this->input->get('orderby', TRUE));
		$status_str = trim($this->input->get('cur_status', TRUE));
		$status_code = intval($this->config->item($status_str, 'apply_status_code'));
		$data['status'] = $status_code === 0 ? APPLY_WAITING : $status_code;
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		if ($data['orderby'] === APPLY_PRESENT) {
			$data['userids'] = array($this->userid);
		} else {
			$data['userids'] = get_direct_subordinates($this->userid);
		}
		
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
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = $this->config->config['apply_status_str'][$one['status']];
		}
		
		$this->load->view('admin_audit', $data);
	}
	
	public function approve($page = 1) {
		if ($this->permission != EMBASSY_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['userids'] = array();
		$data['permission'] = $this->permission;
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['page'] = $page - 1;
		$lang = trim($this->input->get('lang', TRUE));
		$lang = $lang === 'en' ? 'en' : '';
		
		$data['orderby'] = intval($this->input->get('orderby', TRUE));
		$status_str = trim($this->input->get('cur_status', TRUE));
		$status_code = intval($this->config->item($status_str, 'apply_status_code'));
		$data['status'] = $status_code === 0 ? APPLY_PASSED : $status_code;
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		if ($data['orderby'] === APPLY_PRESENT) {
			$data['userids'] = get_direct_subordinates($this->userid);
		} else {
			$data['userids'] = get_direct_indirect_subordinates($this->userid);
		}
		
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
		
		if ($lang === 'en') {
			$config['prev_link'] = 'Prev';
			$config['next_link'] = 'Next';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
		} else {
			$config['prev_link'] = '上一页';
			$config['next_link'] = '下一页';
			$config['first_link'] = '首 页';
			$config['last_link'] = '尾 页';
		}
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['records'] = $this->adm->get_applications($data);
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = $this->config->config['apply_status_str'.$lang][$one['status']];
		}
		
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		$data['auto_visa_switch'] = $redis->sIsMember('auto_visa', $this->userid);
		
		$this->load->view('admin_approve'.$lang, $data);
	}
	
	public function quick($page = 1) {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		//$data['userids'] = array();
		$data['permission'] = $this->permission;
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['page'] = $page - 1;
		
		$data['orderby'] = intval($this->input->get('orderby', TRUE));
		$status_str = trim($this->input->get('cur_status', TRUE));
		$status_code = intval($this->config->item($status_str, 'apply_status_code'));
		$data['status'] = $status_code === 0 ? APPLY_WAITING : $status_code;
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		/*if ($data['orderby'] === APPLY_PRESENT) {
			$data['userids'] = array(PRESENT_USERID);
		}*/
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/quick/';
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
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = $this->config->item($one['status'], 'apply_status_str');
		}
		
		$this->load->view('admin_quick', $data);
	}
	
	public function account($page = 1) {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['page'] = $page - 1;
		$data['status'] = intval($this->input->get('account_status', TRUE));
		$data['permission'] = intval($this->input->get('account_type', TRUE));
		$data['province_id'] = intval($this->input->get('province', TRUE));
		$data['city_id'] = intval($this->input->get('city', TRUE));
		
		$data['email'] = trim($this->input->get('email', TRUE));
		
		$this->load->model('user_model', 'user');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/account/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->user->sum_users($data);
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
		$data['users'] = $this->user->user_list($data);
		$data['num_users'] = $config['total_rows'];
		
		$this->load->model('admin_model', 'adm');
		$locations = $this->adm->get_locations();
		
		foreach ($data['users'] as &$one) {
			$one['province_str'] = $locations[$one['city_id']]['province_cn'];
			$one['city_str'] = $locations[$one['city_id']]['city_cn'];
			
			$one['permission_str'] = $this->config->item($one['permission'], 'account_type');
			$one['status_str'] = $this->config->config['account_status'][$one['status']];
			
			$one['superiors'] = $this->adm->superior_for_account($one['province_id'], $one['permission']);
		}
		
		$this->load->view('admin_account', $data);
	}
	
	/*public function permit($page = 1) {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
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
		$data['num_users'] = $config['total_rows'];
		
		$provinces = array('0' => '任何', '1' => '北京', '2' => '广东', '3' => '上海');
		
		foreach ($data['users'] as &$one) {
			$one['province_str'] = $provinces[$one['province_id']];
			
			$one['permission_str'] = $this->config->item($one['permission'], 'account_type');
			$one['status_str'] = $this->config->config['account_status'][$one['status']];
		}
		
		$this->load->view('admin_permit', $data);
	}
	
	public function ordinary($page = 1) {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
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
		$data['num_users'] = $config['total_rows'];
		
		foreach ($data['users'] as &$one) {
			$one['status_str'] = $this->config->config['account_status'][$one['status']];
		}
		
		$this->load->view('admin_ordinary', $data);
	}*/
	
	public function total_preview($uuid = '') {
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$attributes = '*';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $attributes);
		
		if ($info) {
			//$info['photo_pic'] = SCAN_DOMAIN .$uuid .'/photo';
			$info['passport_pic'] = SCAN_DOMAIN .substr($uuid, 0, 2). "/$uuid/passport";
			//$info['identity_pic'] = SCAN_DOMAIN .$uuid .'/identity';
			//$info['ticket_pic'] = SCAN_DOMAIN .$uuid .'/ticket';
			//$info['deposition_pic'] = SCAN_DOMAIN .$uuid .'/deposition';
			
			$info['user'] = $this->user_info;
			$this->load->view('admin_view', $info);
		} else {
			$msg['tips'] = '你所请求的申请记录不存在！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function auditing($uuid = '', $opt = '') {
		$data['userid'] = $this->userid;
		$data['uuid'] = $uuid;
		$data['message'] = trim($this->input->post('message', TRUE));
		//$data['fee'] = trim($this->input->post('fee', TRUE));
		$data['status'] = intval($this->config->item($opt, 'apply_status_code'));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		$this->load->model('admin_model', 'adm');
		if ($this->adm->auditing_application($data)) {
			$ret['msg'] = 'success';
			
			update_status($data['uuid'], $data['status']);
			//push_email_queue($opt.'_notification', $data['uuid']);
		} else {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
		
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		if ($data['status'] === APPLY_PASSED && $redis->sIsMember('auto_visa', $this->user_info['superior_id'])) {
			$redis->lPush('auto_visa_queue', json_encode(array('userid' => $this->user_info['superior_id'], 'uuid' => $data['uuid'])));
		}
	}
	
	public function approving($uuid = '', $opt = '') {
		if ($this->permission != EMBASSY_ADMIN && $this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Forbidden');
		}
		
		$data['uuid'] = $uuid;
		$data['userid'] = $this->userid;
		$data['visa_no'] = '';
		$data['message'] = '';
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		$this->load->helper('util');
		$data['status'] = intval($this->config->item($opt, 'apply_status_code'));
		
		$this->load->model('admin_model', 'adm');
		
		if ($data['status'] === VISA_ISSUED) {
			$data['start_time'] = strtotime('today');
			$data['end_time'] = $data['start_time'] + 86400 * VISA_VALID_DAYS - 1;
			
			$attributes = '*';
			$info = $this->adm->retrieve_some_info($uuid, $attributes);
			
			if (!$info) {
				$ret['msg'] = 'invalid';
				echo json_encode($ret);
				exit('No This Application');
			}
			
			if ($id = $this->adm->final_audit($data)) {
				$data['visa_no'] = gen_visa_number($id);
				$this->adm->update_visa_number($id, $data['visa_no']);
				$data['message'] = '该申请通过最终审核并成功获取签证（编号 '.$data['visa_no'].'）。';
				
				/*require '../application/third_party/PHPWord/PHPWord.php';
				$PHPWord = new PHPWord();

				$document = $PHPWord->loadTemplate(VISA_TEMPLATE);

				$document->setValue('name', $info['first_name'].' '.$info['last_name']);
				$document->setValue('visa_no', $data['visa_no']);
				$document->setValue('date_of_issue_v', date('j M, Y', $data['start_time']));
				$document->setValue('date_of_expiry_v', date('j M, Y', $data['end_time']));
				$document->setValue('gender', ($info['gender'] > 1 ? 'Female' : 'Male'));
				$document->setValue('place_of_birth', $info['birth_place']);
				$document->setValue('passport_no', $info['passport_number']);
				$document->setValue('date_of_birth', date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day'])));
				$document->setValue('type', 'P');
				$document->setValue('place_of_issue_p', $info['passport_place']);
				$document->setValue('date_of_issue_p', date('j M, Y', $info['passport_date']));
				$document->setValue('date_of_expiry_p', date('j M, Y', $info['passport_expiry']));
				//$document->setValue('visa_fee', 'RMB'.$info['fee']);
				
				$path = VISA_PATH .$uuid.'/';
				if (file_exists($path) === FALSE) {
					mkdir($path, 0777);
				}

				$document->save($path.$data['visa_no'].'.docx');*/
				
				update_status($data['uuid'], $data['status']);
				//push_email_queue($opt.'_notification', $data['uuid']);
			} else {
				$data['visa_no'] = '';
				$data['message'] = '该申请已作最终审核，无须重复操作！';
			}
		} else if ($data['status'] === VISA_REFUSED) {
			$data['visa_no'] = 'Refused';
			$data['message'] = '该申请未能正常获得签证，如还需签证请另作申请！';
			
			update_status($data['uuid'], $data['status']);
		} else if ($this->permission == SYSTEM_ADMIN && $data['status'] === VISA_EXPIRED) {
			$data['visa_no'] = 'Expired';
			$data['message'] = '该签证由系统管理员设置为过期状态！';
			
			update_status($data['uuid'], $data['status']);
		} else if ($this->permission == SYSTEM_ADMIN && $data['status'] === APPLY_TRASHED) {
			$data['visa_no'] = 'Trashed';
			$data['message'] = '该申请已被系统管理员删除！';
			
			update_status($data['uuid'], $data['status']);
		} else {
			$ret['msg'] = 'fail';
			echo json_encode($ret);
			exit('Invalid Arguments');
		}
		
		$ret['msg'] = 'success';
		echo json_encode($ret);
		
		$this->adm->auditing_application($data);
	}
	
	/*public function scan_upload($uuid = '') {
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$user = $this->user_info;
		$attributes = '*';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $attributes);
		
		if ($info) {
			$this->load->view('audit_upload', $info);
		} else {
			$msg['tips'] = '你所请求的申请记录不存在！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	private function upload_pics($uuid, $filename) {
		if (($_FILES[$filename]['type'] == 'image/png') || ($_FILES[$filename]['type'] == 'image/jpeg') ||
			($_FILES[$filename]['type'] == 'image/pjpeg') || ($_FILES[$filename]['type'] == 'image/gif')) {
			if ($_FILES[$filename]['error'] > 0) {
				return FALSE;
			} else {
				$path = SCAN_PATH .substr($uuid, 0, 2) ."/$uuid/";
				if (file_exists($path) === FALSE) {
					mkdir($path, 0777, TRUE);
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
				$msg['tips'] = '上传失败，请返回重新操作！';
				$link = 'javascript:history.go(-1);';
				$location = '返回上一步';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
			}
		}
		
		header('Location: /admin/total_preview/'.$uuid);
	}*/
	
	public function download_excel() {
		if ($this->permission != EMBASSY_ADMIN && $this->permission != OFFICE_ADMIN && $this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userids'] = array();
		$data['permission'] = $this->permission;
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		$this->load->helper('util');
		if (!check_parameters($data)) exit('Parameters Not Enough');
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$data['start_time'].'至'.$data['end_time'].'.csv"');
		header('Cache-Control: max-age=0');
		
		$fp = fopen('php://output', 'a');
		
		// Set Head Titles
		$excelHeadTitle = array('', 
								'申请流水号',
								'申请人姓名',
								'出生日期',
								'性别',
								'国籍',
								'护照号',
								'申请时间',
								'申请状态',
								'审核时间',
								'缴费时间',
								'签证费用',
								'签证时间',
								'签证编号',
								'旅行社',
								'旅行社经手人',
								'办事处',
								'办事处经手人',
								'大使馆',
								'大使馆经手人');
		
		foreach ($excelHeadTitle as &$title) {
			$title = iconv('utf-8', 'gbk', $title);
		}
		
		fputcsv($fp, $excelHeadTitle);
		
		$page = 0;
		$i = 1;
		
		$this->load->model('user_model', 'user');
		
		$reservation_users = array();
		$reservation_users = $this->user->get_reservation_users(0);
		
		$office_admins = array();
		
		switch (intval($this->permission)) {
			case OFFICE_ADMIN: 
					$office_admins = $this->user->get_office_admins(0, $this->user_info['agency_id']);
					foreach ($office_admins as $key => $value) {
						$data['userids'] = array_merge($data['userids'], get_direct_subordinates($key));
					}
					break;
			case EMBASSY_ADMIN: 
					$office_admins = $this->user->get_office_admins(0, 0);
					$data['userids'] = get_direct_indirect_subordinates($this->userid);
					break;
			default : $office_admins = $this->user->get_office_admins(0, 0);
		}
		
		$embassy_admins = array();
		$embassy_admins = $this->user->get_embassy_admins();
		
		$this->load->model('admin_model', 'adm');
		while ($records = $this->adm->retrieve_records($data, $page)) {
			// Set Cell Content
			foreach ($records as $one) {
				$excelCell = array();
				
				$excelCell['counter'] = $i;
				$excelCell['uuid'] = $one['uuid'];
				$excelCell['full_name'] = $one['first_name'].' '.$one['last_name'];
				$excelCell['birthday'] = date('Y-m-d', strtotime($one['birth_year'].'-'.$one['birth_month'].'-'.$one['birth_day']));
				$excelCell['gender'] = $one['gender'] == 1 ? '男' : '女';
				$excelCell['nationality'] = $one['nationality'];
				$excelCell['passport_number'] = $one['passport_number'];
				$excelCell['submit_time'] = $one['submit_time'];
				$excelCell['status'] = $this->config->item($one['status'], 'apply_status_str');
				$excelCell['audit_time'] = $one['audit_time'];
				$excelCell['pay_time'] = $one['pay_time'];
				$excelCell['fee'] = $one['fee'];
				$excelCell['approve_time'] = $one['approve_time'];
				$excelCell['visa_no'] = $one['visa_no'];
				
				$excelCell['agency'] = $reservation_users[$one['userid']]['agency'];
				$excelCell['agency_admin'] = $reservation_users[$one['userid']]['nickname'];
				
				$userid = $this->adm->get_admin_userid($one['uuid'], APPLY_NOTPASSED, APPLY_PASSED);
				$excelCell['office'] = $office_admins[$userid]['agency'];
				$excelCell['office_admin'] = $office_admins[$userid]['nickname'];
				
				$userid = $this->adm->get_admin_userid($one['uuid'], VISA_REFUSED, VISA_EXPIRED);
				$excelCell['embassy'] = $embassy_admins[$userid]['agency'];
				$excelCell['embassy_admin'] = $embassy_admins[$userid]['nickname'];
				
				foreach ($excelCell as &$cell) {
					$cell = iconv('utf-8', 'gbk', $cell);
				}
				
				fputcsv($fp, $excelCell);
				
				$i ++;
			}
			unset($records);
			$page ++;
		}
		
		fclose($fp);
	}
	
	/*public function download_excel_test() {
		if ($this->permission != EMBASSY_ADMIN && $this->permission != OFFICE_ADMIN && $this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userids'] = array();
		$data['permission'] = $this->permission;
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		$this->load->helper('util');
		if (!check_parameters($data)) exit('Parameters Not Enough');
		
		require '../application/third_party/PHPExcel/PHPExcel.php';
		
		//$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		//$cacheSettings = array('memoryCacheSize' => '256MB');
		//PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		
		$excel = new PHPExcel();
		
		// Set Head Titles
		$excel	->setActiveSheetIndex(0)
				->setCellValue('A1', '')
				->setCellValue('B1', '申请流水号')
				->setCellValue('C1', '申请人姓名')
				->setCellValue('D1', '出生日期')
				->setCellValue('E1', '性别')
				->setCellValue('F1', '国籍')
				->setCellValue('G1', '护照号')
				->setCellValue('H1', '申请时间')
				->setCellValue('I1', '申请状态')
				->setCellValue('J1', '审核时间')
				->setCellValue('K1', '缴费时间')
				->setCellValue('L1', '签证费用')
				->setCellValue('M1', '签证时间')
				->setCellValue('N1', '签证编号')
				->setCellValue('O1', '旅行社')
				->setCellValue('P1', '旅行社经手人')
				->setCellValue('Q1', '办事处')
				->setCellValue('R1', '办事处经手人')
				->setCellValue('S1', '大使馆')
				->setCellValue('T1', '大使馆经手人');
		
		$page = 0;
		$i = 1;
		ini_set('memory_limit', '512M');
		
		$this->load->model('user_model', 'user');
		
		$reservation_users = array();
		$reservation_users = $this->user->get_reservation_users(0);
		
		$office_admins = array();
				
		switch (intval($this->permission)) {
			case OFFICE_ADMIN: 
					$office_admins = $this->user->get_office_admins(0, $this->user_info['agency_id']);
					foreach ($office_admins as $key => $value) {
						$data['userids'] = array_merge($data['userids'], get_direct_subordinates($key));
					}
					break;
			case EMBASSY_ADMIN: 
					$office_admins = $this->user->get_office_admins(0, 0);
					$data['userids'] = get_direct_indirect_subordinates($this->userid);
					break;
			default : $office_admins = $this->user->get_office_admins(0, 0);
		}
		
		$embassy_admins = array();
		$embassy_admins = $this->user->get_embassy_admins();
		
		$this->load->model('admin_model', 'adm');
		while ($records = $this->adm->retrieve_records($data, $page)) {
			// Set Cell Content
			foreach ($records as $one) {
				$one['agency'] = $reservation_users[$one['userid']]['agency'];
				$one['agency_admin'] = $reservation_users[$one['userid']]['nickname'];
				
				$userid = $this->adm->get_admin_userid($one['uuid'], APPLY_NOTPASSED, APPLY_PASSED);
				$one['office'] = $office_admins[$userid]['agency'];
				$one['office_admin'] = $office_admins[$userid]['nickname'];
				
				$userid = $this->adm->get_admin_userid($one['uuid'], VISA_REFUSED, VISA_EXPIRED);
				$one['embassy'] = $embassy_admins[$userid]['agency'];
				$one['embassy_admin'] = $embassy_admins[$userid]['nickname'];
				
				$cur_column = $i + 1;
				$excel	->setActiveSheetIndex(0)
						->setCellValue('A'.$cur_column, $i)
						->setCellValue('B'.$cur_column, $one['uuid'])
						->setCellValue('C'.$cur_column, $one['first_name'].' '.$one['last_name'])
						->setCellValue('D'.$cur_column, date('Y-m-d', strtotime($one['birth_year'].'-'.$one['birth_month'].'-'.$one['birth_day'])))
						->setCellValue('E'.$cur_column, ($one['gender'] == 1 ? '男' : '女'))
						->setCellValue('F'.$cur_column, $one['nationality'])
						->setCellValue('G'.$cur_column, $one['passport_number'])
						->setCellValue('H'.$cur_column, $one['submit_time'])
						->setCellValue('I'.$cur_column, $this->config->item($one['status'], 'apply_status_str'))
						->setCellValue('J'.$cur_column, $one['audit_time'])
						->setCellValue('K'.$cur_column, $one['pay_time'])
						->setCellValue('L'.$cur_column, $one['fee'])
						->setCellValue('M'.$cur_column, $one['approve_time'])
						->setCellValue('N'.$cur_column, $one['visa_no'])
						->setCellValue('O'.$cur_column, $one['agency'])
						->setCellValue('P'.$cur_column, $one['agency_admin'])
						->setCellValue('Q'.$cur_column, $one['office'])
						->setCellValue('R'.$cur_column, $one['office_admin'])
						->setCellValue('S'.$cur_column, $one['embassy'])
						->setCellValue('T'.$cur_column, $one['embassy_admin']);
				
				$i ++;
			}
			unset($records);
			$page ++;
		}
		
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(32);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(16);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(32);
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(16);
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(32);
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(16);
		$excel->getActiveSheet()->setTitle('申请记录');
		$excel->setActiveSheetIndex(0);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$data['start_time'].'至'.$data['end_time'].'.xlsx"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save('php://output');
		exit(0);
	}*/
	
	public function activate_account() {
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Forbidden');
		}
		
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$activate = trim($this->input->post('activate', TRUE));
		$data['status'] = $activate === 'yes' ? 1 : ($activate === 'no' ? -1 : 0);
		
		$this->load->model('user_model', 'user');
		
		$ret['msg'] = 'fail';
		
		if ($this->user->change_account_status($data) > 0) {
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
	
	public function update_superior() {
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Forbidden');
		}
		
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$data['superior_id'] = trim($this->input->post('superior_id', TRUE));
		$data['original_superior_id'] = trim($this->input->post('original_superior_id', TRUE));
		
		$this->load->model('user_model', 'user');
		
		$ret['msg'] = 'fail';
		
		if ($this->user->update_superior($data) > 0) {
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
	
	public function audit_trace($page = 1) {
		if ($this->permission != EMBASSY_ADMIN && $this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$lang = trim($this->input->get('lang', TRUE));
		$lang = $lang === 'en' ? 'en' : '';
		
		$this->load->helper('util');
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/audit_trace/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_auditing_records($this->userid);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		
		if ($lang === 'en') {
			$config['prev_link'] = 'Prev';
			$config['next_link'] = 'Next';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
		} else {
			$config['prev_link'] = '上一页';
			$config['next_link'] = '下一页';
			$config['first_link'] = '首 页';
			$config['last_link'] = '尾 页';
		}
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['records'] = $this->adm->get_auditing_records($this->userid, $page - 1);
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = $this->config->item($one['status'], 'apply_status_str'.$lang);
		}
		
		if ($this->permission == EMBASSY_ADMIN) {
			$this->load->view('admin_approve_records'.$lang, $data);
		} else {
			$this->load->view('admin_audit_records', $data);
		}
	}
	
	public function audit_trace_by_uuid($uuid = '') {
		$this->load->helper('util');
		$this->load->model('admin_model', 'adm');
		$records = $this->adm->get_auditing_records_by_uuid($uuid);
		
		foreach ($records as &$one) {
			$one['status_str'] = $this->config->item($one['status'], 'apply_status_str');
		}
		
		$ret['records'] = $records;
		
		echo json_encode($ret);
	}
	
	public function download_visa($uuid = '') {		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->get_visa_info($uuid);
		
		if ($info) {
			$this->load->helper('util');
			visa_pdf($info);
		} else {
			$ret['msg'] = 'Visa Not Found';
			
			echo json_encode($ret);
		}
	}
	
	public function download_form($uuid = '') {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$attributes = '*';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $attributes);
		
		if ($info) {
			$this->load->view('form_for_download', $info);
		} else {
			$msg['tips'] = '你所请求的申请记录不存在！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function agency($page = 1) {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/agency/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_agencies();
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
		$data['agencies'] = $this->adm->get_agency_list($page - 1);
		$data['num_agencies'] = $config['total_rows'];
		
		$locations = $this->adm->get_locations();
		
		foreach ($data['agencies'] as &$one) {
			$one['province_str'] = $locations[$one['city_id']]['province_cn'];
			$one['city_str'] = $locations[$one['city_id']]['city_cn'];
			
			$one['permission_str'] = $this->config->item($one['permission'], 'agency_type');
			$one['status_str'] = $this->config->config['account_status'][$one['status']];
		}

		$this->load->view('admin_agency', $data);
	}
	
	public function new_province_city_agency() {
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Perform This Task');
		}
		
		$data['province_id'] = intval($this->input->post('province_id', TRUE));
		$data['new_province'] = trim($this->input->post('new_province', TRUE));
		$data['city_id'] = intval($this->input->post('city_id', TRUE));
		$data['new_city'] = trim($this->input->post('new_city', TRUE));
		$data['new_agency_name'] = trim($this->input->post('new_agency_name', TRUE));
		$data['new_agency_addr'] = trim($this->input->post('new_agency_addr', TRUE));
		$data['new_agency_cont'] = trim($this->input->post('new_agency_cont', TRUE));
		$data['permission'] = intval($this->input->post('permission', TRUE));
		$data['time'] = $_SERVER['REQUEST_TIME'];
		
		$this->load->model('admin_model', 'adm');
		
		$ret['msg'] = 'fail';
		
		if ($data['province_id'] === 0 && $data['new_province'] !== '') {
			if (($data['province_id'] = $this->adm->upsert_province($data)) <= 0) {
				$ret['msg'] = 'province fail';
				echo json_encode($ret);
				exit();
			}
		}
		
		if ($data['city_id'] === 0 && $data['new_city'] !== '') {
			if (($data['city_id'] = $this->adm->upsert_city($data)) <= 0) {
				$ret['msg'] = 'city fail';
				echo json_encode($ret);
				exit();
			}
		}
		
		if ($data['province_id'] > 0 && $data['city_id'] > 0 && $data['new_agency_name'] !== '' && $data['new_agency_addr'] !== '' && $data['new_agency_cont']) {
			if ($this->adm->upsert_agency($data) > 0) {
				$ret['msg'] = 'success';
			}
		}
		
		echo json_encode($ret);
		
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		$redis->del('city_and_province');
	}
	
	public function province_list() {
		header('Content-Type: application/json; charset=utf-8');
		
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Request This Info');
		}
		
		$ret['msg'] = 'success';
		$this->load->model('admin_model', 'adm');
		$ret['provinces'] = $this->adm->get_provinces();
		
		echo json_encode($ret);
	}
	
	public function city_list($province_id = 0) {
		header('Content-Type: application/json; charset=utf-8');
		
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Request This Info');
		}
		
		$ret['msg'] = 'success';
		$this->load->model('admin_model', 'adm');
		$ret['cities'] = $this->adm->get_cities($province_id);
		
		echo json_encode($ret);
	}
	
	public function agency_list() {
		$data['city_id'] = intval($this->input->get('city_id', TRUE));
		$data['permission'] = intval($this->input->get('permission', TRUE));
		
		header('Content-Type: application/json; charset=utf-8');
		
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Request This Info');
		}
		
		$ret['msg'] = 'success';
		$this->load->model('admin_model', 'adm');
		$ret['agencies'] = $this->adm->get_agencies($data);
		
		echo json_encode($ret);
	}
	
	/*public function fix_relation() {
		$this->load->library('RedisDB');
		$this->load->model('admin_model', 'adm');
		$this->adm->fix_relation();
	}*/
	
	public function update_agency() {
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Perform This Task');
		}
		
		$data['agency_id'] = intval($this->input->post('agency_id', TRUE));
		$data['agency_name'] = trim($this->input->post('agency_name', TRUE));
		$data['agency_addr'] = trim($this->input->post('agency_addr', TRUE));
		$data['agency_cont'] = trim($this->input->post('agency_cont', TRUE));
		
		$this->load->helper('util');
		if (!check_parameters($data)) exit('Parameters Not Enough');
		
		$ret['msg'] = 'fail';
		
		$this->load->model('admin_model', 'adm');
		if ($this->adm->update_agency_detail($data) > 0) {
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
	
	public function delete_agency() {
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Perform This Task');
		}
		
		$agency_id = intval($this->input->post('agency_id', TRUE));
		
		$this->load->model('admin_model', 'adm');	
		if ($this->adm->delete_agency_and_their_users($agency_id) > 0) {
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
	
	public function auto_visa($option) {
		if ($this->permission != EMBASSY_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Perform This Task');
		}
		
		$result = 0;
		$ret['msg'] = 'fail';
		
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		switch ($option) {
			case 'on': 	$result = $redis->sAdd('auto_visa', $this->userid); break;
			case 'off': $result = $redis->sRem('auto_visa', $this->userid); break;
			default : $result = -1;
		}
		
		if ($result > 0) {
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
}

/* End of file */