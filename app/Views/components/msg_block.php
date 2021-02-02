<?php if (session()->has('error')) : ?>
    <div class="login_msg" data-judul="Info Gagal" data-type="info" data-message="<?= esc(session('error')); ?>"></div>
<?php endif ?>