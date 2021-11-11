<!-- konten Home -->
<?php // $session = session() 

use App\Controllers\Manage_data;

?>
<?= $this->extend('template/web_frame') ?>

<?= $this->section('content') ?>

<?php $session = session(); ?>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-3"></div>


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
                                Pengguna mengisi tanggal untuk
                            </li>
                            <li>
                                Pengguna.....
                            </li>
                            <li>
                                Harap menunggu ....

                            </li>
                        </ol>

                        <!-- </p> -->
                    </div>
                </div>
            </div>

            <div class="col-3"></div>
            <!-- /.col-md-6 -->
        </div>

        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-3"></div>

            <div class="col-lg">

                <!-- form -->
                <div class="card card-primary card-outline mx-auto">
                    <!-- <div class="card-header">
                        <h1 class="card-title">Catatan: format tanggal -> bulan-hari-tahun</h3>
                    </div> -->
                    <!-- /.card-header -->

                    <!-- form start -->

                    <!-- <form method="post" action="<?= base_url(); ?>/data_idv/tambah_idv_aksi"> -->
                    <form method="post" enctype="multipart/form-data" action="<?= base_url(); ?>/Manage_data/olah_dokumen">


                        <div class="card-body ">


                            <!-- <div class="alert alert-danger alert-dismissible"> -->
                            <?php // echo $validation->listErrors(); 
                            ?>
                            <!-- </div> -->


                            <div class="form-group">
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
                            </div>

                            <div class="form-group">
                                <label for="datepicker1">Range Tanggal Akhir</label>
                                <div class="input-group date" id="datepicker2" data-target-input="nearest">
                                    <input type="date" class="form-control datepicker-input" data-target="#datepicker2" name="datepicker2" />
                                    <div class="input-group-append" data-target="#datepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <small id="datepicker2" class="form-text text-muted">
                                    Format tanggal: bulan-hari-tahun
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="InputFile">Input File Excel</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="hidden" id="InputFile" name="file_excel" accept=".xlsx " required>
                                        <label for="InputFile"></label>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-group" style="color: red;">
                            
                                <span> Deez nuts </span>
                            </div> -->

                            <p class="login-box-msg" >
                                <?= $session->getflashdata('msg'); ?>
                            </p>


                            <!-- <div class="form-group">
                                <label for="coord">Cell paling bawah kolom Frekuensi</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" placeholder="Cell..." name="coord" required>
                                </div>
                                <small id="coordlabel" class="form-text text-muted">
                                    Koordinat cell paling bawah kolom Frekuensi
                                </small>
                            </div> -->

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