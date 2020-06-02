<?php 

/**
 * 
 */
class AdminController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') != null){
			if($this->session->userdata('level') != 'admin'){
				redirect('login');
			}
		}else{
			redirect('login');
		}
	}

	public function index(){
		$this->parseData = [
			'content' => 'content/admin/dashboardView',
			'title' => 'Halaman Dashboard',
			'grafikData' => $this->grafikDashboard()
		];

		$this->load->view('containerView', $this->parseData);
	}

	// Method Pengguna hingga tanda akhir

	public function pengguna(){
		$this->parseData = [
			'content' => 'content/admin/pengguna/index',
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
			'content' => 'content/admin/satuan_barang/index',
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
		$satuan_barang = $this->satuan->getAll()->result();

		$this->parseData = [
			'content' => 'content/admin/barang/index',
			'title' => 'Halaman Barang',
			'satuan_barang' => $satuan_barang
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function ajax_get_all_barang(){
		$barang = $this->barang->getAll();

		if($barang->num_rows() > 0){
			$data = $barang->result();

			foreach($data as $row){
				$datas[] = [
					'kode_barang' => $row->id_item,
					'satuan_barang' => $row->unit_name,
					'nama_barang' => $row->item_name,
					'harga_beli' => $row->buy_price,
					'harga_jual' => $row->sell_price,
					'stok' => $row->stock,
					'button' => '<a data-id="'.$row->id_item.'" data-toggle="modal" data-target="#ourModal" class="btn btn-sm btn-warning bEdit">edit</a> | <a data-id="'.$row->id_item.'" class="btn btn-sm btn-danger bDelete">delete</a>'
				];
			}

			echo json_encode($datas);
		} else {
			echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
		}
	}

	public function ajax_get_barang_by_id(){
		$this->form_validation->set_rules('id', 'ID', 'required');

		if($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		} else {
			$id = $this->input->post('id');
			$data = $this->barang->getById($id);

			if ($data->num_rows() > 0) {
				$row = [
					'id_item' => $data->row()->id_item,
					'id_unit' => $data->row()->id_unit,
					'item_name' => $data->row()->item_name,
					'buy_price' => $data->row()->buy_price,
					'sell_price' => $data->row()->sell_price,
					'stock' => $data->row()->stock
				];

				echo json_encode($row);
			}else{
				echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
			}
		}
	}

	public function ajax_save_barang(){
		$this->form_validation->set_rules('satuan_barang', 'Satuan Barang', 'required');
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
		$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
		// $this->form_validation->set_rules('stok', 'Stok', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$satuanBarang = $this->input->post('satuan_barang');
			$kode_barang = $this->input->post('kode_barang');
			$nama_barang = $this->input->post('nama_barang');
			$harga_beli = $this->input->post('harga_beli');
			$harga_jual = $this->input->post('harga_jual');
			// $stok = $this->input->post('stok');

			$data = [
				'id_item' => $kode_barang,
				'id_unit' => $satuanBarang,
				'item_name' => $nama_barang,
				'buy_price' => $harga_beli,
				'sell_price' => $harga_jual,
				// 'stock' => $stok
			];

			if($this->barang->save($data)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
			}
		}
	}

	public function ajax_update_barang($id){
		$this->form_validation->set_rules('satuan_barang', 'Satuan Barang', 'required');
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');
		$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
		// $this->form_validation->set_rules('stok', 'Stok', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$satuanBarang = $this->input->post('satuan_barang');
			$kode_barang = $this->input->post('kode_barang');
			$nama_barang = $this->input->post('nama_barang');
			$harga_beli = $this->input->post('harga_beli');
			$harga_jual = $this->input->post('harga_jual');
			// $stok = $this->input->post('stok');

			$data = [
				'id_item' => $kode_barang,
				'id_unit' => $satuanBarang,
				'item_name' => $nama_barang,
				'buy_price' => $harga_beli,
				'sell_price' => $harga_jual,
				// 'stock' => $stok
			];

			$where = [
				'id_item' => $id
			];

			if($this->barang->update($data, $where)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
			}
		}
	}

	public function ajax_delete_barang($id){
		if(!empty($id)){
			$where = ['id_item'=>$id];
			if($this->barang->delete($where)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil dihapus', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal dihapus, silahkan coba lagi!', 'error', 0));
			}
		}else{
			echo json_encode($this->message('Gagal!', 'Data gagal dihapus, silahkan coba lagi!', 'error', 0));
		}
	}

	// Akhir method barang

	// Method Supplier hingga tanda akhir

	public function supplier(){

		$this->parseData = [
			'content' => 'content/admin/supplier/index',
			'title' => 'Halaman Barang'
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function ajax_get_all_supplier(){
		$barang = $this->supplier->getAll();

		if($barang->num_rows() > 0){
			$data = $barang->result();

			foreach($data as $row){
				$datas[] = [
					'supplier_name' => $row->supplier_name,
					'address' => $row->address,
					'phone' => $row->phone,
					'button' => '<a data-id="'.$row->id_supplier.'" data-toggle="modal" data-target="#ourModal" class="btn btn-sm btn-warning bEdit">edit</a> | <a data-id="'.$row->id_supplier.'" class="btn btn-sm btn-danger bDelete">delete</a>'
				];
			}

			echo json_encode($datas);
		} else {
			echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
		}
	}

	public function ajax_get_supplier_by_id(){
		$this->form_validation->set_rules('id', 'ID', 'required');

		if($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		} else {
			$id = $this->input->post('id');
			$data = $this->supplier->getById($id);

			if ($data->num_rows() > 0) {
				$row = [
					'supplier_name' => $data->row()->supplier_name,
					'address' => $data->row()->address,
					'phone' => $data->row()->phone,
				];

				echo json_encode($row);
			}else{
				echo json_encode($this->message('Gagal', 'Data kosong!', 'error', 0));
			}
		}
	}

	public function ajax_save_supplier(){
		$this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('telp', 'No. Telpon', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$supplier_name = $this->input->post('nama_supplier');
			$address = $this->input->post('alamat');
			$phone = $this->input->post('telp');

			$data = [
				'supplier_name' => $supplier_name,
				'address' => $address,
				'phone' => $phone,
			];

			if($this->supplier->save($data)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
			}
		}
	}

	public function ajax_update_supplier($id){
		$this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('telp', 'No. Telpon', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$supplier_name = $this->input->post('nama_supplier');
			$address = $this->input->post('alamat');
			$phone = $this->input->post('telp');

			$data = [
				'supplier_name' => $supplier_name,
				'address' => $address,
				'phone' => $phone,
			];

			$where = [
				'id_supplier' => $id
			];

			if($this->supplier->update($data, $where)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil disimpan', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal disimpan, silahkan coba lagi!', 'error', 0));
			}
		}
	}

	public function ajax_delete_supplier($id){
		if(!empty($id)){
			$where = ['id_supplier'=>$id];
			if($this->supplier->delete($where)){
				echo json_encode($this->message('Berhasil!', 'Data telah berhasil dihapus', 'success', 1));
			} else {
				echo json_encode($this->message('Gagal!', 'Data gagal dihapus, silahkan coba lagi!', 'error', 0));
			}
		}else{
			echo json_encode($this->message('Gagal!', 'Data gagal dihapus, silahkan coba lagi!', 'error', 0));
		}
	}

	// Akhir method supplier

	// Method list transaksi hingga tanda akhir

	public function list_transaksi_barang_masuk(){
		$list = $this->beli->getAllJoined();

		$this->parseData = [
			'content' => 'content/admin/transaksi/list/barang_masuk',
			'title' => 'List Transaksi Barang Masuk',
			'list' => $list
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function list_transaksi_barang_keluar(){
		$list = $this->jual->getAllJoined();

		$this->parseData = [
			'content' => 'content/admin/transaksi/list/barang_keluar',
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
}











































