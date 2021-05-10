<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Transaksi</title>
    <?= link_tag('assets/images/brand/ar.png', 'shortcut icon') ?>
</head>
<?= link_tag([
    'href'  => 'assets/css/printer.css',
    'rel'   => 'stylesheet',
    'type'  => 'text/css',
]); ?>

<body id="print">
    <header>
        <div class="row">
            <div class="logo py-3">
                <img src="http://localhost:8080/assets/images/brand/ar.png" alt="">
            </div>
            <div class="title py-3 ml-3">
                <h2>Alex Cell</h2>
                <h3>Laporan Penjualan Konter 1</h3>
            </div>
        </div>
        <hr>
    </header>
    <main>
        <button class="print-no-display btn btn-primary mt-3" onclick="{window.print()}">Cetak</button>
        <div class="trx-kartu my-3">
            <h4 class="my-3">Transaksi Kartu</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Terjual</th>
                        <th>Sisa</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trx_kartu as $kartu) : ?>
                        <tr>
                            <td><?= $kartu->produk_nama; ?></td>
                            <td><small>IDR</small> <?= number_format($kartu->harga_user, 0, "", ".") ?></td>
                            <td><?= number_format($kartu->stok_terjual, 0, "", ".") ?> <small>pcs</small></td>
                            <td><?= number_format($kartu->trx_kartu_qty, 0, "", ".") ?> <small>pcs</small></td>
                            <td class="text-right"><small>IDR</small> <?= number_format(($kartu->harga_user * $kartu->stok_terjual), 0, "", ".") ?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="border-top text-right"><small>IDR</small> <?= number_format($trx->total_kartu, 0, "", ".") ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="trx-acc page-breake mt-5">
            <h4 class="my-3">Transaksi Aksesoris</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Terjual</th>
                        <th>Sisa</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trx_acc as $acc) : ?>
                        <tr>
                            <td><?= $acc->produk_nama; ?></td>
                            <td><small>IDR</small> <?= number_format($acc->harga_user, 0, "", ".") ?></td>
                            <td><?= number_format($acc->stok_terjual, 0, "", ".") ?> <small>pcs</small></td>
                            <td><?= number_format($acc->trx_acc_qty, 0, "", ".") ?> <small>pcs</small></td>
                            <td class="text-right"><small>IDR</small> <?= number_format(($acc->harga_user * $acc->stok_terjual), 0, "", ".") ?></td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="border-top text-right"><small>IDR</small> <?= number_format($trx->total_acc, 0, "", ".") ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row justify-between page-breake mt-3">
            <div class="col-5">
                <div class="trx-acc mt-5">
                    <h4 class="my-3">Transaksi Saldo</h4>
                    <table class=" table">
                        <thead>
                            <tr>
                                <th>ID AR</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $list_total_trx_saldo = []; ?>
                            <?php foreach ($trx_saldo as $saldo) : ?>
                                <tr>
                                    <td><?= $saldo->ar_id ?></td>
                                    <td class="text-center"><?= $saldo->ar_nama ?></td>
                                    <td class="text-right"><small>IDR</small> <?= number_format($saldo->saldo, 0, "", ".") ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="border-top text-right"><small>IDR</small> <?= number_format($trx->total_saldo, 0, "", ".") ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-5">
                <div class="trx-acc mt-5">
                    <h4 class="my-3">Total Transaksi</h4>
                    <dl>
                        <dt>
                            <h5>Penjualan</h5>
                        </dt>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Modal Awal</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_modal, 0, "", ".") ?></dd>
                        </div>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Reseller</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_partai, 0, "", ".") ?></dd>
                        </div>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Saldo</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_saldo, 0, "", ".") ?></dd>
                        </div>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Pulsa</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_pulsa, 0, "", ".") ?></dd>
                        </div>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Kartu</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_kartu, 0, "", ".") ?></dd>
                        </div>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Aksesoris</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_acc, 0, "", ".") ?></dd>
                        </div>
                        <hr>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Total</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format(array_sum([
                                                                    $trx->total_acc,
                                                                    $trx->total_kartu,
                                                                    $trx->total_saldo,
                                                                    $trx->total_partai,
                                                                    $trx->total_modal,
                                                                    $trx->total_pulsa,
                                                                ]), 0, "", ".") ?></dd>
                        </div>
                        <dt>
                            <h5 class="mt-3">Pengeluaran</h5>
                        </dt>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Total</dd>
                            <dd class="mr-3">- <small>IDR</small> <?= number_format($trx->total_keluar, 0, "", ".") ?></dd>
                        </div>
                        <dt>
                            <h5 class="mt-3">Tunai</h5>
                        </dt>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Total</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format($trx->total_tunai, 0, "", ".") ?></dd>
                        </div>
                        <dt>
                            <h5 class="mt-3">Hasil Rekap</h5>
                        </dt>
                        <hr>
                        <div class="row justify-between align-items-end">
                            <dd class="ml-3 mt-3">Total</dd>
                            <dd class="mr-3"><small>IDR</small> <?= number_format(($trx->total_tunai - $trx->total_trx), 0, "", ".") ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </main>
    <?= script_tag(['src' => 'assets/js/printer.js']); ?>
</body>

</html>