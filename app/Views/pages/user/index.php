<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Karyawan</h3>
            <?php if (in_groups('admin')) : ?>
                <!-- Button trigger modal -->
                <a href="<?= route_to('tambah-user'); ?>" class="tambah-user btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light float-right text-white">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    Karyawan
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div id="content-view-user" data-url="<?= route_to('info-user'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal user -->
<div id="modal-user"></div>

<?= $this->endSection(); ?>