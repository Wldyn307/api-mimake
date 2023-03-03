<?php

use Illuminate\Http\Request;
use App\Http\Controllers\barangC;
use App\Http\Controllers\transaksiC;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/barang', barangC::class);
Route::apiResource('/transaksi', transaksiC::class);


// route::get('/transactions',[transactionsC::class,'index'])->middleware(['auth:sanctum']);
// route::get('/transactions/{id}',[transactionsC::class,'detail'])->middleware(['auth:sanctum']);

// route::post('/login',[AuthC::class,'login']);


