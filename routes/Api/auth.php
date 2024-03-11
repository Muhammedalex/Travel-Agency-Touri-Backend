<?php

use App\Http\Controllers\Admin\RolesAndPermissionsController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UpdateProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::middleware('setapplang')->prefix('{locale}')->group(function(){
    Route::post('/auth/register',[RegisterController::class , 'register']);

    Route::post('/auth/login',[LoginController::class , 'login']);
    
    Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'forgotPass']);
    
    Route::post('/auth/reset-password', [ResetPasswordController::class, 'resetPass']);
    Route::post('/auth/email', [EmailVerificationController::class, 'email']);

    
});

Route::middleware(['auth:sanctum','setapplang'])->prefix('{locale}')->group(function () {
    Route::get('/auth/profile',function(Request $request){
        return Auth::guard('sanctum')->user();
    });
    Route::post('/auth/logout', [LoginController::class, 'logout']);

    Route::post('/auth/update-profile',[UpdateProfileController::class,'update']);
    Route::get('/auth/get-otp', [EmailVerificationController::class, 'sendEmailVerifiy']);
});

//spati

Route::middleware(['auth:sanctum','setapplang'])->prefix('{locale}/admin')->group(function(){
    Route::apiResource('role-permission', RolesAndPermissionsController::class);
});