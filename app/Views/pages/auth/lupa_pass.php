<?= $this->extend('layouts/auth'); ?>

<?= $this->section('content'); ?>

<form class="form-horizontal" action="index.html">

    <!-- <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Enter your <b>Email</b> and instructions will be sent to you!
    </div> -->
    <p class="mb-3">masukkan alamat email Anda di bawah ini dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda!</p>

    <div class="form-group">
        <div class="col-xs-12">
            <input class="form-control" type="email" required="" placeholder="Email">
        </div>
    </div>

    <div class="form-group text-center row m-t-20">
        <div class="col-12">
            <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Send Email</button>
        </div>
    </div>

</form>

<?= $this->endSection(); ?>