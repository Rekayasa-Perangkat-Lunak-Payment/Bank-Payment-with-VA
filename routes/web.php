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
Route::get('/addUserInstitute', [PageController::class, 'addUserInstitutePage'])->name('addUserInstitute');
Route::get('/userInstitute/{id}', [PageController::class, 'userInstitutePage'])->name('userInstitute');

Route::get('/user/{id}/disable', [PageController::class, 'disableUserView'])->name('user.disable');
Route::get('/user/{id}/change-password', [PageController::class, 'changePasswordView'])->name('user.changePassword');
Route::get('/user/{id}/edit', [PageController::class, 'editUserView'])->name('user.edit');

Route::get('/studentList', [PageController::class, 'studentListPage'])->name('studentList');
Route::get('/addStudent', [PageController::class, 'addStudentPage']);
Route::get('/student/{id}', [PageController::class, 'studentPage']);

Route::get('/paymentPeriodList', [PageController::class, 'paymentPeriodListPage'])->name('paymentPeriodList');
Route::get('/paymentPeriod/{id}', [PageController::class, 'paymentPeriodPage'])->name('paymentPeriod');

Route::get('/invoiceList', [PageController::class, 'invoiceListPage'])->name('invoiceList');
Route::get('/invoice/{id}', [PageController::class, 'invoicePage'])->name('invoice');

Route::get('/transactions', [PageController::class, 'transactionsPage'])->name('transactions');
Route::get('/transactions/{id}', [PageController::class, 'transactionPage'])->name('transaction');
