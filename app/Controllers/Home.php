<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function __construct()
	{
		$this->session = session();
	}

	public function index()
	{
		// if ($this->session->masuk == FALSE) {
		// 	$arr = [
		// 		'username'  => 'Guest',
		// 		// 'user_id' => '0',
		// 		'masuk' => FALSE
		// 	];

		// 	$this->session->set($arr);
		// }
		
		$data = [
			'title'		=> 'Home Aplikasi Clustering Data Penjualan Tlogomart',
			'heading' 	=> 'Selamat Datang di Aplikasi Clustering Data Penjualan Tlogomart.',
		];
		return view('home2', $data);
	}
}
