<table id="datatable" class="table table-bordered table-hover table-striped text-center">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Gambar</th>
            <th>Kategori</th>
            <th>QTY</th>
            <th>Harga Supply</th>
            <th>Harga User</th>
            <th>Harga Reseller</th>
            <th>Deskripsi</th>
            <th>#</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($produk as $item) : ?>
            <tr>
                <td><?= $item->produk_nama ?></td>
                <td><img class="rounded-circle" src="assets/images/products/<?= $item->produk_gambar ?>" alt="user" width="40"> </td>
                <td><?= $item->kategori_nama ?></td>
                <td><?= $item->produk_qty ?> <small>pcs</small></td>
                <td><small>IDR</small> <?= $item->harga_supply ?></td>
                <td><small>IDR</small> <?= $item->harga_user ?></td>
                <td><small>IDR</small> <?= $item->harga_partai ?></td>
                <td><?= $item->produk_deskripsi ?></td>
                <td>
                    <div class="tabledit-toolbar btn-toolbar">
                        <div class="btn-group btn-group-sm">
                            <button class="tabledit-edit-button btn btn-sm btn-warning text-white" style="float: none; margin: 5px;">
                                <i class="mdi mdi-table-edit"></i>
                            </button>
                            <button class="tabledit-edit-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>