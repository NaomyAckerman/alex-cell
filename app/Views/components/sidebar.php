<div id="sidebar-menu">
    <ul>
        <li class="menu-title">Main</li>

        <li>
            <a href="<?= route_to('dashboard'); ?>" class="waves-effect<?= (current_url(true)->getSegment(1) === '') ? ' active' : ''; ?>">
                <i class="mdi mdi-airplay"></i>
                <span> Dashboard </span>
            </a>
        </li>
        <li class="menu-title">Info</li>

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
    </ul>
</div>