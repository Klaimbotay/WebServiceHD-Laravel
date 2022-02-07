<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DietsController;
use App\Http\Controllers\CalculatorController;


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
    return view('welcome');
});

Route::view('/home', 'home')->middleware(['auth', 'verified']);

Route::resource('calc', CalculatorController::class)->middleware(['auth', 'verified']);
Route::resource('profile', ProfileController::class)->middleware(['auth', 'verified']);
Route::resource('diets', DietsController::class)->middleware(['auth', 'verified']);

//Route::get('password', [ProfileController::class, 'store'])->middleware(['auth', 'verified']);
Route::put('profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified']);
Route::put('diets', [DietsController::class, 'update'])->middleware(['auth', 'verified']);
Route::post('diets/{id}', [DietsController::class, 'destroy'])->name('destroy')->middleware(['auth', 'verified']);
//Route::view('/diets', 'diets')->middleware(['auth', 'verified']);


//Route::view('/calulator', 'calculator')->middleware(['auth', 'verified']);
