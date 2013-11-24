<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends CI_Controller {

	public function agencies() {
		//$userid = $this->userid;
		$userid = trim($this->input->get('userid', TRUE));
		$this->load->model('apply_model', 'alm');
		$agencies = $this->alm->get_all_agencies();
		
		$this->load->view('agency_selection', $agencies);
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
		$this->load->model('apply_model', 'alm');
		$info = $this->alm->retrieve_basic_info($userid);
	
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
			$data['uuid'] = uuid();
		}
		
		/*if (!check_parameters($data)) {
			$this->load->view('parameters_error');
			die();
		}*/
		
		$this->load->model('apply_model', 'alm');
		
		if ($this->alm->update_basic_info($data) > 0) {
			
		} else {
			
		}
	}
	
	
	public function 
}

/* End of file */