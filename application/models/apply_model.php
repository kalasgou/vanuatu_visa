<?php
	class Apply_model extends CI_Model {
		
		private $apply_db;
		
		public function __construct() {
			parent::__construct();
			$this->apply_db = $this->load->database('default', TRUE);
		}
		
		public function retrieve_some_info($userid, $attributes) {
			$this->apply_db->select($attributes);
			$this->apply_db->where('userid', $userid);
			$this->apply_db->where('status', 0);
			$this->apply_db->order_by('apply_time', 'desc');
			$this->apply_db->limit(1);
			$query = $this->apply_db->get('visa_applying');
			
			return $query->row_array();
		}
		
		public function update_basic_info($data) {
			$sql = 	'INSERT INTO visa_applying (uuid, name_en, name_cn, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info, apply_time) '.
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
					'apply_time = VALUES(apply_time)';
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
						'apply_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_passport_info($data) {
			$sql = 	'INSERT INTO visa_applying (uuid, passport_info, apply_time) '.
					'VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE '.
					'passport_info = VALUES(passport_info), '.
					'apply_time = VALUES(apply_time)';
			$args = array(
						'uuid' => $data['uuid'],
						'passport_info' => json_encode(array(
							'passport_number' => $data['passport_number'],
							'passport_place' => $data['passport_place'],
							'passport_date' => $data['passport_date'],
							'passport_expiry' => $data['passport_expiry'],
							)),
						'apply_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_travel_info($data) {
			$sql = 	'INSERT INTO visa_applying (uuid, purpose, destination, relative_info, detail_info, apply_time) '.
					'VALUES (?, ?, ?, ?, ? ,?) ON DUPLICATE KEY UPDATE '.
					'purpose = VALUES(purpose), '.
					'destination = VALUES(destination), '.
					'relative_info = VALUES(relative_info), '.
					'detail_info = VALUES(detail_info), '.
					'apply_time = VALUES(apply_time)';
			$args = array(
						'uuid' => $data['uuid'],
						'purpose' => $data['purpose'],
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
						'apply_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
		
		public function update_complement_info($data) {
			$children_info = array();
			$length = count($data['child_name']);
			for ($i = 0; $i < $length; $i ++) {
				$tmp['chlid_name'] = $data['child_name'][$i];
				$tmp['child_sex'] = $data['child_sex'][$i];
				$tmp['child_date'] = $data['child_date'][$i];
				$tmp['child_place'] = $data['child_place'][$i];
				
				$children_info[] = $tmp;
			}
			
			$behaviour_info = array();
			$behaviour['criminal'] = $data['criminal'];
			$behaviour['crime_country'] = $data['crime_country'];
			$behaviour['deported'] = $data['deported'];
			$behaviour['deport_country'] = $data['deport_country'];
			$behaviour['visited'] = $data['visited'];
			$behaviour['applied'] = $data['applied'];
			$behaviour['apply_date'] = $data['apply_date'];
			$behaviour['refused'] = $data['refused'];
			$behaviour['refuse_date'] = $data['refuse_date'];
			
			$sql = 	'INSERT INTO visa_applying (uuid, children_info, behaviour_info, apply_time) '.
					'VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE '.
					'children_info = VALUES(children_info), '.
					'behaviour_info = VALUES(behaviour_info)';
			$args = array(
						'uuid' => $data['uuid'],
						'children_info' => json_encode($children_info),
						'behaviour_info' => json_encode($behaviour_info),
						'apply_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
					);
			
			$this->apply_db->query($sql, $args);
			
			return $this->apply_db->affected_rows();
		}
	}
?>