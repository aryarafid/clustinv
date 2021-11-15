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
            <!-- <div class="col-2"></div> -->
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
                                Aplikasi ini digunakan untuk mengelompokkan data penjualan minimarket Tlogomart menjadi
                                tiga kelompok: Laku, Sedang, dan Tidak Laku.
                            </li>
                            <li>
                                Clustering atau kegiatan pengelompokan menggunakan metode clustering algoritma K-Medoids.
                                <ul>
                                    <li>

                                        Berdasarkan pada data jumlah barang yang
                                        terjual dan persentase Frekuensi pada data penjualan dalam rentang waktu yang telah ditentukan.
                                    </li>
                                </ul>
                            </li>

                            <li>
                                Algoritma PAM (Partioning Around Medoids) atau biasa juga disebut dengan algoritma KMedoids, merupakan
                                algoritma yang diwakili oleh cluster berupa medoid (Kamila et al, 2019). Perbedaan antara algoritma K-Medoids
                                dengan slgoritma K-Means yaitu K-Medoids menggunakan objek sebagai perwakilan (medoid) pusat cluster untuk
                                tiap cluster, sementara algoritma K-Means membutuhkan nilai rata-rata (mean) sebagai pusat cluster
                                <br>
                            </li>
                        </ol>

                        <!-- </p> -->
                    </div>
                </div>
            </div>
            <!-- <div class="col-2"></div> -->
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
                        <h6 class="card-title text-center" style="flex-direction: column; ">
                            Silakan mengklik tombol-tombol pada sidebar untuk menuju ke menu masing-masing.</h6>
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