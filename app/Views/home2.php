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
                                tiga kelompok/<b>cluster</b>: Laku, Sedang, dan Tidak Laku.
                            </li>
                            <li>
                                Clustering atau kegiatan pengelompokan menggunakan metode clustering algoritma bernama
                                <b>K-Medoids</b>.
                                <ul>
                                    <li>
                                        Berdasarkan pada <b>
                                            data jumlah barang yang terjual
                                        </b>
                                        dan
                                        <b>
                                            persentase Frekuensi pada data penjualan
                                        </b>
                                        dalam rentang waktu yang telah ditentukan.
                                    </li>
                                </ul>
                            </li>

                            <li>
                                Urutan langkah algoritma K-Medoids adalah sebagai berikut.
                                <ol>
                                    <li>
                                        Inisialisasikan pusat cluster sebanyak jumlah cluster (k).
                                    </li>
                                    <li>
                                        Setiap data atau objek dialokasikan ke cluster terdekat dan dihitung jaraknya.
                                    </li>
                                    <li>
                                        Pilih objek pada masing-masing cluster secara acak sebagai kandidat medoid baru.
                                    </li>
                                    <li>
                                        Hitung jarak setiap objek yang terdapat pada masing-masing cluster dengan calon medoid baru.
                                    </li>
                                    <li>
                                        Hitung total simpangan (S) dengan menghitung nilai total jarak baru – total jarak lama.
                                        Jika didapatkan S < 0, tukarlah objek dengan data cluster untuk membuat sekumpulan k objek baru sebagai medoid. </li>
                                    <li>
                                        Ulangi langkah 3 sampai dengan 5 hingga tidak terjadi perubahan medoid, sehingga diperoleh cluster
                                        serta anggota cluster masing-masing.
                                    </li>
                                </ol>

                            </li>
                        </ol>

                        <!-- </p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-lg">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Tentang Tlogomart</h5>
                    </div>
                    <div class="card-body justify-content-center">
                        <!-- <h6 class="card-title">Special title treatment</h6> -->
                        <!-- <p class="card-text"> -->
                        <ol>
                            <li>
                                Tempat Belanja Keluarga
                            </li>
                            <li>
                                No telp: (0298) 3429307
                            </li>
                            <li>
                                Alamat: Jl Raya Tuntang Bringin KM. 0,5 Depan Stasiun Tuntang, Dsn Daleman, Ds. Tuntang, Kec. Tuntang, Kab. Semarang
                            </li>
                            <li>
                                Email: tlogomart@gmail.com
                            </li>


                        </ol>

                        <!-- </p> -->
                    </div>
                </div>
            </div>
            <div class="col-2">
            </div>
        </div>

        <!-- <div class="row"> -->
        <!-- /.col-md-6 -->
        <!-- <div class="col-2"></div>
            <div class="col-8">
                <div class="card card-primary card-outline"> -->
        <!-- <div class="card-header">
                        <h5 class="m-0">Featured</h5>
                    </div> -->
        <!-- <div class="card-body text-center">
                        <h6 class="card-title text-center" style="flex-direction: column; ">
                            Silakan mengklik tombol-tombol pada sidebar untuk menuju ke menu masing-masing.</h6>
                    </div>
                </div>
            </div>
            <div class="col-2"></div> -->

        <!-- /.col-md-6 -->
        <!-- </div> -->
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?= $this->endSection() ?>