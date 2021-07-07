<?php if ($trx && in_groups('owner')) : ?>
    <div class="col-12 mt-3">
        <a target="_blank" href="<?= route_to('report-trx', date_format($trx->created_at, 'Y-m-d'), $trx->konter_id); ?>" class="btn btn-primary btn-sm waves-effect waves-light text-white">Report</a>
    </div>
<?php endif; ?>
<div class="col-12 mt-3">
    <div class="card m-b-30 shadow">
        <h4 class="card-header mt-0 text-white bg-primary">Transaksi Kartu</h4>
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-hover table-striped text-center">
                <?php $list_total_trx_kartu = []; ?>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th>Terjual</th>
                        <th>Sisa</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($trx_kartu) : ?>
                        <?php $no = 1;
                        foreach ($trx_kartu as $kartu) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $kartu->produk_nama; ?></td>
                                <td>
                                    <?php if ($kartu->produk_gambar) : ?>
                                        <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $kartu->produk_gambar); ?>">
                                            <?= img("assets/images/products/$kartu->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'width' => '60', 'alt' => 'produk']); ?>
                                        </a>
                                    <?php else : ?>
                                        <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $kartu->produk_nama, true, ['class' => 'rounded-circle', 'width' => '60', 'alt' => 'produk']); ?>
                                    <?php endif; ?>
                                </td>
                                <td><small>IDR</small> <?= number_format($kartu->harga_user, 0, "", ".") ?></td>
                                <td><?= number_format($kartu->stok_terjual, 0, "", ".") ?> <small>pcs</small></td>
                                <td><?= number_format($kartu->trx_kartu_qty, 0, "", ".") ?> <small>pcs</small></td>
                                <td><small>IDR</small> <?= number_format(($kartu->harga_user * $kartu->stok_terjual), 0, "", ".") ?></td>
                            </tr>
                            <?php array_push($list_total_trx_kartu, ($kartu->harga_user * $kartu->stok_terjual)) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <h5 class="mt-0 round-inner my-3 font-16 font-weight-bold"><small>Total TRX Kartu : IDR </small><?= number_format(array_sum($list_total_trx_kartu), 0, "", ".") ?></h5>
            </table>
        </div>
    </div>
</div>
<div class="col-12 mt-3">
    <div class="card m-b-30 shadow">
        <h4 class="card-header mt-0 text-white bg-primary">Transaksi Aksesoris</h4>
        <div class="card-body">
            <table id="datatable2" class="table table-bordered table-hover table-striped text-center">
                <?php $list_total_trx_acc = []; ?>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th>Terjual</th>
                        <th>Sisa</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($trx_acc) : ?>
                        <?php $no = 1;
                        foreach ($trx_acc as $acc) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $acc->produk_nama; ?></td>
                                <td>
                                    <?php if ($acc->produk_gambar) : ?>
                                        <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $acc->produk_gambar); ?>">
                                            <?= img("assets/images/products/$acc->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'width' => '60', 'alt' => 'produk']); ?>
                                        </a>
                                    <?php else : ?>
                                        <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $acc->produk_nama, true, ['class' => 'rounded-circle', 'width' => '60', 'alt' => 'produk']); ?>
                                    <?php endif; ?>
                                </td>
                                <td><small>IDR</small> <?= number_format($acc->harga_user, 0, "", ".") ?></td>
                                <td><?= number_format($acc->stok_terjual, 0, "", ".") ?> <small>pcs</small></td>
                                <td><?= number_format($acc->trx_acc_qty, 0, "", ".") ?> <small>pcs</small></td>
                                <td><small>IDR</small> <?= number_format(($acc->harga_user * $acc->stok_terjual), 0, "", ".") ?></td>
                            </tr>
                            <?php array_push($list_total_trx_acc, ($acc->harga_user * $acc->stok_terjual)) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <h5 class="mt-0 round-inner my-3 font-16 font-weight-bold"><small>Total TRX Aksesoris : IDR </small><?= number_format(array_sum($list_total_trx_acc), 0, "", ".") ?></h5>
            </table>
        </div>
    </div>
