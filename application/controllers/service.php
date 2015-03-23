<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH .'core/UserController.php';

class Service extends UserController {
	 
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		header('Location: '. base_url('service/searchVisas'));
	}
	
	public function searchVisas() {
		if ($this->permission != CUSTOMER_SERVICE) {
			$msg['tips'] = '你的帐户无此操作权限！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$passport_number = $this->input->get('passport_number');
		
		$data = array();
		$visas = array();
		
		if (!empty($passport_number)) {
			$this->load->model('service_model', 'service');
			$visas = $this->service->searchVisasByPassport($passport_number);
			
			foreach ($visas as &$one) {
				$one['status_str'] = $this->config->config['apply_status_str'][$one['status']];
			}
		}
		
		$data['user'] = $this->user_info;
		$data['visas'] = $visas;
		$data['num_records'] = count($visas);
		$data['passport_number'] = $passport_number;
		
		$this->load->view('service_search_visas', $data);
	}
}
?>