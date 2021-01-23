<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title">Data Produk</h3>
        </div>
        <div class="card-body">
            <div id="content-view-produk" data-url="<?= base_url('get-produk'); ?>"></div>
        </div>
    </div>

    <!-- end row -->
</div>

<?= $this->endSection(); ?>