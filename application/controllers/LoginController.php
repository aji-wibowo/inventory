<?php

/**
* 
*/
class LoginController extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Users', 'user');
	}

	public function login(){
		$cookie = get_cookie('inventory');

		if ($this->session->userdata('logged_in')) {
			redirect('/');
		}elseif($cookie <> ""){
			$cekCookie = $this->user->getByCookie($cookie);

			if($cekCookie->num_rows() == 0){
				$this->load->view("content/auth/loginView");
			}else{
				$setMe = [
					"logged_in" => true,
					"username" => $cekCookie->row()->username,
					"fullname" => $cekCookie->row()->fullname,
					"level" => $cekCookie->row()->level,
					"created_date" => $cekCookie->row()->created_at
				];

				$this->_createSession($setMe);

				redirect('/');
			}
		}else{
			$this->load->view("auth/loginView");
		}
	}

	public function login_proses(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$remember = $this->input->post("ingat_saya");

		$isExist = $this->user->getByUsername($username);

		if($isExist->num_rows() > 0){
			if($this->_credentialCheck($isExist->row()->password, $password)){
				if($remember){
					$keyCookie = random_string('alnum', 64);

					$data = ['cookie' => $keyCookie];
					$where = ['id_user' => $isExist->row()->id_user];
					if($this->user->update($data, $where)){
						set_cookie('sunsoftware', $keyCookie, 3600*24*30);
					}
				}

				$setMe = [
					"logged_in" => true,
					"username" => $isExist->row()->username,
					"fullname" => $isExist->row()->fullname,
					"level" => $isExist->row()->level,
					"created_date" => $isExist->row()->created_at
				];

				$this->_createSession($setMe);

				redirect("/");

			}else{
				$this->session->set_flashdata('message', 'login gagal, silahkan coba lagi!');
				redirect("login");
			}
		}
	}

	public function logout(){
		delete_cookie('inventory');
		$this->session->sess_destroy();
		redirect('login');
	}

	private function _createSession($data){
		$this->session->set_userdata( $data );
	}

	private function _credentialCheck($originPassword, $inputedPassword){
		if($originPassword == md5($inputedPassword)){
			return true;
		}

		return false;
	}

}