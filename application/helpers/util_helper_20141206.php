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
		//$mail->addReplyTo();
		//$mail->addCC();
		
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
	
	function get_direct_subordinates($userid) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		
		return array_merge($redis->sMembers($userid.'_subordinate_ids'), array($userid));
	}
	
	function get_direct_indirect_subordinates($userid) {
		$CI = & get_instance();
		$CI->load->library('RedisDB');
		$redis = $CI->redisdb->instance(REDIS_DEFAULT);
		
		$userids = array();
		$office_admins = $redis->sMembers($userid.'_subordinate_ids');
		foreach ($office_admins as $one) {
			$userids = array_merge($userids, $redis->sMembers($one.'_subordinate_ids'));
		}
		
		return array_merge($userids, $office_admins);
	}
	
	function visa_pdf($info) {
		require '../application/third_party/tcpdf/tcpdf.php';
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// remove default header/footer  
		$pdf->SetPrintHeader(false);  
		$pdf->SetPrintFooter(false);
		// set image scale factor  
		$pdf->SetImageScale(PDF_IMAGE_SCALE_RATIO); 
		$pdf->AddPage();
		//$pdf->SetJPEGQuality(100);
		$pdf->Image(TEMPLATE_PATH .'background.jpg', 14);
		$pdf->Image(TEMPLATE_PATH .'qrcode.png', 170, 75, 25, 25);
		$pdf->Image(TEMPLATE_PATH .'stamp_and_signature.jpg', 124, 134, 58.8, 48);
		$pdf->SetFont('arialuni', 'B', 18);
		$pdf->Text(50, 66, 'Vanuatu Embassy Travel Certification');
		$pdf->SetFont('arialuni', '', 12);
		$pdf->Text(20, 105, 'Name: '.$info['first_name'].' '.$info['last_name']);
		$pdf->Text(110, 105, 'Sex: '.($info['gender'] > 1 ? 'Female' : 'Male'));
		$pdf->Text(20, 115, 'Place of Birth: '.$info['birth_place']);
		$pdf->Text(110, 115, 'Date of Birth: '.date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day'])));
		$pdf->Text(20, 125, 'Passport No.: '.$info['passport_number']);
		$pdf->Text(110, 125, 'Ref No.: '.$info['visa_no']);
		$pdf->Text(20, 135, 'Type: P');
		//$pdf->Text(110, 135, 'Length of Stay: '. MAX_STAY_DAYS .' Days');
		$pdf->Text(20, 145, 'Place of Issue: '.$info['passport_place']);
		$pdf->Text(20, 155, 'Passport Date of Issue: '.date('j M, Y', $info['passport_date']));
		$pdf->Text(20, 165, 'Passport Date of Expiry: '.date('j M, Y', $info['passport_expiry']));
		$pdf->Text(20, 175, 'Date of Issue: '.date('j M, Y', $info['start_time']));
		//$pdf->Text(20, 185, 'Date of Expiry :'.date('j M, Y', $info['end_time']));
		$pdf->Text(20, 185, 'Visa and Length of Stay: You will get an entry visa upon arrival for a period of 30 days.');
		
		$pdf->SetMargins(21, 0);
		$pdf->SetFont('arialuni', '', 12);
		$pdf->WriteHTML('<br><br><br><br><br>Reminder :
						<br><br>The above individual is confirmed to travel to Vanuatu and the authorities concerned are therefore informed. 
						');
		$pdf->Output($info['visa_no'].' - '.$info['passport_number'].'.pdf', 'D');
		
		unset($pdf);
	}
?>