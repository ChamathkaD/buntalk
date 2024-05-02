<?php

use Cyntrek\Outlet\Http\Controllers\Admin\OutletController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/outlet'], function () {

    Route::controller(OutletController::class)->group(function () {

        Route::get('', 'index')
            ->name('admin.outlet.index');

        Route::post('create', 'store')
            ->name('admin.outlet.store');

        Route::get('edit/{id}', 'edit')
            ->name('admin.outlet.edit');

        Route::put('edit/{id}', 'update')
            ->name('admin.outlet.update');

        Route::delete('edit/{id}', 'destroy')
            ->name('admin.outlet.destroy');
    });

});
