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

		// // // ========	=	=	=	==	=	=	=	=		=	==	 start loop UNTUK DAPET SIL_CO >80%
		do {

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
			$froptosos = array();
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
			// array_values($cl1);
			$cl2 = $this->data_model->clust_array($clustarray, 2);
			// array_values($cl2);
			$cl3 = $this->data_model->clust_array($clustarray, 3);
			// array_values($cl3);

			// // // ========	=	=	=	==	=	=	=	=		=	==	validasi SSE
			$optable = $this->data_model->sse_first($optable);				// 1
			$cl1 = $this->data_model->sse_scnd($cl1, $cl2, $cl3);			// 2
			$cl2 = $this->data_model->sse_scnd($cl2, $cl1, $cl3);
			$cl3 = $this->data_model->sse_scnd($cl3, $cl1, $cl2);
			$sosa = array_merge($cl1, $cl2, $cl3);

			// // ========	=	=	=	==	=	=	=	=		=	==mindah ke Sosa dan sort untuk memudahkan proses akhir SSE
			for ($i = 0; $i < count($optable); $i++) {
				$froptosos[$i] = [
					'kode2' 	=> $optable[$i]['kode2'],
					'cluster' 	=> $optable[$i]['cluster'],
					'a_i' 		=> $optable[$i]['a_i'],
				];
			}

			usort(
				$froptosos,
				function (array $a, array $b) {
					if ($a['cluster'] < $b['cluster']) {
						return -1;
					} else if ($a['cluster'] > $b['cluster']) {
						return 1;
					} else {
						return 0;
					};
				}
			);

			for ($i = 0; $i < count($sosa); $i++) {
				$sosa[$i]['kode2g'] 	= $froptosos[$i]['kode2'];
				$sosa[$i]['clusterg']	= $froptosos[$i]['cluster'];
				$sosa[$i]['a_i'] 		= $froptosos[$i]['a_i'];
			}

			// // ========	=	=	=	==	=	=	=	=		=	==proses akhir SSE
			$final_si = $this->data_model->s_i($sosa);

			// $final_si = number_format(($this->data_model->final_si($final_si)), 3, ',', '.');
			$final_si = $this->data_model->final_si($final_si);

			echo "<hr>";
			echo ("Silhouette coefficient akhir = " . $final_si);

			// dd($final_si);

		} while ($final_si < 0.700);
		// // // ========	=	=	=	==	=	=	=	=		=	==	 EndLOOP, BALIK KE LOOP TERATAS UNTUK DAPET SIL_CO >80%


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

// for the record, array di sini ada 4 grup wkwkkw
// tampilloop
// optable
// clustarray
// cl1 cl2 cl3