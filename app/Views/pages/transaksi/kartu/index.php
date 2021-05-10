<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30 shadow">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Transaksi</h3>
            <!-- Button trigger modal -->
            <a href="<?= route_to('tambah-trx-kartu'); ?>" class="tambah-trx-kartu btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white float-right">
                <i class="mdi mdi-wallet-giftcard"></i>
                Tambah Tansaksi
            </a>
        </div>
        <div class="card-body">
            <div id="content-view-trx-kartu" data-url="<?= route_to('info-trx-kartu'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal trx-kartu -->
<div id="modal-trx-kartu"></div>

<?= $this->endSection(); ?>