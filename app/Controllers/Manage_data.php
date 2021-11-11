<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\data_model;
use App\Models\penjualan_model;
use App\Models\rinc_penjualan_model;

use App\Controllers\Rekap_data;

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
		return view('manage_data/md_dash', $data);
	}

	public function olah_dokumen()			//upload dan olah xlsx pake phpspreadsheet, parameter-> (tanggal input , dokumen xlsx)
	{
		$rules = [
			'file_excel' => [
				'rules' => 'uploaded[file_excel]|max_size[file_excel,5000]|ext_in[file_excel,xlsx]'
			],
		];

		// if (!$file->isValid()) {
		// 	throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
		// } else
		if ($this->validate($rules)) {
			$file = $this->request->getFile('file_excel');
			// echo 'deez nuts';
			// die;
			
			// $rett = array(
			$date1 = $this->request->getPost('datepicker1');
			$date2 = $this->request->getPost('datepicker2');
			// $filename = $file->getName();
			// $coord = $this->request->getPost('coord');
			// );

			$reader = IOFactory::createReader('Xlsx');
			$spreadsheet = $reader->load($file);
			$writer = IOFactory::createWriter($spreadsheet, 'Html');
			// $message = $writer->save('php://output');

			$highestColumn = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
			$highestRow = ($spreadsheet->setActiveSheetIndex(0)->getHighestRow()) - 1;

			$coord = $highestColumn . "{$highestRow}";
			// echo $coord;

			// echo 'getHighestColumn() =  [' . $highestColumm . ']<br/>';
			// echo 'getHighestRow() =  [' . $highestRow . ']<br/>';

			$worksheet = $spreadsheet->getActiveSheet()->rangeToArray(
				"B4:{$coord}",     // The worksheet range that we want to retrieve
				// "B35:J71",
				NULL,        // Value that should be returned for empty cells
				NULL,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
				NULL,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
				NULL         // Should the array be indexed by cell row and cell column
			);
			// $rows = $worksheet->toArray();
			$worksheet = array_values($worksheet);
			$kolom_array = [
				"kode", "nama_produk", "kms", "terjual", "hrg_jual", "netto", "laba_kotor", "struk", "frek", "barcode"
			];


			// print_r($kolom_array);
			// exit;

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


			$data = [
				'date1' => $date1,
				'date2' => $date2,
				'worksheet' => $worksheet
			];
		} else {
			$data['validation'] = $this->validator;
		} 

		// echo "<pre>";

		// d($data['worksheet']);
		$this->clustering($data);
	}

	public function clustering($data)
	{
		// $session = \Config\Services::session();

		// $tabel = $data['worksheet'];
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

		for ($i = 0; $i < 100; $i++) {
			$tampilloop[$i] = [
				'meds1' 	=> $meds1   = $this->data_model->getMedoidNorm($optable),
				'optable' 	=> $optable = $this->data_model->countdis1($optable, $meds1),
				'optable' 	=> $optable = $this->data_model->getSimpangan($optable),
				'optable' 	=> $optable = $this->data_model->clustering($optable),
				'jumsimp' 	=> $jumsimp = $this->data_model->sumSimpangan($optable),
			];
		}

		// 	// 	// // ========	=	=	=	==			=	==selama hasil minus berkurang, berarti kondisinya while selisih < 0
		do {
			$selsimp = $tampilloop[$lpcnt + 1]['jumsimp'] - $tampilloop[$lpcnt]['jumsimp'];
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

		$r12 = $this->data_model->rij($ssw1, $ssb12);
		$r13 = $this->data_model->rij($ssw2, $ssb13);
		$r23 = $this->data_model->rij($ssw3, $ssb23);

		$dbi = max($r12, $r13, $r23) / 3;

		$selsimp = round($selsimp, 6);
		$dbi = round($dbi,6);

		// echo $dbi;
		// echo '<br>';
		// echo $selsimp;
		// die;
		

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

		// echo "Medoid= ";				//for testing purposes
		// echo "<pre>";
		// d($meds1);
		// echo ("<hr>");
		// echo ("selisih simpangan= " . $selsimp);
		// echo ("<hr>");
		// echo ("DBI= " . $dbi);
		// d($data['worksheet']);

		// exit;

		// $dbi = floatval(str_replace('.', ',', $dbi));
		// $selsimp = floatval(str_replace('.', ',', $selsimp));

		// // // // ========	=	=	=	==	=	=	=	=		=	==	 Saving data to db and redirecting to rekap. 
		$session = session();
		$tgl_pencairan = date("Y-m-d H:i:s");				//datetimestamp input

		$dataPenjualan = [									//insert tabel penjualan
			// 
			"timestamp_enterdata" => $tgl_pencairan,
			"start_date" 	=> $data['date1'],
			"end_date" 		=> $data['date2'],
			"dbi" 			=> $dbi,
			"selisih_simpangan" => $selsimp
		];

		// dd($dataPenjualan);

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
}
