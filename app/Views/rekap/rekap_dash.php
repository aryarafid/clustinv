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
                <div class="card card-primary card-outline">
                    <!-- <div class="card-header"> -->
                    <!-- <h3 class="card-title"> Dashboard Rekapitulasi Data Hasil Klasterisasi </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div> -->
                    <!-- </div> -->

                    <div class="card-body">
                        <table id="rekap_cluster" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID Penjualan</th>
                                    <th>Rentang Tanggal Awal</th>
                                    <th>Rentang Tanggal Akhir</th>
                                    <th>Waktu Memasukkan Data</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- loop tr td -->
                                    <?php
                                    foreach ($data_penjualan as $dp) {
                                    ?>
                                <tr>
                                    <td> <?= $dp['penjualan_id']; ?> </td>
                                    <td> <?= $dp['start_date']; ?> </td>
                                    <td> <?= $dp['end_date']; ?> </td>
                                    <td> <?= $dp['timestamp_enterdata']; ?> </td>
                                    <td>
                                        <a href="#">
                                            <a href="<?= base_url(); ?>/rekap_data/rekap_tr/<?=  $dp['penjualan_id']; ?>">
                                                <button type="button" class="btn btn-primary">
                                                    Detail Rekap
                                                </button>
                                            </a>
                                        </a>
                                        <a href="#">
                                            <a href="<?= base_url(); ?>/rekap_data/delete_rekap/<?=  $dp['penjualan_id']; ?>">
                                                <button type="button" class="btn btn-danger">
                                                    Hapus Data
                                                </button>
                                            </a>
                                        </a>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tr>

                            </tbody>


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