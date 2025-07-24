<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;
use App\Models\Transaction;

Route::get('/', function () {
    return view('payment'); // Halaman pilih metode pembayaran
});

Route::post('/checkout', [MidtransController::class, 'checkout'])->name('checkout');
Route::post('/payment/callback', [MidtransController::class, 'handleCallback']);
Route::get('/payment/success', function () {
    return view('success');
});
Route::get('/transactions', [MidtransController::class, 'list'])->name('transactions.index');
Route::post('/transactions/check/{orderId}', [MidtransController::class, 'checkStatus'])->name('transactions.check');
