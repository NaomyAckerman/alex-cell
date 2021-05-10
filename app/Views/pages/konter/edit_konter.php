<!-- Modal Edit Konter -->
<div class="modal fade" id="modal-edit-konter" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('update-konter', $konter->id) ?>" class="update-konter" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT" />
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Konter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="konter-nama">Konter</label>
                                <input type="text" class="form-control" name="konter_nama" id="konter-nama" value="<?= $konter->konter_nama; ?>" placeholder="Masukkan nama konter">
                                <div id="konter-nama-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="konter-no-telp">No Telp</label>
                                <input type="text" class="form-control" name="konter_no_telp" id="konter-no-telp" value="<?= $konter->konter_no_telp; ?>" placeholder="Masukkan No Telp">
                                <div id="konter-no-telp-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="konter-email">Email</label>
                                <input type="text" class="form-control" name="konter_email" id="konter-email" value="<?= $konter->konter_email; ?>" placeholder="Masukkan email konter">
                                <div id="konter-email-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="konter-gambar" class="konter-img-preview rainbow">
                                        <i class="konter-img-icon mdi mdi-camera"></i>
                                        <?= ($konter->konter_gambar) ?
                                            img('assets/images/konter/' . $konter->konter_gambar, true, ['class' => 'konter-img d-none', 'alt' => 'konter']) :
                                            img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $konter->konter_nama, true, ['class' => 'konter-img d-none', 'alt' => 'konter']);
                                        ?>
                                    </label>
                                    <div class="custom-file col-7">
                                        <input type="file" class="custom-file-input" name="konter_gambar" id="konter-gambar">
                                        <label for="konter-gambar" class="custom-file-label konter-img-text" data-browse="Cari">Pilih gambar konter</label>
                                        <div id="produk-gambar-err" class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-update-konter btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>