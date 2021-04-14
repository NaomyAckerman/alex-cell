<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Transaksi Tgl <?= $tgl_trx; ?></h3>
        </div>
        <div class="card-body">
            <?php if (!$trx_kartu) : ?>

                <div class="col-6">
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
                    <form action="<?= route_to('transaksi-kartu-store') ?>" class="store-transaksi-kartu" method="post">
                        <?= csrf_field() ?>
                        <?php foreach ($produk_kartu as $kartu) : ?>
                            <div class="info-box mt-3">
                                <span class="info-box-icon">
                                    <?php if ($kartu->produk_gambar) : ?>
                                        <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $kartu->produk_gambar); ?>">
                                            <?= img("assets/images/products/$kartu->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                        </a>
                                    <?php else : ?>
                                        <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $kartu->produk_nama, true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                    <?php endif; ?>
                                </span>
                                <div class="info-box-content">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <label for="<?= $kartu->produk_nama; ?>"><?= $kartu->produk_nama; ?></label>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <input type="hidden" class="form-control" name="produk_id[]" value="<?= $kartu->produk_id; ?>">
                                            <input type="number" class="form-control" name="produk_sisa[]" id="<?= $kartu->produk_nama; ?>" placeholder="Masukkan sisa produk">
                                            <div id="<?= $kartu->produk_nama; ?>-err" class="invalid-feedback">
                                                Please provide a valid zip.
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">IDR <?= number_format($kartu->harga_user, 0, "", "."); ?></span>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <span class="info-box-text">Stok : <?= $kartu->stok; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        <?php endforeach ?>
                        <button type="submit" class="btn-store-transaksi-kartu btn btn-sm btn-primary m-b-10 waves-effect waves-light">Simpan</button>
                    </form>
                </div>

            <?php elseif ($data_submit) : ?>

                <h1>anda sudah submit gan</h1>

            <?php else : ?>

                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <form action="<?= route_to('transaksi-kartu'); ?>" method="post" class="mt-3">
                    <?= csrf_field(); ?>
                    <div class="col-6">
                        <?php foreach ($trx_kartu as $trx) : ?>
                            <input type="hidden" name="produk_id[]" value="<?= $trx->produk_id; ?>">
                            <input type="hidden" name="txr_kartu_qty[]" value="<?= $trx->trx_kartu_qty; ?>">
                            <p><?= $trx->produk_nama; ?></p>
                            <p><?= $trx->trx_kartu_qty; ?></p>
                            <a href="<?= route_to('transaksi-kartu-edit', $trx->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <?php endforeach ?>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>

            <?php endif; ?>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>