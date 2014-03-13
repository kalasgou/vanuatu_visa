<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	
	public function visa_verify_pic() {
		$data['passport'] = trim($this->input->get('passport', TRUE));
		$data['visa'] = trim($this->input->get('visa', TRUE));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		
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
			imagettftext($image_out, $font_size, 0, 272, 680, $color, VISA_FONT_TYPE, 'Name :'.$info['first_name'].' '.$info['last_name']."\n");
			imagettftext($image_out, $font_size, 0, 272, 775, $color, VISA_FONT_TYPE, 'Visa No. :'.$info['visa_no']."\n");
			imagettftext($image_out, $font_size, 0, 272, 870, $color, VISA_FONT_TYPE, 'Date of Issue :'.date('j M, Y', $info['start_time'])."\n");
			imagettftext($image_out, $font_size, 0, 272, 965, $color, VISA_FONT_TYPE, 'Date of Expiry :'.date('j M, Y', $info['end_time'])."\n");
			imagettftext($image_out, $font_size, 0, 272, 1060, $color, VISA_FONT_TYPE, 'Max Days of Stay :'.MAX_STAY_DAYS.' Days'."\n");
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
	
	public function visa_verify_table() {
		$data['passport'] = trim($this->input->get('passport', TRUE));
		$data['visa'] = trim($this->input->get('visa', TRUE));
		$data['uuid'] = trim($this->input->get('apply_id', TRUE));
		
		if (strlen($data['passport']) + strlen($data['visa']) + strlen($data['uuid']) === 0) {
			$msg['tips'] = '请输入有效查询参数！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一步';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$info = array();
		$output = array();
		$output['valid_visa'] = FALSE;
		
		$this->load->model('api_model', 'api');
		$info = $this->api->get_visa_info($data);
		
		if ($info) {
			$output['valid_visa'] = TRUE;
			$output['apply_id'] = $info['uuid'];
			$output['status'] = $info['status'];
			$output['name'] = $info['first_name'].' '.$info['last_name'];
			$output['gender'] = $info['gender'] > 1 ? 'Female' : 'Male';
			$output['birth_place'] = $info['birth_place'];
			$output['birth_date'] = date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day']));
			$output['passport_number'] = $info['passport_number'];
			$output['passport_place'] = $info['passport_place'];
			$output['passport_date'] = date('j M, Y', $info['passport_date']);
			$output['passport_expiry'] = date('j M, Y', $info['passport_expiry']);
			$output['type'] = 'P';
			$output['visa_number'] = $info['visa_no'];
			$output['visa_date'] = date('j M, Y', $info['start_time']);
			$output['visa_expiry'] = date('j M, Y', $info['end_time']);
			$output['max_stay'] = MAX_STAY_DAYS .' Days';
			$output['application_status'] = $this->config->item($info['status'], 'apply_status_str_en');
			$output['visa_status'] = 'Not Available';
			
			if ($info['status'] == APPLY_ACCEPTED) {
				$output['application_status'] = 'Visa Issued';
				$output['visa_status'] = 'Valid';
			} else if ($info['status'] == VISA_EXPIRED) {
				$output['application_status'] = 'Visa Issued';
				$output['visa_status'] = 'Expired';
			}
		}
		
		$this->load->view('visa_info_table', $output);
	}
	
	function download_visa_word($apply_id = '', $visa = '') {
		if ($apply_id === '' || $visa === '') {
			$msg['tips'] = '参数不足，出错了！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$filename = VISA_PATH .$apply_id.'/'.$visa.'.docx';
		if (!file_exists($filename)) {
			$msg['tips'] = '你所请求的签证文件不存在或已过期！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename='.basename($filename));
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.filesize($filename));
		readfile($filename);
	}
	
	function download_visa_pdf($apply_id = '', $visa = '') {
		if ($apply_id === '' || $visa === '') {
			$msg['tips'] = '参数不足，出错了！';
			$link = 'javascript:history.go(-1);';
			$location = '返回上一页';
			$msg['target'] = '<a href="'.$link.'">'.$location.'</a>';
			show_error($msg);
		}
		
		$data['uuid'] = $apply_id;
		$data['visa'] = $visa;
		$data['passport'] = '';
		
		$this->load->model('api_model', 'api');
		$info = $this->api->get_visa_info($data);
		
		if ($info) {
			require '../application/third_party/tcpdf/tcpdf.php';
			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// remove default header/footer  
			$pdf->SetPrintHeader(false);  
			$pdf->SetPrintFooter(false);
			// set image scale factor  
			$pdf->SetImageScale(PDF_IMAGE_SCALE_RATIO); 
			$pdf->AddPage();
			$pdf->SetJPEGQuality(100);
			$pdf->Image('/var/vanuatuvisa.cn/www/www/background.jpeg');
			$pdf->SetFont('', 'B', 14);
			$pdf->Text(84, 62, 'Single Entry Visa');
			$pdf->SetFont('', '', 12);
			$pdf->Text(38, 77, 'Name :'.$info['first_name'].' '.$info['last_name']);
			$pdf->Text(110, 77, 'Sex :'.($info['gender'] > 1 ? 'Female' : 'Male'));
			$pdf->Text(38, 84.5, 'Place of Birth :'.$info['birth_place']);
			$pdf->Text(110, 84.5, 'Date of Birth :'.date('j M, Y', strtotime($info['birth_year'].'-'.$info['birth_month'].'-'.$info['birth_day'])));
			$pdf->Text(38, 92, 'Passport No. :'.$info['passport_number']);
			$pdf->Text(110, 92, 'Visa No. :'.$info['visa_no']);
			$pdf->Text(38, 99.5, 'Type :P');
			$pdf->Text(110, 99.5, 'Max Days of Stay :90 Days');
			$pdf->Text(38, 107, 'Place of Issue :'.$info['passport_place']);
			$pdf->Text(38, 114.5, 'Passport Date of Issue :'.date('j M, Y', $info['passport_date']));
			$pdf->Text(38, 122, 'Passport Date of Expiry :'.date('j M, Y', $info['passport_expiry']));
			$pdf->Text(38, 129.5, 'Visa Date of Issue :'.date('j M, Y', $info['start_time']));
			$pdf->Text(38, 137, 'Visa Date of Expiry :'.date('j M, Y', $info['end_time']));
			$pdf->SetMargins(39, 0);
			$pdf->WriteHTML('<br><br><br><br><br>Reminder :
							<br>1. Please check all the information on your e-Visa certificate to make sure they are correct. Please direct to contact your travel agency or organization if there is any error.
							<br>2. Your e-Visa fee payment has been paid.
							<br>3. Your e-Visa is only valid for one (1) entry. Please print out 2 copies of this e-Visa certificate .E-Visa printout in black and white is acceptable. Pass one (1) copy to immigration as your Travel Visa at entry and one (1) copy upon departure.
							<br>4. All your information will be checked on arrival at the Immigration Online System. You are required to fill out departure and arrival cards at the entry and exit points. As in other countries have problems, please contact our country consulate or visit the website: www.vanuatuembassy.cn.
							<br>5. Length of stay not more than the visa expiry date, employment prohibited.
							');
			$pdf->Output($info['visa_no'].'.pdf', 'I');
		} else {
			$ret['msg'] = 'Visa Not Found';
			
			echo json_encode($ret);
		}
	}
}
?>