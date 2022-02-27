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
			'title'		=> 'Dashboard Data Hasil Clustering',
			'heading' 	=> 'Dashboard Data Hasil Clustering',
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

		$getbyID = $this->rinc_penjualan_model->selectbyid($penjualan_ids);
		$getDateTStamp = $this->penjualan_model->getDateTStamp($penjualan_ids);

		$cl1 = $this->data_model->clust_array($getbyID, 1);
		$cl2 = $this->data_model->clust_array($getbyID, 2);
		$cl3 = $this->data_model->clust_array($getbyID, 3);

		$cl11 = $this->data_model->clust_array($getbyID, 1);
		$cl22 = $this->data_model->clust_array($getbyID, 2);
		$cl33 = $this->data_model->clust_array($getbyID, 3);

		// dd($cl1);
		// exit;

		$data = [
			'title'		=> 'Data Hasil Clustering',
			'heading' 	=> 'Data Hasil Clustering',
			'tab_ori' => $getbyID,
			'penjualan_id' => $penjualan_ids,
			'getDateTStamp' => $getDateTStamp,
			'cl1' => $cl1,
			'cl2' => $cl2,
			'cl3' => $cl3,
			'cl11' => $cl11,
			'cl22' => $cl22,
			'cl33' => $cl33,
		];

		// dd($data['tab_ori']);

		return view('rekap/rekap_detail', $data);
	}

	public function editnamaID($id)
	{
		$nama_id = $this->request->getPost('nama_id');
		$this->rinc_penjualan_model->changenamaID($id, $nama_id);
		echo "<script>alert('Data berhasil diedit');window.location = '" . base_url() . '/rekap_data' . "';</script>";
	}

	public function delete_rekap($id)		//hapus data rekap
	{
		$this->rinc_penjualan_model->cust_delete($id);
		echo "<script>alert('Data berhasil dihapus');window.location = '" . base_url() . '/rekap_data' . "';</script>";
	}
}
