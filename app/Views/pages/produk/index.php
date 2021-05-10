<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30 shadow">
        <div class="card-header">
            <h3 class="card-title d-inline">Data <?= $title; ?></h3>
            <!-- Button trigger modal -->
            <?php if (in_groups('admin')) : ?>
                <a href="<?= route_to('tambah-produk'); ?>" class="tambah-produk btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light float-right text-white">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    Produk
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div id="content-view-produk" data-url="<?= route_to('info-produk'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal Produk -->
<div id="modal-produk"></div>

<?= $this->endSection(); ?>