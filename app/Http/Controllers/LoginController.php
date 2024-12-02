<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    // protected $redirectTo;
    // public function redirectTo()
    // {
    //     switch(Auth::user()->role){
    //         case 'bank_admin':
    //             $this->redirectTo = '/dashboardBank';
    //             return $this->redirectTo;
    //             break;
    //         case 'institution_admin':
    //             $this->redirectTo = '/dashboardInstitution';
    //             return $this->redirectTo;
    //             break;
    //         default:
    //             $this->redirectTo = '/login';
    //             return $this->redirectTo;
    //     }
    // }
}
