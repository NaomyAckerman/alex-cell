<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">
    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Transaksi <?= $trx_kartu->produk_nama; ?></h3>
        </div>
        <div class="card-body">
            <?php if (session()->has('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?php foreach (session()->getFlashdata('error') as $err) : ?>
                        <?= $err; ?>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
            <?php if (session()->has('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <?= session()->getFlashdata('errors'); ?>
                </div>
            <?php endif; ?>
            <form action="<?= route_to('transaksi-kartu-update', $trx_kartu->id) ?>" class="update-transaksi-kartu" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT" />
                <div class="info-box mt-3">
                    <span class="info-box-icon">
                        <?php if ($trx_kartu->produk_gambar) : ?>
                            <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $trx_kartu->produk_gambar); ?>">
                                <?= img("assets/images/products/$trx_kartu->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                            </a>
                        <?php else : ?>
                            <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $trx_kartu->produk_nama, true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                        <?php endif; ?>
                    </span>
                    <div class="info-box-content">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label for="<?= $trx_kartu->produk_nama; ?>"><?= $trx_kartu->produk_nama; ?></label>
                            </div>
                            <div class="col-12 col-lg-8">
                                <input type="number" class="form-control" name="trx_kartu_qty" id="<?= $trx_kartu->produk_nama; ?>" value="<?= $trx_kartu->trx_kartu_qty; ?>" placeholder="Masukkan sisa produk">
                                <div id="<?= $trx_kartu->produk_nama; ?>-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <span class="info-box-text">IDR <?= number_format($trx_kartu->harga_user, 0, "", "."); ?></span>
                            </div>
                            <div class="col-12 col-lg-6">
                                <span class="info-box-text">Stok : <?= $trx_kartu->stok; ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <a href="<?= route_to('transaksi-kartu'); ?>" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light">kembali</a>
                <button type="submit" class="btn-update-transaksi-kartu btn btn-sm btn-primary m-b-10 waves-effect waves-light">Update</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>