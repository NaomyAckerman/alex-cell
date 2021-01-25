<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Produk</h3>
            <!-- Button trigger modal -->
            <a href="<?= base_url('create-produk'); ?>" id="tambah-produk" class="btn btn-primary btn-sm float-right">Produk</a>
        </div>
        <div class="card-body">
            <div id="content-view-produk" data-url="<?= base_url('get-produk'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<!-- Modal Produk -->
<div id="modal-produk"></div>

<?= $this->endSection(); ?>