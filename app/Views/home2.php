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
                                Aplikasi ini digunakan untuk mengklasterisasi/mengelompokkan data penjualan minimarket Tlogomart menjadi
                                tiga kelompok: Laku, Sedang, dan Tidak Laku.
                            </li>
                            <li>
                                Pengelompokan menggunakan metode clustering algoritma K-Medoids dan berdasarkan pada jumlah barang yang
                                terjual dan Frekuensi pada data penjualan dalam rentang waktu yang telah ditentukan.
                            </li>
                            <br>
                            <li>
                                K-means merupakan salah satu algoritma clustering . Tujuan algoritma ini yaitu untuk membagi data mejadi beberapa keiompok. Algoritma
                                ini menerima masukan berupa data tanpa label kelas. Hal ini berbeda dengan supervised learring yang menerima masukan berupa vektor (x1,
                                yt) , (X2 , y2) , ..., pd, yf), di mana xi merupakan data dari suatu data pelatihan dan yfi merupakan label kelas untuk xd.
                                
                                Pada algoritma pembelajaran ini, komputer mengeiompokkan sendiri data-data yang menjadi masukannya tarpa mengetahui terfebih oulu
                                target kelasnya, Pembelajaran ini termusuak dalam unsupenvised learning. Masukan yang diterina adalah data atau cbjek dan k buah kelompok
                                (cluster) yang dilinginkan. Algoritma ini akan mengelompokkan data atbu cojek ke dalam k buah kelompok tersebut. Pada setiap cluster
                                terdapat titik pusat (centroild) yang merepresentasikan cluster tersebut.
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