<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">
    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Transaksi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if (!$status_submit) : ?>
                    <div class="col-6">
                        <h5 class="mb-3">Transaksi Baru</h5>
                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <?= session()->getFlashdata('errors'); ?>
                            </div>
                        <?php endif; ?>
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
                        <?php if (session()->has('success')) : ?>
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <?= session()->getFlashdata('success'); ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?= route_to('trx-saldo-store') ?>" class="simpan-trx_saldo" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="ar-id">ID AR</label>
                                <input type="text" class="form-control" name="ar_id" id="ar-id" placeholder="Masukkan ID AR">
                                <div id="ar-id-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ar_nama">Nama</label>
                                <input type="text" class="form-control" name="ar_nama" id="ar-nama" placeholder="Masukkan nama">
                                <div id="ar-nama-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="saldo">Saldo</label>
                                <input type="number" class="form-control" name="saldo" id="saldo" placeholder="Masukkan jumlah saldo">
                                <div id="saldo-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <button type="submit" class="btn-simpan-trx-saldo btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light">Simpan</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <h5 class="mb-3">Tansaksi</h5>
                        <?php if ($trx_saldo) : ?>
                            <?php $list_trx_saldo = []; ?>
                            <?php foreach ($trx_saldo as $trx) : ?>
                                <div class="card m-b-30 card-body">
                                    <h4 class="card-title font-20 mt-0"><?= $trx->ar_nama; ?></h4>
                                    <p class="card-text"><?= $trx->ar_id; ?></p>
                                    <p class="card-text">
                                        <small class="text-muted">Saldo <?= $trx->saldo; ?></small>
                                    </p>
                                    <a href="<?= route_to('trx-saldo-edit', $trx->id); ?>" class="btn btn-sm btn-warning">
                                        edit</a>
                                    <form action="<?= route_to('trx-saldo-delete', $trx->id) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger btn-block">Hapus</button>
                                    </form>
                                </div>
                                <?php array_push($list_trx_saldo, $trx->saldo) ?>
                            <?php endforeach; ?>
                            <form action="<?= route_to('transaksi-saldo') ?>" class="submit-transaksi-saldo" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="total_trx_saldo" value="<?= array_sum($list_trx_saldo); ?>" />
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        <?php else : ?>

                            <h6>belum ada transaksi</h6>

                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <h1>anda sudah submit gan</h1>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>