<table id="datatable-konter" class="table table-bordered table-hover table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Gambar</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>#</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        foreach ($konter as $item) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $item->konter_nama ?></td>
                <td>
                    <?php if ($item->konter_gambar) : ?>
                        <a class="image-popup-no-margins" href="<?= base_url('assets/images/konter/' . $item->konter_gambar); ?>">
                            <?= img("assets/images/konter/$item->konter_gambar", true, ['class' => 'rounded-circle', 'width' => 50, 'alt' => 'konter']); ?>
                        </a>
                    <?php else : ?>
                        <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $item->konter_nama, true, ['class' => 'rounded-circle', 'width' => 50, 'alt' => 'konter']); ?>
                    <?php endif; ?>
                </td>
                <td><?= $item->konter_email ?></td>
                <td><?= $item->konter_no_telp ?></td>
                <td>
                    <div class="d-flex justify-content-center">
                        <form action="<?= route_to('hapus-konter', $item->id); ?>" class="hapus-konter" method="post">
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="konter" value="<?= $item->konter_nama; ?>" />
                            <?= csrf_field(); ?>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= route_to('edit-konter', $item->id); ?>" class="edit-konter tabledit-edit-button btn btn-sm btn-warning m-b-10 m-l-10 waves-effect waves-light text-white" style="float: none; margin: 5px;">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>
                                <button type="submit" class="btn-hapus-konter tabledit-delete-button btn btn-sm btn-danger m-b-10 m-l-10 waves-effect waves-light text-white" style="float: none; margin: 5px;">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>