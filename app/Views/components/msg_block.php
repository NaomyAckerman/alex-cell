<?php if (session()->has('error')) : ?>
    <div class="login_msg" data-judul="Info Gagal" data-type="info" data-message="<?= esc(session('error')); ?>"></div>
<?php elseif (session()->has('message')) : ?>
    <div class="login_msg" data-judul="Berhasil" data-type="success" data-message="<?= esc(session('message')); ?>"></div>
<?php endif ?>