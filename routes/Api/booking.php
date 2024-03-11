<?php

use App\Http\Controllers\Booking\Accommodation\AccommodationController;
use App\Http\Controllers\Booking\Accommodation\AccTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','setapplang'])->prefix('{locale}/booking')->group(function(){
    Route::apiResource('accomodation-types',AccTypeController::class)->except('show');
    Route::apiResource('accomodations',AccommodationController::class);


});