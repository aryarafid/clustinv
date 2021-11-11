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

                <!-- <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Grafik Persebaran Produk
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                    </div>
                </div> -->




                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Persebaran Produk<br>
                    <?php
                    // for ($i = 0; $i < count($cl1); $i++) {
                    //     if ($i < (count($cl1)-1)){
                    //         // echo "htmlentities(ENT_QUOTES)";
                    //         // echo "'".$cl1[$i]['nama_produk']."',";
                    //         echo "'".$i."',<br>";
                    //         // echo "htmlentities(ENT_QUOTES)".",";
                    //     }else{
                    //         // echo "htmlentities(ENT_QUOTES)";
                    //         // echo "'".$cl1[$i]['nama_produk']."'";
                    //         echo "'".$i."'";
                    //         // echo "htmlentities(ENT_QUOTES)";
                    //     }

                    // }
                    ?>
                    </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <!-- <div id="chart-container">
                            <canvas id="graphCanvas"></canvas>
                        </div> -->

                        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
                        <script src="https://cdn.plot.ly/plotly-2.4.2.min.js"></script>

                        <!-- declare php code masukin data di sini  -->

                        <div id="tester" style="width:auto; height:600px;"></div>

                        <script>
                            var cluster1 = {
                                x: [

                                    // <?php // for ($i = 0; $i < count($cl1); $i++) {
                                        //     echo "{$cl1[$i]['frek']}";
                                        //     for ($j = 0; $j < (count($cl1) - 1); $j++) {
                                        //         echo ",";
                                        //     }
                                        // }

                                        // 
                                        ?>

                                    <?php
                                    for ($i = 0; $i < count($cl1); $i++) {
                                        if ($i < (count($cl1)-1)) {
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
                                        if ($i < (count($cl1)-1)) {
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
                                text: [
                                    // 'B-a', 'B-b', 'B-c', 'B-d', 'B-e'
                                    <?php
                                    for ($i = 0; $i < count($cl1); $i++) {
                                        if ($i < (count($cl1)-1)){
                                            // echo "htmlentities(ENT_QUOTES)";
                                            // echo "'".$cl1[$i]['nama_produk']."',";
                                            // echo "'".$i."',<br>";
                                            // echo "htmlentities(ENT_QUOTES)".",";
                                        }else{
                                            // echo "htmlentities(ENT_QUOTES)";
                                            // echo "'".$cl1[$i]['nama_produk']."'";
                                            // echo "'".$i."'";
                                            // echo "htmlentities(ENT_QUOTES)";
                                        }

                                    }
                                    ?>
                                ],
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
                                text: [
                                    'B-a', 'B-b', 'B-c', 'B-d', 'B-e'

                                ],
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
                                text: ['B-a', 'B-b', 'B-c', 'B-d', 'B-e'],
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
                                title: {
                                },
                                xaxis: {
                                    title: {
                                        text: '% Frekuensi',
                                        font: {
                                            family: 'Courier New, monospace',
                                            size: 18,
                                            color: '#7f7f7f'
                                        }
                                    },
                                },
                                yaxis: {
                                    title: {
                                        text: 'Jumlah Barang Terjual',
                                        font: {
                                            family: 'Courier New, monospace',
                                            size: 18,
                                            color: '#7f7f7f'
                                        }
                                    }
                                }
                            };

                            Plotly.newPlot('tester', data, layout);
                        </script>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


                <!-- tabel -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Nomor ID pemasukan data:
                            <span style="color: blue;">
                                <?= $penjualan_id; ?>
                            </span>
                            ||
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

                        <!-- <div class="card-tools"> -->

                    </div>

                    <div class="card-body">
                        <table id="resp_table" class="table table-bordered table-hover">
                            <thead>
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
                                        <td> <?= $to['terjual']; ?> </td>
                                        <td> <?= $to['frek']; ?> </td>
                                        <td> <?= $to['cluster']; ?> </td>


                                    </tr>
                                <?php } ?>
                                <!-- </tr> -->

                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>ID Rincian</th>
                                    <th>ID Penjualan</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th># Terjual</th>
                                    <th>Frekuensi (%)</th>
                                    <th> Cluster </th>
                                </tr>
                            </tfoot> -->
                        </table>
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