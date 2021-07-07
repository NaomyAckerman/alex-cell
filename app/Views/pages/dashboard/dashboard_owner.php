<!-- Column -->
<div class="col-12 col-sm-6 col-md-6 col-lg-4">
    <div class="info-box shadow">
        <span class="info-box-icon bg-info text-white elevation-1"><i class="dripicons-headset"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Total Trx Aksesoris</span>
            <span class="info-box-number">
                <small>IDR</small>
                <?= ($trx) ? number_format(array_sum(array_column($trx, 'total_acc')), 0, "", ".") : 0; ?>
            </span>
        </div>
    </div>
    <!-- /.info-box -->
</div>
<!-- Column -->
<!-- Column -->
<div class="col-12 col-sm-6 col-md-6 col-lg-4">
    <div class="info-box shadow">
        <span class="info-box-icon bg-danger text-white elevation-1"><i class="dripicons-card"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Total Trx Kartu</span>
            <span class="info-box-number">
                <small>IDR</small>
                <?= ($trx) ? number_format(array_sum(array_column($trx, 'total_kartu')), 0, "", ".") : 0; ?>
            </span>
        </div>
    </div>
    <!-- /.info-box -->
</div>
<!-- Column -->
<!-- Column -->
<div class="col-12 col-sm-6 col-md-6 col-lg-4">
    <div class="info-box shadow">
        <span class="info-box-icon bg-success text-white elevation-1"><i class="dripicons-store"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Total Trx Reseller</span>
            <span class="info-box-number">
                <small>IDR</small>
                <?= ($trx) ? number_format(array_sum(array_column($trx, 'total_partai')), 0, "", ".") : 0; ?>
            </span>
        </div>
    </div>
    <!-- /.info-box -->
</div>
<!-- Column -->
<!-- Column -->
<!-- <div class="col-12">
    <button class="btn btn-primary waves-effect waves-light text-white">Report</button>
</div> -->
<div class="col-12 col-sm-12 col-md-12">
    <div class="card m-b-30 mt-4 shadow shadow">
        <div class="card-header text-white bg-primary text-white bg-primary">
            Total Penjualan Kartu dan Aksesoris tahun <?= date('Y'); ?>
        </div>
        <div class="card-body">
            <canvas id="bar-kartu-acc" height="300"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-sm-12 col-md-12">
    <div class="card m-b-30 mt-4 shadow">
        <div class="card-header text-white bg-primary">
            Total Pendapatan tahun <?= date('Y'); ?>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <p class="d-flex flex-column">
                    <span>Total Pendatapan</span>
                    <span class="text-bold text-lg">IDR <?= number_format(array_sum(array_merge($laba_konter1, $laba_konter2)), 0, "", "."); ?></span>
                </p>
            </div>
            <div>
                <canvas id="bar-pendapatan" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-sm-12 col-md-6">
    <div class="card m-b-30 mt-4 shadow">
        <div class="card-header text-white bg-primary">
            Persentase 3 produk teratas
        </div>
        <div class="card-body">
            <canvas id="pie-top-produk" height="300"></canvas>
        </div>
    </div>
</div>
<div class="col-12 col-sm-12 col-md-6">
    <div class="card m-b-30 mt-4 shadow">
        <div class="card-header text-white bg-primary">
            Total transaksi hari ini
        </div>
        <div class="card-body">
            <h5 class="text-lightdark">Konter 1</h5>
            <h6><i class="mdi mdi-download mr-2 text-success font-20"></i>IDR <?= ($trx_konter1) ? number_format($trx_konter1->total_trx, 0, "", ".") : 0; ?></h6>
            <h5 class="text-lightdark mt-5">Konter 2</h5>
            <h6><i class="mdi mdi-download mr-2 text-success font-20"></i>IDR <?= ($trx_konter2) ? number_format($trx_konter2->total_trx, 0, "", ".") : 0; ?></h6>
        </div>
    </div>
</div>
<!-- Column -->