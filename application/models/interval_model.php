<?php
	
	class Interval_model extends CI_Model {
		
		private $info_db;
		
		public function __construct() {
			parent::__construct();
			$this->info_db = $this->load->database('default', TRUE);
		}
		
		public function combined_info($uuid) {
			$this->info_db->select('first_name, last_name, gender, passport_number, approve_time, visa_no, email');
			$this->info_db->from('visa_applying');
			$this->info_db->join('applicant', 'applicant.userid = visa_applying.userid', 'left');
			$this->info_db->where('uuid', $uuid);
			$this->info_db->limit(1);
			$query = $this->info_db->get();
			
			return $query->row_array();
		}
		
		public function find_expiring_visa() {
			$uuids = array();
			
			$this->info_db->select('uuid');
			$this->info_db->where('expired', 0);
			$this->info_db->where('end_time <= ', time());
			$query = $this->info_db->get('visa_approved');
			
			foreach ($query->result_array() as $one) {
				$uuids[] = $one['uuid'];
			}
			
			return $uuids;
		}
		
		public function set_visa_expired($uuids) {
			$this->info_db->set('expired', 1);
			$this->info_db->where_in('uuid', $uuids);
			$this->info_db->update('visa_approved');
			
			$this->info_db->set('status', VISA_EXPIRED);
			$this->info_db->where_in('uuid', $uuids);
			$this->info_db->update('visa_applying');
		}
	}
?>