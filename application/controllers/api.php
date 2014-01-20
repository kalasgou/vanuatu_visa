<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Api extends CI_Controller {
		
		public function visa_verify() {
			$data['name'] = trim($this->input->get('name', TRUE));
			$data['passport'] = trim($this->input->get('passport', TRUE));
			$data['visa'] = trim($this->input->get('visa', TRUE));
			
			$this->load->helper('util');
			if (!check_parameters($data)) exit('Parameters Not Enough');
			
			$this->load->model('api_model', 'api');
			$info = $this->api->get_visa_info($data);
			
			if ($info) {
				$font_size = 32;
				
				list($w, $h) = getimagesize(VISA_BACKGROUND);
				$image_in = imagecreatefromjpeg(VISA_BACKGROUND);
				
				$image_out = imagecreatetruecolor($w, $h);
				imagecopyresampled($image_out, $image_in, 0, 0, 0, 0, $w, $h, $w, $h);
				$color = imagecolorallocate($image_out, 0x00, 0x00, 0x00);
				imagettftext($image_out, $font_size, 0, 272, 630, $color, VISA_FONT_TYPE, 'Name :'.$info['name_en'].'/'.$info['name_cn']."\n");
				imagettftext($image_out, $font_size, 0, 272, 720, $color, VISA_FONT_TYPE, 'Visa No. :'.$info['visa_no']."\n");
				imagettftext($image_out, $font_size, 0, 272, 810, $color, VISA_FONT_TYPE, 'Date of Issue :'.date('j M, Y', $info['start_time'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 900, $color, VISA_FONT_TYPE, 'Date of Expiry :'.date('j M, Y', $info['end_time'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 900, $color, VISA_FONT_TYPE, 'Max Days of Stay :90 Days'."\n");
				imagettftext($image_out, $font_size, 0, 272, 1080, $color, VISA_FONT_TYPE, 'Sex :'.($info['gender'] > 1 ? 'Female' : 'Male')."\n");
				imagettftext($image_out, $font_size, 0, 272, 1170, $color, VISA_FONT_TYPE, 'Place of Birth :'.$info['birth_place']."\n");
				imagettftext($image_out, $font_size, 0, 272, 1260, $color, VISA_FONT_TYPE, 'Passport No. :'.$info['passport_number']."\n");
				imagettftext($image_out, $font_size, 0, 272, 1350, $color, VISA_FONT_TYPE, 'Date of Birth :'.date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day']))."\n");
				imagettftext($image_out, $font_size, 0, 272, 1440, $color, VISA_FONT_TYPE, 'Type :P'."\n");
				imagettftext($image_out, $font_size, 0, 272, 1530, $color, VISA_FONT_TYPE, 'Place of Issue :'.$info['passport_place']."\n");
				imagettftext($image_out, $font_size, 0, 272, 1620, $color, VISA_FONT_TYPE, 'Passport Date of Issue :'.date('j M, Y', $info['passport_date'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 1710, $color, VISA_FONT_TYPE, 'Passport Date of Expiry :'.date('j M, Y', $info['passport_expiry'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 1800, $color, VISA_FONT_TYPE, 'Visa Fee :RMB'.$info['fee']."\n");
				
				ob_start();
				imagejpeg($image_out, NULL, 100);
				$image_data = ob_get_clean();
				
				header('Content-Type: image/jpeg');
				echo $image_data;
				
				imagedestroy($image_out);
			} else {
				$ret['code'] = 1;
				$ret['msg'] = 'Visa Not Found';
				
				echo json_encode($ret);
			}
		}
	}
?>