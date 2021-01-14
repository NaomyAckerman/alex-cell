<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<!-- Column -->
<div class="col-12">
    <div class="card m-b-30">
        <div class="card-body text-center">
            <?= img('assets/images/illustration/creative_team.svg', true, ['class' => 'hero-dashboard']); ?>
            <h5 class="card-title"><?= ucwords(user()->username); ?></h5>
            <p class="card-text">
                Selamat datang di sistem management penjualan kartu seluler Alex Cell <?= ucwords(user()->username); ?>.
            </p>
            <button type="button" class="btn btn-primary btn-sm">Profile</button>
        </div>
    </div>
</div>
<!-- Column -->

<?php
if (in_groups('karyawan')) {
    echo $this->include('pages/dashboard/dashboard_kry');
} elseif (in_groups('admin')) {
    echo 'ini adalah admin';
} elseif (in_groups('owner')) {
    echo 'ini adalah Owner';
}
?>

<?= $this->endSection(); ?>