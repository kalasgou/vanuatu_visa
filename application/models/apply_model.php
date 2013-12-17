<?php
	class Apply_model extends CI_Model {
		
		private $apply_db;
		
		public function __construct() {
			parent::__construct();
			$this->apply_db = $this->load->database('default', TRUE);
		}
		
		public function sum_applications($userid) {
			$this->apply_db->where('userid', $userid);
			$this->apply_db->where('status > ', 0);
			return $this->apply_db->count_all_results('visa_applying');
		}
		
		public function retrieve_some_info($userid, $uuid, $attributes) {
			$this->apply_db->select($attributes);
			$this->apply_db->where('userid', $userid);
			$this->apply_db->where('uuid', $uuid);
			$this->apply_db->limit(1);
			$query = $this->apply_db->get('visa_applying');
			
			return $query->row_array();
		}
		
		public function select_agency($data) {
			$sql = 	'INSERT INTO visa_applying (userid, uuid, province_id, modify_time) '.
					'VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE '.
					'province_id = VALUES(province_id), '.
					'modify_time = VALUES(modify_time)';
			$args = array(
						'userid' => $data['userid'],
						'uuid' => $data['uuid'],
						'province_id' => $data['province_id'],
						'modify_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
					
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_basic_info($data) {
			$sql = 	'INSERT INTO visa_applying (uuid, name_en, name_cn, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info, modify_time) '.
					'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE '.
					'name_en = VALUES(name_en), '.
					'name_cn = VALUES(name_cn), '.
					'gender = VALUES(gender), '.
					'family = VALUES(family), '.
					'nationality = VALUES(nationality), '.
					'birth_day = VALUES(birth_day), '.
					'birth_month = VALUES(birth_month), '.
					'birth_year = VALUES(birth_year), '.
					'birth_place = VALUES(birth_place), '.
					'occupation_info = VALUES(occupation_info), '.
					'home_info = VALUES(home_info), '.
					'modify_time = VALUES(modify_time)';
			$args = array(
						'uuid' => $data['uuid'],
						'name_en' => $data['name_en'],
						'name_cn' => $data['name_cn'],
						'gender' => $data['gender'],
						'family' => $data['family'],
						'nationality' => $data['nationality'],
						'birth_day' => $data['birth_day'],
						'birth_month' => $data['birth_month'],
						'birth_year' => $data['birth_year'],
						'birth_place' => $data['birth_place'],
						'occupation_info' => json_encode(array(
							'occupation' => $data['occupation'],
							'employer' => $data['employer'],
							'employer_tel' => $data['employer_tel'],
							'employer_addr' => $data['employer_addr'],
							)),
						'home_info' => json_encode(array(
							'home_addr' => $data['home_addr'],
							'home_tel' => $data['home_tel'],
							)),
						'modify_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_passport_info($data) {
			$sql = 	'INSERT INTO visa_applying (uuid, passport_number, passport_place, passport_date, passport_expiry, modify_time) '.
					'VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE '.
					'passport_number = VALUES(passport_number), '.
					'passport_place = VALUES(passport_place), '.
					'passport_date = VALUES(passport_date), '.
					'passport_expiry = VALUES(passport_expiry), '.
					'modify_time = VALUES(modify_time)';
			$args = array(
						'uuid' => $data['uuid'],
						'passport_number' => $data['passport_number'],
						'passport_place' => $data['passport_place'],
						'passport_date' => strtotime($data['passport_date']),
						'passport_expiry' => strtotime($data['passport_expiry']),
						'modify_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_travel_info($data) {
			$sql = 	'INSERT INTO visa_applying (uuid, purpose, other_purpose, destination, relative_info, detail_info, modify_time) '.
					'VALUES (?, ?, ?, ?, ?, ? ,?) ON DUPLICATE KEY UPDATE '.
					'purpose = VALUES(purpose), '.
					'other_purpose = VALUES(other_purpose), '.
					'destination = VALUES(destination), '.
					'relative_info = VALUES(relative_info), '.
					'detail_info = VALUES(detail_info), '.
					'modify_time = VALUES(modify_time)';
			$args = array(
						'uuid' => $data['uuid'],
						'purpose' => $data['purpose'],
						'other_purpose' => $data['other_purpose'],
						'destination' => $data['destination'],
						'relative_info' => json_encode(array(
							'relative_name' => $data['relative_name'],
							'relative_addr' => $data['relative_addr'],
							)),
						'detail_info' => json_encode(array(
							'arrival_number' => $data['arrival_number'],
							'arrival_date' => $data['arrival_date'],
							'return_number' => $data['return_number'],
							'return_date' => $data['return_date'],
							'duration' => $data['duration'],
							'financial_source' => $data['financial_source'],
							)),
						'modify_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_complement_info($data) {
			$children_info = array();
			$length = count($data['child_name']);
			for ($i = 0; $i < $length; $i ++) {
				$tmp['child_name'] = $data['child_name'][$i];
				$tmp['child_sex'] = $data['child_sex'][$i];
				$tmp['child_date'] = $data['child_date'][$i];
				$tmp['child_place'] = $data['child_place'][$i];
				
				$children_info[] = $tmp;
			}
			
			$behaviour_info = array();
			$behaviour_info['criminal'] = $data['criminal'];
			$behaviour_info['crime_country'] = $data['crime_country'];
			$behaviour_info['deported'] = $data['deported'];
			$behaviour_info['deport_country'] = $data['deport_country'];
			$behaviour_info['visited'] = $data['visited'];
			$behaviour_info['applied'] = $data['applied'];
			$behaviour_info['apply_date'] = $data['apply_date'];
			$behaviour_info['refused'] = $data['refused'];
			$behaviour_info['refuse_date'] = $data['refuse_date'];
			
			$sql = 	'INSERT INTO visa_applying (uuid, children_info, behaviour_info, modify_time) '.
					'VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE '.
					'children_info = VALUES(children_info), '.
					'behaviour_info = VALUES(behaviour_info), '.
					'modify_time = VALUES(modify_time)';
			$args = array(
						'uuid' => $data['uuid'],
						'children_info' => json_encode($children_info),
						'behaviour_info' => json_encode($behaviour_info),
						'modify_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function submit_all_info($userid, $uuid, $status) {
			$this->apply_db->set('status', $status);
			$this->apply_db->set('submit_time', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']));
			$this->apply_db->where('userid', $userid);
			$this->apply_db->where('uuid', $uuid);
			$this->apply_db->update('visa_applying');
			
			return $this->apply_db->affected_rows();
		}
		
		public function get_records($userid, $page) {
			$this->apply_db->select('uuid, name_en, name_cn, status, passport_number, submit_time, audit_time, pay_time, approve_time');
			$this->apply_db->where('userid', $userid);
			$this->apply_db->where('status > ', 0);
			$this->apply_db->order_by('submit_time', 'desc');
			$this->apply_db->limit(20, 20 * $page);
			$query = $this->apply_db->get('visa_applying');
			
			return $query->result_array();
		}
		
		public function check_passport_available($uuid, $passport_number) {
			$this->apply_db->select('passport_number');
			$this->apply_db->where('uuid', $uuid);
			$query = $this->apply_db->get('visa_applying');
			
			$row = $query->row_array();
			
			if (strcmp($passport_number, $row['passport_number']) === 0) {
				return TRUE;
			} else {
				$sql_a = 'SELECT uuid FROM visa_applying WHERE passport_number = "'.$passport_number.'" AND status >= 11 AND status <= 41';
				$sql_b = 'SELECT uuid FROM visa_applying WHERE passport_number = "'.$passport_number.'" AND status = 101 AND approve_time >= "'.date('Y-m-d H:i:s', strtotime('-60 days')).'"';
				$sql = $sql_a.' UNION ALL '.$sql_b;
				$query = $this->apply_db->query($sql);
				
				if ($query->num_rows() === 0) {
					return TRUE;
				}
			}
			
			return FALSE;
		}
	}
?>