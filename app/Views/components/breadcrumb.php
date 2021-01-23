<div class="btn-group float-right">
    <ol class="breadcrumb hide-phone p-0 m-0">
        <li class="breadcrumb-item"><a href="<?= route_to('dashboard'); ?>">Dashboard</a></li>
        <?php if (current_url(true)->getSegment(1) !== '') : ?>
            <li class="breadcrumb-item active"><?= ucfirst($title); ?></li>
        <?php endif; ?>
    </ol>
</div>