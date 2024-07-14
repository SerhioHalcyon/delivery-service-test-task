<?php

use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('delivery')
    ->name('delivery.')
    ->controller(DeliveryController::class)
    ->group(function () {
        Route::post('/', 'store')->name('store');
    });
