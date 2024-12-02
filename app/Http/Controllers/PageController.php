<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function loginPage()
    {
        return view('pages.login'); // You can change this to the actual login page view name.
    }

    public function dashboardPage()
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

    public function settingsPage()
    {
        return view('pages.settings');
    }

    public function instituteListPage()
    {
        return view('pages.instituteList');
    }

    public function institutePage($id){
        return view('pages.institute', compact('id'));
    }

    public function addInstitutePage(){
        return view('pages.addInstitute');
    }
    
    public function profilePage()
    {
        return view('pages.profile');
    }

    public function userInstituteListPage(){
        return view('pages.userInstituteList');
    }


}
