<?php

use Cyntrek\Marx\Http\Controllers\MarxController;
use Illuminate\Support\Facades\Route;

Route::post('pay-now', [MarxController::class, 'payNow'])->name('marcx.pay.now');
Route::get('payment-confirm', [MarxController::class, 'payConfirm'])->name('marcx.pay-confirm');
