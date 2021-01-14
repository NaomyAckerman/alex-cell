<?= $this->extend('layouts/app'); ?>

<?= $this->section('title'); ?>Home<?= $this->endSection(); ?>
<?= $this->section('content'); ?>

<h4 class="page-title">Welcome To Alex Cell <?= user()->username; ?></h4>

<?= $this->endSection(); ?>