<div id="sidebar-menu">
    <ul>
        <li class="menu-title">Main</li>
        <li>
            <a href="<?= route_to('dashboard'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === '') ? ' active' : ''; ?>">
                <i class="mdi mdi-airplay"></i>
                <span> Dashboard </span>
            </a>
        </li>
        <?php if (in_groups('admin') or in_groups('owner')) : ?>
            <li>
                <a href="<?= route_to('produk'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'produk') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Produk </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('user'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'user') ? ' active' : ''; ?>">
                    <i class="mdi mdi-account-multiple"></i>
                    <span> Karyawan </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('info-trx'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'transaksi') ? ' active' : ''; ?>">
                    <i class="mdi mdi-repeat"></i>
                    <span> Transaksi </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('konter'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'konter') ? ' active' : ''; ?>">
                    <i class="mdi mdi-home"></i>
                    <span> Konter </span>
                </a>
            </li>
        <?php elseif (in_groups('karyawan')) : ?>
            <li class="menu-title">Transaksi</li>
            <li>
                <a href="<?= route_to('trx-saldo'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'saldo') ? ' active' : ''; ?>">
                    <i class="mdi mdi-square-inc-cash"></i>
                    <span> Saldo </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('trx-reseller'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'reseller') ? ' active' : ''; ?>">
                    <i class="mdi mdi-cart"></i>
                    <span> Reseller </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('trx-kartu'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'kartu') ? ' active' : ''; ?>">
                    <i class="mdi mdi-cards"></i>
                    <span> Kartu </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('trx-acc'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'acc') ? ' active' : ''; ?>">
                    <i class="mdi mdi-headset"></i>
                    <span> Acc </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('trx-rekap'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'rekap') ? ' active' : ''; ?>">
                    <i class="mdi mdi-scale-balance"></i>
                    <span> Rekap </span>
                </a>
            </li>
        <?php endif; ?>
        <li class="menu-title">Info</li>
        <li>
            <a href="<?= route_to('stok'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'stok') ? ' active' : ''; ?>">
                <i class="mdi mdi-database"></i>
                <span> Stok </span>
            </a>
        </li>
    </ul>
</div>