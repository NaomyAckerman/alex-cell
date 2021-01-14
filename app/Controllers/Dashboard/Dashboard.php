<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return \view('pages/dashboard/index', ['title' => 'dashboard']);
    }

    //--------------------------------------------------------------------

}
