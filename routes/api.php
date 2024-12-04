<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstitutionAdminController;
use App\Http\Controllers\BankAdminController;

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

// Route::prefix('admin')->group(function () {
//     Route::apiResource('institution-admins', InstitutionAdminController::class);
//     Route::apiResource('bank-admins', BankAdminController::class);
// });
