<!DOCTYPE html>
<html>

<?= $this->include('components/header'); ?>

<body>


    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <?= $this->include('components/msg_block'); ?>
        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-4 m-b-15">
                    <a href="<?= route_to('login') ?>" class="logo logo-admin"><img src="assets/images/brand/ar.png" class="w-25" alt="logo">
                        <div>Alex Cell</div>
                    </a>
                </h3>

                <div class="p-3">
                    <?= $this->renderSection('content'); ?>
                </div>

            </div>
        </div>
    </div>

    <?= $this->include('components/footer'); ?>

</body>

</html>