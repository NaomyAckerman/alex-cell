<?php if (session()->has('message')) : ?>
    <div class="alert alert-success">
        <?= session('message') ?>
    </div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
    <div class="login_msg" data-message="<?= esc((session('error'))); ?>" data-judul="Login" data-type="warning"></div>
<?php endif ?>
