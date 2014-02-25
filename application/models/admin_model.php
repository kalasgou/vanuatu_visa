<?php
	class Admin_model extends CI_Model {
		
		private $admin_db;
		
		public function __construct() {
			parent::__construct();
			$this->admin_db = $this->load->database('default', TRUE);
		}
		
		public function sum_applications($data) {
			/*if ($data['province_id'] != 0 || $data['city_id'] != 0) {
				$this->admin_db->where('province_id', $data['province_id']);
				$this->admin_db->where('city_id', $data['city_id']);
			}*/
			if ($data['userids']) {
				$this->admin_db->where_in('userid', $data['userids']);
			}
			
			switch ($data['orderby']) {
				case DEFAULT_QUERY : 
				case APPLY_STATUS : 
								$this->admin_db->where('status', $data['status']);
								break;
				case APPLY_UUID : 
								$this->admin_db->where('uuid', $data['uuid']);
								break;
				case APPLY_PASSPORT : 
								$this->admin_db->where('passport_number', $data['passport']);
								break;
				case APPLY_PERIOD : 	
								$this->admin_db->where('submit_time >= ', $data['start_time'].' 00:00:00'); 
								$this->admin_db->where('submit_time <= ', $data['end_time'].' 23:59:59');
								break;
				case APPLY_PRESENT: break;
				default : return 0;
			}
			
			return $this->admin_db->count_all_results('visa_applying');
		}
		
		public function get_applications($data) {
			$this->admin_db->select('uuid, name_en, name_cn, status, passport_number, submit_time, audit_time, pay_time, approve_time, fee');
			/*if ($data['province_id'] != 0 || $data['city_id'] != 0) {
				$this->admin_db->where('province_id', $data['province_id']);
				$this->admin_db->where('city_id', $data['city_id']);	
			}*/
			if ($data['userids']) {
				$this->admin_db->where_in('userid', $data['userids']);
			}
			
			switch ($data['orderby']) {
				case DEFAULT_QUERY : 
				case APPLY_STATUS : 
								$this->admin_db->where('status', $data['status']);
								break;
				case APPLY_UUID : 
								$this->admin_db->where('uuid', $data['uuid']);
								break;
				case APPLY_PASSPORT : 
								$this->admin_db->where('passport_number', $data['passport']);
								break;
				case APPLY_PERIOD : 	
								$this->admin_db->where('submit_time >= ', $data['start_time'].' 00:00:00'); 
								$this->admin_db->where('submit_time <= ', $data['end_time'].' 23:59:59');
								break;
				case APPLY_PRESENT: break;
				default : return array();
			}
			$this->admin_db->order_by('submit_time', 'desc');
			$this->admin_db->limit(20, 20 * $data['page']);
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
		
		public function retrieve_records($data, $page) {
			$this->admin_db->select('uuid, name_cn, name_en, birth_day, birth_month, birth_year, gender, nationality, passport_number, submit_time, status, audit_time, pay_time, fee, approve_time, visa_no');
			if ($data['province_id'] != 0 || $data['city_id'] != 0) {
				$this->admin_db->where('province_id', $data['province_id']);
				$this->admin_db->where('city_id', $data['city_id']);
			}
			$this->admin_db->where('status >= ', APPLY_WAITING);
			$this->admin_db->where('submit_time >= ', $data['start_time'].' 00:00:00');
			$this->admin_db->where('submit_time <= ', $data['end_time'].' 23:59:59');
			$this->admin_db->order_by('submit_time', 'desc');
			$this->admin_db->limit(1000, 1000 * $page);
			$query = $this->admin_db->get('visa_applying');
			
			return $query->result_array();
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
				if ($data['status'] === APPLY_NOTPASSED || $data['status'] === APPLY_PASSED) {
					$this->admin_db->set('audit_time', $update_time);
					$this->admin_db->set('pay_time', $update_time);
				} else if ($data['status'] === APPLY_REJECTED || $data['status'] === APPLY_ACCEPTED) {
					$this->admin_db->set('approve_time', $update_time);
					if ($data['visa_no'] !== '') {
						$this->admin_db->set('visa_no', $data['visa_no']);
					}
				/*} else if ($data['status'] === APPLY_PAID) {
					$this->admin_db->set('pay_time', $update_time);
					$this->admin_db->set('fee', $data['fee']);*/
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
			$this->admin_db->set('admin_userid', $data['userid']);
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
		
		public function get_admin_userids($uuid, $start, $end) {
			$sql = 'SELECT DISTINCT(admin_userid) FROM visa_auditing WHERE uuid = ? AND status >= ? AND status <= ?';
			$query = $this->admin_db->query($sql, array($uuid, $start, $end));
			
			return $query->result_array();
		}
		
		public function sum_auditing_records($userid) {
			$this->admin_db->where('admin_userid', $userid);
			
			return $this->admin_db->count_all_results('visa_auditing');
		}
		
		public function get_auditing_records($userid, $page) {
			$item = 20;
			
			$this->admin_db->select('uuid, status, audit_time, message');
			$this->admin_db->where('admin_userid', $userid);
			$this->admin_db->order_by('audit_time', 'desc');
			$this->admin_db->limit($item, $item * $page);
			$query = $this->admin_db->get('visa_auditing');
			
			return $query->result_array();
		}
		
		public function get_auditing_records_by_uuid($uuid) {
			$this->admin_db->select('status, audit_time, message');
			$this->admin_db->where('uuid', $uuid);
			$this->admin_db->order_by('audit_time', 'desc');
			$query = $this->admin_db->get('visa_auditing');
			
			return $query->result_array();
		}
		
		public function update_application($data) {
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
			
			$sql = 	'INSERT INTO visa_applying (userid, uuid, province_id, city_id, status, name_en, name_cn, gender, family, nationality, birth_day, birth_month, birth_year, birth_place, occupation_info, home_info, passport_number, passport_place, passport_date, passport_expiry, purpose, other_purpose, destination, relative_info, detail_info, children_info, behaviour_info, modify_time, submit_time, fee) '.
					'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE '.
					'status = VALUES(status), '.
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
					'passport_number = VALUES(passport_number), '.
					'passport_place = VALUES(passport_place), '.
					'passport_date = VALUES(passport_date), '.
					'passport_expiry = VALUES(passport_expiry), '.
					'purpose = VALUES(purpose), '.
					'other_purpose = VALUES(other_purpose), '.
					'destination = VALUES(destination), '.
					'relative_info = VALUES(relative_info), '.
					'children_info = VALUES(children_info), '.
					'behaviour_info = VALUES(behaviour_info), '.
					'detail_info = VALUES(detail_info), '.
					'modify_time = VALUES(modify_time), '.
					'submit_time = VALUES(submit_time), '.
					'fee = VALUES(fee)';
			$args = array(
						'userid' => $data['userid'],
						'uuid' => $data['uuid'],
						'province_id' => $data['province_id'],
						'city_id' => $data['city_id'],
						'status' => $data['status'],
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
						'passport_number' => $data['passport_number'],
						'passport_place' => $data['passport_place'],
						'passport_date' => strtotime($data['passport_date']),
						'passport_expiry' => strtotime($data['passport_expiry']),
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
						'children_info' => json_encode($children_info),
						'behaviour_info' => json_encode($behaviour_info),
						'modify_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
						'submit_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
						'fee' => $data['fee'],
					);
					
			$this->admin_db->query($sql, $args);
			
			return $this->admin_db->affected_rows();
		}
		
		public function get_provinces() {
			$this->admin_db->where('id > ', 0);
			$this->admin_db->order_by('province_cn', 'asc');
			$query = $this->admin_db->get('province');
			
			return $query->result_array();
		}
		
		public function get_cities($province_id) {
			$this->admin_db->where('province_id >', 0);
			$this->admin_db->where('province_id', $province_id);
			$this->admin_db->order_by('city_cn', 'asc');
			$query = $this->admin_db->get('city');
			
			return $query->result_array();
		}
		
		public function get_locations() {
			$locations = array();
			
			$this->load->library('RedisDB');
			$redis = $this->redisdb->instance(REDIS_DEFAULT);
			
			if (($cache = $redis->get('city_and_province')) !== FALSE) {
				$locations = json_decode($cache, TRUE);
			} else {
				$this->admin_db->select('city.id as id, province_cn, city_cn');
				$this->admin_db->from('city');
				$this->admin_db->join('province', 'province.id = city.province_id', 'left');
				$query = $this->admin_db->get();
				
				foreach ($query->result_array() as $one) {
					$locations[$one['id']]['province_cn'] = $one['province_cn'];
					$locations[$one['id']]['city_cn'] = $one['city_cn'];
				}
				
				$redis->setex('city_and_province', 3600, json_encode($locations));
			}
			
			return $locations;
		}
		
		/*public function admin_by_city($province_id, $city_id) {
			$superiors = array();
			$superiors[OFFICE_ADMIN]['0'] = '请选择';
			$superiors[EMBASSY_ADMIN]['0'] = '请选择';
			$superiors[SYSTEM_ADMIN]['0'] = '无';
			
			$this->admin_db->select('userid, nickname, permission');
			$this->admin_db->where('city_id', $city_id);
			$this->admin_db->where_in('permission', array(OFFICE_ADMIN, EMBASSY_ADMIN));
			$query = $this->admin_db->get('user');
			
			foreach ($query->result_array() as $one) {
				$superiors[$one['permission']][$one['userid']] = $one['nickname'];
			}
			
			return $superiors;
		}*/
		
		public function superior_for_account($province_id, $permission) {
			$superiors = array();
			$superiors['0'] = '请选择';
			
			$this->admin_db->select('userid, nickname, permission');
			switch ($permission) {
				case RESERVATION_USER: 
							$this->admin_db->where('province_id', $province_id);
							$this->admin_db->where('permission', OFFICE_ADMIN);
							break;
				case OFFICE_ADMIN:
							$this->admin_db->where('permission', EMBASSY_ADMIN);
							break;
				case EMBASSY_ADMIN:
							$superiors['0'] = '无';
							return $superiors;
				default: $superiors['0'] = '权限出错'; return $superiors;
			}
			
			$query = $this->admin_db->get('user');
			foreach ($query->result_array() as $one) {
				$superiors[$one['userid']] = $one['nickname'];
			}
			
			return $superiors;
		}
		
		/*public function sum_agency() {
			return $this->admin_db->count_all_results('agency');
		}
		
		public function upsert_agency($data) {
			$this->admin_db->set('city_cn', $data['city_cn']);
			$this->admin_db->set('addr_cn', $data['addr_cn']);
			//$this->admin_db->set('city_en', $data['city_en']);
			//$this->admin_db->set('addr_en', $data['addr_en']);
			$this->admin_db->set('contact', $data['contact']);
			$this->admin_db->set('date', $data['date']);
			$this->admin_db->where('id', $data['id']);
			
			$this->admin_db->update('agency');
			
			return $this->admin_db->affected_rows();
		}*/
	}
?>