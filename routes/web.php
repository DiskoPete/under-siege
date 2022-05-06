<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', fn() => view('home'));

Route::get('imprint', fn() => view('imprint'))->name('imprint');

Route::get('sieges/{siege:uuid}', \App\Http\Controllers\Sieges\ViewController::class)->name('sieges.details');
Route::post('sieges', \App\Http\Controllers\Sieges\CreateController::class)->name('sieges.create');

