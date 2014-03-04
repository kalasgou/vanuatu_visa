<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/UserController.php';

class Apply extends UserController {

	public function index() {
		header('Location: '.base_url('/apply/records'));
	}
	
	public function records($page = 1) {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['page'] = $page - 1;
		
		$data['orderby'] = intval($this->input->get('orderby', TRUE));
		$status = trim($this->input->get('cur_status', TRUE));
		$data['status'] = intval($this->config->item($status, 'apply_status_code'));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		$data['passport'] = trim($this->input->get('passport_no', TRUE));
		$data['start_time'] = trim($this->input->get('start_time', TRUE));
		$data['end_time'] = trim($this->input->get('end_time', TRUE));
		
		$this->load->model('apply_model', 'alm');
		
		$this->load->helper('util');
		$this->load->library('pagination');
		
		$config['base_url'] = '/apply/records/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->alm->sum_applications($data);
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
		$data['records'] = $this->alm->get_records($data);
		$data['pagination'] = $this->pagination->create_links();
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = $this->config->config['apply_status_str'][$one['status']];
		}
		
		$this->load->view('apply_records', $data);
	}
	
	/*public function agencies($uuid = '') {
		$agency_info = array();
		$this->load->model('apply_model', 'alm');
		$agency_info = $this->alm->get_agency_info();
		
		$data = array(
					'uuid' => '',
					'province_id' => '1',
					'city_id' => '1',
					'agencies' => $agency_info,
				);
		
		$attributes = 'uuid, province_id, city_id';
		
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['province_id'] = $info['province_id'];
			$data['city_id'] = $info['city_id'];
		}
		
		$this->load->view('step_agency', $data);
	}
	
	public function select_agency() {
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['province_id'] = intval($this->input->post('province_id', TRUE));
		$data['city_id'] = intval($this->input->post('city_id', TRUE));
		
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
		
		if (!check_parameters($data)) {
			$msg['tips'] = '所需填写信息不全，请返回重新输入！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->select_agency($data) > 0) {
			update_status($data['uuid'], AGENCY_SELECTED);
			header('Location: '.base_url('/apply/basic_info/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}*/
	
	public function basic_info($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		/*$this->load->helper('util');
		if (!check_status($uuid, AGENCY_SELECTED)) {
			$msg['tips'] = '请先填写完上述必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}*/
		
		$data = array(
					'uuid' => '',
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
				);
		
		$attributes = 'uuid, first_name, last_name, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['first_name'] = $info['first_name'];
			$data['last_name'] = $info['last_name'];
			$data['gender'] = $info['gender'];
			$data['family'] = $info['family'];
			$data['nationality'] = $info['nationality'];
			$data['birth_day'] = $info['birth_day'];
			$data['birth_month'] = $info['birth_month'];
			$data['birth_year'] = $info['birth_year'];
			$data['birth_place'] = $info['birth_place'];
			
			$data['occupation_info'] = json_decode($info['occupation_info'], TRUE);
			$data['home_info'] = json_decode($info['home_info'], TRUE);
		}
		
		$this->load->view('step_basic', $data);
	}
	
	public function update_basic_info() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['province_id'] = $this->user_info['province_id'];
		$data['city_id'] = $this->user_info['city_id'];
		$data['agency_id'] = $this->user_info['agency_id'];
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['first_name'] = trim($this->input->post('first_name', TRUE));
		$data['last_name'] = trim($this->input->post('last_name', TRUE));
		$data['gender'] = trim($this->input->post('gender', TRUE));
		$data['nationality'] = trim($this->input->post('nationality', TRUE));
		$data['birth_day'] = trim($this->input->post('birth_day', TRUE));
		$data['birth_month'] = trim($this->input->post('birth_month', TRUE));
		$data['birth_year'] = trim($this->input->post('birth_year', TRUE));
		$data['birth_place'] = trim($this->input->post('birth_place', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!check_parameters($data)) {
			$msg['tips'] = '所需填写信息不全，请返回重新输入！';
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
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_basic_info($data) > 0) {
			update_status($data['uuid'], BASIC_UPDATED);
			header('Location: '.base_url('/apply/passport_info/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function passport_info($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		if (!check_status($uuid, BASIC_UPDATED)) {
			$msg['tips'] = '请先填写完必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => '',
					'passport_number' => '',
					'passport_place' => '',
					'passport_date' => '',
					'passport_expiry' => '',
				);
		
		$attributes = 'uuid, passport_number, passport_place, passport_date, passport_expiry';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['passport_number'] = $info['passport_number'];
			$data['passport_place'] = $info['passport_place'];
			$data['passport_date'] = $info['passport_date'] == 0 ? '' : date('Y-m-d', $info['passport_date']);
			$data['passport_expiry'] = $info['passport_expiry'] == 0 ? '' : date('Y-m-d', $info['passport_expiry']);
		}
		
		$this->load->view('step_passport', $data);
	}
	
	public function update_passport_info() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['passport_number'] = trim($this->input->post('passport_number', TRUE));
		$data['passport_place'] = trim($this->input->post('passport_place', TRUE));
		$data['passport_date'] = trim($this->input->post('passport_date', TRUE));
		$data['passport_expiry'] = trim($this->input->post('passport_expiry', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
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
		
		if ($this->alm->update_passport_info($data) > 0) {
			update_status($data['uuid'], PASSPORT_UPDATED);
			header('Location: '.base_url('/apply/travel_info/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function travel_info($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		if (!check_status($uuid, PASSPORT_UPDATED)) {
			$msg['tips'] = '请先填写完必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => '',
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
				);
		
		$attributes = 'uuid, purpose, other_purpose, destination, relative_info, detail_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['purpose'] = $info['purpose'];
			$data['other_purpose'] = $info['other_purpose'];
			$data['destination'] = $info['destination'];
			
			$data['relative_info'] = json_decode($info['relative_info'], TRUE);
			$data['detail_info'] = json_decode($info['detail_info'], TRUE);
		}
		
		$this->load->view('step_travel', $data);
	}
	
	public function update_travel_info() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
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
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_travel_info($data) > 0) {
			update_status($data['uuid'], TRAVEL_UPDATED);
			header('Location: '.base_url('/apply/complement_info/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function complement_info($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		if (!check_status($uuid, TRAVEL_UPDATED)) {
			$msg['tips'] = '请先填写完必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => '',
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
				);
		
		$attributes = 'uuid, children_info, behaviour_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			
			$data['children_info'] = json_decode($info['children_info'], TRUE);
			$data['behaviour_info'] = json_decode($info['behaviour_info'], TRUE);
		}
		
		$this->load->view('step_complement', $data);
	}
	
	public function update_complement_info() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
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
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_complement_info($data) > 0) {
			update_status($data['uuid'], COMPLEMENT_UPDATED);
			header('Location: '.base_url('/apply/scan_file/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function scan_file($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		if (!check_status($uuid, COMPLEMENT_UPDATED)) {
			$msg['tips'] = '请先填写完必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => $uuid,
					'passport_pic' => SCAN_DOMAIN .$uuid .'/passport',
				);
		$data['user'] = $this->user_info;
		
		$this->load->view('step_upload', $data);
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
	
	public function upload_scan_file() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
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
		
		update_status($data['uuid'], PICTURE_UPLOADED);
		header('Location: '.base_url('/apply/confirm_info/'.$data['uuid']));
	}
	
	/*public function fee_payment($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		if (!check_status($uuid, PICTURE_UPLOADED)) {
			$msg['tips'] = '请先填写完必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data = array(
					'uuid' => '',
					'fee' => '',
				);
		
		$attributes = 'uuid, fee';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['fee'] = $info['fee'];
		}
		
		$this->load->view('step_payment', $data);
	}
	
	public function update_fee_payment() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['fee'] = trim($this->input->post('fee', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_fee_payment($data) > 0) {
			update_status($data['uuid'], PAYMENT_UPDATED);
			header('Location: '.base_url('/apply/confirm_info/'.$data['uuid']));
		} else {
			$msg['tips'] = '信息更新失败，请返回重试！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}*/
	
	public function confirm_info($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		if (!check_status($uuid, PICTURE_UPLOADED)) {
			$msg['tips'] = '请先填写完必要信息再前往下一步！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$userid = $this->userid;
		$attributes = '*';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		$info['passport_pic'] = SCAN_DOMAIN .$uuid .'/passport';
		
		$info['user'] = $this->user_info;
		if ($info) {
			$this->load->view('step_confirm', $info);
		} else {
			$msg['tips'] = '你所请求的申请记录不存在！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function submit_all_info($uuid = '', $opt = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('申请流水号出错');
		}
		
		if (!is_editable($data['uuid'])) {
			$msg['tips'] = '该申请不可再修改！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['userid'] = $this->userid;
		$data['uuid'] = $uuid;
		$data['status'] = APPLY_NOTFINISHED;
		switch ($opt) {
			case 'submit': $data['status'] = APPLY_WAITING; break;
			case 'cancel': $data['status'] = APPLY_TRASHED; break;
		}
		
		$this->load->library('RedisDB');
		$redis = $this->redisdb->instance(REDIS_DEFAULT);
		$data['fee'] = $redis->get('visa_fee');
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->submit_all_info($data) > 0) {
			update_status($data['uuid'], $data['status']);
			header('Location: '.base_url('/apply'));
		} else {
			$msg['tips'] = '申请已成功提交，请不要重复提交申请！';
			$link = '/apply';
			$location = '返回用户主页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function trash($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$ret['msg'] = 'forbidden';
			echo json_encode($ret);
			exit('Forbidden');
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$this->load->helper('util');
		
		$ret['msg'] = 'fail';
		
		$this->load->model('apply_model', 'alm');
		if ($this->alm->trash_application($uuid, $this->userid) > 0) {
			update_status($uuid, APPLY_TRASHED);
			$ret['msg'] = 'success';
		}
		
		echo json_encode($ret);
	}
	
	public function view($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$userid = $this->userid;
		$attributes = '*';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		if ($info) {
			if ($info['status'] >= APPLY_WAITING) {
				//$info['photo_pic'] = SCAN_DOMAIN .$uuid .'/photo';
				$info['passport_pic'] = SCAN_DOMAIN .$uuid .'/passport';
				//$info['identity_pic'] = SCAN_DOMAIN .$uuid .'/identity';
				//$info['ticket_pic'] = SCAN_DOMAIN .$uuid .'/ticket';
				//$info['deposition_pic'] = SCAN_DOMAIN .$uuid .'/deposition';
			}
			$this->load->view('apply_view', $info);
		} else {
			$msg['tips'] = '你所请求的申请记录不存在！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
	}
	
	public function download_form($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$userid = $this->userid;
		$attributes = '*';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
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
	
	public function download_visa($uuid = '') {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		if ($uuid === '') {
			show_error('申请流水号出错');
		}
		
		$attributes = 'visa_no';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($this->userid, $uuid, $attributes);
		
		if (!$info || $info['visa_no'] === '') {
			show_error('申请记录或签证文件不存在！');
		}
		
		$filename = VISA_PATH .$uuid.'/'.$info['visa_no'].'.docx';
		if (!file_exists($filename)) {
			$msg['tips'] = '你所请求的签证文件不存在或已过期！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
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
	
	public function audit_trace_by_uuid($uuid = '') {
		$this->load->helper('util');
		$this->load->model('apply_model', 'alm');
		$records = $this->alm->get_auditing_records_by_uuid($uuid);
		
		foreach ($records as &$one) {
			$one['status_str'] = $this->config->config['apply_status_str'][$one['status']];
		}
		
		$ret['records'] = $records;
		
		echo json_encode($ret);
	}
	
	public function download_excel() {
		if ($this->permission != RESERVATION_USER) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['agency_id'] = $this->user_info['agency_id'];
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
		
		$this->load->model('user_model', 'user');
		
		$reservation_users = array();
		$reservation_users = $this->user->get_reservation_users($this->user_info['agency_id']);
		
		$office_admins = array();
		$office_admins = $this->user->get_office_admins($this->user_info['province_id'], 0);
		
		$embassy_admins = array();
		$embassy_admins = $this->user->get_embassy_admins();
		
		$this->load->model('apply_model', 'alm');
		while ($records = $this->alm->retrieve_records($data, $page)) {
			// Set Cell Content
			$i = 1;
			foreach ($records as $one) {
				$one['agency'] = $reservation_users[$one['userid']]['agency'];
				$one['agency_admin'] = $reservation_users[$one['userid']]['nickname'];
				
				$userid = $this->alm->get_admin_userid($one['uuid'], APPLY_NOTPASSED, APPLY_PASSED);
				$one['office'] = $office_admins[$userid]['agency'];
				$one['office_admin'] = $office_admins[$userid]['nickname'];
				
				$userid = $this->alm->get_admin_userid($one['uuid'], APPLY_REJECTED, VISA_EXPIRED);
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
	}
}

/* End of file */