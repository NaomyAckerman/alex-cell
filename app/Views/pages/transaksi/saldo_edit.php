<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">
    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Transaksi Saldo</h3>
        </div>
        <div class="card-body">
            <?php if (session()->has('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?php foreach (session()->getFlashdata('error') as $err) : ?>
                        <ul>
                            <li><small><?= $err; ?></small></li>
                        </ul>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
            <form action="<?= route_to('trx-saldo-update', $trx_saldo->id) ?>" class="update-transaksi-saldo" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT" />
                <div class="info-box mt-3">
                    <div class="info-box-content">
                        <div class="form-group">
                            <label for="ar-nama">Nama AR</label>
                            <input type="text" class="form-control" name="ar_nama" id="ar-nama" value="<?= $trx_saldo->ar_nama; ?>" placeholder="Masukkan nama ar">
                            <div id="ar-nama-err" class="invalid-feedback">
                                Please provide a valid zip.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ar-id">ID AR</label>
                            <input type="text" class="form-control" name="ar_id" id="ar-id" value="<?= $trx_saldo->ar_id; ?>" placeholder="Masukkan id ar">
                            <div id="ar-id-err" class="invalid-feedback">
                                Please provide a valid zip.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="saldo">Saldo</label>
                            <input type="text" class="form-control" name="saldo" id="saldo" value="<?= $trx_saldo->saldo; ?>" placeholder="Masukkan jumlah saldo">
                            <div id="saldo-err" class="invalid-feedback">
                                Please provide a valid zip.
                            </div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <a href="<?= route_to('transaksi-saldo'); ?>" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light">kembali</a>
                <button type="submit" class="btn-update-transaksi-saldo btn btn-sm btn-primary m-b-10 waves-effect waves-light">Update</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>