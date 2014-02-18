<?php
	class User_model extends CI_Model {
		
		private $user_db;
		
		public function __construct() {
			parent::__construct();
			$this->user_db = $this->load->database('default', TRUE);
		}
		
		public function retrieve_cookie($local_key) {
			if ($local_key === '') {
				return FALSE;
			}
			
			$this->load->library('RedisDB');
			$redis = $this->redisdb->instance(REDIS_DEFAULT);
			if (!($user = $redis->get($local_key))) {
				return FALSE;
			} else {
				return json_decode($user, TRUE);
			}
		}
		
		public function push_cookie($user) {
			$local_key = hash('SHA1', $user['userid'].$user['permission'].$user['email'].$_SERVER['REQUEST_TIME']);
			
			if (setcookie('local_key', $local_key, 0, '/', $_SERVER['HTTP_HOST'], FALSE, TRUE)) {
				$json_info = json_encode($user);
				$this->load->library('RedisDB');
				$redis = $this->redisdb->instance(REDIS_DEFAULT);
				$redis->setex($local_key, 3600 * COOKIE_TTL_HOUR, $json_info);
				
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		public function pop_cookie($local_key) {
			setcookie('local_key', '', -1, '/', $_SERVER['HTTP_HOST'], FALSE, TRUE);
			
			$this->load->library('RedisDB');
			$redis = $this->redisdb->instance(REDIS_DEFAULT);
			$redis->del($local_key);
		}
		
		public function user_register($data) {
			$this->user_db->insert('user', $data);
			
			if ($this->user_db->affected_rows() > 0) {
				return $this->user_db->insert_id();
			} 
			
			return -1;
		}
		
		public function user_login($email) {
			$query = $this->user_db->get_where('user', array('email' => $email), 1);
			
			return $query->row_array();
		}
		
		/*public function applicant_register($data) {
			$this->user_db->insert('applicant', $data);
			
			if ($this->user_db->affected_rows() > 0) {
				return $this->user_db->insert_id();
			} 
			
			return -1;
		}
		
		public function administrator_register($data) {
			$this->user_db->insert('administrator', $data);
			
			if ($this->user_db->affected_rows() > 0) {
				return $this->user_db->insert_id();
			} 
			
			return -1;
		}
		
		public function applicant_login($email) {
			$query = $this->user_db->get_where('applicant', array('email' => $email), 1);
			
			return $query->row_array();
		}
		
		public function administrator_login($email) {
			$query = $this->user_db->get_where('administrator', array('email' => $email), 1);
			
			return $query->row_array();
		}*/
		
		/*public function sum_applicant($status) {
			$this->user_db->where('status', $status);
			
			return $this->user_db->count_all_results('applicant');
		} 
		
		public function get_applicants($data) {
			if ($data['email'] !== '') {
				$search = array('email' => $data['email']);
			} else {
				$search = array('status' => $data['status']);
			}
			$query = $this->user_db->get_where('applicant', $search, 20, 20 * $data['page']);
			
			return $query->result_array();
		}
		
		public function sum_administrator($status) {
			$this->user_db->where('status', $status);
			
			return $this->user_db->count_all_results('administrator');
		} 
		
		public function get_administrators($data) {
			if ($data['province_id'] !== 0) {
				$search = array('province_id' => $data['province_id']);
			} else {
				$search = array('status' => $data['status']);
			}
			$query = $this->user_db->get_where('administrator', $search, 20, 20 * $data['page']);
			
			return $query->result_array();
		}*/
		
		public function sum_users($data) {
			if ($data['email'] !== '') {
				$this->user_db->where('email', $data['email']);
			} else {
				if ($data['province_id'] !== 0) {
					$this->user_db->where('province_id', $data['province_id']);
				}
				if ($data['city_id'] !== 0) {
					$this->user_db->where('city_id', $data['city_id']);
				}
				$this->user_db->where('status', $data['status']);
			}
			
			return $this->user_db->count_all_results('user');
		} 
		
		public function user_list($data) {
			if ($data['email'] !== '') {
				$this->user_db->where('email', $data['email']);
			} else {
				if ($data['province_id'] !== 0) {
					$this->user_db->where('province_id', $data['province_id']);
				}
				if ($data['city_id'] !== 0) {
					$this->user_db->where('city_id', $data['city_id']);
				}
				$this->user_db->where('status', $data['status']);
			}
			$this->user_db->limit(20, 20 * $data['page']);
			$query = $this->user_db->get();
			
			return $query->result_array();
		}
		
		public function email_available($email) {
			$this->user_db->where('email', $email);
			
			return $this->user_db->count_all_results('user');
		}
		
		/*public function applicant_email_available($email) {
			$this->user_db->where('email', $email);
			
			return $this->user_db->count_all_results('applicant');
		}
		
		public function administrator_email_available($email) {
			$this->user_db->where('email', $email);
			
			return $this->user_db->count_all_results('administrator');
		}*/
		
		/*public function applicant_nickname_available($nickname) {
			$this->user_db->where('nickname', $nickname);
			
			return $this->user_db->count_all_results('applicant');
		}*/
		
		public function change_account_status($data) {
			$this->user_db->set('status', $data['status']);
			$this->user_db->where('userid', $data['userid']);
			$this->user_db->update('user');
			
			return $this->user_db->affected_rows();
		}
		
		public function update_password($data) {
			$this->user_db->set('password', $data['password']);
			$this->user_db->where('userid', $data['userid']);
			$this->user_db->update('user');
			
			return $this->user_db->affected_rows();
		}
		
		/*public function applicant_info($userid) {
			$this->user_db->select('userid, email, nickname, realname, status');
			$this->user_db->where('userid', $userid);
			$this->user_db->limit(1);
			$query = $this->user_db->get('applicant');
			
			return $query->row_array();
		}
		
		public function administrator_info($userid) {
			$this->user_db->select('userid, email, realname, status');
			$this->user_db->where('userid', $userid);
			$this->user_db->limit(1);
			$query = $this->user_db->get('administrator');
			
			return $query->row_array();
		}*/
		
		public function extra_info($city_id) {
			$this->user_db->select('province_cn, province_en, city_cn, city_en');
			$this->user_db->from('city');
			$this->user_db->join('province', 'province.id = city.province_id', 'left');
			$this->user_db->where('city.id', $city_id);
			$this->user_db->limit(1);
			$query = $this->user_db->get();
			
			return $query->row_array();
		}
		
		public function __call($foo, $bar) {
			return FALSE;
		}
	}
?>