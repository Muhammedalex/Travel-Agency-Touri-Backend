<?php

use App\Http\Controllers\Admin\Data\CountryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','setapplang'])->prefix('{locale}/admin')->group(function(){
    Route::apiResource('country' , CountryController::class);
});

