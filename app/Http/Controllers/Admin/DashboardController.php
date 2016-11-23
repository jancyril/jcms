<?php

namespace Janitor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Janitor\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return $this->admin('dashboard.index', ['pageTitle' => 'Dashboard']);
    }
}
