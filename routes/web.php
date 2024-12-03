<?php
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Auth::routes();
// Route::get('/', [PageController::class, 'showLoginPage']);
// Route::get('/institutionAdmin', 'InstitutionAdminPageController@index')->name('institutionAdmin')->middleware('institution_admin');
// Route::get('/bankAdmin', 'BankAdminPageController@index')->name('bankAdmin')->middleware('bank_admin');

Route::get('/dashboard', [PageController::class, 'dashboardPage']);
Route::get('/settings', [PageController::class, 'settingsPage']);

Route::get('/instituteList', [PageController::class, 'instituteListPage']);
Route::get('/institute/{id}', [PageController::class, 'institutePage']);
Route::get('/addInstitute', [PageController::class, 'addInstitutePage']);

Route::get('/userInstituteList', [PageController::class, 'userInstituteListPage'])->name('userInstituteList');
Route::get('/addUserInstitute', [PageController::class, 'addUserInstitutePage']);