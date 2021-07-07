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