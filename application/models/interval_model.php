<?php
	
	class Interval_model extends CI_Model {
		
		private $info_db;
		
		public function __construct() {
			parent::__construct();
			$this->info_db = $this->load->database('default', TRUE);
		}
		
		public function combined_info($uuid) {
			$this->info_db->select('name_en, name_cn, gender, passport_number, approve_time, visa_no, email');
			$this->info_db->from('visa_applying');
			$this->info_db->join('applicant', 'applicant.userid = visa_applying.userid', 'left');
			$this->info_db->where('uuid', $uuid);
			$this->info_db->limit(1);
			$query = $this->info_db->get();
			
			return $query->row_array();
		}
	}
?>