</div>
<div class="col-6 mt-3">
    <div class="card m-b-30 shadow">
        <h4 class="card-header mt-0 text-white bg-primary">Transaksi Saldo</h4>
        <div class="card-body">
            <?php if ($trx_saldo) : ?>
                <?php $list_total_trx_saldo = []; ?>
                <?php foreach ($trx_saldo as $saldo) : ?>
                    <div class="card m-b-30 shadow">
                        <div class="card-body">
                            <h4 class="card-title mt-0"><?= $saldo->ar_nama ?></h4>
                            <h5 class="mt-0 font-18 round-inner"><small>ID : </small><?= $saldo->ar_id ?></h5>
                            <p class="mb-0 font-16 font-weight-bold text-muted"><small>Saldo : IDR</small> <?= number_format($saldo->saldo, 0, "", ".") ?></p>
                        </div>
                    </div>
                    <?php array_push($list_total_trx_saldo, $saldo->saldo) ?>
                <?php endforeach ?>
                <hr>
                <h5 class="mt-0 round-inner font-16 font-weight-bold"><small>Total Saldo : IDR</small> <?= number_format(array_sum($list_total_trx_saldo), 0, "", ".") ?></h5>
            <?php else : ?>
                <div class="col-12 text-center">
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Tidak ada transaksi!</strong> pada hari tersebut.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-6 mt-3">
    <div class="card m-b-30 shadow">
        <h4 class="card-header mt-0 text-white bg-primary">Transaksi Reseller</h4>
        <div class="card-body">
            <?php if ($trx_reseller) : ?>
                <?php
                $list_nama = [];
                $list_total_trx_reseller = [];
                $list_total_per_reseller = [];
                ?>
                <?php foreach ($trx_reseller as $reseller) : ?>

                    <?php if (!in_array($reseller->reseller, $list_nama)) : ?>
                        <div class="card m-b-30 shadow">
                            <h4 class="card-header font-20 mt-0 text-white bg-primary"><?= $reseller->reseller; ?></h4>
                            <div class="card-body">
                                <?php foreach ($trx_reseller as $reseller2) : ?>
                                    <?php if ($reseller2->reseller == $reseller->reseller) : ?>
                                        <p class="card-text">
                                            <small class="text-muted font-14">Produk : <?= $reseller2->produk_nama; ?></small>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted font-14">Jumlah : <?= number_format($reseller2->trx_partai_qty, 0, "", "."); ?></small>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted font-14">harga : IDR <?= number_format($reseller2->harga_partai, 0, "", "."); ?></small>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted font-14">Total : IDR <?= number_format($reseller2->trx_partai_qty * $reseller2->harga_partai, 0, "", "."); ?></small>
                                        </p>
                                        <hr>
                                        <?php array_push($list_total_per_reseller, ($reseller2->trx_partai_qty * $reseller2->harga_partai)) ?>
                                        <?php array_push($list_total_trx_reseller, ($reseller2->trx_partai_qty * $reseller2->harga_partai)) ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <p class="card-text">
                                    <small class="font-16 font-weight-bold text-muted"><small>Total Transaksi : IDR </small><?= number_format(array_sum($list_total_per_reseller), 0, "", "."); ?></small>
                                </p>
                            </div>
                            <?php $list_total_per_reseller = []; ?>
                        </div>
                    <?php endif; ?>
                    <?php array_push($list_nama, $reseller->reseller); ?>

                <?php endforeach; ?>
                <hr>
                <h5 class="mt-0 round-inner font-16 font-weight-bold"><small>Total Reseller : IDR </small><?= number_format(array_sum($list_total_trx_reseller), 0, "", ".") ?></h5>
            <?php else : ?>
                <div class="col-12 text-center">
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Tidak ada transaksi!</strong> pada hari tersebut.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-12 mt-3">
    <div class="card m-b-30 mt-4 shadow">
        <h4 class="card-header mt-0 text-white bg-primary">Hasil Transaksi</h4>
        <div class="card-body">
            <div class="row">
                <?php if ($trx) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Pengeluaran</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_keluar, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Modal</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_modal, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Kartu</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_kartu, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Aksesoris</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_acc, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Reseller</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_partai, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Saldo</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_saldo, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Pulsa</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_pulsa, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Transaksi Tunai</h4>
                            <p class="font-16 font-weight-bold py-2 badge badge-primary">IDR <?= number_format($trx->total_tunai, 0, "", "."); ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 card-body shadow">
                            <h4 class="card-title font-20 mt-0">Rekap Transaksi</h4>
                            <p class="font-16 font-weight-bold py-2 badge <?= (($trx->total_tunai - $trx->total_trx) < 0) ? 'badge-danger' : 'badge-primary'; ?>">IDR <?= number_format(($trx->total_tunai - $trx->total_trx), 0, "", "."); ?></p>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Tidak ada transaksi!</strong> pada hari tersebut.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>