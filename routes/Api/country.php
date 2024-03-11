<?php

use App\Http\Controllers\Admin\Data\CityController;
use App\Http\Controllers\Admin\Data\CountryController;
use App\Http\Controllers\Admin\Data\TransController;
use App\Http\Controllers\Admin\Data\TransPriceController;
use App\Http\Controllers\Admin\Employees\DriverController;
use App\Http\Controllers\Admin\Photo\PhotoDriverController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','setapplang'])->prefix('{locale}/admin')->group(function(){
    Route::apiResource('country' , CountryController::class);
    Route::apiResource('city' , CityController::class);
    Route::apiResource('transportation' , TransController::class);
    Route::apiResource('transprice' , TransPriceController::class);
    Route::apiResource('driver' , DriverController::class)->except('update');
    Route::post('driver/{driver}' , [DriverController::class,'update']);
    Route::apiResource('photo-driver',PhotoDriverController::class);


});

