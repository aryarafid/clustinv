<?php

namespace App\Models;

use CodeIgniter\Model;

class data_model extends Model
{
    protected $table         = 'samble';
    protected $primarykey    = 'kode2';

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
                ($tabel[$i]['terjual2'] - $maxminfj['minjual'])
                /
                ($maxminfj['maxjual'] - $maxminfj['minjual']);
        }

        // loop for frek
        for ($i = 0; $i < count($tabel); $i++) {
            $tabel[$i]['normfrek'] =
                ($tabel[$i]['frek2'] - $maxminfj['minfrek'])
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

    public function clust_array($tabel, $cl) //masukin hasil clustering ke array biar gmpg hitung sse 2nd phase
    {
        $arrclust = array();        // array baru isi rows bercluster $cl

        for ($i = 0; $i < count($tabel); $i++) {
            if ($tabel[$i]['cluster'] == $cl) {
                $arrclust[$i] = $tabel[$i];
            }
        }
        return array_values($arrclust);
    }

    public function restitch($tab1, $tab2)  //match kode2 dan memindah a_i dari OPT wkwkkw, t1 tujuan, t2 asal (OPT)
    {
        for ($i = 0; $i < count($tab1); $i++) {
            for ($j = 0; $j < count($tab2); $j++) {
                // if ($tab2[$j]['kode2'] == $tab1[$i]['kode2']) {
                if (in_array($tab2[$j]['kode2'], $$tab1)) {
                    $tab1[$i]['a_i'] = $tab2[$i]['a_i'];
                }
            }
        }
    }

    public function sse_first($tabel)     //average intra cluster distance
    {
        # loop jarak antarelemen
        $avg = 0;
        for ($i = 0; $i < count($tabel); $i++) {
            for ($j = 0; $j < count($tabel); $j++) {
                $tabel[$i]['a_i'] = sqrt(
                    (($tabel[$i]['terjual2'] - $tabel[$j]['terjual2']) ** 2)
                        +
                        (($tabel[$i]['frek2'] - $tabel[$j]['frek2']) ** 2)
                )
                    / count($tabel);
            }
        }
        return $tabel;
    }

    public function sse_scnd($cla, $clb, $clc)   //average inter cluster distance
    {
        // $clust = 1;
        for ($i = 0; $i < count($cla); $i++) {
            for ($j = 0; $j < count($clb); $j++) {
                $cla[$i]['jarakcl_b'] = sqrt(
                    (($cla[$i]['terjual2'] - $clb[$j]['terjual2']) ** 2)
                        +
                        (($cla[$i]['frek2'] - $clb[$j]['frek2']) ** 2)
                )
                    / count($clb);
            }
            for ($k = 0; $k < count($clc); $k++) {
                $cla[$i]['jarakcl_c'] = sqrt(
                    (($cla[$i]['terjual2'] - $clc[$k]['terjual2']) ** 2)
                        +
                        (($cla[$i]['frek2'] - $clc[$k]['frek2']) ** 2)
                )
                    / count($clc);
            }
        }
        for ($i = 0; $i < count($cla); $i++) {
            (
                ($cla[$i]['jarakcl_b'] > $cla[$i]['jarakcl_c']) ?
                ($cla[$i]['b_i'] = $cla[$i]['jarakcl_c'])
                : ($cla[$i]['b_i'] = $cla[$i]['jarakcl_b']));
        }
        return $cla;
    }

    public function s_i($tabel)
    {
        for ($i = 0; $i < count($tabel); $i++) {
            $tabel[$i]['s_i'] =
                $tabel[$i]['a_i'] - $tabel[$i]['b_i'] /
                max(
                    array($tabel[$i]['a_i'] - $tabel[$i]['b_i'])
                );
        }
        return $tabel;
    }

    public function final_si($tabel)
    {
        for ($i = 0; $i < count($tabel); $i++) {
            $final_si =+ $tabel[$i]['s_i'];
        }
        $final_si = $final_si / count($tabel);
        return $final_si;
    }
}
