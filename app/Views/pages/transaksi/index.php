<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30">
        <div class="card-header">
            <h3 class="card-title d-inline">Data Transaksi</h3>
        </div>
        <div class="card-body">
            <?php if ($status_submit) : ?>
                <h1>Transaksi telah selesai gan</h1>
            <?php else : ?>
                <form action="<?= route_to('trx-rekap') ?>" class="update-trx-rekap" method="post">
                    <?= csrf_field() ?>
                    <div class="info-box mt-3">
                        <div class="info-box-content">
                            <div class="form-group">
                                <label for="total-pulsa">Total trx Pulsa</label>
                                <input type="number" class="form-control" name="total_pulsa" id="total-pulsa" placeholder="Masukkan total trx pulsa">
                                <div id="total-pulsa-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="total-tunai">Total uang trx</label>
                                <input type="number" class="form-control" name="total_tunai" id="total-tunai" placeholder="Masukkan total uang trx">
                                <div id="total-tunai-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="total-keluar">Total pengeluaran</label>
                                <input type="number" class="form-control" name="total_keluar" id="total-keluar" placeholder="Masukkan total pengeluaran">
                                <div id="total-keluar-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="total-modal">Total modal</label>
                                <input type="number" class="form-control" name="total_modal" id="total-modal" placeholder="Masukkan total modal">
                                <div id="total-modal-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <button type="submit" class="btn-update-transaksi-rekap btn btn-sm btn-primary m-b-10 waves-effect waves-light">Submit</button>
                </form>
            <?php endif; ?>
            <div class="row mt-3">
                <div class="col-6 mt-3">
                    <div class="card m-b-30">
                        <h4 class="card-header mt-0">Transaksi Kartu</h4>
                        <div class="card-body">
                            <?php $list_total_trx_kartu = []; ?>
                            <?php foreach ($trx_kartu as $kartu) : ?>
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="card-title font-20 mt-0"><?= $kartu->produk_nama; ?></h4>
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <?php if ($kartu->produk_gambar) : ?>
                                                    <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $kartu->produk_gambar); ?>">
                                                        <?= img("assets/images/products/$kartu->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $kartu->produk_nama, true, ['class' => 'rounded-circle', 'width' => '60', 'alt' => 'produk']); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-6 align-self-center text-center">
                                                <div class="m-l-10">
                                                    <h5 class="mt-0 round-inner"></h5>
                                                    <h5 class="mt-0 round-inner"><small>IDR</small> <?= $kartu->harga_user ?></h5>
                                                    <p class="mb-0 text-muted"><small>Jumlah</small> <?= $kartu->trx_kartu_qty ?></p>
                                                </div>
                                            </div>
                                            <div class="col-3 align-self-end align-self-right">
                                                <p class="mb-0 text-muted"><small>Sisa</small> <?= $kartu->trx_kartu_qty ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="mt-0 round-inner"><small>Total : IDR</small> <?= ($kartu->harga_user * $kartu->trx_kartu_qty) ?></h5>
                                    </div>
                                </div>
                                <?php array_push($list_total_trx_kartu, ($kartu->harga_user * $kartu->trx_kartu_qty)) ?>
                            <?php endforeach ?>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Total TRX Kartu: IDR</small> <?= array_sum($list_total_trx_kartu) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card m-b-30">
                        <h4 class="card-header mt-0">Transaksi Acc</h4>
                        <div class="card-body">
                            <?php $list_total_trx_acc = []; ?>
                            <?php foreach ($trx_acc as $acc) : ?>
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="card-title font-20 mt-0"><?= $acc->produk_nama; ?></h4>
                                        <div class="d-flex flex-row">
                                            <div class="col-3 align-self-center">
                                                <?php if ($acc->produk_gambar) : ?>
                                                    <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $acc->produk_gambar); ?>">
                                                        <?= img("assets/images/products/$acc->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $acc->produk_nama, true, ['class' => 'rounded-circle', 'width' => '60', 'alt' => 'produk']); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-6 align-self-center text-center">
                                                <div class="m-l-10">
                                                    <h5 class="mt-0 round-inner"></h5>
                                                    <h5 class="mt-0 round-inner"><small>IDR</small> <?= $acc->harga_user ?></h5>
                                                    <p class="mb-0 text-muted"><small>Jumlah</small> <?= $acc->trx_acc_qty ?></p>
                                                </div>
                                            </div>
                                            <div class="col-3 align-self-end align-self-right">
                                                <p class="mb-0 text-muted"><small>Sisa</small> <?= $acc->trx_acc_qty ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="mt-0 round-inner"><small>Total : IDR</small> <?= ($acc->harga_user * $acc->trx_acc_qty) ?></h5>
                                    </div>
                                </div>
                                <?php array_push($list_total_trx_acc, ($acc->harga_user * $acc->trx_acc_qty)) ?>
                            <?php endforeach ?>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Total TRX Acc: IDR</small> <?= array_sum($list_total_trx_acc) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card m-b-30">
                        <h4 class="card-header mt-0">Transaksi Saldo</h4>
                        <div class="card-body">
                            <?php $list_total_trx_saldo = []; ?>
                            <?php foreach ($trx_saldo as $saldo) : ?>
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="card-title font-20 mt-0"><?= $saldo->ar_id ?></h4>
                                        <h5 class="mt-0 round-inner"><small>IDR</small> <?= $saldo->ar_nama ?></h5>
                                        <p class="mb-0 text-muted"><small>Jumlah</small> <?= $saldo->saldo ?></p>
                                    </div>
                                </div>
                                <?php array_push($list_total_trx_saldo, $saldo->saldo) ?>
                            <?php endforeach ?>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Total TRX Saldo: IDR</small> <?= array_sum($list_total_trx_saldo) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card m-b-30">
                        <h4 class="card-header mt-0">Transaksi Reseller</h4>
                        <div class="card-body">
                            <?php
                            $list_nama = [];
                            $list_total_trx_reseller = [];
                            $list_total_per_reseller = [];
                            ?>
                            <?php foreach ($trx_reseller as $reseller) : ?>

                                <?php if (!in_array($reseller->reseller, $list_nama)) : ?>
                                    <div class="card m-b-30 card-body">
                                        <h4 class="card-title font-20 mt-0"><?= $reseller->reseller; ?></h4>
                                        <?php foreach ($trx_reseller as $reseller2) : ?>
                                            <?php if ($reseller2->reseller == $reseller->reseller) : ?>
                                                <hr>
                                                <p class="card-text">
                                                    <small class="text-muted">Nama Produk : <?= $reseller2->produk_nama; ?></small>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">Jumlah : <?= $reseller2->trx_partai_qty; ?></small>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">harga : <?= $reseller2->harga_partai; ?></small>
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">Total : <?= $reseller2->trx_partai_qty * $reseller2->harga_partai; ?></small>
                                                </p>
                                                <?php array_push($list_total_per_reseller, ($reseller2->trx_partai_qty * $reseller2->harga_partai)) ?>
                                                <?php array_push($list_total_trx_reseller, ($reseller2->trx_partai_qty * $reseller2->harga_partai)) ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                        <hr>
                                        <p class="card-text">
                                            <small class="text-danger">Total Transaksi : <?= array_sum($list_total_per_reseller); ?></small>
                                        </p>
                                        <?php $list_total_per_reseller = []; ?>
                                    </div>
                                <?php endif; ?>
                                <?php array_push($list_nama, $reseller->reseller); ?>

                            <?php endforeach; ?>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Total TRX Reseller: IDR</small> <?= array_sum($list_total_trx_reseller) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="card m-b-30">
                        <?php $list_total_trx_global = $trx ? [$trx->total_keluar, $trx->total_modal, $trx->total_pulsa, $trx->total_tunai] : []; ?>
                        <h4 class="card-header mt-0">Hasil Transaksi</h4>
                        <div class="card-body">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <h5 class="mt-0 round-inner"><small>Total Pengeluaran</small> <?= $trx ? $trx->total_keluar : '0'; ?></h5>
                                    <h5 class="mt-0 round-inner"><small>Total Modal</small> <?= $trx ? $trx->total_modal : '0'; ?></h5>
                                    <h5 class="mt-0 round-inner"><small>Total trx Pulsa</small> <?= $trx ? $trx->total_pulsa : '0'; ?></h5>
                                    <h5 class="mt-0 round-inner"><small>Total Uang trx</small> <?= $trx ? $trx->total_tunai : '0'; ?></h5>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Hasil TRX : IDR</small> <?= array_sum(array_merge($list_total_trx_kartu, $list_total_trx_reseller, $list_total_trx_acc, $list_total_trx_saldo, $list_total_trx_global)) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>