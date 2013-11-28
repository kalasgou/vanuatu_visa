<?php
	
	function check_parameters($data) {
		foreach ($data as $one) {
			if ($one === '') {
				return FALSE;
			}
		}
		return TRUE;
	}
	
	function hex16to64($m, $len = 0) {
		$code = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
		$hex2 = array();
		for($i = 0, $j = strlen($m); $i < $j; ++$i) {
			$hex2[] = str_pad(base_convert($m[$i], 16, 2), 4, '0', STR_PAD_LEFT);
		}
		$hex2 = implode('', $hex2);
		$hex2 = str_rsplit($hex2, 6);
		foreach($hex2 as $one) {
			$hex64[] = $code[bindec($one)];
		}
		$short = preg_replace('/^0*/', '', implode('', $hex64));
		if($len) {
			$clen = strlen($short);
			if($clen >= $len) {
				return $short;
			}
			else {
				return str_pad($short, $len, '0', STR_PAD_LEFT);
			}
		}
		return $short;
	}

	function str_rsplit($str, $len = 1) {
		if($str == null || $str == false || $str == '') return false;
		$strlen = strlen($str);
		if($strlen <= $len) return array($str);
		$headlen = $strlen % $len;
		if($headlen == 0) {
			return str_split($str, $len);
		}
		$tmp = array(substr($str, 0, $headlen));
		return array_merge($tmp, str_split(substr($str, $headlen), $len));
	}

	function uuid() {  
		$chars  = md5(uniqid(mt_rand(), true));  
		$uuid   =  substr($chars ,0,8);
		$uuid  .=  substr($chars ,8,4);
		$uuid  .=  substr($chars ,12,4); 
		return $uuid;  
	}
	
	function send_email($data) {
		error_reporting(E_STRICT);
		require '../application/third_party/PHPMailer/class.phpmailer.php';
		//include '../application/third_party/PHPMailer/class.pop3.php';
		include '../application/third_party/PHPMailer/class.smtp.php';
		
		$mail = new PHPMailer();
		$mail->CharSet = 'utf8';
		$mail->IsSMTP();
		$mail->SMTPDebug = FALSE;

		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.exmail.qq.com';
		$mail->Port = 465;

		$mail->Username = 'do_not_reply@appletree.cn';
		$mail->Password = 'RKx6gmVWpUaY123';
		$mail->From = 'do_not_reply@appletree.cn';
		$mail->FromName = 'AppleTree';
		
		$mail->AddAddress($data['email'], $data['nickname']);
		
		$mail->IsHTML(TRUE);
		$mail->Subject = $data['subject'];
		$mail->Body = $data['content'];
		
		$sent = $mail->Send();
		unset($mail);
		
		return $sent;
	}
	
	function create_password($pw_length) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$password = '';
		for ($i = 0; $i < $pw_length; $i++) {
			$password .= $chars[mt_rand(0, strlen($chars) - 1)];
		}
		return $password;
	}
	
	function gen_access_token($userid, $redis) {
		$token_timeout = 172800;
		$access_token = create_password(16);
		$key = $userid.'_'.$_SERVER['REQUEST_TIME'];
		$redis->setex($key, $token_timeout, $access_token);
		$redis->lPush($userid.'_token', $key);
		$redis->lTrim($userid.'_token', 0, 9);
		return $access_token;
	}
	
	function access_token_verify($redis, $userid, $token) {
		$token_keys = $redis->lRange($userid.'_token', 0, -1);
		if (count($token_keys)) {
			foreach ($token_keys as $key_index => $key) {
				if ($redis->get($key) === $token) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	function email_verify($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
?>