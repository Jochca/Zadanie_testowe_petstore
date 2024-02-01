<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pets.index');
});

Route::get('/pets', [App\Http\Controllers\PetController::class, 'index'])->name('pets.index');
Route::post('/pets', [App\Http\Controllers\PetController::class, 'store'])->name('pets.store');
Route::put('/pets', [App\Http\Controllers\PetController::class, 'update'])->name('pets.update');
Route::delete('/pets', [App\Http\Controllers\PetController::class, 'destroy'])->name('pets.destroy');
