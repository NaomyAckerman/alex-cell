<?php if ($status_submit) : ?>
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Transaksi selesai!</strong> Terima kasih sampai jumpa besok.
            </div>
        </div>
    </div>
<?php else : ?>
    <form action="<?= route_to('submit-trx-rekap') ?>" class="submit-trx-rekap" method="post">
        <?= csrf_field() ?>
        <div class="info-box mt-3 shadow">
            <div class="info-box-content">
                <div class="form-group">
                    <label for="total-modal">Total modal</label>
                    <input type="number" class="form-control" name="total_modal" id="total-modal" placeholder="Masukkan total modal">
                    <div id="total-modal-err" class="invalid-feedback">
                        Please provide a valid zip.
                    </div>
                </div>
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
                <button type="submit" class="w-25 btn-submit-trx-rekap btn btn-sm btn-primary m-b-10 waves-effect waves-light text-white">Submit</button>
            </div>
            <!-- /.info-box-content -->
        </div>
    </form>
<?php endif; ?>
<div class="row mt-3">
    <div class="col-12 mt-3">
        <div class="card m-b-30 shadow">
            <h4 class="card-header mt-0 text-white bg-primary">Transaksi Kartu</h4>
            <div class="card-body">
                <table id="datatable-rekap-kartu" class="table table-bordered table-hover table-striped text-center">
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
                                    <td><small>IDR</small> <?= number_format($kartu->stok_terjual, 0, "", ".") ?></td>
                                    <td><small>IDR</small> <?= number_format($kartu->trx_kartu_qty, 0, "", ".") ?></td>
                                    <td><small>IDR</small> <?= number_format(($kartu->harga_user * $kartu->stok_terjual), 0, "", ".") ?></td>
                                </tr>
                                <?php array_push($list_total_trx_kartu, ($kartu->harga_user * $kartu->stok_terjual)) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <h5 class="mt-0 round-inner my-3 font-16 font-weight-bold"><small>Total TRX Kartu: IDR </small><?= number_format(array_sum($list_total_trx_kartu), 0, "", ".") ?></h5>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card m-b-30 shadow">
            <h4 class="card-header mt-0 text-white bg-primary">Transaksi Aksesoris</h4>
            <div class="card-body">
                <table id="datatable-rekap-acc" class="table table-bordered table-hover table-striped text-center">
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
                                    <td><small>IDR</small> <?= number_format($acc->stok_terjual, 0, "", ".") ?></td>
                                    <td><small>IDR</small> <?= number_format($acc->trx_acc_qty, 0, "", ".") ?></td>
                                    <td><small>IDR</small> <?= number_format(($acc->harga_user * $acc->stok_terjual), 0, "", ".") ?></td>
                                </tr>
                                <?php array_push($list_total_trx_acc, ($acc->harga_user * $acc->stok_terjual)) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <h5 class="mt-0 round-inner my-3 font-16 font-weight-bold"><small>Total TRX Aksesoris: IDR</small> <?= number_format(array_sum($list_total_trx_acc), 0, "", ".") ?></h5>
                </table>
            </div>
        </div>
    </div>
    <!-- Old Code -->
    <!-- <div class="col-6 mt-3">
        <div class="card m-b-30">
            <h4 class="card-header mt-0">Transaksi Kartu</h4>
            <div class="card-body">
                <?php //$list_total_trx_kartu = []; 
                ?>
                <?php //foreach ($trx_kartu as $kartu) : 
                ?>
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="card-title font-20 mt-0"><?php //$kartu->produk_nama; 
                                                                ?></h4>
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <?php //if ($kartu->produk_gambar) : 
                                    ?>
                                        <a class="image-popup-no-margins" href="<?php //base_url('assets/images/products/' . $kartu->produk_gambar); 
                                                                                ?>">
                                            <?php //img("assets/images/products/$kartu->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); 
                                            ?>
                                        </a>
                                    <?php //else : 
                                    ?>
                                        <?php //img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $kartu->produk_nama, true, ['class' => 'rounded-circle', 'width' => '60', 'alt' => 'produk']); 
                                        ?>
                                    <?php //endif; 
                                    ?>
                                </div>
                                <div class="col-6 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner"></h5>
                                        <h5 class="mt-0 round-inner"><small>IDR</small> <?php //$kartu->harga_user 
                                                                                        ?></h5>
                                        <p class="mb-0 text-muted"><small>Terjual</small> <?php //$kartu->stok_terjual 
                                                                                            ?></p>
                                    </div>
                                </div>
                                <div class="col-3 align-self-end align-self-right">
                                    <p class="mb-0 text-muted"><small>Sisa</small> <?php //$kartu->trx_kartu_qty 
                                                                                    ?></p>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Total : IDR</small> <?php //($kartu->harga_user * $kartu->stok_terjual) 
                                                                                    ?></h5>
                        </div>
                    </div>
                    <?php //array_push($list_total_trx_kartu, ($kartu->harga_user * $kartu->stok_terjual)) 
                    ?>
                <?php //endforeach 
                ?>
                <hr>
                <h5 class="mt-0 round-inner"><small>Total TRX Kartu: IDR</small> <?php //array_sum($list_total_trx_kartu) 
                                                                                    ?></h5>
            </div>
        </div>
    </div> -->
    <!-- <div class="col-6 mt-3">
        <div class="card m-b-30">
            <h4 class="card-header mt-0">Transaksi Acc</h4>
            <div class="card-body">
                <?php //$list_total_trx_acc = []; 
                ?>
                <?php //foreach ($trx_acc as $acc) : 
                ?>
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="card-title font-20 mt-0"><?php //$acc->produk_nama; 
                                                                ?></h4>
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <?php //if ($acc->produk_gambar) : 
                                    ?>
                                        <a class="image-popup-no-margins" href="<?php //base_url('assets/images/products/' . $acc->produk_gambar); 
                                                                                ?>">
                                            <?php //img("assets/images/products/$acc->produk_gambar", true, ['class' => 'rounded-circle img-fluid', 'alt' => 'produk']); 
                                            ?>
                                        </a>
                                    <?php //else : 
                                    ?>
                                        <?php //img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $acc->produk_nama, true, ['class' => 'rounded-circle', 'width' => '60', 'alt' => 'produk']); 
                                        ?>
                                    <?php //endif; 
                                    ?>
                                </div>
                                <div class="col-6 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner"></h5>
                                        <h5 class="mt-0 round-inner"><small>IDR</small> <?php //$acc->harga_user 
                                                                                        ?></h5>
                                        <p class="mb-0 text-muted"><small>terjual</small> <?php //$acc->stok_terjual 
                                                                                            ?></p>
                                    </div>
                                </div>
                                <div class="col-3 align-self-end align-self-right">
                                    <p class="mb-0 text-muted"><small>Sisa</small> <?php //$acc->trx_acc_qty 
                                                                                    ?></p>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mt-0 round-inner"><small>Total : IDR</small> <?php //($acc->harga_user * $acc->stok_terjual) 
                                                                                    ?></h5>
                        </div>
                    </div>
                    <?php //array_push($list_total_trx_acc, ($acc->harga_user * $acc->stok_terjual)) 
                    ?>
                <?php //endforeach 
                ?>
                <hr>
                <h5 class="mt-0 round-inner"><small>Total TRX Acc: IDR</small> <?php //array_sum($list_total_trx_acc) 
                                                                                ?></h5>
            </div>
        </div>
    </div> -->
    <!-- <div class="col-6 mt-3">
        <div class="card m-b-30 shadow">
            <h4 class="card-header mt-0 text-white bg-primary">Transaksi Saldo</h4>
            <div class="card-body">
                <?php $list_total_trx_saldo = []; ?>
                <?php foreach ($trx_saldo as $saldo) : ?>
                    <div class="card m-b-30 shadow">
                        <div class="card-body">
                            <h4 class="card-title mt-0"><?= $saldo->ar_nama ?></h4>
                            <h5 class="mt-0 font-18 round-inner"><small>ID : </small><?= $saldo->ar_id ?></h5>
                            <p class="mb-0 font-16 font-weight-bold text-muted"><small>Saldo : IDR </small><?= number_format($saldo->saldo, 0, "", ".") ?></p>
                        </div>
                    </div>
                    <?php array_push($list_total_trx_saldo, $saldo->saldo) ?>
                <?php endforeach ?>
                <hr>
                <h5 class="mt-0 round-inner font-16 font-weight-bold"><small>Total Saldo : IDR</small> <?= number_format(array_sum($list_total_trx_saldo), 0, "", ".") ?></h5>
            </div>
        </div>
    </div> -->
    <div class="col-12 mt-3">
        <div class="card m-b-30 shadow">
            <h4 class="card-header mt-0 text-white bg-primary">Transaksi Reseller</h4>
            <div class="card-body">
                <div class="row">
                    <?php
                    $list_nama = [];
                    $list_total_trx_reseller = [];
                    $list_total_per_reseller = [];
                    ?>
                    <?php foreach ($trx_reseller as $reseller) : ?>

                        <?php if (!in_array($reseller->reseller, $list_nama)) : ?>
                            <div class="col-12 col-md-6 col-lg-4">
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
                            </div>
                        <?php endif; ?>
                        <?php array_push($list_nama, $reseller->reseller); ?>

                    <?php endforeach; ?>
                    <hr>
                </div>
                <hr>
                <h5 class="mt-0 round-inner font-16 font-weight-bold"><small>Total Reseller : IDR</small> <?= number_format(array_sum($list_total_trx_reseller), 0, "", ".") ?></h5>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card m-b-30 shadow">
            <h4 class="card-header mt-0 text-white bg-primary">Transaksi Saldo</h4>
            <div class="card-body">
                <div class="row">
                    <?php $list_total_trx_saldo = []; ?>
                    <?php foreach ($trx_saldo as $saldo) : ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card m-b-30 shadow">
                                <div class="card-body">
                                    <h4 class="card-title mt-0"><?= $saldo->ar_nama ?></h4>
                                    <h5 class="mt-0 font-18 round-inner"><small>ID : </small><?= $saldo->ar_id ?></h5>
                                    <p class="mb-0 font-16 font-weight-bold text-muted"><small>Saldo : IDR </small><?= number_format($saldo->saldo, 0, "", ".") ?></p>
                                </div>
                            </div>
                        </div>
                        <?php array_push($list_total_trx_saldo, $saldo->saldo) ?>
                    <?php endforeach ?>
                </div>
                <hr>
                <h5 class="mt-0 round-inner font-16 font-weight-bold"><small>Total Saldo : IDR</small> <?= number_format(array_sum($list_total_trx_saldo), 0, "", ".") ?></h5>
            </div>
        </div>
    </div>
    <div class="col-6 mt-3">
        <div class="card m-b-30 shadow">
            <h4 class="card-header mt-0 text-white bg-primary">Hasil Transaksi</h4>
            <div class="card-body">
                <p class="mt-0 round-inner font-16 font-weight-bold text-muted"><small>Pengeluaran : IDR</small> <?= $trx ? number_format($trx->total_keluar, 0, "", ".") : '0'; ?></p>
                <p class="mt-0 round-inner font-16 font-weight-bold text-muted"><small>Modal : IDR</small> <?= $trx ? number_format($trx->total_modal, 0, "", ".") : '0'; ?></p>
                <p class="mt-0 round-inner font-16 font-weight-bold text-muted"><small>Pulsa : IDR</small> <?= $trx ? number_format($trx->total_pulsa, 0, "", ".") : '0'; ?></p>
                <p class="mt-0 round-inner font-16 font-weight-bold text-muted"><small>Transaksi Tunai : IDR</small> <?= $trx ? number_format($trx->total_tunai, 0, "", ".") : '0'; ?></p>
                <hr>
                <h5 class="mt-0 round-inner font-16 font-weight-bold<?= ($trx->total_tunai - $trx->total_trx) ? ' text-danger' : ''; ?>"><small>Rekap Transaksi : IDR</small> <?= $trx ? number_format(($trx->total_tunai - $trx->total_trx), 0, "", ".") : '0'; ?></h5>
            </div>
        </div>
    </div>
</div>