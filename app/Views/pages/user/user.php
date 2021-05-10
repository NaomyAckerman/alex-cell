<div class="row">
    <?php foreach ($users as $user) : ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <div class="card m-b-30 shadow">
                <div class="card-body">
                    <div class="text-center">
                        <?php if ($user->avatar) : ?>
                            <a class="image-popup-no-margins" href="<?= base_url('assets/images/users/' . $user->avatar); ?>">
                                <?= img("assets/images/users/$user->avatar", true, ['class' => 'rounded-circle img-thumbnail w-50', 'alt' => '']); ?>
                            </a>
                        <?php else : ?>
                            <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $user->username, true, ['class' => 'rounded-circle img-thumbnail w-50', 'alt' => '']); ?>
                        <?php endif; ?>
                        <h4 class="font-16"><?= ucwords($user->username); ?></h4>
                        <a href="" class="text-muted font-14"><?= ucwords($user->email); ?></a>
                        <ul class="list-unstyled list-inline mb-0 mt-3">
                            <p class="font-16"><?= ucwords($user->name); ?> <i class="mdi mdi-account-key <?= ($user->status == 'block') ? 'text-danger' : 'text-primary'; ?>"></i></p>
                        </ul>
                        <a href="" data-user='{"nama" : "<?= $user->username; ?>", "alamat" : "<?= $user->alamat; ?>", "no_telp" : "<?= $user->no_telp; ?>"}' class="detail-user btn btn-primary btn-sm mt-2 waves-effect waves-light text-white"><i class="mdi mdi-eye"></i></a>
                        <form action="<?= route_to('block-user', $user->user_id); ?>" class="block-user d-inline" method="post">
                            <input type="hidden" name="status" value="<?= $user->status; ?>" />
                            <input type="hidden" name="user" value="<?= $user->username; ?>" />
                            <?= csrf_field(); ?>
                            <button class="btn-block-user btn btn-warning btn-sm mt-2 waves-effect waves-light text-white"><i class="mdi mdi-block-helper"></i></button>
                        </form>
                        <form action="<?= route_to('hapus-user', $user->user_id); ?>" class="hapus-user d-inline" method="post">
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="user" value="<?= $user->username; ?>" />
                            <?= csrf_field(); ?>
                            <button class="btn-hapus-user btn btn-danger btn-sm mt-2 waves-effect waves-light text-white"><i class="mdi mdi-delete"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>