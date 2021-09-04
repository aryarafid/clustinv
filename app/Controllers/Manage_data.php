<?php

namespace App\Controllers;

use App\Models\data_model;

class Manage_data extends BaseController
{
	protected $data_model;

	public function __construct()
	{
		$this->data_model = new data_model();
	}

	public function index()
	{
		$this->db = db_connect();

		// // retrieve tabel as array
		$tabel = $this->data_model->findAll();

		// // get maxmin tabel
		$mjual = array_column($tabel, 'terjual2');
		$mfrek = array_column($tabel, 'frek2');

		$maxminfj = array(
			'maxjual' => max($mjual),
			'maxfrek' => max($mfrek),
			'minjual' => min($mjual),
			'minfrek' => min($mfrek),
		);

		// // normalisasi
		$tabel = $this->data_model->normalisasi($tabel, $maxminfj);

		// // array kedua khusus utk operasi
		$optable = array();
		for ($i = 0; $i < count($tabel); $i++) {
			$optable[$i]['kode2']	 = $tabel[$i]['kode2'];
			$optable[$i]['nama2']	 = $tabel[$i]['nama2'];
			$optable[$i]['terjual2'] = $tabel[$i]['terjual2'];
			$optable[$i]['frek2']	 = $tabel[$i]['frek2'];
			$optable[$i]['normfrek'] = $tabel[$i]['normfrek'];
			$optable[$i]['normjual'] = $tabel[$i]['normjual'];
		}

		// // get medoid (ditaruh sini agar bisa randomized), hitung jarak, clusterisasi
		$tampilloop = array();
		$jumsimp = 0;	//jumlah simpangan 
		$lpcnt = 0;		//loop count
		$selsimp = 0; 	//selisih simpangan
		$i = 0;			//index loop utk generate 100 tabel

		for ($i = 0; $i < 100; $i++) {
			$tampilloop[$i] = [
				'meds1' 	=> $meds1   = $this->data_model->getMedoidNorm($tabel),
				'optable' 	=> $optable = $this->data_model->countdis1($optable, $meds1),
				'optable' 	=> $optable = $this->data_model->getSimpangan($optable),
				'optable' 	=> $optable = $this->data_model->clustering($optable),
				'jumsimp' 	=> $jumsimp = $this->data_model->sumSimpangan($optable),
			];
		}

		// // ========	=	=	=	==	=	=	=	=		=	==selama hasil minus berkurang, berarti kondisinya while selisih < 0
		do {
			$selsimp = $tampilloop[$lpcnt + 1]['jumsimp'] - $tampilloop[$lpcnt]['jumsimp'];
			echo "<hr>";
			echo $selsimp;
			echo " ==> loop ke-" . $lpcnt;
			$lpcnt++;
		} while ($selsimp < 0);

		// // ========	=	=	=	==	=	=	=	=		=	==memasukkan cluster2 ke array masing2 untuk memudahkan SSE
		// $clustarray = array();

		for ($i = 0; $i < count($optable); $i++) {
			$clustarray[$i] = [
				'cluster' 	=> $optable[$i]['cluster'],
				'kode2' 	=> $optable[$i]['kode2'],
				'terjual2'	=> $optable[$i]['terjual2'],
				'frek2' 	=> $optable[$i]['frek2'],
			];
		}
		asort($clustarray);
		$cl1 = $this->data_model->clust_array($clustarray, 1);
		$cl2 = $this->data_model->clust_array($clustarray, 2);
		$cl3 = $this->data_model->clust_array($clustarray, 3);

		// 	// ========	=	=	=	==	=	=	=	=		=	==show array elements that are cluster #1, #2, #3 whatevs
		// foreach ($optable as $cl) {
		// 	if ($cl['cluster'] == 1) {
		// 		echo '<pre>';
		// 		var_dump($cl);
		// 	}
		// }

		// validasi SSE
		$optable = $this->data_model->sse_first($optable);

		// // // ========	=	=	=	==	=	=	=	=		=	==	 Strictly for Outputting Results

		dd($optable);

		// // // ========	=	=	=	==	=	=	=	=		=	==	 End

		// $data = [
		// 	'title'		=> 'Manage Data ClustInv',
		// 	'heading' 	=> 'Manage Data Aplikasi Clustering Inventory Tlogomart',
		// 	'data_model' => $tabel,
		// 	'med1' 		=> $tampilloop[$lpcnt]['meds1'],
		// 	'op_tabel'	=> $tampilloop[$lpcnt]['optable'],
		// 	'tampilloop'=> $tampilloop[$lpcnt],
		// 	'lpcnt' 	=> $lpcnt-1
		// ];
		// return view('manage_data/md_dash', $data);
	}
}
