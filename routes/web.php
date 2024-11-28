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

// Login page routes
Route::get('/', function () {
    return view('pages/login');
});
Route::get('/login', function () {
    return view('pages/login');
});

// Dashboard page route
Route::get('/dashboard', function () {
    return view('pages/dashboard');
});

// Settings page route
Route::get('/settings', function () {
    return view('pages/settings');
});

// User Institute List page route
Route::get('/userInstituteList', function () {
    return view('pages/userInstituteList');
});

// Institute List page route
Route::get('/instituteList', function () {
    return view('pages/instituteList');
});

// User Institute page route
Route::get('/userInstitute', function () {
    return view('pages/userInstitute');
});

// Transactions page route
Route::get('/transactions', function () {
    return view('pages/transactions');
});

// Profile and dashboard routes protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'pages/dashboard')->name('dashboard');
    Route::view('/profile', 'pages/profile')->name('profile');
});

// Institute resource routes
Route::resource('institute', InstituteController::class);
