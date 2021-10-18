<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\data_model;

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
		$tabel = $data['worksheet'];
		$loopke = 0;
		// // // ========	=	=	=	==	=	=	=	=		=	==	 start loop UNTUK DAPET SIL_CO >80%
		do {

			// // retrieve tabel as array
			// $tabel = $this->data_model->findAll();

			// // get maxmin tabel
			$mjual = array_column($tabel, 'terjual');
			$mfrek = array_column($tabel, 'frek');

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
				$optable[$i]['kode']	 = $tabel[$i]['kode'];
				$optable[$i]['nama_produk']	 = $tabel[$i]['nama_produk'];
				$optable[$i]['terjual'] = $tabel[$i]['terjual'];
				$optable[$i]['frek']	 = $tabel[$i]['frek'];
				$optable[$i]['normfrek'] = $tabel[$i]['normfrek'];
				$optable[$i]['normjual'] = $tabel[$i]['normjual'];

				unset($tabel[$i]['normfrek']);
				unset($tabel[$i]['normjual']);
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

			// 	// 	// // // SSE PROCESS STARTS HERE
			// 	// 	// // ========	=	=	=	==memasukkan cluster2 ke array masing2 untuk memudahkan SSE
			for ($i = 0; $i < count($optable); $i++) {
				$clustarray[$i] = [
					'cluster' 	=> $optable[$i]['cluster'],
					'kode' 		=> $optable[$i]['kode'],
					'terjual'	=> $optable[$i]['terjual'],
					'frek' 		=> $optable[$i]['frek'],
				];
			}

			asort($clustarray);
			$cl1 = $this->data_model->clust_array($clustarray, 1);
			// array_values($cl1);
			$cl2 = $this->data_model->clust_array($clustarray, 2);
			// array_values($cl2);
			$cl3 = $this->data_model->clust_array($clustarray, 3);
			// array_values($cl3);

			// 	// 	// // // ========	=	=	=	==	=	=	=	=		=	==	validasi SSE
			$optable = $this->data_model->sse_first($optable);				// 1
			$cl1 = $this->data_model->sse_scnd($cl1, $cl2, $cl3);			// 2
			$cl2 = $this->data_model->sse_scnd($cl2, $cl1, $cl3);
			$cl3 = $this->data_model->sse_scnd($cl3, $cl1, $cl2);
			$tabfin = array_merge($cl1, $cl2, $cl3);

			// 	// 	// // ========	=	=	=	==	=	=	=	=		=	==mindah ke tabfin dan sort untuk memudahkan proses akhir SSE
			for ($i = 0; $i < count($optable); $i++) {
				$transtab[$i] = [
					'kode' 		=> $optable[$i]['kode'],
					'cluster' 	=> $optable[$i]['cluster'],
					'a_i' 		=> $optable[$i]['a_i'],
				];
			}

			usort(
				$transtab,
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

			for ($i = 0; $i < count($tabfin); $i++) {
				$tabfin[$i]['kodeg'] 	= $transtab[$i]['kode'];
				$tabfin[$i]['clusterg']	= $transtab[$i]['cluster'];
				$tabfin[$i]['a_i'] 		= $transtab[$i]['a_i'];
			}

			// 	// // ========	=	=	=	==	=	=	=	=		=	==proses akhir SSE
			$final_si = $this->data_model->s_i($tabfin);

			// $final_si = number_format(($this->data_model->final_si($final_si)), 3, ',', '.');
			$final_si = $this->data_model->final_si($final_si);

			$loopke++;
		} while (($final_si < 0.5)
			|| ($final_si > 1)
		);


		// } while ($final_si < 0.700);
		// } while ($final_si < 0.300);

		// // // // ========	=	=	=	==	=	=	=	=		=	==	 EndLOOP, BALIK KE LOOP TERATAS UNTUK DAPET SIL_CO >70%
		// // 80% kebanyakan, even 71% kebanyakan dan kelamaan. paling cepet dan feasible 51


		// 	// // ========	=	=	=	==	=	=	=	= finishing, unset arrays, putting the clusters from transtab to $tabel
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

		for ($i = 0; $i < count($tabel); $i++) {
			$tabel[$i]['cluster'] 	= $fintr[$i]['cluster'];
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
		// var_dump($meds1);

		// echo ("<hr>");
		// echo ("selisih simpangan= " . $selsimp);

		// echo ("<hr>");
		// echo ("s[i] SSE= " . $final_si);

		// dd($fintr);
		// dd($tabel);

		$this->Rekap_data->insert_db($data);

		// // // ========	=	=	=	==	=	=	=	=		=	==	 End
	}

	// dilanjutkan di  rekap data beresta chartjs dll, semi crud masukin ke aja

}
