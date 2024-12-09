<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstitutionAdminController;
use App\Http\Controllers\BankAdminController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\VirtualAccountController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\PaymentPeriodController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth.token')->get('/profile', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login', [UserController::class, 'login'])->name('login');
// Route::post('/logout', [UserController::class, 'logout'])->middleware('auth.token');
// Route::get('/profile', [UserController::class, 'profile'])->middleware('auth.token');
// Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware('auth.token');
// Route::post('/register', [UserController::class, 'register']);

Route::apiResource('transactions', TransactionController::class);
Route::apiResource('institutions', InstitutionController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('userInstitutions', InstitutionAdminController::class);
Route::put('userInstitutions/{id}/disable', [InstitutionAdminController::class, 'disable']);
Route::apiResource('userBanks', BankAdminController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('invoiceItems', InvoiceItemController::class);
Route::apiResource('virtualAccounts', VirtualAccountController::class);
Route::apiResource('itemTypes', ItemTypeController::class);
Route::apiResource('paymentPeriod', PaymentPeriodController::class);

Route::get('/virtualAccountList/{id}', [VirtualAccountController::class, 'getVirtualAccountsByPaymentPeriod']);
Route::post('/bulk-virtual-accounts', [VirtualAccountController::class, 'storeBulkVirtualAccounts']);
Route::get('/students/paymentPeriod/{paymentPeriodId}', [VirtualAccountController::class, 'getStudentsByPaymentPeriod']);
Route::get('/available-filter-options/{paymentPeriodId}', [VirtualAccountController::class, 'getAvailableFilterOptions']);
// Route::prefix('admin')->group(function () {
//     Route::apiResource('institution-admins', InstitutionAdminController::class);
//     Route::apiResource('bank-admins', BankAdminController::class);
// });
