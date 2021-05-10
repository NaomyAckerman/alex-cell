<!DOCTYPE html>
<html>

<?= $this->include('components/header'); ?>

<body class="fixed-left">

    <?= $this->include('components/loader'); ?>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="ion-close"></i>
            </button>

            <!-- LOGO -->
            <?= $this->include('components/brand'); ?>

            <div class="sidebar-inner slimscrollleft">

                <?= $this->include('components/sidebar') ?>

                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <?= $this->include('components/navbar'); ?>

                </div>
                <!-- Top Bar End -->

                <div class="page-content-wrapper ">

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <?= $this->include('components/breadcrumb'); ?>
                                    <h4 class="page-title">
                                        <?= esc(ucwords($title)); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title end breadcrumb -->

                        <div class="row">
                            <?= $this->renderSection('content'); ?>
                        </div>

                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            <footer class="footer">
                © <?= date('Y'); ?> Alex Cell Corporation.
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <?= $this->include('components/footer'); ?>

    <?= $this->renderSection('grafik'); ?>

</body>

</html>