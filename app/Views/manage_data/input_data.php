<!-- konten Home -->
<?php // $session = session() 

use App\Controllers\Manage_data;

?>
<?= $this->extend('template/web_frame') ?>

<?= $this->section('content') ?>

<?php $session = session(); 
$validation =  \Config\Services::validation();?>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-2"></div>


            <div class="col-lg">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Instruksi Penggunaan</h5>
                    </div>
                    <div class="card-body justify-content-center">
                        <!-- <h6 class="card-title">Special title treatment</h6> -->
                        <!-- <p class="card-text"> -->
                        <ol>
                            <li>
                                Pengguna memasukkan alias nama data yang akan diproses guna memudahkan untuk mengenalinya pada 
                                menu dashboard rekapitulasi data.
                            </li>
                            <li>
                                Pengguna mengupload file .xlsx pada tombol Browse. Pastikan data memiliki kolom Frekuensi. 
                            </li>
                            <li>
                                Pengguna mengklik tombol submit untuk memulai proses pengelompokan data. Hasil dapat dilihat di
                                menu Rekapitulasi pada sidebar (menu samping).
                            </li>
                        </ol>

                        <!-- </p> -->
                    </div>
                </div>
            </div>

            <div class="col-2"></div>
            <!-- /.col-md-6 -->
        </div>

        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-3"></div>

            <div class="col-lg">

                <!-- form -->
                <div class="card card-primary card-outline mx-auto">
                    <!-- form start -->

                    <!-- <form method="post" action="<?= base_url(); ?>/data_idv/tambah_idv_aksi"> -->
                    <form method="post" enctype="multipart/form-data" action="<?= base_url(); ?>/Manage_data/olah_dokumen">

                        <div class="card-body ">

                            <div class="alert alert-danger alert-dismissible">
                                <?php echo $validation->listErrors(); ?>
                            </div>

                            <!-- <div class="form-group">
                                <label for="datepicker1">Range Tanggal Awal</label>
                                <div class="input-group date" id="datepicker1" data-target-input="nearest">
                                    <input type="date" class="form-control datepicker-input" data-target="#datepicker1" name="datepicker1" />
                                    <div class="input-group-append" data-target="#datepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <small id="datepicker2" class="form-text text-muted">
                                    Format tanggal: bulan-hari-tahun
                                </small>
                            </div>  -->

                            <!-- <div class="form-group"> -->
                                <!-- <label for="datepicker1">Range Tanggal Akhir</label>
                                <div class="input-group date" id="datepicker2" data-target-input="nearest">
                                    <input type="date" class="form-control datepicker-input" data-target="#datepicker2" name="datepicker2" />
                                    <div class="input-group-append" data-target="#datepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <small id="datepicker2" class="form-text text-muted">
                                    Format tanggal: bulan-hari-tahun
                                </small> -->
                            <!-- </div> -->

                            <div class="form-group">
                                <label for="alias">Nama File Baru</label>
                                <input class="form-control" type="text" placeholder="Default input" name="nama_alias" required>
                                <!-- <small id="nama_alias" class="form-text text-muted">
                                    Masukkan nama file untuk memudahkan identifikasi pada dashboard data rekapitulasi.
                                </small> -->
                            </div>

                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="InputFile">Input File Excel</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="hidden" id="InputFile" name="file_excel" accept=".xlsx " required>
                                        <label for="InputFile"></label>
                                    </div>
                                </div>
                                <!-- <small id="file_excel" class="form-text text-muted">
                                    Pastikan file memiliki kolom Frekuensi.
                                </small> -->
                            </div>

                            <!-- <hr> -->

                        </div>
                        <!-- /.card-body -->


                        <div class="card-footer">
                            <!-- <a href="<?= base_url(); ?>/Manage_data/olah_dokumen"> -->
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <!-- </a> -->
                        </div>

                    </form>

                </div>

            </div>

            <!-- <div class="col-lg "> -->
            <div class="col-3"></div>
            <!-- </div> -->
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<?= $this->endSection() ?>