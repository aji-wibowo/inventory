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
}