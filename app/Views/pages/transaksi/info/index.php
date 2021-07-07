<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="col-12 align-self-center">

    <div class="card m-b-30 shadow">
        <div class="card-header">
            <h3 class="card-title d-inline">Info Transaksi</h3>
        </div>
        <div class="card-body bootstrap-select-1">
            <form action="<?= route_to('info-trx'); ?>" method="post" class="info-trx">
                <div class="row form-material">
                    <?= csrf_field(); ?>
                    <div class="col-12 col-md-4 col-lg-5 align-self-end">
                        <h6 class="text-muted fw-400">Pilih tanggal</h6>
                        <div class="input-group">
                            <input name="tanggal" type="text" class="form-control" value="<?= date('Y-m-d'); ?>" placeholder="<?= date('Y-m-d'); ?>" id="mdate">
                            <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-5 align-self-end">
                        <select name="konter" class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;">
                            <option selected disabled>Pilih Konter</option>
                            <?php foreach ($konter as $item) : ?>
                                <option value="<?= $item->id; ?>"><?= $item->konter_nama; ?></option>
                            <?php endforeach ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2 align-self-end">
                        <button type="submit" class="btn-info-trx btn btn-primary waves-effect waves-light text-white">Cari</button>
                    </div>
                </div>
                <div id="content-view-info-trx" class="row"></div>
            </form>
        </div>
    </div>
    <!-- end row -->
</div>

<?= $this->endSection(); ?>