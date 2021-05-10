<div class="row">
    <?php if (!$status_submit) : ?>
        <?php if ($trx_saldo) : ?>
            <?php $list_trx_saldo = []; ?>
            <?php foreach ($trx_saldo as $trx) : ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card m-b-30 shadow">
                        <div class="card-body">
                            <h4 class="card-title mt-3"><?= $trx->ar_nama ?></h4>
                            <h5 class="mt-3 font-18 round-inner"><small>ID : </small><?= $trx->ar_id ?></h5>
                            <p class="mb-3 font-16 font-weight-bold text-muted"><small>Saldo : IDR</small> <?= number_format($trx->saldo, 0, "", ".") ?></p>
                            <div class="d-flex justify-content-center">
                                <form action="<?= route_to('hapus-trx-saldo', $trx->id); ?>" class="hapus-trx-saldo" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= route_to('edit-trx-saldo', $trx->id); ?>" class="edit-trx-saldo tabledit-edit-button btn btn-sm btn-warning m-b-10 m-l-10 waves-effect waves-light text-white" style="float: none; margin: 5px;">
                                            <i class="mdi mdi-table-edit"></i>
                                        </a>
                                        <button type="submit" class="btn-hapus-trx-saldo tabledit-delete-button btn btn-sm btn-danger m-b-10 m-l-10 waves-effect waves-light text-white" style="float: none; margin: 5px;">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php array_push($list_trx_saldo, $trx->saldo) ?>
                </div>
            <?php endforeach; ?>
            <div class="col-12 mb-3">
                <form action="<?= route_to('submit-trx-saldo') ?>" class="submit-trx-saldo" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="total_trx_saldo" value="<?= array_sum($list_trx_saldo); ?>" />
                    <button type="submit" class="btn-submit-trx-saldo btn btn-primary btn-sm waves-effect waves-light text-white">Submit Transaksi</button>
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