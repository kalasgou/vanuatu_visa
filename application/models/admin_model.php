<?php
	class Admin_model extends CI_Model {
		
		private $admin_db;
		
		public function __construct() {
			parent::__construct();
			$this->admin_db = $this->load->database('default', TRUE);
		}
		
		public function get_applications($province_id) {
			$this->admin_db->select('uuid, name_en, name_cn, status, passport_number, submit_time');
			$this->admin_db->where('province_id', $province_id);
			$this->admin_db->where('status > ', 0);
			$this->admin_db->where('status < ', 1000);
			$this->admin_db->order_by('submit_time', 'desc');
			$query = $this->admin_db->get('visa_applying');
			
			return $query->result_array();
		}
		
		public function retrieve_some_info($uuid, $attributes) {
			$this->admin_db->select($attributes);
			$this->admin_db->where('uuid', $uuid);
			$this->admin_db->limit(1);
			$query = $this->admin_db->get('visa_applying');
			
			return $query->row_array();
		}
		
		public function final_audit($data) {
			$this->admin_db->set('uuid', $data['uuid']);
			$this->admin_db->set('start_time', $data['start_time']);
			$this->admin_db->set('end_time', $data['end_time']);
			$this->admin_db->insert('visa_approved');
			
			if ($this->admin_db->affected_rows() > 0) {
				return $this->admin_db->insert_id();
			} else {
				return FALSE;
			}
		}
		
		public function update_visa_number($id, $number) {
			$this->admin_db->set('visa_no', $number);
			$this->admin_db->where('id', $id);
			$this->admin_db->update('visa_approved');
			
			return $this->admin_db->affected_rows();
		}
	}
?>