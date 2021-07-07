<!-- Modal Tambah TRX ACC -->
<div class="modal fade" id="modal-tambah-trx-acc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('simpan-trx-acc') ?>" class="simpan-trx-acc" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Transaksi Aksesoris</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php foreach ($produk_acc as $acc) : ?>
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="info-box mt-3 shadow">
                                    <span class="info-box-icon">
                                        <?php if ($acc->produk_gambar) : ?>
                                            <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $acc->produk_gambar); ?>">
                                                <?= img("assets/images/products/$acc->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                            </a>
                                        <?php else : ?>
                                            <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $acc->produk_nama, true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                        <?php endif; ?>
                                    </span>
                                    <div class="info-box-content">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <label for="<?= $acc->produk_nama; ?>"><?= $acc->produk_nama; ?></label>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <span class="info-box-text">IDR <?= number_format($acc->harga_user, 0, "", "."); ?></span>
                                            </div>
                                            <div class="col-12 col-lg-5">
                                                <span class="info-box-text">Stok : <?= $acc->stok; ?></span>
                                            </div>
                                            <div class="col-12 col-lg-7">
                                                <input type="hidden" class="form-control" name="produk_id[]" value="<?= $acc->produk_id; ?>">
                                                <input type="number" class="form-control" name="produk_sisa[]" id="<?= $acc->produk_nama; ?>" placeholder="Masukkan sisa">
                                                <div id="<?= $acc->produk_nama; ?>-err" class="invalid-feedback">
                                                    Please provide a valid zip.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-simpan-trx-acc btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>