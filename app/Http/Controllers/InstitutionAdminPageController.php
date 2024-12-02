<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstitutionAdminPageController extends Controller
{
    public function index()
    {
        return view('dashboardInstitution');
    }
}
