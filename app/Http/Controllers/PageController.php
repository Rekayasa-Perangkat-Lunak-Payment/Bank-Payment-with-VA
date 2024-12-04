<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\InstitutionAdminController;
use App\Models\Institution;
use App\Models\InstitutionAdmin;

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

    public function userInstituteListPage(Request $request){
        $response = app(InstitutionAdminController::class)->index($request);
        $userInstitutions = json_decode($response->getContent(), true);
        // dd($userInstitutions);
        return view('pages.userInstituteList', compact('userInstitutions'));
    }

    public function userInstitutePage($id){
        $userInstitute = InstitutionAdmin::findOrFail($id);
        return view('pages.userInstitute', compact('userInstitute'));
    }
    public function addUserInstitutePage(){
        return view('pages.addUserInstitute');
    }

    public function studentListPage(){
        $institutions = Institution::all();
        return view('pages.studentList', compact('institutions'));
    }
}
