<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductConTroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route("product.index"));
});
Route::resource('/product',ProductController::class);
Route::get('/product/delete/{id}', [ProductConTroller::class,'delete']);
Route::get('/pending', [ProductConTroller::class,'pending']);
Route::get('/approve', [ProductConTroller::class,'approve']);
Route::get('/reject', [ProductConTroller::class,'reject']);
Route::get('search', [ProductConTroller::class,'search'])->name='search';
