<!-- Modal Edit Stok -->
<div class="modal fade" id="modal-edit-stok" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('update-stok') ?>" class="update-stok" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Stok Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                        <label for="stok">Stok Masuk</label>
                        <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukkan stok">
                        <div id="stok-err" class="invalid-feedback">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-update-stok btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>