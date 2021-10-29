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

		// $session = session();
		// $this->sessdata =  $session->get();
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

	public function rekap_tr($id = 0)		//show rekap of $data after inputting
	{
		// $penjualan_id = $this->session->userdata['data']['penjualan_id'];
		// var_dump($session->message);
		$uri = service('uri');

		if ($uri->getSegment(2) == 'rekap_tr') {
			$penjualan_ids  = $uri->getSegment(3);
		};

		$session = session();
		$sessdata =  $session->get();
		// print_r($sessdata['penjualan_id']);

		if ($id = 0) {
			$getbyID = $this->rinc_penjualan_model->selectbyid($sessdata['penjualan_id']);
			$penjualan_id = $sessdata['penjualan_id'];
		} else {
			$penjualan_id = $penjualan_ids;

			$getbyID = $this->rinc_penjualan_model->selectbyid($penjualan_id);
		};

		// echo $penjualan_id;
		// exit;

		// d($getbyID);

		$data = [
			'title'		=> 'Rekapitulasi Data Hasil Klasterisasi ',
			'heading' 	=> 'Rekapitulasi Data Hasil Klasterisasi',
			'tab_ori' => $getbyID,
			'penjualan_id' => $penjualan_id,
		];

		return view('rekap/rekap_detail', $data);
	}

	public function rekap_detail($id)		//detail rekap dari dashboard
	{
		# code...
	}

	public function delete_rekap($id)		//hapus data rekap
	{
		$this->rinc_penjualan_model->cust_delete($id);
		// echo "<script>alert('Data berhasil dihapus');
		// window.location = '".base_url() . '/rekap_data'
		
		// </script>;
        echo "<script>alert('Data berhasil dihapus');window.location = '".base_url() . '/rekap_data'."';</script>";

	}
}
