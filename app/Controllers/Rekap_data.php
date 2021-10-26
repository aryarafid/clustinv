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

		// $this->load->library('session');
	}

	public function index()
	{
		// show table dashboard 
		// $data = [
		// 	'title'		=> 'Rekap Data ',
		// 	'heading' 	=> 'Dashboard Aplikasi Clustering Inventory Tlogomart',
		// ];
		// return view('home2', $data);
		echo "deex nuts goteeeem";
	}

	public function rekap_detail()		//show rekap of some $data, $id is included in $data
	{
		// $session = \Config\Services::session();
		$session = session();

		// var_dump($session->message);

		$data =  $session->get();
		return view('rekap/rekap_detail', $data);
	}
}
