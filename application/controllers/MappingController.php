<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MappingController extends MY_Controller {

	/**
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('login');
		}else{
			if($this->session->userdata('level') == 'admin'){
				redirect('admin');
			}elseif($this->session->userdata('level') == 'staff'){
				redirect('staff');
			}elseif($this->session->userdata('level') == 'manager'){
				redirect('manager');
			}else{
				echo 'something wrong';
			}
		}
	}
}
