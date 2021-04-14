<div id="sidebar-menu">
    <ul>
        <li class="menu-title">Main</li>
        <li>
            <a href="<?= route_to('dashboard'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === '') ? ' active' : ''; ?>">
                <i class="mdi mdi-airplay"></i>
                <span> Dashboard </span>
            </a>
        </li>
        <?php if (in_groups('admin')) : ?>
            <li>
                <a href="<?= route_to('produk'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'produk') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Produk </span>
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
                <a href="<?= route_to('transaksi-rekap'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'rekap') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Rekap </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('transaksi-kartu'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'kartu') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Kartu </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('transaksi-acc'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'acc') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Acc </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('transaksi-reseller'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'reseller') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Reseller </span>
                </a>
            </li>
            <li>
                <a href="<?= route_to('transaksi-saldo'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'saldo') ? ' active' : ''; ?>">
                    <i class="mdi mdi-wallet-giftcard"></i>
                    <span> Saldo </span>
                </a>
            </li>
        <?php endif; ?>
        <li class="menu-title">Info</li>
        <li>
            <a href="<?= route_to('stok'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === 'stok') ? ' active' : ''; ?>">
                <i class="mdi mdi-wallet-giftcard"></i>
                <span> Stok </span>
            </a>
        </li>
    </ul>
</div>