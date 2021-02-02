<?= $this->extend('layouts/auth'); ?>

<?= $this->section('content'); ?>

<form class="form-horizontal m-t-20" action="<?= route_to('login') ?>" method="post">

    <?= csrf_field() ?>

    <?php if ($config->validFields === ['email']) : ?>
        <div class="form-group row">
            <div class="col-12">
                <input class="form-control<?= (session('errors.login')) ? ' is-invalid' : '' ?>" name="login" type="text" value="<?= old('login') ?>" placeholder="<?= lang('Auth.email') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.login') ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="form-group row">
            <div class="col-12">
                <input class="form-control<?= (session('errors.login')) ? ' is-invalid' : '' ?>" name="login" type="text" value="<?= old('login') ?>" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.login') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group row">
        <div class="col-12">
            <input class="form-control<?= (session('errors.password')) ? ' is-invalid' : '' ?>" type="password" name="password" value="<?= old('password') ?>" placeholder="<?= lang('Auth.password') ?>">
            <div class="invalid-feedback">
                <?= session('errors.password') ?>
            </div>
        </div>
    </div>

    <?php if ($config->allowRemembering) : ?>
        <div class="form-group row">
            <div class="col-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" <?= (old('remember')) ? 'checked' : '' ?> class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1"><?= lang('Auth.rememberMe') ?></label>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group text-center row m-t-20">
        <div class="col-12">
            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit"><?= lang('Auth.loginAction') ?></button>
        </div>
    </div>

    <div class="form-group m-t-10 mb-0 row">
        <div class="col-sm-7 m-t-20">
            <?php if ($config->activeResetter) : ?>
                <a href="<?= route_to('forgot') ?>" class="text-muted"><i class="mdi mdi-account-circle"></i> <small><?= lang('Auth.forgotYourPassword') ?></small></a>
            <?php endif; ?>
        </div>
        <div class="col-sm-5 m-t-20">
            <?php if ($config->allowRegistration) : ?>
                <a href="<?= route_to('register') ?>" class="text-muted"><i class="mdi mdi-lock"></i> <small><?= lang('Auth.needAnAccount') ?></small></a>
            <?php endif; ?>
        </div>
    </div>
</form>

<?= $this->endSection(); ?>