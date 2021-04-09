<h5>Konter 1</h5>
<table id="datatable" class="table table-bordered table-hover table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        foreach ($konter1 as $k1) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $k1->produk_nama ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h5 class="mt-5">Konter 1</h5>
<table id="datatable" class="table table-bordered table-hover table-striped text-center">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        foreach ($konter1 as $k1) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $k1->produk_nama ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>