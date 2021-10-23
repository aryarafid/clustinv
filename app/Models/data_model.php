<?php

namespace App\Models;

use CodeIgniter\Model;

class data_model extends Model
{
    // protected $table         = 'samble';        //proto's
    // protected $primarykey    = 'kode2';

    /************************************************K MEDOIDS CLUSTERING*************************************************/
    public function __construct()
    {
        parent::__construct();
        helper('array');
    }

    public function getMedoidNorm($tabel)
    {
        for ($i = 0; $i < 3; $i++) {
            $randy[] = mt_rand(0, (count($tabel) - 1));
        }
        for ($i = 0; $i < count($randy); $i++) {
            $medoidnorm[] = $tabel[$randy[$i]];
        }

        $a = $medoidnorm[0];
        $b = $medoidnorm[1];
        $c = $medoidnorm[2];

        if (
            $a['normjual'] == $b['normjual'] or
            $a['normfrek'] == $b['normfrek'] or

            $b['normjual'] == $c['normjual'] or
            $b['normfrek'] == $c['normfrek'] or

            $c['normjual'] == $a['normjual'] or
            $c['normfrek'] == $a['normfrek']
        ) {
            return $this->getMedoidNorm($tabel);
        } else {
            return $medoidnorm;
        }
    }

    public function normalisasi($tabel, $maxminfj)
    {
        // loop for penjualan
        for ($i = 0; $i < count($tabel); $i++) {
            $tabel[$i]['normjual'] =
                ($tabel[$i]['terjual'] - $maxminfj['minjual'])
                /
                ($maxminfj['maxjual'] - $maxminfj['minjual']);
        }

        // loop for frek
        for ($i = 0; $i < count($tabel); $i++) {
            $tabel[$i]['normfrek'] =
                ($tabel[$i]['frek'] - $maxminfj['minfrek'])
                /
                ($maxminfj['maxfrek'] - $maxminfj['minfrek']);
        }

        return $tabel;
    }

    public function countdis1($tabel, $medoids) //hitung jarak v2 - normified
    {
        $db = \Config\Database::connect();

        // Medoid 1
        // for ($i=0; $i < count($medoids) ; $i++) { 
        for ($i = 0; $i < count($tabel); $i++) {
            // tabel - medoid
            $tabel[$i]['jmed1'] = +sqrt(
                ($tabel[$i]['normjual'] - $medoids[0]['normjual']) ** 2
                    +
                    ($tabel[$i]['normfrek'] - $medoids[0]['normfrek']) ** 2
            );
        }

        // medoid 2
        for ($i = 0; $i < count($tabel); $i++) {
            // tabel - medoid
            $tabel[$i]['jmed2'] = +sqrt(
                ($tabel[$i]['normjual'] - $medoids[1]['normjual']) ** 2
                    +
                    ($tabel[$i]['normfrek'] - $medoids[1]['normfrek']) ** 2
            );
        }

        // medoid 3
        for ($i = 0; $i < count($tabel); $i++) {
            // tabel - medoid
            $tabel[$i]['jmed3'] = +sqrt(
                ($tabel[$i]['normjual'] - $medoids[2]['normjual']) ** 2
                    +
                    ($tabel[$i]['normfrek'] - $medoids[2]['normfrek']) ** 2
            );
        }

        return $tabel;
    }

    public function clustering($tabel)
    {
        $db = \Config\Database::connect();

        for ($i = 0; $i < count($tabel); $i++) {
            if (
                ($tabel[$i]['jmed1'] < $tabel[$i]['jmed2']) and ($tabel[$i]['jmed1'] < $tabel[$i]['jmed3'])
            ) {
                $tabel[$i]['cluster'] = 1;
            } elseif (
                ($tabel[$i]['jmed2'] < $tabel[$i]['jmed3']) and ($tabel[$i]['jmed2'] < $tabel[$i]['jmed1'])
            ) {
                $tabel[$i]['cluster'] = 2;
            } elseif (
                ($tabel[$i]['jmed3'] < $tabel[$i]['jmed2']) and ($tabel[$i]['jmed3'] < $tabel[$i]['jmed1'])
            ) {
                $tabel[$i]['cluster'] = 3;
            }
        }

        return $tabel;
    }

    public function getSimpangan($tabel)
    {
        for ($i = 0; $i < count($tabel); $i++) {
            // for ($i=1; $i <= 3 ; $i++) { 
            $tabel[$i]['simpangan'] = min($tabel[$i]['jmed1'], $tabel[$i]['jmed2'], $tabel[$i]['jmed3']);
            // }
        }
        return $tabel;
    }

    public function sumSimpangan($tabel)
    {
        $sumSimpangan = 0;
        for ($i = 0; $i < count($tabel); $i++) {
            $sumSimpangan += $tabel[$i]['simpangan'];
        }
        return $sumSimpangan;
    }
    /************************************************ENDCLUSTERING*************************************************/


    /************************************************tinggalan SSE*************************************************/
    public function clust_array($tabel, $cl)        //masukin hasil clustering ke array biar gmpg hitung sse 2nd phase
    {
        $arrclust = array();        // array baru isi rows bercluster $cl

        for ($i = 0; $i < count($tabel); $i++) {
            if ($tabel[$i]['cluster'] == $cl) {
                $arrclust[$i] = $tabel[$i];
            }
        }
        return array_values($arrclust);
    }
    /************************************************ENDSSE*************************************************/


    /************************************************DBI VALIDATION*************************************************/
    public function centroid($cluster)
    {
        $tterjual = 0;
        $tfrek = 0;
        for ($i = 0; $i < count($cluster); $i++) {
            $tterjual += $cluster[$i]['terjual'];

            $tfrek += $cluster[$i]['frek'];
        }
        $tterjual = $tterjual / count($cluster);
        $tfrek = $tfrek / count($cluster);

        return $centroid = array(
            'terjual' => $tterjual,
            'frek' => $tfrek
        );
    }

    public function sswi($cluster, $centroid)           //sswi , di dalamnya ada distance dr each data ke centroid
    {
        $db = \Config\Database::connect();

        for ($i = 0; $i < count($cluster); $i++) {
            // cluster - centroid
            $sswi = +sqrt(
                ($cluster[$i]['terjual'] - $centroid['terjual']) ** 2
                    +
                    ($cluster[$i]['frek'] - $centroid['frek']) ** 2
            );
        }
        $sswi = $sswi / count($cluster);
        return $sswi;
    }

    public function ssbij($centroid1, $centroid2)       //jarak antar centroid
    {
        // for ($i = 0; $i < count($centroid1); $i++) {
        // cluster - centroid
        $ssbij = +sqrt(
            ($centroid1['terjual'] - $centroid2['terjual']) ** 2
                +
                ($centroid1['frek'] - $centroid2['frek']) ** 2
        );
        // };
        return $ssbij;
    }

    public function rij($sswi, $ssbij)                  //ratio (+ L + yb better) cluster i & j
    {
        $rij = 0;
        return $rij = ($sswi + $sswi)/$ssbij;
    }
    /************************************************END DBI VALIDATION*************************************************/


    public function insert_db($data)
    {
        # code...
    }
}
