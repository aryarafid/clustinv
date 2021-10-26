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
		$file = $this->request->getFile('file_excel');

		if (!$file->isValid()) {
			throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
		}

		// $rett = array(
		$date1 = $this->request->getPost('datepicker1');
		$date2 = $this->request->getPost('datepicker2');
		// $filename = $file->getName();
		$coord = $this->request->getPost('coord');
		// );

		// echo $coord;

		$reader = IOFactory::createReader('Xlsx');
		$spreadsheet = $reader->load($file);
		$writer = IOFactory::createWriter($spreadsheet, 'Html');
		// $message = $writer->save('php://output');

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

		$data = [
			'date1' => $date1,
			'date2' => $date2,
			'worksheet' => $worksheet
		];

		echo "<pre>";

		// print_r($data);
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

		$tabfin = array_merge($cl1, $cl2, $cl3);						//ARRAY YG DIPISAH DIJADIIN 1
		// // // // ========	=	=	=	==	=	=	=	=		=	==	 END DBI VAL

		// 	// // ========	=	=	=	==	=	=	=	= finishing, unset arrays, putting the clusters from transtab to $data['worksheet']
		$fintr = array();								//final transition table

		for ($i = 0; $i < count($tabfin); $i++) {
			$fintr[$i]['kode'] 		= $tabfin[$i]['kode'];
			$fintr[$i]['cluster'] 	= $tabfin[$i]['cluster'];
		}

		usort(
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

		for ($i = 0; $i < count($data['worksheet']); $i++) {
			$data['worksheet'][$i]['cluster'] 	= $fintr[$i]['cluster'];
		}

		unset($transtab);
		unset($cl1);
		unset($cl2);
		unset($cl3);
		unset($optable);
		unset($tabfin);
		unset($fintr);

		// echo "Medoid= ";
		// echo "<pre>";
		// d($meds1);
		// echo ("<hr>");
		// echo ("selisih simpangan= " . $selsimp);
		// echo ("<hr>");
		// echo ("DBI= " . $dbi);
		// d($data['worksheet']);

		// // // // ========	=	=	=	==	=	=	=	=		=	==	 Saving data to db and redirecting to rekap. 

		$session = session();
		$data2 = [
			'id'		=> '21',
			'message' 	=> 'Money',
			'title'		=> 'Detail Rekap',
			'heading' 	=> 'Detail Rekap',
		];

		// $this->session->setFlashdata('data2', $data2);
		$session->set($data2);

		return $this->response->redirect(site_url('Rekap_data/rekap_detail'),'refresh');

		
		// echo view('rekap/rekap_detail', $data2);

		exit;

		// $builderRP = $this->db->table('rinc_penjualan');

		// $dataPenjualan = [
		// 	// 
		// 	"start_date" => $data['date1'],
		// 	"end_date" 	=> $data['date2'],
		// ];
		// $this->penjualan_model->save($dataPenjualan);

		// $penjualan_id = $this->penjualan_model->insertID();

		// for ($i = 0; $i < count($data['worksheet']); $i++) {
		// 	# code...
		// 	// dd($data['worksheet'][$i]);
		// 	$dataRincPenjualan[] = [
		// 		// 
		// 		'penjualan_id'	=> $penjualan_id,
		// 		'kode' 			=> $data['worksheet'][$i]['kode'],
		// 		'nama_produk' 	=> $data['worksheet'][$i]['nama_produk'],
		// 		'terjual' 		=> $data['worksheet'][$i]['terjual'],
		// 		'frek' 			=> $data['worksheet'][$i]['frek'],
		// 		'cluster'		=> $data['worksheet'][$i]['cluster'],
		// 	];
		// };
		// $builderRP->insertBatch($dataRincPenjualan);

	}
}
