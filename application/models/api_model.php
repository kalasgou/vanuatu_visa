<?php
class Api_model extends CI_Model {
	
	private $db_reader;
	
	public function __construct() {
		parent::__construct();
		$this->db_reader = $this->load->database('default', TRUE);
	}
	
	public function get_visa_info($data) {
		$this->db_reader->select('visa_applying.uuid as uuid, status, first_name, last_name, gender, birth_day, birth_month, birth_year, birth_place, birth_place, passport_number, passport_place, passport_date, passport_expiry, fee, visa_approved.visa_no as visa_no, start_time, end_time');
		$this->db_reader->from('visa_applying');
		$this->db_reader->join('visa_approved', 'visa_approved.uuid = visa_applying.uuid', 'left');
		if ($data['uuid'] !== '') {
			$this->db_reader->where('visa_applying.uuid', $data['uuid']);
		}
		if ($data['passport'] !== '') {
			$this->db_reader->where('passport_number', $data['passport']);
		}
		if ($data['visa'] !== '') {
			$this->db_reader->where('visa_applying.visa_no', $data['visa']);
		}
		$query = $this->db_reader->get();
		
		return $query->row_array();
	}
}
?>