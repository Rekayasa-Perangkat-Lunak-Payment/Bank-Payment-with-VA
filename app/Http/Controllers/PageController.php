<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLoginPage()
    {
        return view('pages.login'); // You can change this to the actual login page view name.
    }

    /**
     * Show the dashboard page.
     */
    public function showDashboardPage()
    {
        // dd(Auth::user());
        // if (Auth::user()->role == 'bank_admin') {
        //     return view('pages.dashboardBank');
        // }else if (Auth::user()->role == 'institution_admin') {
        //     return view('pages.dashboardInstitution');
        // }else{
        //     return view('pages.login');
        // }
        return view('pages.dashboardBank');
    }

    /**
     * Show the settings page.
     */
    public function showSettingsPage()
    {
        return view('pages.settings');
    }

    /**
     * Show the institute list page.
     */
    public function showInstituteListPage()
    {
        return view('pages.instituteList');
    }

    /**
     * Show the profile page.
     */
    public function showProfilePage()
    {
        return view('pages.profile');
    }
}
