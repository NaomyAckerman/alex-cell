<?= $this->extend('layouts/auth'); ?>

<?= $this->section('content'); ?>

<?= $this->include('components/msg_block'); ?>

<h2 class="card-header"><?= lang('Auth.resetYourPassword') ?></h2>
<div class="card-body">

    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <p><?= lang('Auth.enterCodeEmailPassword') ?></p>
    </div>

    <form action="<?= route_to('reset-password') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="token"><?= lang('Auth.token') ?></label>
            <input type="text" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" name="token" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>">
            <div class="invalid-feedback">
                <?= session('errors.token') ?>
            </div>
        </div>

        <div class="form-group">
            <label for="email"><?= lang('Auth.email') ?></label>
            <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
            <div class="invalid-feedback">
                <?= session('errors.email') ?>
            </div>
        </div>

        <br>

        <div class="form-group">
            <label for="password"><?= lang('Auth.newPassword') ?></label>
            <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password">
            <div class="invalid-feedback">
                <?= session('errors.password') ?>
            </div>
        </div>

        <div class="form-group">
            <label for="pass_confirm"><?= lang('Auth.newPasswordRepeat') ?></label>
            <input type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" name="pass_confirm">
            <div class="invalid-feedback">
                <?= session('errors.pass_confirm') ?>
            </div>
        </div>

        <br>

        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.resetPassword') ?></button>
    </form>

</div>

<?= $this->endSection(); ?>