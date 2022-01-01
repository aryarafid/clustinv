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
                                        <!-- <td> <? //= $dp['penjualan_id']; 
                                                    ?> </td> -->
                                        <td>
                                            <?= $dp['nama_id'];
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
                                            <? //= $dp['timestamp_enterdata']; 
                                            ?>
                                            <?php echo date('d-m-Y - H:i:s', strtotime($dp['timestamp_enterdata'])); ?>

                                        </td>
                                        <!-- <td> <?//= $dp['dbi']; ?> </td> -->
                                        <!-- <td> <?//= $dp['selisih_simpangan']; ?> </td> -->

                                        <td>
                                            <a href="<?= base_url(); ?>/rekap_data/rekap_tr/<?= $dp['penjualan_id']; ?>">
                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Detail Data Rekap">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </a>

                                            <!-- <a href="#"></a>  -->
                                            <!-- <a href="<?//= base_url(); ?>/rekap_data/editAlias/<?//= $dp['penjualan_id']; ?>"> -->
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default" 
                                            data-placement="top" title="Edit Nama Alias Data Rekapitulasi">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </button>
                                            </a>

                                            <a href="<?= base_url(); ?>/rekap_data/delete_rekap/<?= $dp['penjualan_id']; ?>" onclick="return confirm('Yakin ingin menghapus data?');">
                                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data Rekap">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </a>


                                        </td>

                                    </tr>
                                <?php } ?>
                                <!-- </tr> -->

                            </tbody>


                        </table>

                        <!-- modal edit -->
                        <div class="modal fade" id="modal-default">
                            <form method="post" enctype="multipart/form-data" action="<?= base_url(); ?>/rekap_data/editAlias/<?= $dp['penjualan_id']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Nama Alias Data Rekapitulasi</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <div class="card-body ">

                                                <div class="form-group">
                                                    <label for="alias">Nama Baru</label>
                                                    <input class="form-control" type="text" 
                                                    placeholder="Nama Alias File Baru" name="nama_id" required>
                                                </div>
                                                
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Nama Baru</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </form>
                        </div>


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