<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data <?= $title; ?></h3>
            <!-- Button trigger modal -->
            <a href="<?= route_to('tambah-konter'); ?>" class="tambah-konter btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white float-right">
                <i class="mdi mdi-home"></i>
                Konter
            </a>
        </div>
        <div class="card-body">
            <div id="content-view-konter" data-url="<?= route_to('info-konter'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal Produk -->
<div id="modal-konter"></div>

<?= $this->endSection(); ?>