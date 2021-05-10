<!-- Modal Tambah TRX reseller -->
<div class="modal fade" id="modal-tambah-trx-reseller" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('simpan-trx-reseller') ?>" class="simpan-trx-reseller" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Transaksi Reseller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-simpan-trx-reseller btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>