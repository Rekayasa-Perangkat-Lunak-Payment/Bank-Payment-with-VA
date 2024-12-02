<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [PageController::class, 'showLoginPage']);
Route::get('/institutionAdmin', 'InstitutionAdminPageController@index')->name('institutionAdmin')->middleware('institution_admin');
Route::get('/bankAdmin', 'BankAdminPageController@index')->name('bankAdmin')->middleware('bank_admin');

Route::get('/dashboard', [PageController::class, 'showDashboardPage']);
Route::get('/settings', [PageController::class, 'showSettingsPage']);
Route::get('/instituteList', [PageController::class, 'showInstituteListPage']);
Route::get('/profile', [PageController::class, 'showProfilePage']);