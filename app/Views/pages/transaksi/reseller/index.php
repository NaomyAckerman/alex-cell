<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30 shadow">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Transaksi</h3>
            <!-- Button trigger modal -->
            <a href="<?= route_to('tambah-trx-reseller'); ?>" class="tambah-trx-reseller btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white float-right">
                <i class="mdi mdi-wallet-giftcard"></i>
                Tambah Tansaksi
            </a>
        </div>
        <div class="card-body">
            <div id="content-view-trx-reseller" data-url="<?= route_to('info-trx-reseller'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal trx-reseller -->
<div id="modal-trx-reseller"></div>

<?= $this->endSection(); ?>