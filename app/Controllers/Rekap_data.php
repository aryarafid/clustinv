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
		$this->db = \Config\Database::connect();
		$builder = $this->db->table('users');
		
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
	) {
		$tabel = $data['worksheet'];

		echo "<pre>";
		print_r($data);

		$dataTanggal = [
			"start_date" => $data['date1'],
			"end_date" 	=> $data['date2'],
		];
		$this->tanggal_model->save($dataTanggal);

		$tanggal_id = $this->db->insertID();

		
		$dataPenjualan = [
			// penjualan_id
			"tanggal_id"	=> $tanggal_id,
			"kode" 			=> $data['worksheet']['kode'],	//===========> harusnya sih keknya $data['worksheet'][???]['kode']
			"nama_produk" 	=> $data['worksheet']['nama_produk'],
			"terjual" 		=> $data['worksheet']['terjual'],
			"frek" 			=> $data['worksheet']['frek'],
		];
		$this->penjualan_model->save($dataPenjualan);

		// $dataProduk = [
		// 	"kode" 			=> $tabel['kode'],
		// 	"nama_produk" 	=> $tabel['nama_produk'],
		// ];
		// $this->produk_model->insert($dataProduk);

		echo "HA GOTEEEM";

	}
}
