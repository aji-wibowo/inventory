<?php 

/**
 * 
 */
class StaffController extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') != null){
			if($this->session->userdata('level') != 'staff'){
				redirect('login');
			}
		}else{
			redirect('login');
		}
	}

	public function index(){
		$this->parseData = [
			'content' => 'content/staff/dashboardView',
			'title' => 'Halaman Dashboard'
		];

		$this->load->view('containerView', $this->parseData);
	}

	// Method Satuan Barang hingga tanda akhir

	public function satuan_barang(){
		$this->parseData = [
			'content' => 'content/staff/satuan_barang/index',
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
			'content' => 'content/staff/barang/index',
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
		$this->form_validation->set_rules('stok', 'Stok', 'required');

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
			$stok = $this->input->post('stok');

			$data = [
				'id_item' => $kode_barang,
				'id_unit' => $satuanBarang,
				'item_name' => $nama_barang,
				'buy_price' => $harga_beli,
				'sell_price' => $harga_jual,
				'stock' => $stok
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
		$this->form_validation->set_rules('stok', 'Stok', 'required');

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
			$stok = $this->input->post('stok');

			$data = [
				'id_item' => $kode_barang,
				'id_unit' => $satuanBarang,
				'item_name' => $nama_barang,
				'buy_price' => $harga_beli,
				'sell_price' => $harga_jual,
				'stock' => $stok
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
			'content' => 'content/staff/supplier/index',
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

	// Method transaksi barang masuk hingga tanda berakhir

	public function transaksi_barang_masuk(){
		$supplier = $this->supplier->getAll();
		$barang = $this->barang->getAll();
		$kodeBeli = $this->getLastIdBuyItem();
		$this->temp->removeAll();

		$this->parseData = [
			'content' => 'content/staff/transaksi/barang_masuk',
			'title' => 'Transaksi Barang Masuk',
			'supplier' => $supplier,
			'barang' => $barang,
			'kodeBeli' => $kodeBeli
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function transaksi_barang_keluar(){
		$kodeJual = $this->getLastIdSellItem();
		$barang = $this->barang->getAll();
		$this->temp->removeAll();

		$this->parseData = [
			'content' => 'content/staff/transaksi/barang_keluar',
			'title' => 'Transaksi Barang Masuk',
			'kodeJual' => $kodeJual,
			'barang' => $barang,
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function list_transaksi_barang_masuk(){
		$list = $this->beli->getAllJoined();

		$this->parseData = [
			'content' => 'content/staff/transaksi/list/barang_masuk',
			'title' => 'List Transaksi Barang Masuk',
			'list' => $list
		];

		$this->load->view('containerView', $this->parseData);
	}

	public function list_transaksi_barang_keluar(){
		$list = $this->jual->getAllJoined();

		$this->parseData = [
			'content' => 'content/staff/transaksi/list/barang_keluar',
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

	public function ajax_transaksi_barang_masuk_insert(){
		$this->form_validation->set_rules('id_buy_item', 'ID BUY', 'required');
		$this->form_validation->set_rules('buy_date', 'Tanggal Beli', 'required');
		$this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
		$this->form_validation->set_rules('invoice_number', 'No. Faktur', 'required');

		if ($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));		
		}else{
			$id_buy_item = $this->input->post('id_buy_item');
			$buy_date = $this->input->post('buy_date');
			$id_supplier = $this->input->post('id_supplier');
			$invoice_number = $this->input->post('invoice_number');

			$dataDetail = $this->temp->getByFK($id_buy_item);

			if ($dataDetail->num_rows() > 0) {
				foreach ($dataDetail->result() as $row) {
					$simpanDetail[] = [
						'id_buy_item' => $row->id_buy_item,
						'id_item' => $row->id_item,
						'qty' => $row->qty,
						'price' => $row->price,
						'subtotal' => $row->qty * $row->price
					];
				}

				$grandTot = 0;
				foreach ($simpanDetail as $s) {
					$grandTot += $s['subtotal'];
				}

				$simpanHeader = [
					'id_buy_item' => $id_buy_item,
					'invoice_number' => $invoice_number,
					'buy_date' => $buy_date,
					'id_supplier' => $id_supplier,
					'total' => $grandTot,
					'id_user' => $this->session->userdata('id_user')
				];

				if ($this->beli->save($simpanHeader)) {
					if ($this->beli->saveDetail($simpanDetail)) {
						foreach ($simpanDetail as $u) {
							$barang = $this->barang->getById($u['id_item']);
							if($barang->num_rows() > 0){
								$updateStock = [
									'stock' => $u['qty'] + $barang->row()->stock
								];

								$this->barang->update($updateStock, ['id_item'=>$barang->row()->id_item]);
							}
						}

						$this->temp->removeAll();
						echo json_encode($this->message('Berhasil!', 'Transaksi pembelian telah tersimpan', 'success', 1));
					}else{
						$this->beli->delete(['id_buy_item'=>$id_buy_item]);
						echo json_encode($this->message('Gagal!', 'Error saat simpan detail, data akan di roleback!', 'error', 0));
					}
				}else{
					echo json_encode($this->message('Gagal!', 'Error saat simpan header, data akan di roleback!', 'error', 0));
				}
			}
		}
	}

	public function ajax_transaksi_barang_keluar_insert(){
		$this->form_validation->set_rules('id_sell_item', 'ID SELL', 'required');
		$this->form_validation->set_rules('sell_date', 'Tanggal Jual', 'required');
		$this->form_validation->set_rules('sell_date', 'Tanggal Jual', 'required');
		$this->form_validation->set_rules('customer_payment', 'Bayar', 'required');

		if ($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));		
		}else{
			$id_sell_item = $this->input->post('id_sell_item');
			$sell_date = $this->input->post('sell_date');
			$customer = $this->input->post('customer');
			$customer_payment = $this->input->post('customer_payment');

			$dataDetail = $this->temp->getByFK($id_sell_item);

			if ($dataDetail->num_rows() > 0) {
				foreach ($dataDetail->result() as $row) {
					$simpanDetail[] = [
						'id_sell_item' => $row->id_buy_item,
						'id_item' => $row->id_item,
						'qty' => $row->qty,
						'price' => $row->price,
						'subtotal' => $row->qty * $row->price
					];
				}

				$grandTot = 0;
				foreach ($simpanDetail as $s) {
					$grandTot += $s['subtotal'];
				}

				$simpanHeader = [
					'id_sell_item' => $id_sell_item,
					'customer' => $customer,
					'sell_date' => date('Y-m-d'),
					'customer_payment' => $customer_payment,
					'customer_change' => $customer_payment - $grandTot,
					'total' => $grandTot,
					'id_user' => $this->session->userdata('id_user')
				];

				if ($this->jual->save($simpanHeader)) {
					if ($this->jual->saveDetail($simpanDetail)) {
						foreach ($simpanDetail as $u) {
							$barang = $this->barang->getById($u['id_item']);
							if($barang->num_rows() > 0){
								$updateStock = [
									'stock' => $barang->row()->stock - $u['qty']
								];

								$this->barang->update($updateStock, ['id_item'=>$barang->row()->id_item]);
							}
						}

						$this->temp->removeAll();
						echo json_encode($this->message('Berhasil!', 'Transaksi pembelian telah tersimpan', 'success', 1));
					}else{
						$this->jual->delete(['id_sell_item'=>$id_sell_item]);
						echo json_encode($this->message('Gagal!', 'Error saat simpan detail, data akan di roleback!', 'error', 0));
					}
				}else{
					echo json_encode($this->message('Gagal!', 'Error saat simpan header, data akan di roleback!', 'error', 0));
				}
			}else{
				echo json_encode($this->message('Gagal!', 'Data yang akan anda simpan tidak ada!', 'error', 0));
			}
		}
	}

	public function ajax_transaksi_insert_temporary(){
		$this->form_validation->set_rules('id_item', 'Item ID', 'required');
		$this->form_validation->set_rules('qty', 'QTY', 'required');
		$this->form_validation->set_rules('mode', 'mode', 'required');

		if($this->form_validation->run() == false){
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$id_item = $this->input->post('id_item');
			$qty = $this->input->post('qty');
			$id_buy_item_last = $this->input->post('mode') == 'masuk' ? $this->getLastIdBuyItem() : $this->getLastIdSellItem();
			$barang = $this->barang->getById($id_item);

			if($barang->num_rows() > 0){
				$dataTemp = [
					'id_buy_item' => $id_buy_item_last,
					'id_item' => $id_item,
					'qty' => $qty,
					'price' => $barang->row()->buy_price
				];

				$isTempExist = $this->temp->getByIdItem($barang->row()->id_item);

				if($isTempExist->num_rows() > 0){
					$qtyUpdate = $qty + $isTempExist->row()->qty;

					$dataUpdate = [
						'id_buy_item' => $id_buy_item_last,
						'qty' => $qtyUpdate,
						'price' => $barang->row()->buy_price
					];

					$whereTemp = ['id_item'=>$barang->row()->id_item];

					if($this->temp->update($dataUpdate, $whereTemp)){
						echo json_encode($this->message('Sukses!', 'Data berhasil terupdate ke temporary!', 'success', 1));
					}else{
						echo json_encode($this->message('Gagal!', 'Data tidak tersimpan ke temporary!', 'error', 0));
					}

				}else{

					if($this->temp->save($dataTemp)){
						echo json_encode($this->message('Sukses!', 'Data berhasil tersimpan ke temporary!', 'success', 1));
					}else{
						echo json_encode($this->message('Gagal!', 'Data tidak tersimpan ke temporary!', 'error', 0));
					}

				}
			}else{
				echo json_encode($this->message('Gagal!', 'Data yang coba Anda masukan tidak ditemukan!', 'error', 0));
			}
		}
	}

	public function ajax_transaksi_get_temporary(){
		$this->form_validation->set_rules('kode', 'Item ID', 'required');

		if ($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$kode = $this->input->post('kode');
			$data = $this->temp->getByFK($kode);

			if ($data->num_rows() > 0) {
				foreach ($data->result() as $row) {
					$barang = $this->barang->getById($row->id_item);

					if($barang->num_rows() > 0){
						$datas[] = [
							'kode_barang' => $barang->row()->id_item,
							'nama_barang' => $barang->row()->item_name,
							'qty' => $row->qty,
							'harga_satuan' => $barang->row()->buy_price,
							'subtotal' => $row->qty * $barang->row()->buy_price,
							'button' => '<button data-id-temp="'.$row->id_buy_sell_item_temporary.'" class="btn btn-xs btn-danger bDeleteTemp"><i class="fas fa-close"> hapus</i></button>'
						];
					}
				}

				echo json_encode($datas);
			}else{
				echo json_encode($this->message('Gagal!', 'Tidak ada history temporary!', 'error', 0));
			}
		}
	}

	public function ajax_transaksi_delete_temporary(){
		$this->form_validation->set_rules('id_temp', 'Temp ID', 'required');

		if ($this->form_validation->run() == false) {
			$errorMessage = '';
			foreach($this->form_validation->error_array() as $error){
				$errorMessage .= ' ' . $error;
			}
			echo json_encode($this->message('Gagal!', $errorMessage, 'error', 0));
		}else{
			$id_temp = $this->input->post('id_temp');

			$where = ['id_buy_sell_item_temporary'=>$id_temp];

			if (!$this->temp->delete($where)) {
				echo json_encode($this->message('Gagal!', 'gagal hapus!', 'error', 0));
			}else{
				echo json_encode($this->message('Sukses!', 'Data berhasil tersimpan ke temporary!', 'success', 1));
			}
		}
	}

	// Akhir method transaksi
}



















