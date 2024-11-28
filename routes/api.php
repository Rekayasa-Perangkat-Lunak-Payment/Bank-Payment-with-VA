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

// User route with API authentication middleware
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::post('/update-profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::post('/register', [UserController::class, 'register']);

Route::apiResource('transactions', TransactionController::class);
Route::apiResource('institutions', InstitutionController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('institution-admins', InstitutionAdminController::class);
Route::apiResource('bank-admins', BankAdminController::class);