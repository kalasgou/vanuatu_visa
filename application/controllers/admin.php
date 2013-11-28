<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function auditing() {
		$data['userid'] = trim(this->input->post('userid', TRUE));
		$data['uuid'] = trim($this->input->post('uuid', TRUE));
		$data['passed'] = trim($this->input->post('passed', TRUE));
		$data['reason'] = trim($this->input->post('reason', TRUE));
	}
	
	public function approving() {
		$data['uuid'] = $this->input->post('uuid', TRUE);
	}
}

/* End of file */