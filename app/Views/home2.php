<!-- konten Home -->
<?php // $session = session() 
?>
<?= $this->extend('template/web_frame') ?>

<?= $this->section('content') ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-2"></div>
            <div class="col-lg">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Tentang Aplikasi</h5>
                    </div>
                    <div class="card-body justify-content-center">
                        <!-- <h6 class="card-title">Special title treatment</h6> -->
                        <!-- <p class="card-text"> -->
                        <ol>
                            <li>
                                Aplikasi ini dirancang untuk mengelompokkan data penjualan Tlogomart menjadi
                                tiga kategori: Laku, Sedang, dan Tidak Laku.
                                <ol type="a">
                                    <li>
                                        Pengelompokan berdasarkan pada atribut Penjualan dan Frekuensi pada
                                        Data Penjualan dalam periode yang telah ditentukan
                                    </li>
                                </ol>
                            </li>
                            <li>
                                Menggunakan Data Mining Clustering Kmedoids.
                            </li>
                            <li>
                                Buck

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
            <div class="col-2"></div>
            <div class="col-8">
                <div class="card card-primary card-outline">
                    <!-- <div class="card-header">
                        <h5 class="m-0">Featured</h5>
                    </div> -->
                    <div class="card-body text-center">
                        <h6 class="card-title text-center" style="flex-direction: column; ">Silakan mengklik tombol-tombol berikut untuk menuju ke menu masing-masing.</h6>
                        <p class="card-text"></p>
                        <a href="<?= base_url() . "/Manage_data"; ?>" class="btn btn-primary">Insert Data</a>
                        <a href="#" class="btn btn-primary">Rekap Data</a>

                    </div>
                </div>
            </div>
            <div class="col-2"></div>

            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?= $this->endSection() ?>