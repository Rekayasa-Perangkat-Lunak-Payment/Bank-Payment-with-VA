<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankAdminPageController extends Controller
{
    public function index()
    {
        return view('dashboardBank');
    }
}
