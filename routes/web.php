<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
Route::get('/',[AuthController::class,'login']);
Route::post('/',[AuthController::class,'auth_login']);
Route::get('/logout',[AuthController::class,'logout']);

Route::group(['middleware'=>'useradmin'],function(){

    Route::get('panel/dashboard', [DashboardController::class, 'dashboard']);
    
});
