<div class="row">
    <div class="col-12 col-sm-12 col-md-4">
        <div class="card m-b-30 shadow">
            <div class="card-body">
                <div class="text-center">
                    <?php if ($profile->avatar) : ?>
                        <a class="image-popup-no-margins" href="<?= base_url('assets/images/users/' . $profile->avatar); ?>">
                            <?= img("assets/images/users/$profile->avatar", true, ['class' => 'rounded-circle img-thumbnail w-50', 'alt' => '']); ?>
                        </a>
                    <?php else : ?>
                        <?= img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $profile->username, true, ['class' => 'rounded-circle img-thumbnail w-50', 'alt' => '']); ?>
                    <?php endif; ?>
                    <h4 class="font-16"><?= ucwords($profile->username); ?></h4>
                    <span class="text-muted font-14"><?= ucwords($profile->email); ?></span>
                    <ul class="list-unstyled list-inline mb-0 mt-3">
                        <p class="font-16"><?= ucwords($profile->name); ?> <i class="mdi mdi-account-key text-primary"></i></p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link waves-effect waves-light active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</a>
                    <a class="nav-link waves-effect waves-light" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Edit</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <ul class="list-unstyled list-inline mb-0 mt-3">
                            <p class="font-16"><i class="mdi mdi-home text-primary"></i> Alamat : <?= ucwords($profile->alamat); ?></p>
                            <p class="font-16"><i class="mdi mdi-cellphone-iphone text-primary"></i> Phone : <?= $profile->no_telp; ?></p>
                            <p class="font-16"><i class="mdi mdi-email-open text-primary"></i> Email : <?= ucwords($profile->email); ?></p>
                            <p class="font-16"><i class="mdi mdi-gender-male-female text-primary"></i> Jenis Kelamin : <?= $profile->jenkel; ?></p>
                            <p class="font-16"><i class="mdi mdi-account-card-details text-primary"></i> Penugasan : Konter <?= ucwords($profile->konter_nama); ?></p>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <form action="<?= route_to('update-profile', $profile->user_id); ?>" method="post" class="update-profile">
                            <input type="hidden" name="_method" value="PUT" />
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="username">Nama</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= ucwords($profile->username); ?>" />
                                <div id="username-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="<?= ucwords($profile->email); ?>" />
                                <div id="email-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no-telp">No Telp</label>
                                <input type="text" name="no_telp" id="no-telp" class="form-control" value="<?= ucwords($profile->no_telp); ?>" />
                                <div id="no-telp-err" class="invalid-feedback">
                                    Please provide a valid zip.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="perempuan">Kenis Kelamin</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="perempuan" id="perempuan" name="jenkel" <?= ($profile->jenkel == 'Perempuan') ? 'checked' : false; ?> class="custom-control-input">
                                        <label class="custom-control-label" for="perempuan">Perempuan</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" value="Laki - Laki" id="laki" name="jenkel" <?= ($profile->jenkel == 'Laki - Laki') ? 'checked' : false; ?> class="custom-control-input">
                                        <label class="custom-control-label" for="laki">Laki - Laki</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="avatar" class="avatar-img-preview rainbow">
                                        <i class="avatar-img-icon mdi mdi-camera"></i>
                                        <?= ($profile->avatar) ?
                                            img('assets/images/users/' . $profile->avatar, true, ['class' => 'avatar-img d-none', 'alt' => 'avatar']) :
                                            img('https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=' . $profile->username, true, ['class' => 'avatar-img d-none', 'alt' => 'avatar']);
                                        ?>
                                    </label>
                                    <div class="custom-file col-7">
                                        <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                        <label for="avatar" class="custom-file-label avatar-img-text" data-browse="Cari">Pilih gambar avatar</label>
                                        <div id="avatar-err" class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger"><small>Note : Kosongkan password bila tidak ingin merubahnya</small></span>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" />
                            </div>
                            <button type="submit" class="btn-update-profile btn btn-primary waves-effect waves-light text-white">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>