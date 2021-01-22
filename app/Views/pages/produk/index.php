<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title">DataTable with minimal features & hover style</h3>
        </div>
        <div class="card-body">
            <h4 class="mt-0 header-title">Default Datatable</h4>
            <div id="content-view-produk" data-url="<?= base_url('get-produk'); ?>"></div>
        </div>
    </div>

    <!-- end row -->
</div>

<?= $this->endSection(); ?>