<?= $this->extend('layouts/auth'); ?>

<?= $this->section('content'); ?>

<?= $this->include('components/msg_block'); ?>

<h2 class="card-title text-center"><?= lang('Auth.forgotPassword') ?></h2>
<form class="form-horizontal" action="<?= route_to('forgot') ?>" method="post">
    <?= csrf_field() ?>
    <!-- <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Enter your <b>Email</b> and instructions will be sent to you!
    </div> -->
    <p class="mb-3"><?= lang('Auth.enterEmailForInstructions') ?></p>

    <div class="form-group">
        <div class="col-xs-12">
            <input class="form-control<?= ((session('errors.email'))) ? ' is-invalid' : '' ?>" type="text" name="email" value="<?= old('email') ?>" placeholder="<?= lang('Auth.email') ?>">
            <div class="invalid-feedback">
                <?= session('errors.email') ?>
            </div>
        </div>
    </div>

    <div class="form-group text-center row m-t-20">
        <div class="col-12">
            <button class="btn btn-danger btn-block waves-effect waves-light" type="submit"><?= lang('Auth.sendInstructions') ?></button>
        </div>
    </div>

</form>

<?= $this->endSection(); ?>