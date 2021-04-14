<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">
    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Transaksi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if ($status_submit) : ?>
                    <h1>anda sudah submit gan</h1>
                <?php else : ?>
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
                        <form action="<?= route_to('transaksi-reseller-store') ?>" class="simpan-transaksi_reseller" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="reseller">Reseller</label>
                                <input type="text" class="form-control" name="reseller" id="reseller" placeholder="Masukkan nama reseller">
                                <div id="reseller-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="produk-id">Produk</label>
                                <select class="custom-select select2" name="produk_id" id="produk-id">
                                    <option selected disabled>Pilih produk</option>
                                    <?php foreach ($produk as $item) : ?>
                                        <option value="<?= $item->id; ?>"><?= $item->produk_nama; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="produk-id-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="trx-partai-qty">Jumlah</label>
                                <input type="number" class="form-control" name="trx_partai_qty" id="trx-partai-qty" placeholder="Masukkan jumlah">
                                <div id="trx-partai-qty-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <button type="submit" class="btn-simpan-konter btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light">Simpan</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <h5 class="mb-3">Tansaksi</h5>
                        <?php if ($trx_reseller) : ?>

                            <?php
                            $list_nama = [];
                            $list_total = [];
                            $list_total_per_reseller = [];
                            ?>
                            <?php foreach ($trx_reseller as $trx) : ?>

                                <?php if (!in_array($trx->reseller, $list_nama)) : ?>
                                    <div class="card m-b-30 card-body">
                                        <h4 class="card-title font-20 mt-0"><?= $trx->reseller; ?></h4>
                                        <?php foreach ($trx_reseller as $trx2) : ?>
                                            <?php if ($trx2->reseller == $trx->reseller) : ?>
                                                <hr>
                                                <p class="card-text">
                                                    <small class="text-muted">Nama Produk : <?= $trx2->produk_nama; ?></small>
                                                <form action="<?= route_to('transaksi-reseller-hapus', $trx2->id) ?>" class="hapus-transaksi-reseller" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="produk_id" value="<?= $trx2->produk_id; ?>" />
                                                    <input type="hidden" name="qty" value="<?= $trx2->trx_partai_qty; ?>" />
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">Jumlah : <?= $trx2->trx_partai_qty; ?></small>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">harga : <?= $trx2->harga_partai; ?></small>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">Total : <?= $trx2->trx_partai_qty * $trx2->harga_partai; ?></small>
                                                </p>
                                                <?php array_push($list_total_per_reseller, ($trx2->trx_partai_qty * $trx2->harga_partai)) ?>
                                                <?php array_push($list_total, ($trx2->trx_partai_qty * $trx2->harga_partai)) ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                        <hr>
                                        <p class="card-text">
                                            <small class="text-danger">Total Transaksi : <?= array_sum($list_total_per_reseller); ?></small>
                                        </p>
                                        <?php $list_total_per_reseller = []; ?>
                                    </div>
                                <?php endif; ?>
                                <?php array_push($list_nama, $trx->reseller); ?>

                            <?php endforeach; ?>

                            <form action="<?= route_to('transaksi-reseller') ?>" class="submit-transaksi-reseller" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="total_trx_reseller" value="<?= array_sum($list_total); ?>" />
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>

                        <?php else : ?>

                            <h6>belum ada transaksi</h6>

                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>