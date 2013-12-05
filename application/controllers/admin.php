<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/AdminLoginController.php';

class Admin extends AdminLoginController {

	public function index() {
		switch (intval($this->permission)) {
			case 3: header('Location: '. base_url('/admin/audit')); break;
			case 2: header('Location: '. base_url('/admin/approve')); break;
			case 1: $this->load->view('system_admin_index', $this->user_info); break;
			default : 
				$msg['tips'] = 'account forbidden';
				$link = '/admin_login';
				$location = 'index page';
				$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
				show_error($msg);
		}
	}
	
	public function audit($opt = 'wait', $page = 1) {
		$this->load->helper('util');
		$data['status'] = text2status($opt);
		$data['province_id'] = $this->user_info['province_id'];
		$data['page'] = $page - 1;
		
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['passport'] = trim($this->input->post('passport', TRUE));
		$data['start_time'] = trim($this->input->post('start_time', TRUE));
		$data['end_time'] = trim($this->input->post('end_time', TRUE));
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url('/admin/audit/'.$opt.'/');
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_applications($data);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->initialize($config);
		$data['records'] = $this->adm->get_applications($data);
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = status2text($one['status']);
		}
		
		$this->load->view('admin_audit', $data);
	}
	
	public function approve($opt = 'paid', $page = 1) {
		$user = $this->user_info;
		
		$this->load->helper('util');
		$data['status'] = text2status($opt);
		$data['province_id'] = $this->user_info['province_id'];
		$data['page'] = $page - 1;
		
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['passport'] = trim($this->input->post('passport', TRUE));
		$data['start_time'] = trim($this->input->post('start_time', TRUE));
		$data['end_time'] = trim($this->input->post('end_time', TRUE));
		
		$this->load->model('admin_model', 'adm');
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url('/admin/audit/'.$opt.'/');
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;
		$config['total_rows'] = $this->adm->sum_applications($data);
		$config['per_page'] = 20;
		$config['use_page_numbers'] = TRUE;
		
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['first_link'] = '首 页';
		$config['last_link'] = '尾 页';
		
		$data['user'] = $this->user_info;
		$data['pagination'] = $this->pagination->initialize($config);
		$data['records'] = $this->adm->get_applications($data);
		
		foreach ($data['records'] as &$one) {
			$one['status_str'] = status2text($one['status']);
		}
		
		$this->load->view('admin_approve', $data);
	}
	
	public function total_preview($uuid = '') {
		if ($uuid === '') {
			show_error('uuid empty error', 500);
			die();
		}
		
		$user = $this->user_info;
		$attributes = '*';
		
		$this->load->model('admin_model', 'adm');
		$info = $this->adm->retrieve_some_info($uuid, $user['province_id'], $attributes);
		
		if ($info) {
			$this->load->view('apply_view', $info);
		} else {
			show_error('no application available', 500);
		}
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
		$data['uuid'] = $uuid;
		$data['userid'] = $this->userid;
		$data['start_time'] = strtotime('today');
		$data['end_time'] = $data['start_time'] + 86400 * 60;
		
		$this->load->model('admin_model', 'adm');
		$attributes = '*';
		$info = $this->adm->retrieve_some_info($uuid, $this->user_info['province_id'], $attributes);
		
		if (!$info) {
			$msg['tips'] = 'forbidden';
			$link = '/admin/approve';
			$location = 'index page';
			$msg['target'] = '<a href="'.$link.'">go to page '.$location.'</a>';
			show_error($msg, 500);
		}
		
		if (($id = $this->adm->final_audit($data))) {
			$this->load->helper('util');
			$visa_no = gen_visa_number($id);
			$this->adm->update_visa_number($id, $visa_no);
			
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
			
			header('Content-Description: File Transfer');
			header('Content-Type: application/force-download');
			header('Content-Disposition: attachment; filename='.basename($path.$visa_no.'.docx'));
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path.$visa_no.'.docx'));
			readfile($path.$visa_no.'.docx');
			//unlink($path.$visa_no.'.docx');
			
			//email();
		}
	}
	
	public function scan_upload($uuid = '') {
		$userid = $this->userid;
		
		$data['uuid'] = $uuid;
		if ($data['uuid'] === '') {
			show_error('uuid empty error', 500);
		}
		
		$this->load->view('audit_upload', $data);
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
				show_error('upload failed', 500);
			}
		}
		
		header('Location: /admin/total_preview/');
	}
	
}

/* End of file */