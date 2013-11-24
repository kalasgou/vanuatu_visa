<?php
	class Apply_model extends CI_Model {
		
		private $apply_db;
		
		public function __construct() {
			parent::__construct();
			$this->apply_db = $this->load->database('default', TRUE);
		}
		
		public function retrieve_basic_info($userid) {
			$this->apply_db->select('uuid, name_en, name_cn, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info');
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
	}
?>