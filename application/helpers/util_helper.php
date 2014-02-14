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
		
		$mail->SMTPDebug = FALSE;
	
		$mail->isSMTP();		
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp-mail.outlook.com';
		$mail->Port = 587;
		$mail->Username = 'vanuatuembassycn@hotmail.com';
		$mail->Password = 'cnmbeva11';

		$mail->From = 'vanuatuembassycn@hotmail.com';
		$mail->FromName = 'VanuatuVisa';
		$mail->addAddress($data['email'], $data['user']);
		$mail->addReplyTo('305858854@qq.com');
		$mail->addCC('305858854@qq.com');
		
		if (isset($data['visa_file'])) {
			$mail->addAttachment($data['visa_file'], 'Visa签证.docx');
		}
		
		$mail->isHTML(TRUE);
		$mail->CharSet = 'utf8';
		$mail->WordWrap = 50;	
		
		$mail->Subject = $data['subject'];
		$mail->Body = $data['content'];
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
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
	
	function email_verify($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function gen_visa_number($id) {
		$id -= 1;
		$range = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$number = '0000CH13';
		for ($i = 3; $i >= 0; $i --) {
			$left = $id % 36;
			$number[$i] = strval($range[$left]);
			$id = intval($id / 36);
			if ($id === 0) break;
		}
		return $number;
	}
	
	function status2text($status_code) {
		$description = array(
							'-128' => '负溢出异常',
							'-1' => '已删除',
							'0' => '未完成',
							'11' => '等待审核',
							'21' => '未通过',
							'31' => '通过审核',
							'41' => '已缴款',
							'91' => '被拒签',
							'101' => '已出签证',
							'125' => '申请过期无效',
							'126' => '签证过期无效',
							'127' => '正溢出异常',
						);
		
		return $description[strval($status_code)];
	}
	
	function text2status($text_string) {
		$status = '11';
		
		switch ($text_string) {
			case 'drop': $status = '-1'; break;
			case 'half': $status = '0'; break;
			case 'wait': $status = '11'; break;
			case 'fail': $status = '21'; break;
			case 'pass': $status = '31'; break;
			case 'paid': $status = '41'; break;
			case 'oops': $status = '91'; break;
			case 'visa': $status = '101'; break;
			case 'lost': $status = '125'; break;
			case 'best': $status = '126'; break;
		}
		
		return $status;
	}
	
	function check_status($uuid, $cur_status) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		return ($cur_status > intval($redis->hGet('application_status', $uuid)) ? FALSE : TRUE);
	}
	
	function update_status($uuid, $forward_status) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		if (intval($redis->hGet('application_status', $uuid)) < 11) {
			$redis->hSet('application_status', $uuid, $forward_status);
		} else if ($forward_status > 11) {
			$redis->hSet('application_status', $uuid, $forward_status);
		} else {
			$redis->hSet('application_status', $uuid, 11);
		}
	}
	
	function is_editable($uuid) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		return (intval($redis->hGet('application_status', $uuid)) > 21 ? FALSE : TRUE);
	}
	
	function push_email_queue($key, $id) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		$redis->lPush($key, $id);
	}
	
	function pop_email_queue($key) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		return $redis->rPop($key);
	}
	
	function gen_random_word($length = 5) {
		$letters = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$word = '';
		$pos = -1;
		
		for ($i = 0; $i < $length; $i ++) {
			$pos = mt_rand(0, 61);
			$word .= $letters[$pos];
		}
		
		return $word;
	}
	
	function get_captcha() {
		$CI = & get_instance();
		$CI->load->helper('captcha');
		$val = array(
				'img_width' => 120,
				'img_height' => 30,
				'img_path' => CAPTCHA_PATH,
				'img_url' => CAPTCHA_DOMAIN,
				'font_path' => '/data/file/resource/arial.ttf',
				'word' => gen_random_word(5),
				);
		$cap = create_captcha($val);
		
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		$redis->setex(strtolower($cap['word']), 300, intval($cap['time']));
		
		return $cap['image'];
	}
	
	function check_captcha($word) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		$time = intval($redis->get(strtolower($word)));
		
		if ($_SERVER['REQUEST_TIME'] - $time <= 300) {
			$redis->del(strtolower($word));
			return TRUE;
		}
		
		return FALSE;
	}
?>