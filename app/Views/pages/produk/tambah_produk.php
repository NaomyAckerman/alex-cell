<!-- Modal Tambah Produk -->
<div class="modal fade" id="modal-tambah-produk" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('simpan-produk') ?>" class="simpan-produk" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="produk-nama">Produk</label>
                                <input type="text" class="form-control" name="produk_nama" id="produk-nama" placeholder="Masukkan nama produk">
                                <div id="produk-nama-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kategori-id">Kategori</label>
                                <select class="custom-select select2" name="kategori_id" id="kategori-id">
                                    <option selected disabled>Pilih kategori</option>
                                    <?php foreach ($kategori as $item) : ?>
                                        <option value="<?= $item->id; ?>"><?= $item->kategori_nama; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="kategori-id-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="produk-gambar" class="produk-img-preview rainbow">
                                        <i class="produk-img-icon mdi mdi-camera"></i>
                                        <img src="" class="produk-img d-none" alt="produk">
                                    </label>
                                    <div class="custom-file col-7">
                                        <input type="file" class="custom-file-input" name="produk_gambar" id="produk-gambar">
                                        <label for="produk-gambar" class="custom-file-label produk-img-text" data-browse="Cari">Pilih gambar produk</label>
                                        <div id="produk-gambar-err" class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="produk-deskripsi">Deskripsi</label>
                                <textarea class="form-control textarea" maxlength="255" name="produk_deskripsi" id="produk-deskripsi" rows="3" placeholder="Masukkan deskripsi produk"></textarea>
                                <div id="produk-deskripsi-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="produk-qty">Qty</label>
                                <input type="text" class="form-control" name="produk_qty" id="produk-qty" placeholder="Masukkan jumlah produk">
                                <div id="produk-qty-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga-supply">Harga Supply</label>
                                <input type="text" class="form-control" name="harga_supply" id="harga-supply" placeholder="Masukkan harga supply">
                                <div id="harga-supply-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga-user">Harga User</label>
                                <input type="text" class="form-control" name="harga_user" id="harga-user" placeholder="Masukkan harga user">
                                <div id="harga-user-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga-partai">Harga Partai</label>
                                <input type="text" class="form-control" name="harga_partai" id="harga-partai" placeholder="Masukkan harga partai">
                                <div id="harga-partai-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-simpan-produk btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>