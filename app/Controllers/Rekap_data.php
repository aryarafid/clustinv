<?php

namespace App\Controllers;

use App\Models\data_model;
use App\Models\penjualan_model;
use App\Models\produk_model;
use App\Models\tanggal_model;

class Rekap_data extends BaseController
{
	public function __construct()
	{
		$this->data_model = new data_model();
		$this->penjualan_model = new penjualan_model();
		$this->produk_model = new produk_model();
		$this->tanggal_model = new tanggal_model();

		// $this->load->library('session');
	}

	public function index()
	{
		// show table dashboard 
		$data = [
			'title'		=> 'Rekap Data ',
			'heading' 	=> 'Dashboard Aplikasi Clustering Inventory Tlogomart',
		];
		return view('home2', $data);
	}

	public function insert_db(
		$data
	)
	{
		$tabel = $data['worksheet'];
		
		echo "<pre>";
		print_r($data);
		// dd($data);

		// $dataPenjualan = [

		// ];
		// $this->penjualan_model->insert($dataPenjualan);

		// $dataProduk = [

		// ];
		// $this->produk_model->insert($dataProduk);

		// $dataTanggal = [
			
		// ];
		// $this->tanggal_model->insert($dataTanggal);

	}


}
