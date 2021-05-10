<!-- Modal Edit trx acc -->
<div class="modal fade" id="modal-edit-trx-acc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('update-trx-acc',  $trx_acc->id) ?>" class="update-trx-acc" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT" />
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit transaksi aksesoris</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="trx-acc-qty">Jumlah Sisa</label>
                        <input type="number" class="form-control" name="trx_acc_qty" id="trx-acc-qty" value="<?= $trx_acc->trx_acc_qty; ?>" placeholder="Masukkan sisa produk">
                        <div id="trx-acc-qty-err" class="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-update-trx-acc btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>