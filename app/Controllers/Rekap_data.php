<?php

namespace App\Controllers;

use App\Models\data_model;
use App\Models\penjualan_model;
// use App\Models\produk_model;
use App\Models\rinc_penjualan_model;

class Rekap_data extends BaseController
{
	public function __construct()
	{
		$this->data_model = new data_model();
		$this->penjualan_model = new penjualan_model();
		// $this->produk_model = new produk_model();
		$this->rinc_penjualan_model = new rinc_penjualan_model();
		$this->db = \Config\Database::connect();
		$builderRP = $this->db->table('rinc_penjualan');

		$session = session();
		$this->sessdata =  $session->get();
		// $sessID = $this->sessdata->penjualan_id;

		// $this->load->library('session');
	}

	public function index()
	{
		// show table dashboard 
		$data_penjualan = $this->penjualan_model->findAll();

		$data = [
			'title'		=> 'Dashboard Rekapitulasi Data Hasil Klasterisasi ',
			'heading' 	=> 'Dashboard Rekapitulasi Data Hasil Klasterisasi',
			'data_penjualan' => $data_penjualan
		];
		return view('rekap/rekap_dash', $data);
		// echo "yeah";
	}

	public function rekap_tr()		//show rekap of $data after inputting
	{
		// $penjualan_id = $this->session->userdata['data']['penjualan_id'];
		// var_dump($session->message);

		return view('rekap/rekap_detail', $this->sessdata);
	}

	public function rekap_detail($id)		//detail rekap dari dashboard
	{
		# code...
	}

	public function delete_rekap($id)		//hapus data rekap
	{
		# code...
	}
	
}
