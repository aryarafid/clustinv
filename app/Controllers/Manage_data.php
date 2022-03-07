<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\data_model;
use App\Models\penjualan_model;
use App\Models\rinc_penjualan_model;

use App\Controllers\Rekap_data;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Strings\EchoedStringsSniff;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Manage_data extends BaseController
{
	protected $data_model;

	public function __construct()
	{
		$this->data_model = new data_model();
		$this->penjualan_model = new penjualan_model();
		$this->rinc_penjualan_model = new rinc_penjualan_model();
		helper('url');
		$this->Rekap_data = new Rekap_data();
		$this->session = session();
		// $this->load->library('session');
	}

	public function index()
	{
		$data = [
			'title'		=> 'Insert Data ClustInv',
			'heading'	=> 'Halaman untuk Memproses Data Penjualan',
		];
		return view('manage_data/input_data', $data);
	}

	public function olah_dokumen()			//upload dan olah xlsx pake phpspreadsheet, parameter-> (tanggal input , dokumen xlsx)
	{
		$rules = [
			'file_excel' => [
				'rules' => 'uploaded[file_excel]|max_size[file_excel,5000]|ext_in[file_excel,xlsx,xls]'
			],
		];

		if ($this->validate($rules)) {
			$file = $this->request->getFile('file_excel');

			$reader = IOFactory::createReader('Xlsx');
			$spreadsheet = $reader->load($file);
			$writer = IOFactory::createWriter($spreadsheet, 'Html');

			// get nama
			$nama_id = $this->request->getPost('nama_id');

			// set active index to 1st sheet
			$date1 = $spreadsheet->setActiveSheetIndex(0);
			$date2 = $spreadsheet->setActiveSheetIndex(0);

			// get date
			$date1 = $spreadsheet->getActiveSheet()->getCell('B2')->getFormattedValue();
			$date1 = strtotime($date1);
			$date1 = date('Y-m-d', $date1);
			$date2 = $spreadsheet->getActiveSheet()->getCell('D2')->getFormattedValue();
			$date2 = strtotime($date2);
			$date2 = date('Y-m-d', $date2);
			
			$highestColumn = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
			$highestRow = ($spreadsheet->setActiveSheetIndex(0)->getHighestRow()) - 1;

			$coord = $highestColumn . "{$highestRow}";
			
			$worksheet = $spreadsheet->getActiveSheet()->rangeToArray(
				"B4:{$coord}",     // The worksheet range that we want to retrieve
				// "B35:J71",
				NULL,        // Value that should be returned for empty cells
				NULL,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
				NULL,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
				NULL         // Should the array be indexed by cell row and cell column
			);
			$worksheet = array_values($worksheet);
			$kolom_array = [
				"kode", "nama_produk", "kms", "terjual", "hrg_jual", "netto", "laba_kotor", "struk", "frek", "barcode"
			];

			for ($i = 0; $i < count($worksheet); $i++) {
				// 	// $kolom_array = implode(" ",$kolom_array);
				for ($j = 0; $j < count($kolom_array); $j++) {
					$worksheet[$i]["{$kolom_array[$j]}"] = $worksheet[$i]["{$j}"];

					unset($worksheet[$i]["{$j}"]);
					unset($worksheet[$i]["kms"]);
					unset($worksheet[$i]["barcode"]);
					unset($worksheet[$i]["struk"]);
					unset($worksheet[$i]["laba_kotor"]);
					unset($worksheet[$i]["hrg_jual"]);
					unset($worksheet[$i]["netto"]);
				}
			}

			// // Mengganti titik di kolom frek dan membagi dg 100  
			for ($i = 0; $i < count($worksheet); $i++) {
				$worksheet[$i]["frek"] = str_replace(".", "", $worksheet[$i]["frek"]);
				$worksheet[$i]["frek"] = $worksheet[$i]["frek"] / 100;
			}
			
			$ids = array_search('PLASTIK TLOGO MART', array_column($worksheet, 'nama_produk'));
			unset($worksheet[$ids]);

			$worksheet = array_values($worksheet);
			$data = [
				'nama_id' => $nama_id,
				'date1' => $date1,
				'date2' => $date2,
				'worksheet' => $worksheet
			];
		} else {
			$data['validation'] = $this->validator;
		}

		$this->clustering($data);
	}

	public function clustering($data)
	{
		$loopke = 0;

		// // retrieve tabel as array
		// $data['worksheet'] = $this->data_model->findAll();

		// // get maxmin tabel
		$mjual = array_column($data['worksheet'], 'terjual');
		$mfrek = array_column($data['worksheet'], 'frek');

		$maxminfj = array(
			'maxjual' => max($mjual),
			'maxfrek' => max($mfrek),
			'minjual' => min($mjual),
			'minfrek' => min($mfrek),
		);

		// // normalisasi
		$data['worksheet'] = $this->data_model->normalisasi($data['worksheet'], $maxminfj);

		// // array kedua khusus utk operasi
		$optable = array();
		for ($i = 0; $i < count($data['worksheet']); $i++) {
			$optable[$i]['kode']	 = $data['worksheet'][$i]['kode'];
			$optable[$i]['nama_produk']	 = $data['worksheet'][$i]['nama_produk'];
			$optable[$i]['terjual'] = $data['worksheet'][$i]['terjual'];
			$optable[$i]['frek']	 = $data['worksheet'][$i]['frek'];
			$optable[$i]['normfrek'] = $data['worksheet'][$i]['normfrek'];
			$optable[$i]['normjual'] = $data['worksheet'][$i]['normjual'];

			unset($data['worksheet'][$i]['normfrek']);
			unset($data['worksheet'][$i]['normjual']);
		}

		// 	// // get medoid (ditaruh sini agar bisa randomized), hitung jarak, clusterisasi
		$tampilloop = array();		//mother array utk proses kmedoids 
		$transtab = array();
		$jumsimp = 0;				//jumlah simpangan 
		$lpcnt = 0;					//loop count
		$selsimp = 0; 				//selisih simpangan

		$meds = [			
			[
				$optable[127],
				$optable[2097],
				$optable[2448],
			],
			[
				$optable[1391],
				$optable[2523],
				$optable[1647],
			]
		];

		// for ($i = 0; $i < 100; $i++) {
		for ($i = 0; $i < 2; $i++) {

			$tampilloop[$i] = [
				// 'meds1' 	=> $meds1   = $this->data_model->getMedoidNorm($optable),
				'meds' 	=> $meds[$i],
 
				'optable' 	=> $optable = $this->data_model->countdis1($optable, $meds[$i]),
				'optable' 	=> $optable = $this->data_model->getSimpangan($optable),
				'optable' 	=> $optable = $this->data_model->clustering($optable),
				'jumsimp' 	=> $jumsimp = $this->data_model->sumSimpangan($optable),
			];
		}

		// 	// 	// // ========	=	=	=	==			=	==selama hasil minus berkurang, berarti kondisinya while selisih < 0
		do {
			// $selsimp = $tampilloop[$lpcnt + 1]['jumsimp'] - $tampilloop[$lpcnt]['jumsimp'];
			$selsimp = $tampilloop[1]['jumsimp'] - $tampilloop[0]['jumsimp'];

			$lpcnt++;
		} while ($selsimp < 0);


		// 	// 	// // // // // //	=	=	=	==			= DBI PROCESS STARTS HERE
		// 	// 	// // ========	=	=	=	==memasukkan cluster2 ke array masing2 untuk memudahkan DBI
		for ($i = 0; $i < count($optable); $i++) {
			$clustarray[$i] = [
				'cluster' 	=> $optable[$i]['cluster'],
				'kode' 		=> $optable[$i]['kode'],
				'terjual'	=> $optable[$i]['terjual'],
				'frek' 		=> $optable[$i]['frek'],
			];
		}

		asort($clustarray);
		$cl1 = $this->data_model->clust_array($clustarray, 1);		//separate per clusters
		$cl2 = $this->data_model->clust_array($clustarray, 2);
		$cl3 = $this->data_model->clust_array($clustarray, 3);

		$centc1 = $this->data_model->centroid($cl1);		//get centroid per cluster
		$centc2 = $this->data_model->centroid($cl2);
		$centc3 = $this->data_model->centroid($cl3);

		$ssw1 = $this->data_model->sswi($cl1, $centc1);		//jarak cluster ke centroid
		$ssw2 = $this->data_model->sswi($cl2, $centc2);
		$ssw3 = $this->data_model->sswi($cl3, $centc3);

		$ssb12 = $this->data_model->ssbij($centc1, $centc2);	//jarak antar centroid
		$ssb13 = $this->data_model->ssbij($centc1, $centc3);
		$ssb23 = $this->data_model->ssbij($centc2, $centc3);

		$r12 = $this->data_model->rij($ssw1, $ssw2, $ssb12);
		$r13 = $this->data_model->rij($ssw1, $ssw3, $ssb13);
		$r23 = $this->data_model->rij($ssw2, $ssw3, $ssb23);

		$dbi = max($r12, $r13, $r23) / 3;

		$selsimp = round($selsimp, 6);
		$dbi = round($dbi, 6);

		$tabfin = array_merge($cl1, $cl2, $cl3);						//ARRAY YG DIPISAH DIJADIIN 1
		// // // // ========	=	=	=	==	=	=	=	=		=	==	 END DBI VAL

		// 	// // ========	=	=	=	== finishing, unsetting arrays, putting the clusters from transtab to $data['worksheet']
		$fintr = array();								//final transition table

		for ($i = 0; $i < count($tabfin); $i++) {
			$fintr[$i]['kode'] 		= $tabfin[$i]['kode'];
			$fintr[$i]['cluster'] 	= $tabfin[$i]['cluster'];
		}

		usort(											//sort by kode
			$fintr,
			function (array $a, array $b) {
				if ($a['kode'] < $b['kode']) {
					return -1;
				} else if ($a['kode'] > $b['kode']) {
					return 1;
				} else {
					return 0;
				};
			}
		);

		for ($i = 0; $i < count($data['worksheet']); $i++) {					//kolom cluster dimasukin ke array data
			$data['worksheet'][$i]['cluster'] 	= $fintr[$i]['cluster'];
		}

		unset($transtab);
		unset($cl1);
		unset($cl2);
		unset($cl3);
		unset($optable);
		unset($tabfin);
		unset($fintr);

		// // // // ========	=	=	=	==	=	=	=	=		=	==	 Saving data to db and redirecting to rekap. 
		$session = session();
		$tgl_pencairan = date("Y-m-d H:i:s");				//datetimestamp input

		$dataPenjualan = [									//insert tabel penjualan
			// 
			"timestamp_enterdata" => $tgl_pencairan,
			"nama_id"	=> $data['nama_id'],
			"start_date" 	=> $data['date1'],
			"end_date" 		=> $data['date2'],
			"dbi" 			=> $dbi,
			"selisih_simpangan" => $selsimp
		];
		
		$this->penjualan_model->save($dataPenjualan);

		$penjualan_id = $this->penjualan_model->insertID();		//get id penjualan dari tabel penjualan

		$builderRP = $this->db->table('rinc_penjualan');		//utk insert batch

		for ($i = 0; $i < count($data['worksheet']); $i++) {			//insert tabel penjualan
			# code...
			// dd($data['worksheet'][$i]);	
			$dataRincPenjualan[] = [
				// 
				'penjualan_id'	=> $penjualan_id,
				'kode' 			=> $data['worksheet'][$i]['kode'],
				'nama_produk' 	=> $data['worksheet'][$i]['nama_produk'],
				'terjual' 		=> $data['worksheet'][$i]['terjual'],
				'frek' 			=> $data['worksheet'][$i]['frek'],
				'cluster'		=> $data['worksheet'][$i]['cluster'],
			];
		};
		$builderRP->insertBatch($dataRincPenjualan);

		$fdata = [										//pass data to rekap_data/rekap transition
			'penjualan_id'	=> $penjualan_id,
		];
		$session->setFlashdata($fdata);

		return $this->response->redirect(site_url('Rekap_data'), 'refresh');

		// exit;
	}

	public function process_kerangka()  //skeleton processing
	{
		// 1st phase
		$rules = [
			'file_excel' => [
				'rules' => 'uploaded[file_excel]|max_size[file_excel,5000]|ext_in[file_excel,xlsx,xls]'
			],
		];

		// validasi rule
		if ($this->validate($rules)) {
			$file = $this->request->getFile('file_excel');

			// $nama_id = $this->request->getPost('nama_id');

			// load file
			$reader = IOFactory::createReader('Xlsx');
			$spreadsheet = $reader->load($file);

			// get date from file
			$date1 = $spreadsheet->getActiveSheet()->getCell('B2')->getFormattedValue();
			$date1 = strtotime($date1);
			$date1 = date('Y-m-d', $date1);
			$date2 = $spreadsheet->getActiveSheet()->getCell('D2')->getFormattedValue();
			$date2 = strtotime($date2);
			$date2 = date('Y-m-d', $date2);

			$highestColumn = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
			$highestRow = ($spreadsheet->setActiveSheetIndex(0)->getHighestRow()) - 1;

			$coord = $highestColumn . "{$highestRow}";

			$worksheet = $spreadsheet->getActiveSheet()->rangeToArray(
				"B4:{$coord}",     // The worksheet range that we want to retrieve
				// "B35:J71",
				NULL,        // Value that should be returned for empty cells
				NULL,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
				NULL,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
				NULL         // Should the array be indexed by cell row and cell column
			);
			$worksheet = array_values($worksheet);
			$kolom_array = [
				"kode", "nama_produk", "kms", "terjual", "hrg_jual", "netto", "laba_kotor", "struk", "frek", "barcode"
			];

			d($worksheet);

			for ($i = 0; $i < count($worksheet); $i++) {
				// 	// $kolom_array = implode(" ",$kolom_array);
				for ($j = 0; $j < count($kolom_array); $j++) {
					$worksheet[$i]["{$kolom_array[$j]}"] = $worksheet[$i]["{$j}"];
					unset($worksheet[$i]["{$j}"]);
					unset($worksheet[$i]["kms"]);
					unset($worksheet[$i]["barcode"]);
					unset($worksheet[$i]["struk"]);
					unset($worksheet[$i]["laba_kotor"]);
					unset($worksheet[$i]["hrg_jual"]);
					unset($worksheet[$i]["netto"]);
				}
			}

			// // Mengganti titik di kolom frek dan membagi dg 100  
			for ($i = 0; $i < count($worksheet); $i++) {
				$worksheet[$i]["frek"] = str_replace(".", "", $worksheet[$i]["frek"]);
				$worksheet[$i]["frek"] = $worksheet[$i]["frek"] / 100;
			}

			
			// dd($worksheet);

			$ids = array_search('PLASTIK TLOGO MART', array_column($worksheet, 'nama_produk'));
			// echo $id;
			unset($worksheet[$ids]);

			$worksheet = array_values($worksheet);

			$data = [
				// 'nama_id' => $nama_id,
				'date1' => $date1,
				'date2' => $date2,
				'worksheet' => $worksheet
			];
		} else {
			$data['validation'] = $this->validator;
		}

		////////////////////////////////////////////////////////////2nd phase

		$loopke = 0;

		// // retrieve tabel as array
		// $data['worksheet'] = $this->data_model->findAll();

		// // get maxmin tabel
		$mjual = array_column($data['worksheet'], 'terjual');
		$mfrek = array_column($data['worksheet'], 'frek');

		$maxminfj = array(
			'maxjual' => max($mjual),
			'maxfrek' => max($mfrek),
			'minjual' => min($mjual),
			'minfrek' => min($mfrek),
		);

		// // normalisasi
		$data['worksheet'] = $this->data_model->normalisasi($data['worksheet'], $maxminfj);

		// // array kedua khusus utk operasi
		$optable = array();
		for ($i = 0; $i < count($data['worksheet']); $i++) {
			$optable[$i]['kode']	 	 = $data['worksheet'][$i]['kode'];
			$optable[$i]['nama_produk']	 = $data['worksheet'][$i]['nama_produk'];
			$optable[$i]['terjual'] 	 = $data['worksheet'][$i]['terjual'];
			$optable[$i]['frek']	 	 = $data['worksheet'][$i]['frek'];
			$optable[$i]['normfrek'] 	 = $data['worksheet'][$i]['normfrek'];
			$optable[$i]['normjual'] 	 = $data['worksheet'][$i]['normjual'];

			unset($data['worksheet'][$i]['normfrek']);
			unset($data['worksheet'][$i]['normjual']);
		}

		// dd($optable);

		// 	// // get medoid (ditaruh sini agar bisa randomized), hitung jarak, clusterisasi
		$tampilloop = array();		//mother array utk proses kmedoids 
		$transtab = array();
		$jumsimp = 0;				//jumlah simpangan 
		$lpcnt = 0;					//loop count
		$selsimp = 0; 				//selisih simpangan

		// $meds0 = array(
		// 	$optable[127],
		// 	$optable[2097],
		// 	$optable[2448],
		// );

		// $meds1 = array(
		// 	$optable[1391],
		// 	$optable[2523],
		// 	$optable[1647],
		// );

		$meds = [
			
			[
				$optable[127],
				$optable[2097],
				$optable[2448],
			],
			[
				$optable[1391],
				$optable[2523],
				$optable[1647],
			]
		];

		// dd($meds);
		
		// d($optable);
		d($meds);


		// PAKENYA MULTI ARRAY AJA
		// MEDS 1[] 2[]

		// for ($i = 0; $i < 100; $i++) {
		for ($i = 0; $i < 2; $i++) {
			$tampilloop[$i] = [
				// 'meds1' 	=> $meds[$i]   = $this->data_model->getMedoidNorm($optable),
				'meds' 	=> $meds[$i],

				// 'meds1' 	=> $meds1   = array(
				// 	$optable[197],
				// 	$optable[171],
				// 	$optable[1376],
				// ),
				'dis' 	=> $optable = $this->data_model->countdis1($optable, $meds[$i]),
				'simp' 	=> $optable = $this->data_model->getSimpangan($optable),
				'cl' 	=> $optable = $this->data_model->clustering($optable),
				'jumsimp' 	=> $jumsimp = $this->data_model->sumSimpangan($optable),
			];
		}

		// echo "<pre>";
		echo "hasil hitungan iterasi 1";
		d($tampilloop[0]['cl']);

		echo "hasil hitungan iterasi 2";
		d($tampilloop[1]['cl']);



		// 	// 	// // ========	=	=	=	==			=	==selama hasil minus berkurang, berarti kondisinya while selisih < 0
		do {
			// $selsimp = $tampilloop[$lpcnt + 1]['jumsimp'] - $tampilloop[$lpcnt]['jumsimp'];
			$selsimp = $tampilloop[1]['jumsimp'] - $tampilloop[0]['jumsimp'];
			$lpcnt++;
		} while ($selsimp < 0);

		// echo $selsimp; exit;

		// 	// 	// // // // // //	=	=	=	==			= DBI PROCESS STARTS HERE
		// 	// 	// // ========	=	=	=	==memasukkan cluster2 ke array masing2 untuk memudahkan DBI
		for ($i = 0; $i < count($optable); $i++) {
			$clustarray[$i] = [
				'cluster' 	=> $optable[$i]['cluster'],
				'kode' 		=> $optable[$i]['kode'],
				'terjual'	=> $optable[$i]['terjual'],
				'frek' 		=> $optable[$i]['frek'],
			];
		}

		asort($clustarray);
		$cl1 = $this->data_model->clust_array($clustarray, 1);		//separate per clusters
		$cl2 = $this->data_model->clust_array($clustarray, 2);
		$cl3 = $this->data_model->clust_array($clustarray, 3);

		echo "pemisahan per cluster";

		d($cl1);
		d($cl2);
		d($cl3);

		$centc1 = $this->data_model->centroid($cl1);		//get centroid per cluster
		$centc2 = $this->data_model->centroid($cl2);
		$centc3 = $this->data_model->centroid($cl3);
		
		echo "centroid";
		d($centc1);
		d($centc2);
		d($centc3);

		$ssw1 = $this->data_model->sswi($cl1, $centc1);		//jarak cluster ke centroid
		$ssw2 = $this->data_model->sswi($cl2, $centc2);
		$ssw3 = $this->data_model->sswi($cl3, $centc3);

		echo "perhitungan dbi";
		d($ssw1);
		d($ssw2);
		d($ssw3);

		$ssb12 = $this->data_model->ssbij($centc1, $centc2);	//jarak antar centroid
		$ssb13 = $this->data_model->ssbij($centc1, $centc3);
		$ssb23 = $this->data_model->ssbij($centc2, $centc3);

		echo "perhitungan ssb";
		d($ssb12);
		d($ssb13);
		d($ssb23);

		$r12 = $this->data_model->rij($ssw1, $ssw2, $ssb12);
		$r13 = $this->data_model->rij($ssw1, $ssw3, $ssb13);
		$r23 = $this->data_model->rij($ssw2, $ssw3, $ssb23);

		echo "perhitungan rij";
		d($r12);
		d($r13);
		d($r23);

		$dbi = max($r12, $r13, $r23) / 3;

		$selsimp = round($selsimp, 6);
		$dbi = round($dbi, 6);

		$tabfin = array_merge($cl1, $cl2, $cl3);						//ARRAY YG DIPISAH DIJADIIN 1
		// // // // ========	=	=	=	==	=	=	=	=		=	==	 END DBI VAL

		// 	// // ========	=	=	=	== finishing, unsetting arrays, putting the clusters from transtab to $data['worksheet']
		$fintr = array();								//final transition table

		for ($i = 0; $i < count($tabfin); $i++) {
			$fintr[$i]['kode'] 		= $tabfin[$i]['kode'];
			$fintr[$i]['cluster'] 	= $tabfin[$i]['cluster'];
		}

		usort(											//sort by kode
			$fintr,
			function (array $a, array $b) {
				if ($a['kode'] < $b['kode']) {
					return -1;
				} else if ($a['kode'] > $b['kode']) {
					return 1;
				} else {
					return 0;
				};
			}
		);

		for ($i = 0; $i < count($data['worksheet']); $i++) {					//kolom cluster dimasukin ke array data
			$data['worksheet'][$i]['cluster'] 	= $fintr[$i]['cluster'];
		}

		unset($transtab);
		unset($cl1);
		unset($cl2);
		unset($cl3);
		unset($optable);
		unset($tabfin);
		unset($fintr);


		echo "final product;\n";
		echo "loop count= " . $lpcnt;
		echo "\nMedoid= ";				//for testing purposes
		echo "<pre>";
		d($meds);
		echo ("<hr>");
		echo ("selisih simpangan= " . $selsimp);
		echo ("<hr>");
		echo ("DBI= " . $dbi);
		d($data['worksheet']);

		// exit;

		// $dbi = floatval(str_replace('.', ',', $dbi));
		// $selsimp = floatval(str_replace('.', ',', $selsimp));
	}

}
