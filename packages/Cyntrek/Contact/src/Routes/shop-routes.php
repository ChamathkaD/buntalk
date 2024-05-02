<?php

use Cyntrek\Contact\Http\Controllers\Shop\ContactController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'contact'], function () {

    Route::get('', [ContactController::class, 'index'])
        ->name('shop.contact.index');

    Route::post('store', [ContactController::class, 'store'])
        ->name('shop.contact.store');
});
