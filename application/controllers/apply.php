<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends CI_Controller {

	public function agencies() {
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
							'province_cn' => '上海办事处',
							'location_cn' => '上海XXXXXXXXXX',
							),
						array(
							'id' => '3',
							'province_cn' => '广州办事处',
							'location_cn' => '广州XXXXXXXXXX',
							),
						),
				);
		//$userid = $this->userid;
		$userid = trim($this->input->get('userid', TRUE));
		$attributes = 'uuid, province_id';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $attributes);
		
		$this->load->view('step_zero', $data);
	}
	
	public function select_agency() {
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['province_id'] = trim($this->input->post('province_id', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!check_parameters($data)) {
			$this->load->view('parameters_error');
			die();
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->select_agency($data) > 0) {
			echo 'success';
		} else {
			echo 'fail';
		}
	}
	
	public function basic_info() {
		$data = array(
					'uuid' => '',
					'name_en' => 'kalasou',
					'name_cn' => '杜宇翔',
					'gender' => '',
					'family' => '',
					'nationality' => '中国',
					'birth_day' => '17',
					'birth_month' => '3',
					'birth_year' => '1988',
					'birth_place' => '广东省湛江市',
					'occupation_info' => array(
						'occupation' => '软件工程师',
						'employer' => '广州苹果树',
						'employer_tel' => '020-13450229947',
						'employer_addr' => '东风路',
						),
					'home_info' => array(
						'home_addr' => '农讲所德政中路',
						'home_tel' => '13450229947',
						),
				);
		//$userid = $this->userid;
		$userid = trim($this->input->get('userid', TRUE));
		$attributes = 'uuid, name_en, name_cn, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $attributes);
	
		$this->load->view('step_one', $data);
	}
	
	public function update_basic_info() {
		//$userid = $this->userid;
		$data['userid'] = trim($this->input->post('userid', TRUE));
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
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!check_parameters($data)) {
			$this->load->view('parameters_error');
			die();
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_basic_info($data) > 0) {
			echo 'success';
		} else {
			echo 'fail';
		}
	}
	
	public function passport_info() {
		$data = array(
					'uuid' => '',
					'passport_number' => '软件工程师',
					'passport_place' => '广州苹果树',
					'passport_date' => '450229947',
					'passport_expiry' => '1450229947',
				);
		//$userid = $this->userid;
		$userid = trim($this->input->get('userid', TRUE));
		$attributes = 'uuid, passport_number, passport_place, passport_date, passport_expiry';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $attributes);
	
		$this->load->view('step_two', $data);
	}
	
	public function update_passport_info() {
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['passport_number'] = trim($this->input->post('passport_number', TRUE));
		$data['passport_place'] = trim($this->input->post('passport_place', TRUE));
		$data['passport_date'] = trim($this->input->post('passport_date', TRUE));
		$data['passport_expiry'] = trim($this->input->post('passport_expiry', TRUE));
		
		$this->load->helper('util');
		
		if ($data['uuid'] === '') {
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!check_parameters($data)) {
			$this->load->view('parameters_error');
			die();
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_passport_info($data) > 0) {
			echo 'success';
		} else {
			echo 'fail';
		}
	}
	
	public function travel_info() {
		$data = array(
					'uuid' => '',
					'purpose' => '',
					'destination' => '海边123',
					'relative_info' => array(
						'relative_name' => '软件工程师',
						'relative_addr' => '广州苹果树',
						),
					'detail_info' => array(
						'arrival_number' => 'CHNA123123123',
						'arrival_date' => '2013-12-01',
						'return_number' => 'NACH123123123',
						'return_date' => '2013-12-31',
						'duration' => '10天',
						'financial_source' => 'Daily Paid',
						),
				);
		//$userid = $this->userid;
		$userid = trim($this->input->get('userid', TRUE));
		$attributes = 'uuid, purpose, destination, relative_info, detail_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $attributes);
	
		$this->load->view('step_three', $data);
	}
	
	public function update_travel_info() {
		$data['userid'] = trim($this->input->post('userid', TRUE));
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['purpose'] = trim($this->input->post('purpose', TRUE));
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
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		if (!check_parameters($data)) {
			$this->load->view('parameters_error');
			die();
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_travel_info($data) > 0) {
			echo 'success';
		} else {
			echo 'fail';
		}
	}
	
	public function complement_info() {
		$data = array(
					'uuid' => '',
					'children_info' => array(
						array (
							'child_name' => '软件工程师12',
							'child_sex' => '广州苹果树',
							'child_date' => '广州苹果树21',
							'child_place' => '广州苹果树22',
							),
						array (
							'child_name' => '软件工程师22',
							'child_sex' => '广州苹果树',
							'child_date' => '广州苹果树31',
							'child_place' => '广州苹果树42',
							),
						array (
							'child_name' => '软件工程师11',
							'child_sex' => '广州苹果树',
							'child_date' => '广州苹果树51',
							'child_place' => '广州苹果树62',
							),
						),
					'behaviour_info' => array(
						'criminal' => 'yes',
						'crime_country' => 'America',
						'deported' => 'yes',
						'deport_country' => 'China',
						'visited' => 'no',
						'applied' => 'no',
						'apply_date' => '',
						'refused' => 'no',
						'refuse_date' => '',
						),
				);
		//$userid = $this->userid;
		$userid = trim($this->input->get('userid', TRUE));
		$attributes = 'uuid, children_info, behaviour_info';
		
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_some_info($userid, $attributes);
	
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
			$data['uuid'] = hex16to64(uuid(), 0);
		}
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_complement_info($data) > 0) {
			echo 'success';
		} else {
			echo 'fail';
		}
	}
}

/* End of file */