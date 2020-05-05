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

		// $this->temp->removeAll();
	}

	public $parseData = [
		'content' => 'dashboard',
		'title' => 'Dashboard'
	];

	public function message($title, $text, $icon, $status = null){
		$message = [
			'status' => $status,
			'title' => $title,
			'text' => $text,
			'icon' => $icon,
		];

		return $message;
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