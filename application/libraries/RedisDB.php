<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class RedisDB {
		
		static private $instance = array();
		
		function instance($socket) {
			if ($socket === '') {
				$socket = REDIS_DEFAULT;
			}
			
			if (isset(self::$instance[$socket])) {
				try {
					self::$instance[$socket]->ping();
					return self::$instance[$socket];
				} catch (RedisException $ept) {
					unset(self::$instance[$socket]);
				}
			}
			
			$redis = new Redis();
			if (!$redis->connect('127.0.0.1', $socket)) {
				unset($redis);
				die('Redis not Ready');
			}
			
			self::$instance[$socket] = $redis;
			
			return $redis;
		}
	}
?>