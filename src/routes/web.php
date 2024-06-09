<?php

use Illuminate\Support\Facades\Route;
use App\Models\Shoes;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', [\App\Http\Controllers\ShoesController::class, 'index']);
Route::get('add/{id}', [\App\Http\Controllers\ShoesController::class, 'addToCart']);
Route::get('update/{id}/{amount}', [\App\Http\Controllers\ShoesController::class, 'updateItemCart']);
Route::get('delete/{id}', [\App\Http\Controllers\ShoesController::class, 'deleteItemCart']);
Route::get('showCart', [\App\Http\Controllers\ShoesController::class, 'showCart']);



