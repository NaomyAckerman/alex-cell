<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data <?= $title; ?> <?= (in_groups('karyawan') ? $konter->konter_nama : null) ?></h3>
            <?php if (in_groups('karyawan')) : ?>
                <!-- Button trigger modal -->
                <a href="<?= route_to('edit-stok'); ?>" class="edit-stok btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white float-right">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    Stok
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div id="content-view-stok" data-url="<?= route_to('info-stok'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal stok -->
<div id="modal-stok"></div>

<?= $this->endSection(); ?>