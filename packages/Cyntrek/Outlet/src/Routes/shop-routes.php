<?php

use Illuminate\Support\Facades\Route;
use Cyntrek\Outlet\Http\Controllers\Shop\OutletController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'outlet'], function () {
    Route::get('', [OutletController::class, 'index'])->name('shop.outlet.index');
});