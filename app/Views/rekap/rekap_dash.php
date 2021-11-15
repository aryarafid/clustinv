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
                        
                        <table id="resp_table" class="display table table-bordered table-hover">
                            <thead>
                                <tr title="Klik untuk mengurutkan data">
                                    <!-- <th>ID Penjualan</th> -->
                                    <th>Nama Alias</th>

                                    <th>Rentang Tanggal Awal</th>
                                    <th>Rentang Tanggal Akhir</th>
                                    <th>Tanggal dan Waktu Memasukkan Data</th>
                                    <!-- <th>Nilai Davies-Bouldin Index</th>
                                    <th>Selisih Simpangan</th> -->
                                    <th>Aksi</th>


                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr> -->
                                <!-- loop tr td -->
                                <?php
                                foreach ($data_penjualan as $dp) {
                                ?>
                                    <tr>
                                        <!-- <td> <?//= $dp['penjualan_id']; ?> </td> -->
                                        <td>
                                            <?= $dp['nama_alias']; 
                                            ?>
                                        </td>
                                        <td>
                                            <? // = // $dp['start_date']; 
                                            ?>
                                            <?php echo date('d-m-Y', strtotime($dp['start_date'])); ?>
                                        </td>
                                        <td>
                                            <? //= $dp['end_date']; 
                                            ?>
                                            <?php echo date('d-m-Y', strtotime($dp['end_date'])); ?>

                                        </td>
                                        <td>
                                            <?//= $dp['timestamp_enterdata']; ?>
                                            <?php echo date('d-m-Y - H:i:s', strtotime($dp['timestamp_enterdata'])); ?>

                                        </td>
                                        <!-- <td> <?//= $dp['dbi']; ?> </td> -->
                                        <!-- <td> <?//= $dp['selisih_simpangan']; ?> </td> -->

                                        <td>
                                            <a href="#">
                                                <a href="<?= base_url(); ?>/rekap_data/rekap_tr/<?= $dp['penjualan_id']; ?>">
                                                    <!-- <button type="button" class="btn btn-primary"> -->
                                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Detail Data Rekap">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                    
                                                </a>
                                            </a>
                                            <a href="#">
                                                <!-- <a href="<?= base_url(); ?>/rekap_data/delete_rekap/<?= $dp['penjualan_id']; ?>"> -->
                                                <a href="<?= base_url(); ?>/rekap_data/delete_rekap/<?= $dp['penjualan_id']; ?>
                                                " onclick="return confirm('Yakin ingin menghapus data?');">
                                                    <!-- <button type="button" class="btn btn-danger"> -->
                                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data Rekap">

                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </a>
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>
                                <!-- </tr> -->

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

<!-- confirm script -->
<!-- <script>
    function myFunction() {
        confirm("Press a button!");
    }
    
</script> -->



<?= $this->endSection() ?>