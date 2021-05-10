<div class="row">
    <?php if ($status_submit) : ?>
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Transaksi selesai!</strong> Terima kasih sampai jumpa besok.
            </div>
        </div>
    <?php else : ?>
        <?php if ($trx_reseller) : ?>

            <?php
            $list_nama = [];
            $list_total = [];
            $list_total_per_reseller = [];
            ?>
            <?php foreach ($trx_reseller as $trx) : ?>

                <?php if (!in_array($trx->reseller, $list_nama)) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card m-b-30 shadow">
                            <h4 class="card-header font-20 mt-0 text-white bg-primary"><?= $trx->reseller; ?></h4>
                            <div class="card-body">
                                <?php foreach ($trx_reseller as $trx2) : ?>
                                    <?php if ($trx2->reseller == $trx->reseller) : ?>
                                        <p class="card-text">
                                            <small class="text-muted font-14">Produk : <?= $trx2->produk_nama; ?></small>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted font-14">Jumlah : <?= number_format($trx2->trx_partai_qty, 0, "", "."); ?></small>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted font-14">harga : <?= number_format($trx2->harga_partai, 0, "", "."); ?></small>
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text">
                                                <small class="text-muted font-14">Total : IDR <?= number_format($trx2->trx_partai_qty * $trx2->harga_partai, 0, "", "."); ?></small>
                                            </p>
                                            <form action="<?= route_to('hapus-trx-reseller', $trx2->id) ?>" class="hapus-trx-reseller" method="post">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <input type="hidden" name="produk" value="<?= $trx2->produk_nama; ?>" />
                                                <input type="hidden" name="reseller" value="<?= $trx2->reseller; ?>" />
                                                <input type="hidden" name="produk_id" value="<?= $trx2->produk_id; ?>" />
                                                <input type="hidden" name="qty" value="<?= $trx2->trx_partai_qty; ?>" />
                                                <button type="submit" class="btn-hapus-trx-reseller btn btn-danger btn-sm waves-effect waves-light text-white">Hapus</button>
                                            </form>
                                        </div>
                                        <hr>
                                        <?php array_push($list_total_per_reseller, ($trx2->trx_partai_qty * $trx2->harga_partai)) ?>
                                        <?php array_push($list_total, ($trx2->trx_partai_qty * $trx2->harga_partai)) ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <p class="card-text">
                                    <small class="font-16 font-weight-bold text-muted"><small>Total Transaksi : IDR </small><?= number_format(array_sum($list_total_per_reseller), 0, "", "."); ?></small>
                                </p>
                                <?php $list_total_per_reseller = []; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php array_push($list_nama, $trx->reseller); ?>

            <?php endforeach; ?>

            <div class="col-12">
                <form action="<?= route_to('submit-trx-reseller') ?>" class="submit-trx-reseller" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="total_trx_reseller" value="<?= array_sum($list_total); ?>" />
                    <button type="submit" class="btn-submit-trx-reseller btn btn-primary btn-sm waves-effect waves-light text-white">Submit</button>
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
    <?php endif; ?>
</div>