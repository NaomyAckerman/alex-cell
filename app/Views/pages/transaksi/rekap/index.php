<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30 shadow">
        <div class="card-header text-white bg-primary">
            <h3 class="card-title d-inline">Rekap Transaksi</h3>
        </div>
        <div class="card-body">
            <div id="content-view-trx-rekap" data-url="<?= route_to('info-trx-rekap'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>