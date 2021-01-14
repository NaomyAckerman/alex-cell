<!DOCTYPE html>
<html>

<?= $this->include('components/header'); ?>

<body>


    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-0 m-b-15">
                    <a href="<?= route_to('login') ?>" class="logo logo-admin"><img src="assets/images/logo.png" height="24" alt="logo"></a>
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