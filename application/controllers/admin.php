<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/AdminLoginController.php';

class Admin extends AdminLoginController {

	public function index() {
		$this->load->view('admin_index', $this->user_info);
	}
	
	public function audit() {
		$user = $this->user_info;
		$this->load->model('admin_model', 'adm');
		$data['records'] = $this->adm->get_applications($user['province_id']);
		
		$this->load->view('admin_audit', $data);
	}
	
	public function auditing($uuid) {
		$userid = $this->userid;
		$data['uuid'] = $uuid;
		$data['passed'] = trim($this->input->post('passed', TRUE));
		$data['reason'] = trim($this->input->post('reason', TRUE));
		$data['start_time'] = strtotime('today');
		$data['end_time'] = $data['start_time'] + 86400 * 60;
		
		$this->load->model('admin_model', 'adm');
		
		if (($id = $this->adm->final_audit($data))) {
			$this->load->helper('util');
			$visa_no = gen_visa_number($id);
			$this->adm->update_visa_number($id, $visa_no);
			
			$attributes = '*';
			$info = $this->adm->retrieve_some_info($uuid, $attributes);
			
			require '../application/third_party/PHPWord/PHPWord.php';
			$PHPWord = new PHPWord();

			$document = $PHPWord->loadTemplate('../www/visa_file/form.docx');

			$document->setValue('name', $info['name_en'].'/'.$info['name_cn']);
			$document->setValue('visa_no', $visa_no);
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
			$document->setValue('visa_fee', 'RMB180');

			$document->save($visa_no.'.docx');
		}
	}
	
	public function approving() {
		$data['uuid'] = $this->input->post('uuid', TRUE);
	}
}

/* End of file */