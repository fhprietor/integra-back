<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTrackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/overview', [DashboardController::class, 'overview']);
    Route::get('/refresh', [AuthController::class, 'refresh']);
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customer', [CustomerController::class, 'show']);
    Route::get('/customer/{id}/tracking',[CustomerTrackingController::class,'index']);
    Route::get('/customer/{id}/loanHistory',[CustomerController::class,'loanHistory']);
    Route::get('/customer/{id}/salesByCustomer',[OperationController::class,'salesByCustomer']);

});

//Route::get('/survey-by-slug/{survey:slug}', [\App\Http\Controllers\SurveyController::class, 'showForGuest']);
//Route::post('/survey/{survey}/answer', [\App\Http\Controllers\SurveyController::class, 'storeAnswer']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
