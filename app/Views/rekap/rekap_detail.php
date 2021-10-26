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
                <div class="card collapsed-card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"> Rekap Data <?php echo "ID data yang ditampilin di page ini= " . $penjualan_id; ?> </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                       
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