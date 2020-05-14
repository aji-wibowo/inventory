<?php

/**
 * 
 */
class MY_Controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_Users', 'user');
		$this->load->model('M_Satuan', 'satuan');
		$this->load->model('M_Barang', 'barang');
		$this->load->model('M_Supplier', 'supplier');
		$this->load->model('M_Temp', 'temp');
		$this->load->model('M_Beli', 'beli');
		$this->load->model('M_Jual', 'jual');
	}

	public $parseData = [
		'content' => 'dashboard',
		'title' => 'Dashboard'
	];

	public function grafikDashboard(){
		$jual = $this->jual->getReport()->result_array();
		$beli = $this->beli->getReport()->result_array();

		$summaryJual = $this->jual->getSummary()->row_array();
		$summaryBeli = $this->beli->getSummary()->row_array();

		if(count($jual) > 0){

			foreach ($jual as $j) {
				$data[$j['id_item']][] = [
					'barang' => $j['item_name'],
					'keluar' => $j['qty']
				];
			}

			foreach ($beli as $b) {
				$data[$b['id_item']][] = [
					'barang' => $b['item_name'],
					'masuk' => $b['qty']
				];
			}

			foreach ($data as $row) {
				$ready[] = array_merge($row[0], $row[1]);
			}

		} else {
			$ready = [];
			$summaryJual = ['qty'=>0, 'jual'=>0];
			$summaryBeli = ['qty'=>0, 'beli'=>0];
		}

		return $collation = ['ready' => $ready, 'summaryJual' => $summaryJual, 'summaryBeli' => $summaryBeli];
	}

	public function message($title, $text, $icon, $status = null){
		$message = [
			'status' => $status,
			'title' => $title,
			'text' => $text,
			'icon' => $icon,
		];

		return $message;
	}

	public function set_message_flash($title, $text, $icon, $status = null){
		$this->session->set_flashdata('status',$status);
		$this->session->set_flashdata('title',$title);
		$this->session->set_flashdata('text',$text);
		$this->session->set_flashdata('icon',$icon);
	}

	public function getLastIdBuyItem(){
		$data = $this->beli->getLastID();

		if($data->row()->id_buy_item != ''){
			$urutan = substr($data->row()->id_buy_item, -3);
			$urutan = $urutan + 1;
			$kode = sprintf("%03d", $urutan);
			$kode = 'BL'.date('my').$kode;
		}else{
			$kode = 'BL'.date('my').'001';
		}

		return $kode;
	}

	public function getLastIdSellItem(){
		$data = $this->jual->getLastID();

		if($data->row()->id_sell_item != ''){
			$urutan = substr($data->row()->id_sell_item, -3);
			$urutan = $urutan + 1;
			$kode = sprintf("%03d", $urutan);
			$kode = 'JL'.date('my').$kode;
		}else{
			$kode = 'JL'.date('my').'001';
		}

		return $kode;
	}
}