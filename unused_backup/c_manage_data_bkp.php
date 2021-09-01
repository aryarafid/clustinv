<?php

// setor unused codes

namespace App\Controllers;

use App\Models\data_model;

// setor unused codes

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
			$optable[$i]['normfrek'] = $tabel[$i]['normfrek'];
			$optable[$i]['normjual'] = $tabel[$i]['normjual'];
		}

		// get medoid
		// $meds1 = array($tabel[27],$tabel[36],$tabel[20]);
		// $meds1 = $this->data_model->getMedoid();
		// $meds1 = $this->data_model->getMedoidNorm($tabel);
		// // $meds2 = $this->data_model->getMedoidNorm($tabel);
		// // $meds3 = $this->data_model->getMedoidNorm($tabel);

		// dd($meds1);	

		// // hitung jarak, clusterisasi

		$tampilloop = array();
		$jumsimp = 0;		//jumlah simpangan 
		$lpcnt = 0;		//loop count
		$selsimp = 0; 	//selisih simpangan
		$dumm = 0;

		// do {
		// do {
		// 	$tampilloop = [
		// 		$optable = $this->data_model->countdis1($optable, $meds1),
		// 		$optable = $this->data_model->getSimpangan($optable),
		// 		$optable = $this->data_model->clustering($optable),
		// 		$sumot = $this->data_model->sumSimpangan($optable),
		// 		//  
		// 	];
		// 	$dumm++;
		// } while ($dumm <= $lpcnt);
		// 	$lpcnt++;
		// } while ($lpcnt < 3);

		for ($lpcnt = 0; $lpcnt < 3; $lpcnt++) {
			$tampilloop[$lpcnt] = [
				$meds1   = $this->data_model->getMedoidNorm($tabel),
				$optable = $this->data_model->countdis1($optable, $meds1),
				$optable = $this->data_model->getSimpangan($optable),
				$optable = $this->data_model->clustering($optable),
				$jumsimp = $this->data_model->sumSimpangan($optable),
			];

			// $tampilloop2 = [
			// 	$optable = $this->data_model->countdis1($optable, $meds2),
			// 	$optable = $this->data_model->getSimpangan($optable),
			// 	$optable = $this->data_model->clustering($optable),
			// 	$jumsimp = $this->data_model->sumSimpangan($optable),
			// ];

			// $tampilloop3 = [
			// 	$optable = $this->data_model->countdis1($optable, $meds3),
			// 	$optable = $this->data_model->getSimpangan($optable),
			// 	$optable = $this->data_model->clustering($optable),
			// 	$jumsimp = $this->data_model->sumSimpangan($optable),
			// ];
		}

		// $tampilloop1 = $this->data_model->kMedoid($optable, $meds1);

		// do {
		// 	$tampilloop = [
		// 		$optable = $this->data_model->countdis1($optable, $meds1),
		// 		$optable = $this->data_model->getSimpangan($optable),
		// 		$optable = $this->data_model->clustering($optable),
		// 		$sumot = $this->data_model->sumSimpangan($optable),
		// 	]; 
		// 	$lpcnt++;
		// } while ($lpcnt < 5);

		// dd($tampilloop);
		echo "<pre>";
		// foreach ($tampilloop as $value) {
		// 	var_dump($value);
		// }

		foreach ($tampilloop as $v) {
			var_dump($v);
		}
		// var_dump($tampilloop2);
		// var_dump($tampilloop3);


		// $data = [
		// 	'title'		=> 'Manage Data ClustInv',
		// 	'heading' 	=> 'Manage Data Aplikasi Clustering Inventory Tlogomart',
		// 	'data_model' => $tabel,
		// 	'med1' 		=> $meds1,
		// 	'op_tabel'	=> $optable,
		// 	'tampilloop'=> $tampilloop,
		// 	'lpcnt' => $lpcnt
		// ];
		// return view('manage_data/md_dash', $data);
	}
}

// setor unused codes, DUMP

	// do {
		// 	$selijs = $tampilloop[$lpcnt]['jumsimp'] - $tampilloop[$lpcnt]['jumsimp'];

		// } while (s);

		// }

		// simpangan baru - lama, if > 0 then stop subtracting

		// for ($i=1; $i < count($tampilloop); $i++) { 
		// 	$tampilloop[$i][4];
		// }

		// var_dump($tampilloop[3]);
		// echo "<pre>";
		// var_dump($tampilloop);

		// foreach ($tampilloop as $tl => $v) {
		// 	# code...

		// 	echo "key: ".$tl,", v: ".$v;

		// echo floatval($tampilloop[0]['jumsimp']) . "<br>";
		// echo floatval($tampilloop[1]['jumsimp']) . "<br>";
		// echo floatval($tampilloop[2]['jumsimp']) . "<br>";
		// }

		// dd($tampilloop);
		// };

			// final dummy loop 
		// do {
		// 	$selsimp = $tampilloop[$i+1]['jumsimp'] - $tampilloop[$i]['jumsimp'];
		// 	echo "<hr>";
		// 	echo $selsimp;
		// 	$i++;
		// } while ($i < 10);

	//}

	
    //  UNUSED from Model //
    // public function kMedoid($tabel, $medoid) //proses kmedoids pada tabel
    // {
    //     $array = array();
    //     $array = [
    //         $tabel = $this->countdis1($tabel, $medoid),
    //         $tabel = $this->getSimpangan($tabel),
    //         $tabel = $this->clustering($tabel),
	// 		$jumsimp = $this->sumSimpangan($tabel)
    //     ];
    //     return $array;
    // }

	
    //UNUSED
    // public function excountdis($tabel, $medoids) //hitung jarak v1
    // {
    //     $db = \Config\Database::connect();

    //     // Medoid 1
    //     // for ($i=0; $i < count($medoids) ; $i++) { 
    //     for ($i = 0; $i < count($tabel); $i++) {
    //         // tabel - medoid
    //         $tabel[$i]['jmed1'] = +sqrt(
    //             ($tabel[$i]['terjual2'] - $medoids[0]['terjual2']) ** 2
    //                 +
    //                 ($tabel[$i]['frek2'] - $medoids[0]['frek2']) ** 2
    //         );
    //     }

    //     // medoid 2
    //     for ($i = 0; $i < count($tabel); $i++) {
    //         // tabel - medoid
    //         $tabel[$i]['jmed2'] = +sqrt(
    //             ($tabel[$i]['terjual2'] - $medoids[1]['terjual2']) ** 2
    //                 +
    //                 ($tabel[$i]['frek2'] - $medoids[1]['frek2']) ** 2
    //         );
    //     }

    //     // medoid 3
    //     for ($i = 0; $i < count($tabel); $i++) {
    //         // tabel - medoid
    //         $tabel[$i]['jmed3'] = +sqrt(
    //             ($tabel[$i]['terjual2'] - $medoids[2]['terjual2']) ** 2
    //                 +
    //                 ($tabel[$i]['frek2'] - $medoids[2]['frek2']) ** 2
    //         );
    //     }

    //     return $tabel;
    // }
