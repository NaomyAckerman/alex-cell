<?php if (in_groups('karyawan')) : ?>
    <!-- Stok Konter -->
    <div class="row">
        <div class="col-6">
            <div class="card my-3">
                <h4 class="card-header mt-0">Stok Kartu</h4>
                <?php foreach ($stok_kartu as $kartu) : ?>
                    <div class="col-12">
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
                                    <div class="col-12 col-lg-6">
                                        <span class="info-box-text"><?= $kartu->produk_nama; ?></span>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <span class="info-box-text">Stok : <?= $kartu->stok; ?></span>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <span class="info-box-text">IDR <?= number_format($kartu->harga_user, 0, "", "."); ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endforeach ?>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-6">
            <div class="card my-3">
                <h4 class="card-header mt-0">Stok Acc</h4>
                <?php foreach ($stok_acc as $acc) : ?>
                    <div class="col-12">
                        <div class="info-box mt-3">
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
                                        <span class="info-box-text"><?= $acc->produk_nama; ?></span>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <span class="info-box-text">Stok : <?= $acc->stok; ?></span>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <span class="info-box-text">IDR <?= number_format($acc->harga_user, 0, "", "."); ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endforeach ?>
            </div>
            <!-- /.card -->
        </div>
    </div>
<?php else : ?>
    <!-- Stok Global -->
    <form action="<?= route_to('info-stok') ?>" class="form-info-stok my-3 row" method="post">
        <?= csrf_field() ?>
        <div class="col-6">
            <div class="form-group">
                <select class="custom-select select2" name="konter_id" id="konter-id">
                    <option selected disabled>Pilih Konter</option>
                    <?php foreach ($konter as $k) : ?>
                        <option value="<?= $k->id; ?>"><?= $k->konter_nama; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <button type="submit" class="btn-info-stok btn btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Cari</button>
        </div>
    </form>

    <div class="row">
        <div class="col-6">
            <div class="card shadow">
                <h4 class="card-header mt-0 text-white bg-primary">Stok Kartu</h4>
                <div id="info-stok-kartu">
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Data tidak ada!</strong> Silahkan pilih konter untuk mencari data.
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-6">
            <div class="card shadow">
                <h4 class="card-header mt-0 text-white bg-primary">Stok Acc</h4>
                <div id="info-stok-acc">
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Data tidak ada!</strong> Silahkan pilih konter untuk mencari data.
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
<?php endif; ?>