<!-- konten Home -->
<?php // $session = session() 
?>
<?= $this->extend('template/web_frame') ?>

<!-- no loop at all, all normal!!! -->


<?= $this->section('content') ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg">
                <!-- tabel -->
                <div class="card collapsed-card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Penjualan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tb-penjualan1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <!-- <th>Nama</th> -->
                                    <th>Penjualan</th>
                                    <th>Frekuensi (%)</th>
                                    <th> Normalisasi Penjualan </th>
                                    <th> Normalisasi Frekuensi </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- loop tr td -->
                                    <?php
                                    foreach ($data_model as $dm) {
                                    ?>
                                <tr>
                                    <td> <?= $dm['kode2']; ?> </td>
                                    <!-- <td>  -->
                                    <!-- <td> $md['nama'] missing -->
                                    <!-- </td> -->
                                    <td> <?= $dm['terjual2']; ?> </td>
                                    <td> <?= $dm['frek2']; ?> </td>
                                    <td> <?= $dm['normjual']; ?> </td>
                                    <td> <?= $dm['normfrek']; ?> </td>

                                </tr>
                            <?php } ?>
                            </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode</th>
                                    <!-- <th>Nama</th> -->
                                    <th>Penjualan</th>
                                    <th>Frekuensi (%)</th>
                                    <th> Normalisasi Penjualan </th>
                                    <th> Normalisasi Frekuensi </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

                <!-- Medoid select screen -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Medoid 1, jumlah K = 3</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tb-medoid" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <?php $no = 1 ?>
                                    <th>K</th>
                                    <th>Kode</th>
                                    <!-- <th>Nama</th> -->
                                    <th>Penjualan</th>
                                    <th>Frekuensi (%)</th>
                                    <th> Normalisasi Penjualan </th>
                                    <th> Normalisasi Frekuensi </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- loop tr td -->
                                    <?php
                                    foreach ($med1 as $md) {
                                    ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td> <?= $md['kode2']; ?> </td>
                                    <!-- <td> $md['nama'] missing -->
                                    <td> <?= $md['terjual2']; ?> </td>
                                    <td> <?= $md['frek2']; ?> </td>
                                    <td> <?= $md['normjual']; ?> </td>
                                    <td> <?= $md['normfrek']; ?> </td>

                                </tr>
                            <?php } ?>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- loop perhitungan cluster -->
                <?php // for ($i = 0; $i < $lpcnt; $i++) { 
                ?>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Hasil Akhir Perhitungan Jarak terhadap Medoid, iterasi ke-<?= $lpcnt; ?>

                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tb-medoid" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <?php $no = 1 ?>
                                    <th>Kode</th>
                                    <!-- <th>Nama</th> -->
                                    <th>Norm. Penjualan</th>
                                    <th>Norm. Frekuensi (%)</th>
                                    <th>Jarak Med1 (F)</th>
                                    <th>Jarak Med2 (S)</th>
                                    <th>Jarak Med3 (N)</th>
                                    <th>Simpangan</th>
                                    <th>Cluster?</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- loop tr td -->
                                    <?php
                                    foreach ($op_tabel as $ot) {
                                    ?>
                                <tr>
                                    <td> <?= $ot['kode2']; ?> </td>
                                    <!-- <td>  -->
                                    <!-- <td> $md['nama'] missing -->
                                    <!-- </td> -->
                                    <td> <?= $ot['normjual']; ?> </td>
                                    <td> <?= $ot['normfrek']; ?> </td>
                                    <td> <?= $ot['jmed1']; ?> </td>
                                    <td> <?= $ot['jmed2']; ?> </td>
                                    <td> <?= $ot['jmed3']; ?> </td>
                                    <td> <?= $ot['simpangan']; ?> </td>
                                    <td> <?= $ot['cluster']; ?> </td>
                                    <!-- <td>Jarak Med1</td> -->
                                    <!-- <td>Jarak Med2</td> -->
                                    <!-- <td>Jarak Med3</td> -->

                                </tr>
                            <?php } ?>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Total simpangan -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Perhitungan Simpangan Loop ke-<?= $lpcnt; ?>

                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <p> Jumlah simpangan adalah <?= $tampilloop['3']; ?> </p>
                    </div>
                </div>
                <!-- / Total simpangan -->


                <!-- / loop perhitungan cluster -->
                <?php // }; 
                ?>

            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?= $this->endSection() ?>