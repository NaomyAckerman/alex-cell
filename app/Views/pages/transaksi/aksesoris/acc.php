<div class="row">
    <?php if (!$status_submit) : ?>
        <?php if ($trx_acc) : ?>
            <div class="col-12">
                <form action="<?= route_to('submit-trx-acc'); ?>" method="post" class="submit-trx-acc mt-3">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <?php foreach ($trx_acc as $trx) : ?>
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="produk_id[]" value="<?= $trx->produk_id; ?>">
                                <input type="hidden" name="txr_acc_qty[]" value="<?= $trx->trx_acc_qty; ?>">
                                <div class="info-box mt-3 shadow">
                                    <span class="info-box-icon">
                                        <?php if ($trx->produk_gambar) : ?>
                                            <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $trx->produk_gambar); ?>">
                                                <?= img("assets/images/products/$trx->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                            </a>
                                        <?php else : ?>
                                            <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $trx->produk_nama, true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                        <?php endif; ?>
                                    </span>
                                    <div class="info-box-content">
                                        <div class="row">
                                            <div class="col-6 col-lg-6">
                                                <label for="<?= $trx->produk_nama; ?>"><?= $trx->produk_nama; ?></label>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <span class="info-box-text">Sisa : <?= $trx->trx_acc_qty; ?></span>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <span class="info-box-text">IDR <?= number_format($trx->harga_user, 0, "", "."); ?></span>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <a href="<?= route_to('edit-trx-acc', $trx->id); ?>" class="edit-trx-acc btn btn-warning btn-sm waves-effect waves-light text-white">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <button type="submit" class="btn-submit-trx-acc btn btn-sm btn-primary waves-effect waves-light text-white">Submit</button>
                </form>
            </div>
        <?php else : ?>
            <div class="col-md-12">
                <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Tidak ada transaksi hari ini!</strong> Silahkan melakukan transaksi.
                </div>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Transaksi selesai!</strong> Terima kasih sampai jumpa besok.
            </div>
        </div>
    <?php endif; ?>
</div>