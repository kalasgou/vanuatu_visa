<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/UserController.php';

class Admin extends UserController {
	
	public function index() {
		switch (intval($this->permission)) {
			case OFFICE_ADMIN: header('Location: '. base_url('/admin/audit')); break;
			case EMBASSY_ADMIN: header('Location: '. base_url('/admin/approve')); break;
			case SYSTEM_ADMIN: header('Location: '. base_url('/admin/permit')); break;
			default : 
				$msg['tips'] = '你的帐户无此操作权限！';
				$link = 'javascript:history.go(-1);';
				$location = '返回上一步';
				$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
				show_error($msg);
		}
	}
	
	public function register() {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['email'] = trim($this->input->post('email', TRUE));
		$data['password'] = trim($this->input->post('password', TRUE));
		$data['nickname'] = trim($this->input->post('nickname', TRUE));
		$data['agency'] = trim($this->input->post('agency', TRUE));
		$data['telephone'] = trim($this->input->post('telephone', TRUE));
		$data['permission'] = trim($this->input->post('permission', TRUE));
		$data['province_id'] = trim($this->input->post('province_id', TRUE));
		$data['city_id'] = trim($this->input->post('city_id', TRUE));
		$data['status'] = ACCOUNT_NORMAL;
		$data['reg_ip'] = ip2long($this->input->ip_address());
		$data['reg_time'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		
		$this->load->helper('util');
		
		if (!check_parameters($data)) {
			$msg['tips'] = '所需填写信息不全，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if (!email_verify($data['email'])) {
			$msg['tips'] = '电子邮箱格式不正确，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('user_model', 'user');
		
		if ($this->user->user_email_available($data['email']) > 0) {
			$msg['tips'] = '所填邮箱已被他人使用，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		require '../application/third_party/pass/PasswordHash.php';
		$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
		$data['password'] = $hasher->HashPassword($data['password']);
		if (strlen($data['password']) < 20) {
			show_error('password hash too short');
		}
		
		if (($userid = $this->user->user_register($data)) > 0) {
			$msg['tips'] = '注册成功！可点击以下链接继续注册。';
			$link = '/admin/register';
			$location = '点击注册';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		} else {
			$msg['tips'] = '注册失败，请稍候再试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function present($uuid = '') {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => '',
					'userid' => '1',
					'province_id' => $this->user_info['province_id'],
					'city_id' => $this->user_info['city_id'],
					'name_en' => '',
					'name_cn' => '',
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
			$data['occupation_info'] = json_decode($info['occupation_info'], TRUE);
			$data['home_info'] = json_decode($info['home_info'], TRUE);
			$data['relative_info'] = json_decode($info['relative_info'], TRUE);
			$data['detail_info'] = json_decode($info['detail_info'], TRUE);
			$data['children_info'] = json_decode($info['children_info'], TRUE);
			$data['behaviour_info'] = json_decode($info['behaviour_info'], TRUE);
		}
		
		$data['user'] = $this->user_info;
		
		$this->load->view('offline_present', $data);
	}
	
	public function submit_present() {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['province_id'] = trim($this->input->post('province_id', TRUE));
		$data['city_id'] = trim($this->input->post('city_id', TRUE));
		$data['status'] = APPLY_WAITING;
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = '/admin';
			$location = '返回管理主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		// Basic Info
		$data['name_en'] = trim($this->input->post('name_en', TRUE));
		$data['name_cn'] = trim($this->input->post('name_cn', TRUE));
		$data['gender'] = trim($this->input->post('gender', TRUE));
		$data['family'] = trim($this->input->post('family', TRUE));
		$data['nationality'] = trim($this->input->post('nationality', TRUE));
		$data['birth_day'] = trim($this->input->post('birth_day', TRUE));
		$data['birth_month'] = trim($this->input->post('birth_month', TRUE));
		$data['birth_year'] = trim($this->input->post('birth_year', TRUE));
		$data['birth_place'] = trim($this->input->post('birth_place', TRUE));
		$data['occupation'] = trim($this->input->post('occupation', TRUE));
		$data['employer'] = trim($this->input->post('employer', TRUE));
		$data['employer_tel'] = trim($this->input->post('employer_tel', TRUE));
		$data['employer_addr'] = trim($this->input->post('employer_addr', TRUE));
		$data['home_addr'] = trim($this->input->post('home_addr', TRUE));
		$data['home_tel'] = trim($this->input->post('home_tel', TRUE));
		
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
			update_status($data['uuid'], 11);
			header('Location: '.base_url('/admin/audit?orderby=2&apply_id='.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function audit($page = 1) {
		if ($this->permission != OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['page'] = $page - 1;
		
		$status = trim($this->input->get('cur_status', TRUE));
		$data['status'] = intval($this->confg->item($status, 'apply_status_code'));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		$data['userid'] = trim($this->input->get('user', TRUE));
		
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
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['page'] = $page - 1;
		
		$status = trim($this->input->get('cur_status', TRUE));
		$data['status'] = intval($this->confg->item($status, 'apply_status_code'));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		$data['userid'] = trim($this->input->get('user', TRUE));
		
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
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = status2text($one['status']);
		}
		
		$this->load->view('admin_approve', $data);
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
		
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['page'] = $page - 1;
		
		$status = trim($this->input->get('cur_status', TRUE));
		$data['status'] = intval($this->confg->item($status, 'apply_status_code'));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		$data['userid'] = trim($this->input->get('user', TRUE));
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/fast/';
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
			$one['status_str'] = status2text($one['status']);
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
		$data['province_id'] = intval($this->input->get('province_id', TRUE));
		$data['city_id'] = intval($this->input->get('city_id', TRUE));
		$data['email'] = intval($this->input->get('email', TRUE));
		
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
		
		$provinces = array('0' => '任何', '1' => '北京', '2' => '广东', '3' => '上海');
		
		foreach ($data['users'] as &$one) {
			$one['province_str'] = $provinces[$one['province_id']];
			
			$one['permission_str'] = $this->config->item($one['permission'], 'account_type');
			$one['status_str'] = $this->config->config['account_status'][$one['status']];
		}
		
		$this->load->view('admin_permit', $data);
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
		$data['status'] = intval($this->confg->item($opt, 'apply_status_code'));
		
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
	}
	
	public function approving($uuid = '', $opt = '') {
		$data['uuid'] = $uuid;
		$data['userid'] = $this->userid;
		$data['visa_no'] = '';
		$data['message'] = '';
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		$this->load->helper('util');
		$data['status'] = intval($this->confg->item($opt, 'apply_status_code'));
		
		$this->load->model('admin_model', 'adm');
		
		if ($data['status'] === APPLY_ACCEPTED) {
			$data['start_time'] = strtotime('today');
			$data['end_time'] = $data['start_time'] + 86400 * VISA_VALID_DAYS;
			
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
				//$document->setValue('visa_fee', 'RMB'.$info['fee']);
				
				$path = VISA_PATH .$uuid.'/';
				if (file_exists($path) === FALSE) {
					mkdir($path, 0777);
				}

				$document->save($path.$data['visa_no'].'.docx');
				
				update_status($data['uuid'], $data['status']);
				push_email_queue($opt.'_notification', $data['uuid']);
			} else {
				$data['visa_no'] = '';
				$data['message'] = '该申请已作最终审核，无须重复操作！';
			}
		} else if ($data['status'] === APPLY_REJECTED) {
			$data['visa_no'] = 'Refused';
			$data['message'] = '该申请未能正常获得签证，如还需签证请另作申请！';
			
			update_status($data['uuid'], $data['status']);
			push_email_queue($opt.'_notification', $data['uuid']);
		} else {
			$ret['msg'] = 'fail';
			echo json_encode($ret);
			exit('Forbidden');
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
		if ($this->permission != OFFICE_ADMIN || $this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		$this->load->helper('util');
		if (!check_parameters($data)) exit('Parameters Not Enough');
		
		require '../application/third_party/PHPExcel/PHPExcel.php';
		
		$excel = new PHPExcel();
		
		// Set Head Titles
		$excel	->setActiveSheetIndex(0)
				->setCellValue('A1', '')
				->setCellValue('B1', '申请流水号')
				->setCellValue('C1', '申请人中文/英文姓名')
				->setCellValue('D1', '出生日期')
				->setCellValue('E1', '性别')
				->setCellValue('F1', '国籍')
				->setCellValue('G1', '护照号')
				->setCellValue('H1', '申请时间')
				->setCellValue('I1', '当前申请状态')
				->setCellValue('J1', '审核时间')
				->setCellValue('K1', '缴费时间')
				->setCellValue('L1', '签证费用')
				->setCellValue('M1', '签证时间')
				->setCellValue('N1', '签证编号')
				->setCellValue('O1', '办事处经手人')
				->setCellValue('P1', '大使馆经手人');
		
		$page = 0;
		
		$office_admins = array();
		$embassy_admins = array();
		
		$this->load->model('admin_model', 'adm');
		$this->load->model('user_model', 'user');
		while ($records = $this->adm->retrieve_records($data, $page)) {
			// Set Cell Content
			$i = 1;
			foreach ($records as $one) {
				$cur_column = $i + 1;
				$excel	->setActiveSheetIndex(0)
						->setCellValue('A'.$cur_column, $i)
						->setCellValue('B'.$cur_column, $one['uuid'])
						->setCellValue('C'.$cur_column, $one['name_cn'].'/'.$one['name_en'])
						->setCellValue('D'.$cur_column, date('Y-m-d', strtotime($one['birth_year'].'-'.$one['birth_month'].'-'.$one['birth_day'])))
						->setCellValue('E'.$cur_column, ($one['gender'] == 1 ? '男' : '女'))
						->setCellValue('F'.$cur_column, $one['nationality'])
						->setCellValue('G'.$cur_column, $one['passport_number'])
						->setCellValue('H'.$cur_column, $one['submit_time'])
						->setCellValue('I'.$cur_column, status2text($one['status']))
						->setCellValue('J'.$cur_column, $one['audit_time'])
						->setCellValue('K'.$cur_column, $one['pay_time'])
						->setCellValue('L'.$cur_column, 'RMB'.$one['fee'])
						->setCellValue('M'.$cur_column, $one['approve_time'])
						->setCellValue('N'.$cur_column, $one['visa_no']);
				
				$name_office = '';
				$admin_userids = $this->adm->get_admin_userids($one['uuid'], 21, 41);
				foreach ($admin_userids as $admin) {
					if (!isset($office_admins[$admin['admin_userid']]['realname'])) {
						$info = $this->user->administrator_info($admin['admin_userid']);
						$office_admins[$info['userid']]['realname'] = $info['realname'];
					}
					$name_office .= $office_admins[$admin['admin_userid']]['realname'].'、';
				}
				
				$name_embassy = '';
				$admin_userids = $this->adm->get_admin_userids($one['uuid'], 91, 101);
				foreach ($admin_userids as $admin) {
					if (!isset($embassy_admins[$admin['admin_userid']]['realname'])) {
						$info = $this->user->administrator_info($admin['admin_userid']);
						$embassy_admins[$info['userid']]['realname'] = $info['realname'];
					}
					$name_embassy .= $embassy_admins[$admin['admin_userid']]['realname'].'、';
				}
				
				$excel	->setActiveSheetIndex(0)
						->setCellValue('O'.$cur_column, $name_office)
						->setCellValue('P'.$cur_column, $name_embassy);
				
				$i ++;
			}
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
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(32);
		$excel->getActiveSheet()->setTitle('申请记录');
		$excel->setActiveSheetIndex(0);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$data['start_time'].'至'.$data['end_time'].'.xlsx"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save('php://output');
		exit(0);
	}
	
	public function activate_account() {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$data['user_type'] = trim($this->input->post('user_type', TRUE));
		$activate = trim($this->input->post('activate', TRUE));
		$data['status'] = $activate === 'yes' ? 1 : ($activate === 'no' ? -1 : 0);
		
		$this->load->model('user_model', 'user');
		
		$ret['msg'] = 'fail';
		
		if ($this->user->change_account_status($data) > 0) {
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
	
	public function audit_trace($page = 1) {
		if ($this->permission < EMBASSY_ADMIN || $this->permission > OFFICE_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/audit_trace/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_auditing_records($this->userid);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$this->pagination->initialize($config);
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->create_links();
		$data['records'] = $this->adm->get_auditing_records($this->userid, $page - 1);
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = $this->config->item($one['status'], 'apply_status_str');
		}
		
		if ($this->permission == 2) {
			$this->load->view('admin_approve_records', $data);
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
		
		$attributes = 'visa_no';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $attributes);
		
		if (!$info || $info['visa_no'] === '') {
			show_error('申请记录或签证文件不存在！');
		}
		
		$filename = VISA_PATH .$uuid.'/'.$info['visa_no'].'.docx';
		if (!file_exists($filename)) {
			$msg['tips'] = '你所请求的签证文件不存在或已过期！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename='.basename($filename));
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($filename));
		readfile($filename);
	}
	
	public function agency($page = 1) {
		if ($this->permission != SYSTEM_ADMIN) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = '/admin/agency/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_agency();
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
		$data['agencies'] = $this->adm->get_agencies($page - 1);
		$data['num_agencies'] = $config['total_rows'];
		
		foreach ($data['agencies'] as &$one) {
			$one['status_str'] = $one['status'] == 1 ? '正常' : '失效';
		}

		$this->load->view('admin_agency', $data);
	}
	
	public function update_agency() {
		if ($this->permission != SYSTEM_ADMIN) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Account Not Allowed to Perform This Task');
		}
		
		$data['id'] = trim($this->input->post('id', TRUE));
		$data['city_cn'] = trim($this->input->post('city_cn', TRUE));
		$data['addr_cn'] = trim($this->input->post('addr_cn', TRUE));
		//$data['city_en'] = trim($this->input->post('city_en', TRUE));
		//$data['addr_en'] = trim($this->input->post('addr_en', TRUE));
		$data['contact'] = trim($this->input->post('contact', TRUE));
		$data['date'] = $_SERVER['REQUEST_TIME'];
		
		$this->load->model('admin_model', 'adm');
		
		if ($this->adm->upsert_agency($data) > 0) {
			$ret['msg'] = 'success';
		} else {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
}

/* End of file */