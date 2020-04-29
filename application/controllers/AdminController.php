<?php 

/**
 * 
 */
class AdminController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == null && $this->session->userdata('level') == null){
			redirect('login');
		}
	}

	public function index(){
		$this->parseData = [
			'content' => 'content/dashboardView',
			'title' => 'Halaman Dashboard'
		];

		$this->load->view('containerView', $this->parseData);
	}

	// Method Pengguna hingga tanda akhir

	public function pengguna(){
		$this->parseData = [
			'content' => 'content/admin/index',
			'title' => 'Halaman Pengguna'
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function ajax_get_all_pengguna(){
		$user = $this->user->getAll();

		if($user->num_rows() > 0){
			$data = $user->result();

			foreach($data as $row){
				$datas[] = [
					'username' => $row->username,
					'fullname' => $row->fullname,
					'jabatan' => $row->level,
					'status' => $row->status == '1' ? 'Aktif' : 'Nonaktif'
				];
			}

			echo json_encode($datas);
		} else {
			echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
		}
	}

	public function ajax_save_pengguna(){
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('repassword', 'Re-Password', 'required|min_length[5]');
		$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|min_length[5]');
		$this->form_validation->set_rules('level', 'Level', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$repassword = $this->input->post('repassword');
			$fullname = $this->input->post('fullname');
			$level = $this->input->post('level');
			$status = $this->input->post('status');

			if($password == $repassword){
				$data = [
					'username' => $username,
					'password' => md5($password),
					'level' => $level,
					'status' => $status,
					'fullname' => $fullname
				];

				if($this->user->save($data)){
					echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
				} else {
					echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
				}

			} else {
				echo json_encode($this->message('Gagal!', 'Password tidak sama, silahkan masukan ulang', 'error', 0));
			}
		} 
	}

	// Akhir method pengguna

	// Method Satuan Barang hingga tanda akhir

	public function satuan_barang(){
		$this->parseData = [
			'content' => 'content/satuan_barang/index',
			'title' => 'Halaman Satuan Barang'
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function ajax_get_all_satuan(){
		$unit = $this->satuan->getAll();

		if($unit->num_rows() > 0){
			$data = $unit->result();

			foreach($data as $row){
				$datas[] = [
					'unit_name' => $row->unit_name,
					'button' => '<a data-id="'.$row->id_unit.'" data-toggle="modal" data-target="#ourModal" class="btn btn-sm btn-warning bEdit">edit</a> | <a data-id="'.$row->id_unit.'" class="btn btn-sm btn-danger bDelete">delete</a>'
				];
			}

			echo json_encode($datas);
		} else {
			echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
		}
	}

	public function ajax_save_satuan(){
		$this->form_validation->set_rules('unit_name', 'Nama Satuan', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$unit_name = $this->input->post('unit_name');

			$data = [
				'unit_name' => $unit_name
			];

			if($this->satuan->save($data)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
			}
		}
	}

	public function ajax_get_by_id(){
		$this->form_validation->set_rules('id', 'ID', 'required');

		if($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		} else {
			$id = $this->input->post('id');
			$data = $this->satuan->getById($id);

			if ($data->num_rows() > 0) {
				$row = [
					'unit_name' => $data->row()->unit_name
				];

				echo json_encode($row);
			}else{
				echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
			}
		}
	}

	public function ajax_update_satuan($id){
		$this->form_validation->set_rules('unit_name', 'Nama Satuan', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$unit_name = $this->input->post('unit_name');
			
			$data = [
				'unit_name' => $unit_name
			];

			$where = [
				'id_unit' => $id
			];

			if($this->satuan->update($data, $where)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
			}
		}
	}

	public function ajax_delete_satuan($id){
		if(!empty($id)){
			$where = ['id_unit'=>$id];
			if($this->satuan->delete($where)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil dihapus', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal dihapus, silahkan coba lagi!', 'error', 0));
			}
		}else{
			echo json_encode($this->message('Gagal!', 'Data gagal dihapus, silahkan coba lagi!', 'error', 0));
		}
	}

	// Akhir method satuan barang

	// Method Barang hingga tanda akhir

	public function barang(){
		$this->parseData = [
			'content' => 'content/barang/index',
			'title' => 'Halaman Barang'
		];

		$this->load->view('containerView', $this->parseData);
	}

	// Akhir method barang

}











































