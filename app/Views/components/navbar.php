<nav class="navbar-custom">

    <ul class="list-inline float-right mb-0">
        <!-- language-->

        <li class="list-inline-item dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <?= ucwords(user()->username); ?> <img src="https://ui-avatars.com/api/?size=128&bold=true&background=random&color=ffffff&rounded=true&name=<?= user()->username; ?>" alt="user" class="rounded-circle ml-2">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5>Welcome</h5>
                </div>
                <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= route_to('logout'); ?>"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left waves-light waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>
    </ul>

    <div class="clearfix"></div>

</nav>