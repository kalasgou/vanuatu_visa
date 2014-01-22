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
				$font_size = 34;
				
				list($w, $h) = getimagesize(VISA_BACKGROUND);
				$image_in = imagecreatefromjpeg(VISA_BACKGROUND);
				
				$image_out = imagecreatetruecolor($w, $h);
				imagecopyresampled($image_out, $image_in, 0, 0, 0, 0, $w, $h, $w, $h);
				$color = imagecolorallocate($image_out, 0x00, 0x00, 0x00);
				imagettftext($image_out, 38, 0, 720, 580, $color, VISA_FONT_TYPE, "Single Entry Visa\n");
				imagettftext($image_out, $font_size, 0, 272, 680, $color, VISA_FONT_TYPE, 'Name :'.$info['name_en'].'/'.$info['name_cn']."\n");
				imagettftext($image_out, $font_size, 0, 272, 775, $color, VISA_FONT_TYPE, 'Visa No. :'.$info['visa_no']."\n");
				imagettftext($image_out, $font_size, 0, 272, 870, $color, VISA_FONT_TYPE, 'Date of Issue :'.date('j M, Y', $info['start_time'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 965, $color, VISA_FONT_TYPE, 'Date of Expiry :'.date('j M, Y', $info['end_time'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 1060, $color, VISA_FONT_TYPE, 'Max Days of Stay :90 Days'."\n");
				imagettftext($image_out, $font_size, 0, 272, 1155, $color, VISA_FONT_TYPE, 'Sex :'.($info['gender'] > 1 ? 'Female' : 'Male')."\n");
				imagettftext($image_out, $font_size, 0, 272, 1250, $color, VISA_FONT_TYPE, 'Place of Birth :'.$info['birth_place']."\n");
				imagettftext($image_out, $font_size, 0, 272, 1345, $color, VISA_FONT_TYPE, 'Passport No. :'.$info['passport_number']."\n");
				imagettftext($image_out, $font_size, 0, 272, 1440, $color, VISA_FONT_TYPE, 'Date of Birth :'.date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day']))."\n");
				imagettftext($image_out, $font_size, 0, 272, 1535, $color, VISA_FONT_TYPE, 'Type :P'."\n");
				imagettftext($image_out, $font_size, 0, 272, 1630, $color, VISA_FONT_TYPE, 'Place of Issue :'.$info['passport_place']."\n");
				imagettftext($image_out, $font_size, 0, 272, 1725, $color, VISA_FONT_TYPE, 'Passport Date of Issue :'.date('j M, Y', $info['passport_date'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 1820, $color, VISA_FONT_TYPE, 'Passport Date of Expiry :'.date('j M, Y', $info['passport_expiry'])."\n");
				imagettftext($image_out, $font_size, 0, 272, 1915, $color, VISA_FONT_TYPE, 'Visa Fee :RMB'.$info['fee']."\n");
				
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