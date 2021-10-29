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
                    <div class="card-header">
                        <h3 class="card-title"> ID data yang ditampilin di halaman rekapitulasi ini = <?php echo $penjualan_id; ?> </h3>
                        <!-- <div class="card-tools"> -->

                    </div>

                    <div class="card-body">
                        <table id="rekap_cluster" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID Rincian</th>
                                    <th>ID Penjualan</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th># Terjual</th>
                                    <th>Frekuensi (%)</th>
                                    <th> Cluster </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- loop tr td -->
                                    <?php
                                    foreach ($tab_ori as $to) {
                                    ?>
                                <tr>
                                    <td> <?= $to['id_rincian']; ?> </td>
                                    <td> <?= $to['penjualan_id']; ?> </td>
                                    <td> <?= $to['kode']; ?> </td>
                                    <td> <?= $to['nama_produk']; ?> </td>
                                    <td> <?= $to['terjual']; ?> </td>
                                    <td> <?= $to['frek']; ?> </td>
                                    <td> <?= $to['cluster']; ?> </td>


                                </tr>
                            <?php } ?>
                            </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID Rincian</th>
                                    <th>ID Penjualan</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th># Terjual</th>
                                    <th>Frekuensi (%)</th>
                                    <th> Cluster </th>
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