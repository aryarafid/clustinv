<!-- konten Rekap detail 1 id -->
<?php

use App\Controllers\Rekap_data;

$session = session()
?>
<?= $this->extend('template/web_frame') ?>

<?= $this->section('content') ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg">

                <div class="row">
                    <a href="<?= base_url() . "/Rekap_data"; ?>">
                        <button type="button" class="btn btn-primary">
                            << Kembali </button>
                    </a>

                </div>
                <br>

                <div class="card card-primary card-outline">
                    <!-- <div class="card-header">
                    <div class="col-12 col-sm-6"> -->
                    <div class="card-header p-0 border-bottom-0">

                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" 
                                role="tab" aria-controls="nav-home" aria-selected="true">Full Data</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" 
                                role="tab" aria-controls="nav-profile" aria-selected="false">1</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" 
                                role="tab" aria-controls="nav-contact" aria-selected="false">2</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" 
                                role="tab" aria-controls="nav-contact" aria-selected="false">3</a>
                        </div>
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>


                    </div>

                    <script>
                        $(document).ready(function() {
                            $(".nav-tabs a").click(function() {
                                $(this).tab('show');
                            });
                        });
                    </script>

                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <?= $this->endSection() ?>