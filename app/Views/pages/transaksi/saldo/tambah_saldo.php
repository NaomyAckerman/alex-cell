<!-- Modal Tambah TRX Saldo -->
<div class="modal fade" id="modal-tambah-trx-saldo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= route_to('simpan-trx-saldo') ?>" class="simpan-trx-saldo" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Transaksi saldo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ar-id">ID AR</label>
                        <input type="text" class="form-control" name="ar_id" id="ar-id" placeholder="Masukkan ID AR">
                        <div id="ar-id-err" class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ar_nama">Nama</label>
                        <input type="text" class="form-control" name="ar_nama" id="ar-nama" placeholder="Masukkan nama">
                        <div id="ar-nama-err" class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="saldo">Saldo</label>
                        <input type="number" class="form-control" name="saldo" id="saldo" placeholder="Masukkan jumlah saldo">
                        <div id="saldo-err" class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary m-b-10 m-l-10 waves-effect waves-light text-white" data-dismiss="modal">kembali</button>
                    <button type="submit" class="btn-simpan-trx-saldo btn btn-sm btn-primary m-b-10 m-l-10 waves-effect waves-light text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>