<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstituteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages/login');
});

Route::get('/dashboard', function () {
    return view('pages/dashboard');
});

Route::get('/settings', function () {
    return view('pages/settings');
});

Route::get('/userInstituteList', function () {
    return view('pages/userInstituteList');
});

Route::get('/instituteList', function () {
    return view('pages/instituteList');
});

// Route::get('/institute', function () {
//     return view('pages/institute');
// });

Route::resource('institute', InstituteController::class);

Route::get('/userInstitute', function () {
    return view('pages/userInstitute');
});
