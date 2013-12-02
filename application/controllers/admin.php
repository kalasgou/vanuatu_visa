<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/AdminLoginController.php';

class Admin extends AdminLoginController {

	public function index() {
		switch (intval($this->permission)) {
			case 3: $this->load->view('agency_admin_index', $this->user_info); break;
			case 2: $this->load->view('embassy_admin_index', $this->user_info); break;
			case 1: $this->load->view('system_admin_index', $this->user_info); break;
			default : 
				$msg['tips'] = 'account forbidden';
				$link = '/admin_login';
				$location = 'index page';
				$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
				show_error($msg);
		}
	}
	
	public function audit_list($opt = 'wait') {
		$user = $this->user_info;
		
		$this->load->helper('util');
		$status = text2status($opt);
		
		$this->load->model('admin_model', 'adm');
		$data['records'] = $this->adm->get_applications($user['province_id'], $status);
		
		$this->load->view('admin_audit', $data);
	}
	
	public function audit_preview($uuid = '') {
		$user = $this->user_info;
	}
	
	public function auditing($uuid = '', $opt = '') {
		$data['userid'] = $this->userid;
		$data['uuid'] = $uuid;
		$data['message'] = trim($this->input->post('message', TRUE));
		
		$this->load->helper('util');
		$data['status'] = text2status($opt);
		
		if ($data['uuid'] === '') {
			show_error('uuid empty error', 500);
		}
		
		$this->load->model('admin_model', 'adm');
		if ($this->adm->auditing_application($data)) {
			$ret['msg'] = 'success';
		} else {
			$ret['msg'] = 'fail';
		}
		
		echo json_encode($ret);
	}
	
	public function approving($uuid = '') {
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

			$document = $PHPWord->loadTemplate('/var/visa_file/visa_template.docx');

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
			
			$path = VISA_PATH .$uuid.'/';
			if (file_exists($path) === FALSE) {
				mkdir($path, 0777);
			}

			$document->save($path.$visa_no.'.docx');
		}
	}
}

/* End of file */