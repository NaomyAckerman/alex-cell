<table id="datatable" class="table table-bordered table-hover table-striped text-center table-responsive">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Gambar</th>
            <th>Kategori</th>
            <th>QTY</th>
            <th>Harga Supply</th>
            <th>Harga User</th>
            <th>Harga Reseller</th>
            <th>Deskripsi</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        foreach ($produk as $item) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $item->produk_nama ?></td>
                <td>
                    <?php if ($item->produk_gambar) : ?>
                        <a class="image-popup-no-margins" href="<?= base_url('assets/images/products/' . $item->produk_gambar); ?>">
                            <?= img("assets/images/products/$item->produk_gambar", true, ['class' => 'rounded-circle', 'width' => 50, 'alt' => 'produk']); ?>
                        </a>
                    <?php else : ?>
                        <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $item->produk_nama, true, ['class' => 'rounded-circle', 'width' => 50, 'alt' => 'produk']); ?>
                    <?php endif; ?>
                </td>
                <td><?= $item->kategori_nama ?></td>
                <td><?= $item->produk_qty ?> <small>pcs</small></td>
                <td><small>IDR</small> <?= number_format($item->harga_supply, 0, "", ".") ?></td>
                <td><small>IDR</small> <?= number_format($item->harga_user, 0, "", ".") ?></td>
                <td><small>IDR</small> <?= number_format($item->harga_partai, 0, "", ".") ?></td>
                <td><?= $item->produk_deskripsi ?></td>
                <td>
                    <div class="d-flex justify-content-center">
                        <form action="<?= route_to('hapus-produk', $item->produk_slug); ?>" class="hapus-produk" method="post">
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="produk" value="<?= $item->produk_nama; ?>" />
                            <?= csrf_field(); ?>
                            <div class="btn-group btn-group-sm">
                                <a href="<?= route_to('edit-produk', $item->produk_slug); ?>" class="edit-produk tabledit-edit-button btn btn-sm btn-warning m-b-10 m-l-10 waves-effect waves-light text-white" style="float: none; margin: 5px;">
                                    <i class="mdi mdi-table-edit"></i>
                                </a>
                                <button type="submit" class="btn-hapus-produk tabledit-delete-button btn btn-sm btn-danger m-b-10 m-l-10 waves-effect waves-light text-white" style="float: none; margin: 5px;">
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