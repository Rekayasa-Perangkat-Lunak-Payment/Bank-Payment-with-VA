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
use App\Models\ItemType;
use App\Models\Student;

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


Route::post('/login', [UserController::class, 'login'])->name('login');

Route::apiResource('transactions', TransactionController::class);
Route::get('/transactions/institution/{institutionId}', [TransactionController::class, 'getTransactionsByInstitutionId']);
Route::get('/transactions/institution/{institutionId}/paymentPeriod/{paymentPeriodId}', [TransactionController::class, 'getTransactionsByInstitutionIdAndPaymentPeriodId']);

Route::apiResource('institutions', InstitutionController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('userInstitutions', InstitutionAdminController::class);
Route::put('userInstitutions/{id}/disable', [InstitutionAdminController::class, 'disable']);
Route::apiResource('userBanks', BankAdminController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('invoiceItems', InvoiceItemController::class);
Route::apiResource('virtualAccounts', VirtualAccountController::class);
Route::apiResource('itemTypes', ItemTypeController::class);

Route::apiResource('paymentPeriods', PaymentPeriodController::class);
Route::get('/paymentPeriods/institution/{institutionId}', [PaymentPeriodController::class, 'getPaymentPeriodsByInstitution']);

Route::get('/virtualAccountList/{id}', [VirtualAccountController::class, 'getVirtualAccountsByPaymentPeriod']);
Route::get('/virtualAccounts/institution/{institutionId}', [VirtualAccountController::class, 'getVirtualAccountsByInstitution']);
Route::get('/virtualAccounts/institution/{institutionId}/paymentPeriod/{paymentPeriodId}', [VirtualAccountController::class, 'getVirtualAccountsByInstitutionAndPaymentPeriod']);
Route::get('/institution/{institutionId}/itemTypes', [ItemTypeController::class, 'getInstitutionItemTypes']);
Route::post('/bulk-virtual-accounts', [VirtualAccountController::class, 'storeBulkVirtualAccounts']);
Route::get('/students/institution/{institutionId}', [StudentController::class, 'getStudentsByInstitution']);
Route::get('/students/paymentPeriod/{paymentPeriodId}', [VirtualAccountController::class, 'getStudentsByPaymentPeriod']);
Route::get('/available-filter-options/{paymentPeriodId}', [VirtualAccountController::class, 'getAvailableFilterOptions']);
Route::post('/students/login', [StudentController::class, 'login']);