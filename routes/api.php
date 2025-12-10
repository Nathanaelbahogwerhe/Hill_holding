<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\DepartmentApiController;
use App\Http\Controllers\Api\FilialeApiController;
use App\Http\Controllers\Api\LeaveTypeApiController;
use App\Http\Controllers\Api\LeaveApiController;
use App\Http\Controllers\Api\PayrollApiController;
use App\Http\Controllers\Api\InsurancePlanApiController;
use App\Http\Controllers\Api\EmployeeInsuranceApiController;
use App\Http\Controllers\Api\AssetApiController;
use App\Http\Controllers\Api\TransactionApiController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MessageController;

// Auth publiques
Route::post('/auth/login',  [AuthController::class, 'login']);

// ProtÃ©gÃ©es par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me',     [AuthController::class, 'me']);
    Route::post('/auth/logout',[AuthController::class, 'logout']);

    Route::apiResource('employees', EmployeeApiController::class);
    Route::apiResource('departments', DepartmentApiController::class);
    Route::apiResource('filiales', FilialeApiController::class);
    Route::apiResource('leave-types', LeaveTypeApiController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('leaves', LeaveApiController::class);
    Route::apiResource('payrolls', PayrollApiController::class);
    Route::apiResource('insurance-plans', InsurancePlanApiController::class);
    Route::apiResource('employee-insurances', EmployeeInsuranceApiController::class);
    Route::apiResource('assets', AssetApiController::class);
    Route::apiResource('transactions', TransactionApiController::class);
});










