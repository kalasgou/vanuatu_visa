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
				$redis->setex($local_key, 3600, $json_info);
				
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
		
		public function applicant_register($data) {
			$this->user_db->insert('applicant', $data);
			
			return $this->user_db->affected_rows();
		}
		
		public function administrator_register($data) {
			$this->user_db->insert('administrator', $data);
			
			return $this->user_db->affected_rows();
		}
		
		public function applicant_login($email) {
			$query = $this->user_db->get_where('applicant', array('email' => $email), 1);
			
			return $query->row_array();
		}
		
		public function administrator_login($email) {
			$query = $this->user_db->get_where('administrator', array('email' => $email), 1);
			
			return $query->row_array();
		}
		
		function __call($foo, $bar) {
			return FALSE;
		}
	}
?>