<?php
class Service_model extends CI_Model {
	
	private $service_db;
	
	public function __construct() {
		parent::__construct();
		$this->service_db = $this->load->database('default', TRUE);
	}
	
	public function searchVisasByPassport($passport_number) {
		$visas = array();
		
		$query = $this->service_db
						->select('uuid, first_name, last_name, passport_number, visa_no, status, submit_time, audit_time, approve_time')
						->from('visa_applying')
						->where("passport_number = '{$passport_number}'")
						->get();
		
		if ($query->num_rows() > 0) {
			$visas = $query->result_array();
		}
		
		return $visas;
	}
}
?>