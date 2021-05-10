<!-- Modal Tambah user -->
<div class="modal fade" id="modal-tambah-user" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('simpan-user') ?>" class="simpan-user" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Karyawan Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username">
                                <div id="username-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan email">
                                <div id="email-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no-telp">No Telp</label>
                                <input type="text" class="form-control" name="no_telp" id="no-telp" placeholder="Masukkan no telp">
                                <div id="no-telp-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="karyawan">Role</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="admin" id="admin" name="role" class="custom-control-input">
                                        <label class="custom-control-label" for="admin">Admin</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="karyawan" id="karyawan" name="role" checked class="custom-control-input">
                                        <label class="custom-control-label" for="karyawan">Karyawan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="perempuan">Kenis Kelamin</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="perempuan" id="perempuan" name="jenkel" checked class="custom-control-input">
                                        <label class="custom-control-label" for="perempuan">Perempuan</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="Laki - Laki" id="laki" name="jenkel" class="custom-control-input">
                                        <label class="custom-control-label" for="laki">Laki - Laki</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="konter-id">Konter</label>
                                <select class="custom-select select2" name="konter_id" id="konter-id">
                                    <option selected disabled>Pilih konter</option>
                                    <?php foreach ($konter as $item) : ?>
                                        <option value="<?= $item->id; ?>"><?= $item->konter_nama; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div id="konter-id-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-hash">Password</label>
                                <input type="Password" class="form-control" name="password_hash" id="password-hash" placeholder="Masukkan password">
                                <div id="password-hash-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control textarea" maxlength="255" name="alamat" id="alamat" rows="7" placeholder="Masukkan alamat"></textarea>
                                <div id="alamat-err" class="invalid-feedback">
                                    Please select a valid state.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-simpan-user btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>