<?php
	class Admin_model extends CI_Model {
		
		private $admin_db;
		
		public function __construct() {
			parent::__construct();
			$this->admin_db = $this->load->database('default', TRUE);
		}
		
		public function sum_applications($province_id, $status = 1) {
			$this->admin_db->where('province_id', $province_id);
			$this->admin_db->where('status', $status);
			return $this->admin_db->count_all_results('visa_applying');
		}
		
		public function get_applications($province_id, $status = 1) {
			$this->admin_db->select('uuid, name_en, name_cn, status, passport_number, submit_time');
			$this->admin_db->where('province_id', $province_id);
			$this->admin_db->where('status', $status);
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
		
		public function auditing_application($data) {
			$update_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			
			$this->admin_db->set('uuid', $data['uuid']);
			$this->admin_db->set('status', $data['status']);
			$this->admin_db->set('admin_userid', $data['userid']);
			$this->admin_db->set('audit_time', $update_time);
			$this->admin_db->set('message', $data['message']);
			$this->admin_db->insert('visa_auditing');
			
			if ($this->admin_db->affected_rows() > 0) {
				if ($data['status'] === 21 || $data['status'] === 31) {
					$this->admin_db->set('audit_time', $update_time);
				} else if ($data['status'] === 41) {
					$this->admin_db->set('paid_time', $update_time);
				} else {
					return FALSE;
				}
				$this->admin_db->set('status', $data['status']);
				$this->admin_db->where('uuid', $data['uuid']);
				$this->admin_db->update('visa_applying');
				
				if ($this->admin_db->affected_rows() > 0) {
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
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