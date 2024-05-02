<?php

use Cyntrek\Contact\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/contact'], function () {
    Route::controller(ContactController::class)->group(function () {
        Route::get('', 'index')
            ->name('admin.contact.index');
    });
});
