<!-- konten Rekap detail 1 id -->
<?php $session = session()
?>
<?= $this->extend('template/web_frame') ?>

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
                        <h3 class="card-title"> Rekap Data <?php echo "ID data yang ditampilin di page ini= " . $penjualan_id; ?> </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="rekap_cluster" class="table table-bordered table-hover">
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
                                    foreach ($tab_ori as $to) {
                                    ?>
                                <tr>
                                    <td> <?= $to['kode2']; ?> </td>
                                    <!-- <td>  -->
                                    <!-- <td> $md['nama'] missing -->
                                    <!-- </td> -->
                                    <td> <?= $to['terjual2']; ?> </td>
                                    <td> <?= $to['frek2']; ?> </td>
                                    <td> <?= $to['normjual']; ?> </td>
                                    <td> <?= $to['normfrek']; ?> </td>

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

                </div>

            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?= $this->endSection() ?>