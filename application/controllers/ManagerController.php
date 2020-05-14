<?php 

/**
 * 
 */
class ManagerController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') != null){
			if($this->session->userdata('level') != 'manager'){
				redirect('login');
			}
		}else{
			redirect('login');
		}
	}

	public function index(){
		$this->parseData = [
			'content' => 'content/manager/dashboardView',
			'title' => 'Halaman Dashboard',
			'grafikData' => $this->grafikDashboard()
		];

		$this->load->view('containerView', $this->parseData);
	}

	// Method Pengguna hingga tanda akhir

	public function pengguna(){
		$this->parseData = [
			'content' => 'content/manager/pengguna/index',
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
					'status' => $row->status == '1' ? 'Aktif' : 'Nonaktif',
					'button' => '<a href="#" data-id="'.$row->id_user.'" class="btn btn-xs btn-warning bEdit" data-toggle="modal" data-target="#ourModal"><i class="fas fa-edit"></i> ubah</a> | <a href="#" data-id="'.$row->id_user.'" class="btn btn-xs btn-danger bDelete"><i class="fas fa-trash"></i> hapus</a>'
				];
			}

			echo json_encode($datas);
		} else {
			echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
		}
	}

	public function ajax_get_pengguna_by_id(){
		$this->form_validation->set_rules('id', 'ID', 'required');

		if ($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		} else {
			$user = $this->user->getById($this->input->post('id'));

			if($user->num_rows() > 0){
				$data = [
					'username' => $user->row()->username,
					'fullname' => $user->row()->fullname,
					'level' => $user->row()->level,
					'statusAktif' => $user->row()->status
				];

				echo json_encode($data);
			}else{
				echo json_encode($this->message('Gagal!', 'Data yang Anda cari tidak ditemukan!', 'error', 0));
			}

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

	public function ajax_update_pengguna($id){
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');
		$this->form_validation->set_rules('password', 'Password', 'min_length[5]');
		$this->form_validation->set_rules('repassword', 'Re-Password', 'min_length[5]');
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

			if(!empty($password)){

				$isExist = $this->user->getById($id);

				if($isExist->num_rows() > 0){
					if($password == $repassword){
						$data = [
							'username' => $username,
							'password' => md5($password),
							'level' => $level,
							'status' => $status,
							'fullname' => $fullname
						];

						$where = [
							'id_user' => $id
						];

						if($this->user->update($data, $where)){
							echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
						} else {
							echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
						}

					} else {
						echo json_encode($this->message('Gagal!', 'Password tidak sama, silahkan masukan ulang', 'error', 0));
					}
				}else{
					echo json_encode($this->message('Gagal!', 'Username tidak ditemukan!', 'error', 0));
				}

			} else {
				$data = [
					'username' => $username,
					'level' => $level,
					'status' => $status,
					'fullname' => $fullname
				];

				$where = [
					'id_user' => $id
				];

				if($this->user->update($data, $where)){
					echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
				} else {
					echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
				}
			}
		} 
	}

	public function ajax_delete_pengguna_by_id($id){
		if(!empty($id)){
			if ($this->user->delete(['id_user'=>$id])) {
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil dihapus', 'success', 1));
			}else{
				echo json_encode($this->message('Gagal!', 'Data telah gagal dihapus', 'error', 0));
			}
		}else{
			echo json_encode($this->message('Gagal!', 'Data telah gagal dihapus, expected parameter!', 'error', 0));
		}
	}

	// Akhir method pengguna

	// Method list transaksi hingga tanda akhir

	public function list_transaksi_barang_masuk(){
		$list = $this->beli->getAllJoined();

		$this->parseData = [
			'content' => 'content/manager/transaksi/list/barang_masuk',
			'title' => 'List Transaksi Barang Masuk',
			'list' => $list
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function list_transaksi_barang_keluar(){
		$list = $this->jual->getAllJoined();

		$this->parseData = [
			'content' => 'content/manager/transaksi/list/barang_keluar',
			'title' => 'List Transaksi Barang Keluar',
			'list' => $list
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function ajax_detail_transaksi_barang_masuk($id){
		if(empty($id)){
			echo json_encode($this->message('Gagal!', 'Expected Parameter ID!', 'error', 0));
		}else{
			$data = $this->beli->getAllDetails($id);

			if($data->num_rows() > 0){
				foreach ($data->result() as $row) {
					$datas[] = [
						'id_buy_item' => $row->id_buy_item,
						'invoice_number' => $row->invoice_number,
						'buy_date' => $row->buy_date,
						'total' => $row->total,
						'supplier_name' => $row->supplier_name,
						'item_name' => $row->item_name,
						'unit_name' => $row->unit_name,
						'qty' => $row->qty,
						'price' => $row->price,
						'subtotal' => $row->subtotal,
						'fullname' => $row->fullname
					];
				}

				echo json_encode($datas);
			}else{
				echo json_encode($this->message('Gagal!', 'Data tidak ada!', 'error', 0));	
			}
		}
	}

	public function ajax_detail_transaksi_barang_keluar($id){
		if(empty($id)){
			echo json_encode($this->message('Gagal!', 'Expected Parameter ID!', 'error', 0));
		}else{
			$data = $this->jual->getAllDetails($id);

			if($data->num_rows() > 0){
				foreach ($data->result() as $row) {
					$datas[] = [
						'id_sell_item' => $row->id_sell_item,
						'sell_date' => $row->sell_date,
						'customer' => $row->customer,
						'customer_payment' => $row->customer_payment,
						'customer_change' => $row->customer_change,
						'total' => $row->total,
						'item_name' => $row->item_name,
						'unit_name' => $row->unit_name,
						'qty' => $row->qty,
						'price' => $row->price,
						'subtotal' => $row->subtotal,
						'fullname' => $row->fullname
					];
				}

				echo json_encode($datas);
			}else{
				echo json_encode($this->message('Gagal!', 'Data tidak ada!', 'error', 0));	
			}
		}
	}

	// Akhir method list transaksi

	// Method laporan

	public function laporan_barang_masuk(){
		$this->parseData = [
			'content' => 'content/manager/laporan/laporanMasukView',
			'title' => 'Laporan Barang Masuk'
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function laporan_barang_keluar(){
		$this->parseData = [
			'content' => 'content/manager/laporan/laporanKeluarView',
			'title' => 'Laporan Barang Keluar'
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function laporan_stok_barang(){
		$data = $this->barang->getAll();

		if($data->num_rows() > 0){
			$parseData = ['data' => $data->result()];

			$this->load->library('pdf');

			$this->pdf->setPaper('A4', 'potrait');
			$this->pdf->filename = "laporan-barang-masuk.pdf";
			$this->pdf->load_view('content/manager/laporan/laporanStokBarangCetak', $parseData);
		} else {
			$this->set_message_flash('Error', 'Data kosong', 'error');
			redirect('manager');
		}
	}

	public function laporan_barang_masuk_cetak(){

		$this->form_validation->set_rules('fromDate', 'Tanggal Awal', 'required');
		$this->form_validation->set_rules('toDate', 'Tanggal Sampai', 'required');

		if ($this->form_validation->run() == true) {
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');

			$where = ['buy_date >='=>date('Y-m-d', strtotime($fromDate)), 'buy_date <='=>date('Y-m-d', strtotime($toDate))];

			$data = $this->beli->getAllDetailsByWhere($where)->result();

			if(count($data) > 0){

				foreach ($data as $row) {
					$dataReport[$row->id_buy_item][] = [
						'id_item' => $row->id_item,
						'item_name' => $row->item_name,
						'unit_name' => $row->unit_name,
						'qty' => $row->qty,
						'price' => $row->price,
						'subtotal' => $row->subtotal,
						'total' => $row->total
					];
				}

				$parseData = ['header' => $data, 'detail' => $dataReport];

				$this->load->library('pdf');

				$this->pdf->setPaper('A4', 'potrait');
				$this->pdf->filename = "laporan-barang-masuk.pdf";
				$this->pdf->load_view('content/manager/laporan/laporanMasukCetak', $parseData);
			}else{
				$this->set_message_flash('Error', 'Data kosong', 'error');
				redirect('manager/laporan/transaksi/masuk');
			}

		} else {
			$this->set_message_flash('Error', 'Isi form yang tertera dengan benar!', 'error');
			$this->session->set_flashdata('coba', 'coba');
			redirect('manager/laporan/transaksi/masuk');
		}
	}

	public function laporan_barang_keluar_cetak(){

		$this->form_validation->set_rules('fromDate', 'Tanggal Awal', 'required');
		$this->form_validation->set_rules('toDate', 'Tanggal Sampai', 'required');

		if ($this->form_validation->run() == true) {
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');

			$where = ['sell_date >='=>date('Y-m-d', strtotime($fromDate)), 'sell_date <='=>date('Y-m-d', strtotime($toDate))];

			$data = $this->jual->getAllDetailsByWhere($where)->result();

			if(count($data) > 0){

				foreach ($data as $row) {
					$dataReport[$row->id_sell_item][] = [
						'id_item' => $row->id_item,
						'item_name' => $row->item_name,
						'unit_name' => $row->unit_name,
						'qty' => $row->qty,
						'price' => $row->price,
						'subtotal' => $row->subtotal,
						'total' => $row->total
					];
				}

				$parseData = ['header' => $data, 'detail' => $dataReport];

				$this->load->library('pdf');

				$this->pdf->setPaper('A4', 'potrait');
				$this->pdf->filename = "laporan-barang-masuk.pdf";
				$this->pdf->load_view('content/manager/laporan/laporanKeluarCetak', $parseData);
			}else{
				$this->set_message_flash('Error', 'Data kosong', 'error');
				redirect('manager/laporan/transaksi/masuk');
			}

		} else {
			$this->set_message_flash('Error', 'Isi form yang tertera dengan benar!', 'error');
			$this->session->set_flashdata('coba', 'coba');
			redirect('manager/laporan/transaksi/masuk');
		}
	}

	// Akhir method laporan





























}