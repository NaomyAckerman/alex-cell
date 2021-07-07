<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<!-- Column -->
<div class="col-12">
    <div class="card m-b-30 shadow">
        <div class="card-body text-center">
            <?= img('assets/images/illustration/creative_team.svg', true, ['class' => 'hero-dashboard']); ?>
            <h5 class="card-title"><?= ucwords(user()->username); ?></h5>
            <p class="card-text">
                Selamat datang di sistem management penjualan kartu seluler Alex Cell <?= ucwords(user()->username); ?>.
            </p>
            <a href="<?= route_to('profile'); ?>" class="btn btn-primary btn-sm waves-effect waves-light text-white">Profile</a>
        </div>
    </div>
</div>
<!-- Column -->

<?php
if (in_groups('karyawan')) {
    echo $this->include('pages/dashboard/dashboard_kry');
} elseif (in_groups('admin')) {
    echo $this->include('pages/dashboard/dashboard_admin');
} elseif (in_groups('owner')) {
    echo $this->include('pages/dashboard/dashboard_owner');
}
?>

<?= $this->endSection(); ?>

<?php if (in_groups('owner')) : ?>
    <?= $this->section('grafik'); ?>
    <script>
        let ctxKartuAcc = document.getElementById('bar-kartu-acc').getContext('2d');
        let kartuAccChart = new Chart(ctxKartuAcc, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mai", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                        label: "Kartu",
                        backgroundColor: "#5b6be8",
                        borderColor: "#5b6be8",
                        borderWidth: 1,
                        hoverBackgroundColor: "#5b6be8",
                        hoverBorderColor: "#5b6be8",
                        data: [
                            <?php foreach ($total_kartu as $kartu) : ?>
                                <?= $kartu ?>,
                            <?php endforeach; ?>
                        ]
                    },
                    {
                        label: "Aksesoris",
                        backgroundColor: "#ced4da",
                        borderColor: "#ced4da",
                        borderWidth: 1,
                        hoverBackgroundColor: "#ced4da",
                        hoverBorderColor: "#ced4da",
                        data: [
                            <?php foreach ($total_acc as $acc) : ?>
                                <?= $acc ?>,
                            <?php endforeach; ?>
                        ]
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        })
        let ctxPendapatan = document.getElementById('bar-pendapatan').getContext('2d');
        let pendapatanChart = new Chart(ctxPendapatan, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                        label: "Konter1",
                        backgroundColor: "#5b6be8",
                        borderColor: "#5b6be8",
                        borderWidth: 1,
                        hoverBackgroundColor: "#5b6be8",
                        hoverBorderColor: "#5b6be8",
                        data: [
                            <?php foreach ($laba_konter1 as $laba) : ?>
                                <?= $laba ?>,
                            <?php endforeach; ?>
                        ],
                        lineTension: 0.3
                    },
                    {
                        label: "Konter2",
                        backgroundColor: "#ced4da",
                        borderColor: "#ced4da",
                        borderWidth: 1,
                        hoverBackgroundColor: "#ced4da",
                        hoverBorderColor: "#ced4da",
                        data: [
                            <?php foreach ($laba_konter2 as $laba) : ?>
                                <?= $laba ?>,
                            <?php endforeach; ?>
                        ],
                        lineTension: 0.3
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        })
        let ctxTopProduk = document.getElementById('pie-top-produk').getContext('2d');
        let topProdukChart = new Chart(ctxTopProduk, {
            type: 'doughnut',
            data: {
                labels: [
                    <?php foreach ($top_produk as $item) : ?> "<?= $item->produk_nama; ?>",
                    <?php endforeach; ?>
                ],
                datasets: [{
                    data: [
                        <?php foreach ($top_produk as $item) : ?>
                            <?= $item->stok_terjual; ?>,
                        <?php endforeach; ?>
                    ],
                    backgroundColor: [
                        "#5b6be8",
                        "#e8da5b",
                        "#e85b5b",
                        "#5be893",
                        "#5bc2e8"
                    ],
                    hoverBackgroundColor: [
                        "#5b6be8",
                        "#e8da5b",
                        "#e85b5b",
                        "#5be893",
                        "#5bc2e8"
                    ],
                    hoverBorderColor: "#fff",
                    hoverOffset: 5
                }]
            },
            options: {
                plugins: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                                var total = meta.total;
                                var currentValue = dataset.data[tooltipItem.index];
                                var percentage = parseFloat((currentValue / total * 100).toFixed(1));
                                return currentValue + ' (' + percentage + '%)';
                            },
                            title: function(tooltipItem, data) {
                                return data.labels[tooltipItem[0].index];
                            }
                        }
                    },
                }
            },
        })
    </script>
    <?= $this->endSection(); ?>
<?php endif; ?>