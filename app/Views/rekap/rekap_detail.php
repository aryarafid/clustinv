<!-- konten Rekap detail 1 id -->
<?php

use App\Controllers\Rekap_data;

$session = session()
?>
<?= $this->extend('template/web_frame') ?>

<?= $this->section('content') ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg">

                <div class="row">
                    <a href="<?= base_url() . "/Rekap_data"; ?>">
                        <button type="button" class="btn btn-primary">
                            << Kembali </button>
                    </a>

                </div>
                <br>

                <div class="card card-primary card-outline">
                    <!-- <div class="card-header">
                    <div class="col-12 col-sm-6"> -->

                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">
                                        Tabel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">
                                        Grafik</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <!-- Tab Tabel -->
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <!-- Nomor ID pemasukan data:
                                            <span style="color: blue;"> -->
                                            <? //= $penjualan_id; 
                                            ?>
                                            <!-- </span>
                                            || -->
                                            Rentang tanggal:
                                            <span style="color: blue;">
                                                <?= $getDateTStamp[0]['start_date']; ?>
                                            </span>
                                            sampai dengan
                                            <span style="color: blue;">
                                                <?= $getDateTStamp[0]['end_date']; ?>
                                            </span>
                                            || Waktu dan tanggal penginputan:
                                            <span style="color: blue;">
                                                <?= $getDateTStamp[0]['timestamp_enterdata'] ?>
                                            </span>
                                        </h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="card card-primary card-outline card-outline-tabs">
                                            <div class="card-header p-0 border-bottom-0">
                                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="custom-tabs-four-full-tab" data-toggle="pill" href="#custom-tabs-four-full" role="tab" aria-controls="custom-tabs-four-full" aria-selected="true">
                                                            Full Data</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-four-satu-tab" data-toggle="pill" href="#custom-tabs-four-satu" role="tab" aria-controls="custom-tabs-four-satu" aria-selected="false">
                                                            Cluster 1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-four-dua-tab" data-toggle="pill" href="#custom-tabs-four-dua" role="tab" aria-controls="custom-tabs-four-dua" aria-selected="false">
                                                            Cluster 2</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="custom-tabs-four-tiga-tab" data-toggle="pill" href="#custom-tabs-four-tiga" role="tab" aria-controls="custom-tabs-four-tiga" aria-selected="false">
                                                            Cluster 3</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="card-body">
                                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                                    <!-- full -->
                                                    <div class="tab-pane fade show active" id="custom-tabs-four-full" role="tabpanel" aria-labelledby="custom-tabs-four-full-tab">
                                                        <table id="resp_table" class="table table-bordered table-hover">
                                                            <thead style="width: 100%">
                                                                <tr>
                                                                    <!-- <th>ID Rincian</th> -->
                                                                    <!-- <th>ID Penjualan</th> -->
                                                                    <th>Kode</th>
                                                                    <th>Nama</th>
                                                                    <th># Terjual</th>
                                                                    <th>Frekuensi (%)</th>
                                                                    <th>Cluster </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- <tr> -->
                                                                <!-- loop tr td -->
                                                                <?php
                                                                foreach ($tab_ori as $to) {
                                                                ?>
                                                                    <tr>
                                                                        <!-- <td> <?= $to['id_rincian']; ?> </td> -->
                                                                        <!-- <td> <?= $to['penjualan_id']; ?> </td> -->
                                                                        <td> <?= $to['kode']; ?> </td>
                                                                        <td> <?= $to['nama_produk']; ?> </td>
                                                                        <td style="text-align: right;">  <?= $to['terjual']; ?> </td>
                                                                        <td style="text-align: right;"> <?= number_format($to['frek'], 2, ',', ' '); ?> </td>
                                                                        <td style="text-align: center;"> <?= $to['cluster']; ?> </td>


                                                                    </tr>
                                                                <?php } ?>
                                                                <!-- </tr> -->

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- cl1 -->
                                                    <div class="tab-pane fade" id="custom-tabs-four-satu" role="tabpanel" aria-labelledby="custom-tabs-four-satu-tab">
                                                        <table id="resp_table1" class="table table-bordered table-hover">
                                                            <thead style="width: 100%">
                                                                <tr>
                                                                    <!-- <th>ID Rincian</th> -->
                                                                    <!-- <th>ID Penjualan</th> -->
                                                                    <th>Kode</th>
                                                                    <th>Nama</th>
                                                                    <th># Terjual</th>
                                                                    <th>Frekuensi (%)</th>
                                                                    <th>Cluster </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- <tr> -->
                                                                <!-- loop tr td -->
                                                                <?php
                                                                foreach ($cl11 as $cl11) {
                                                                ?>
                                                                    <tr>
                                                                        <!-- <td> <?= $to['id_rincian']; ?> </td> -->
                                                                        <!-- <td> <?= $to['penjualan_id']; ?> </td> -->
                                                                        <td> <?= $cl11['kode']; ?> </td>
                                                                        <td> <?= $cl11['nama_produk']; ?> </td>
                                                                        <td style="text-align: right;"> <?= $cl11['terjual']; ?> </td>
                                                                        <!-- <td style="text-align: right;"> <?// = $cl11['frek']; ?> </td> -->
                                                                        <td style="text-align: right;"> <?= number_format($to['frek'], 2, ',', ' '); ?> </td>

                                                                        <td style="text-align: center;"> <?= $cl11['cluster']; ?> </td>


                                                                    </tr>
                                                                <?php } ?>
                                                                <!-- </tr> -->

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- cl2 -->
                                                    <div class="tab-pane fade" id="custom-tabs-four-dua" role="tabpanel" aria-labelledby="custom-tabs-four-dua-tab">
                                                        <table id="resp_table2" class="table table-bordered table-hover">
                                                            <thead style="width: 100%">
                                                                <tr>
                                                                    <!-- <th>ID Rincian</th> -->
                                                                    <!-- <th>ID Penjualan</th> -->
                                                                    <th>Kode</th>
                                                                    <th>Nama</th>
                                                                    <th># Terjual</th>
                                                                    <th>Frekuensi (%)</th>
                                                                    <th>Cluster </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- <tr> -->
                                                                <!-- loop tr td -->
                                                                <?php
                                                                foreach ($cl22 as $cl22) {
                                                                ?>
                                                                    <tr>
                                                                        <!-- <td> <?= $to['id_rincian']; ?> </td> -->
                                                                        <!-- <td> <?= $to['penjualan_id']; ?> </td> -->
                                                                        <td> <?= $cl22['kode']; ?> </td>
                                                                        <td> <?= $cl22['nama_produk']; ?> </td>
                                                                        <td style="text-align: right;"> <?= $cl22['terjual']; ?> </td>
                                                                        <!-- <td style="text-align: right;"> <?// = $cl11['frek']; ?> </td> -->
                                                                        <td style="text-align: right;"> <?= number_format($to['frek'], 2, ',', ' '); ?> </td>
                                                                        <td style="text-align: center;"> <?= $cl22['cluster']; ?> </td>


                                                                    </tr>
                                                                <?php } ?>
                                                                <!-- </tr> -->

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- cl3 -->
                                                    <div class="tab-pane fade" id="custom-tabs-four-tiga" role="tabpanel" aria-labelledby="custom-tabs-four-tiga-tab">
                                                        <table id="resp_table3" class="table table-bordered table-hover">
                                                            <thead style="width: 100%">
                                                                <tr>
                                                                    <!-- <th>ID Rincian</th> -->
                                                                    <!-- <th>ID Penjualan</th> -->
                                                                    <th>Kode</th>
                                                                    <th>Nama</th>
                                                                    <th># Terjual</th>
                                                                    <th>Frekuensi (%)</th>
                                                                    <th>Cluster </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- <tr> -->
                                                                <!-- loop tr td -->
                                                                <?php
                                                                foreach ($cl33 as $cl33) {
                                                                ?>
                                                                    <tr>
                                                                        <!-- <td> <?= $to['id_rincian']; ?> </td> -->
                                                                        <!-- <td> <?= $to['penjualan_id']; ?> </td> -->
                                                                        <td> <?= $cl33['kode']; ?> </td>
                                                                        <td> <?= $cl33['nama_produk']; ?> </td>
                                                                        <td style="text-align: right;"> <?= $cl33['terjual']; ?> </td>
                                                                        <!-- <td style="text-align: right;"> <?// = $cl11['frek']; ?> </td> -->
                                                                        <td style="text-align: right;"> <?= number_format($to['frek'], 2, ',', ' '); ?> </td>
                                                                        <td style="text-align: center;"> <?= $cl33['cluster']; ?> </td>


                                                                    </tr>
                                                                <?php } ?>
                                                                <!-- </tr> -->

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card -->
                                        </div>


                                    </div>
                                </div>
                                <!-- Tab Grafik -->
                                <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                    <div class="card-header">

                                        <h3 class="card-title">Grafik Persebaran Produk<br></h3>

                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">

                                        <script src="https://cdn.plot.ly/plotly-2.4.2.min.js"></script>

                                        <!-- declare php code masukin data di sini  -->

                                        <div id="grafik"></div>

                                        <script>
                                            var cluster1 = {
                                                x: [
                                                    <?php
                                                    for ($i = 0; $i < count($cl1); $i++) {
                                                        if ($i < (count($cl1) - 1)) {
                                                            echo $cl1[$i]['frek'] . ',';
                                                        } else {
                                                            echo $cl1[$i]['frek'];
                                                        }
                                                    }
                                                    ?>

                                                ],
                                                y: [
                                                    <?php
                                                    for ($i = 0; $i < count($cl1); $i++) {
                                                        if ($i < (count($cl1) - 1)) {
                                                            echo $cl1[$i]['terjual'] . ',';
                                                        } else {
                                                            echo $cl1[$i]['terjual'];
                                                        }
                                                    }
                                                    ?>
                                                ],
                                                mode: 'markers+text',
                                                type: 'scatter',
                                                name: 'Cluster 1',
                                                // text: [
                                                //     // 'B-a', 'B-b', 'B-c', 'B-d', 'B-e'
                                                //     <?php
                                                        //     // for ($i = 0; $i < count($cl1); $i++) {
                                                        //     //     if ($i < (count($cl1) - 1)) {
                                                        //     //     } else {
                                                        //     //     }
                                                        //     // }
                                                        //     
                                                        ?>
                                                // ],
                                                textposition: 'top center',
                                                textfont: {
                                                    family: 'Raleway, sans-serif'
                                                },
                                                marker: {
                                                    size: 12
                                                }
                                            };

                                            var cluster2 = {
                                                x: [
                                                    <?php for ($i = 0; $i < count($cl2); $i++) {
                                                        echo "{$cl2[$i]['frek']},";
                                                    }
                                                    ?>

                                                ],
                                                y: [
                                                    <?php for ($i = 0; $i < count($cl2); $i++) {
                                                        echo "{$cl2[$i]['terjual']},";
                                                    }
                                                    ?>
                                                ],
                                                mode: 'markers+text',
                                                type: 'scatter',
                                                name: 'Cluster 2',
                                                // text: [
                                                //     'B-a', 'B-b', 'B-c', 'B-d', 'B-e'

                                                // ],
                                                textfont: {
                                                    family: 'Times New Roman'
                                                },
                                                textposition: 'bottom center',
                                                marker: {
                                                    size: 12
                                                }
                                            };

                                            var cluster3 = {
                                                x: [

                                                    <?php for ($i = 0; $i < count($cl3); $i++) {
                                                        echo "{$cl3[$i]['frek']},";
                                                    }
                                                    ?>

                                                ],
                                                y: [
                                                    <?php for ($i = 0; $i < count($cl3); $i++) {
                                                        echo "{$cl3[$i]['terjual']},";
                                                    }
                                                    ?>
                                                ],
                                                mode: 'markers+text',
                                                type: 'scatter',
                                                name: 'Cluster 3',
                                                // text: ['B-a', 'B-b', 'B-c', 'B-d', 'B-e'],
                                                textfont: {
                                                    family: 'Times New Roman'
                                                },
                                                textposition: 'bottom center',
                                                marker: {
                                                    size: 12
                                                }
                                            };

                                            var data = [cluster1, cluster2, cluster3];

                                            var layout = {
                                                title: {},
                                                xaxis: {
                                                    title: {
                                                        text: '% Frekuensi',
                                                        font: {
                                                            family: 'Arial, sans-serif',
                                                            size: 18,
                                                            color: '#7f7f7f'
                                                        }
                                                    },
                                                },
                                                yaxis: {
                                                    title: {
                                                        text: 'Jumlah Barang Terjual',
                                                        font: {
                                                            family: 'Arial, sans-serif',

                                                            size: 18,
                                                            color: '#7f7f7f'
                                                        }
                                                    }
                                                }
                                            };

                                            Plotly.newPlot('grafik', data, layout);
                                        </script>



                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>


            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?= $this->endSection() ?>