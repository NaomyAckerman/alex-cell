<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Profile <?= ucwords($user); ?></h3>
        </div>
        <div class="card-body">
            <div id="content-view-profile" data-url="<?= route_to('info-profile'); ?>"></div>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>