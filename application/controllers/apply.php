<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/ApplyLoginController.php';

class Apply extends ApplyLoginController {
	
	/*function test_captcha() {
		$this->load->helper('captcha');
		$val = array(
				'img_path' => './captcha/',
				'img_url' => '/captcha/',
				);
		$cap = create_captcha($val);
		var_dump($cap);
	}*/
	
	public function index($page = 1) {
		$userid = $this->userid;
		$this->load->model('apply_model', 'alm');
		
		$this->load->helper('util');
		$this->load->library('pagination');
		
		$config['base_url'] = '/apply/index/';
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->alm->sum_applications($userid);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$this->pagination->initialize($config); 
		
		$data['user'] = $this->user_info;
		$data['records'] = $this->alm->get_records($userid, $page - 1);
		$data['pagination'] = $this->pagination->create_links();
		$data['num_records'] = $config['total_rows'];
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = status2text($one['status']);
		}
		
		$this->load->view('apply_records', $data);
	}
	
	public function agencies($uuid = '') {
		$data = array(
					'uuid' => '',
					'province_id' => '1',
					'agencies' => array(
						array(
							'id' => '1',
							'province_cn' => '北京办事处',
							'location_cn' => '北京XXXXXXXXXX',
							),
						array(
							'id' => '2',
							'province_cn' => '广州办事处',
							'location_cn' => '广州XXXXXXXXXX',
							),
						array(
							'id' => '3',
							'province_cn' => '上海办事处',
							'location_cn' => '上海XXXXXXXXXX',
							),
						),
				);
		$userid = $this->userid;
		$attributes = 'uuid, province_id';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['province_id'] = $info['province_id'];
		}
		
		$this->load->view('step_zero', $data);
	}
	
	public function select_agency() {
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['province_id'] = trim($this->input->post('province_id', TRUE));
		
		$this->load->helper('util');
		if (!is_editable($uuid)) {
			show_error('not editable');
		}
		
		if ($data['uuid'] === '') {
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!check_parameters($data)) {
			show_error('parameters not enough');
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->select_agency($data) > 0) {
			update_status($data['uuid'], 1);
			header('Location: '.base_url('/apply/basic_info/'.$data['uuid']));
		} else {
			echo 'fail';
		}
	}
	
	public function basic_info($uuid = '') {
		$this->load->helper('util');
		if (!check_status($uuid, 1)) {
			show_error('Do not JUMP!!!');
		}
		
		$data = array(
					'uuid' => '',
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
				);
		$userid = $this->userid;
		$attributes = 'uuid, name_en, name_cn, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['name_en'] = $info['name_en'];
			$data['name_cn'] = $info['name_cn'];
			$data['gender'] = $info['gender'];
			$data['family'] = $info['family'];
			$data['nationality'] = $info['nationality'];
			$data['birth_day'] = $info['birth_day'];
			$data['birth_month'] = $info['birth_month'];
			$data['birth_year'] = $info['birth_year'];
			$data['birth_place'] = $info['birth_place'];
			
			$occupation_info = json_decode($info['occupation_info'], TRUE);
			$data['occupation_info'] = $occupation_info;
			
			$home_info = json_decode($info['home_info'], TRUE);
			$data['home_info'] = $home_info;
		}
		
		$this->load->view('step_one', $data);
	}
	
	public function update_basic_info() {
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
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
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('uuid empty error');
		}
		
		if (!is_editable($data['uuid'])) {
			show_error('not editable');
		}
		
		if (!check_parameters($data)) {
			show_error('parameters not enough');
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_basic_info($data) > 0) {
			update_status($data['uuid'], 2);
			header('Location: '.base_url('/apply/passport_info/'.$data['uuid']));
		} else {
			echo 'fail';
		}
	}
	
	public function passport_info($uuid = '') {
		$this->load->helper('util');
		if (!check_status($uuid, 2)) {
			show_error('Do not JUMP!!!');
		}
		
		$data = array(
					'uuid' => '',
					'passport_number' => '',
					'passport_place' => '',
					'passport_date' => '',
					'passport_expiry' => '',
				);
		$userid = $this->userid;
		$attributes = 'uuid, passport_number, passport_place, passport_date, passport_expiry';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['passport_number'] = $info['passport_number'];
			$data['passport_place'] = $info['passport_place'];
			$data['passport_date'] = date('Y-m-d', $info['passport_date']);
			$data['passport_expiry'] = date('Y-m-d', $info['passport_expiry']);
		}
		
		$this->load->view('step_two', $data);
	}
	
	public function update_passport_info() {
		$data['userid'] = $this->userid;
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['passport_number'] = trim($this->input->post('passport_number', TRUE));
		$data['passport_place'] = trim($this->input->post('passport_place', TRUE));
		$data['passport_date'] = trim($this->input->post('passport_date', TRUE));
		$data['passport_expiry'] = trim($this->input->post('passport_expiry', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			show_error('uuid empty error');
		}
		
		if (!is_editable($data['uuid'])) {
			show_error('not editable');
		}
		
		if (!check_parameters($data)) {
			show_error('parameters not enough');
		}
		
		$this->load->model('apply_model', 'alm');
		
		if (!$this->alm->check_passport_available($data['uuid'], $data['passport_number'])) {
			show_error('passport not available');
		}
		
		if ($this->alm->update_passport_info($data) > 0) {
			update_status($data['uuid'], 3);
			header('Location: '.base_url('/apply/travel_info/'.$data['uuid']));
		} else {
			echo 'fail';
		}
	}
	
	public function travel_info($uuid = '') {
		$this->load->helper('util');
		if (!check_status($uuid, 3)) {
			show_error('Do not JUMP!!!');
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
		$userid = $this->userid;
		$attributes = 'uuid, purpose, other_purpose, destination, relative_info, detail_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			$data['purpose'] = $info['purpose'];
			$data['other_purpose'] = $info['other_purpose'];
			$data['destination'] = $info['destination'];
			
			$relative_info = json_decode($info['relative_info'], TRUE);
			$data['relative_info'] = $relative_info;
			
			$detail_info = json_decode($info['detail_info'], TRUE);
			$data['detail_info'] = $detail_info;
		}
		
		$this->load->view('step_three', $data);
	}
	
	public function update_travel_info() {
		$data['userid'] = trim($this->input->post('userid', TRUE));
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
			show_error('uuid empty error');
		}
		
		if (!is_editable($data['uuid'])) {
			show_error('not editable');
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_travel_info($data) > 0) {
			update_status($data['uuid'], 4);
			header('Location: '.base_url('/apply/complement_info/'.$data['uuid']));
		} else {
			echo 'fail';
		}
	}
	
	public function complement_info($uuid = '') {
		$this->load->helper('util');
		if (!check_status($uuid, 4)) {
			show_error('Do not JUMP!!!');
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
		$userid = $this->userid;
		$attributes = 'uuid, children_info, behaviour_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		$data['user'] = $this->user_info;
		if ($info) {
			$data['uuid'] = $info['uuid'];
			
			$children_info = json_decode($info['children_info'], TRUE);
			if ($children_info) {
				$i = 0;
				foreach ($children_info as $one) {
					$data['children_info'][$i] = $one;
					$i++;
				}
			}
			$behaviour_info = json_decode($info['behaviour_info'], TRUE);
			$data['behaviour_info'] = $behaviour_info;
		}
		
		$this->load->view('step_four', $data);
	}
	
	public function update_complement_info() {
		$data['userid'] = trim($this->input->post('userid', TRUE));
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
			show_error('uuid empty error');
		}
		
		if (!is_editable($data['uuid'])) {
			show_error('not editable');
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_complement_info($data) > 0) {
			update_status($data['uuid'], 5);
			header('Location: '.base_url('/apply/confirm_info/'.$data['uuid']));
		} else {
			echo 'fail';
		}
	}
	
	public function confirm_info($uuid = '') {
		$this->load->helper('util');
		if (!check_status($uuid, 5)) {
			show_error('Do not JUMP!!!');
		}
		
		if ($uuid === '') {
			show_error('uuid empty error');
		}
		
		$userid = $this->userid;
		$attributes = '*';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		$info['user'] = $this->user_info;
		if ($info) {
			$this->load->view('step_five', $info);
		} else {
			show_error('no application available');
		}
	}
	
	public function submit_all_info($uuid = '', $opt = '') {
		$userid = $this->userid;
		$status = 0;
		switch ($opt) {
			case 'submit': $status = 11; break;
			case 'cancel': $status = -1; break;
		}
		
		$this->load->helper('util');
		
		if ($uuid === '') {
			show_error('uuid empty error');
		}
		
		if (!is_editable($data['uuid'])) {
			show_error('not editable');
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->submit_all_info($userid, $uuid, $status) > 0) {
			update_status($uuid, $status);
			header('Location: '.base_url('/apply'));
		} else {
			$msg['tips'] = 'do not repeat it';
			$msg['link'] = '/apply/records';
			$msg['location'] = 'index page';
			$this->load->view('simple_msg_page', $msg);
		}
	}
	
	public function view($uuid = '') {
		if ($uuid === '') {
			show_error('uuid empty error');
		}
		
		$userid = $this->userid;
		$attributes = '*';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		if ($info) {
			if ($info['status'] >= 41) {
				$info['photo_pic'] = SCAN_DOMAIN .$uuid .'/photo';
				$info['passport_pic'] = SCAN_DOMAIN .$uuid .'/passport';
				$info['identity_pic'] = SCAN_DOMAIN .$uuid .'/identity';
				$info['ticket_pic'] = SCAN_DOMAIN .$uuid .'/ticket';
				$info['deposition_pic'] = SCAN_DOMAIN .$uuid .'/deposition';
			}
			$this->load->view('apply_view', $info);
		} else {
			show_error('no application available');
		}
	}
	
	public function download_form($uuid = '') {
		if ($uuid === '') {
			show_error('uuid empty error');
		}
		
		$userid = $this->userid;
		$attributes = '*';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		if ($info) {
			$this->load->view('form_for_download', $info);
		} else {
			show_error('no application available');
		}
	}
	
	public function download_visa($uuid = '') {
		if ($uuid === '') {
			show_error('uuid empty error');
		}
		
		$userid = $this->userid;
		$attributes = 'visa_no';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $uuid, $attributes);
		
		if (!$info || $info['visa_no'] === '') {
			show_error('Bad Request');
		}
		
		$filename = VISA_PATH .$uuid.'/'.$info['visa_no'].'.docx';
		if (!file_exists($filename)) {
			show_error('Cannot Find Visa File');
		}
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename='.basename($filename));
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($filename));
		readfile($filename);
	}
}

/* End of file */