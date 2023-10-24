<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

/**
 * ces routes sont pour la partie authentification
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/**
 * Les routes de resource sont utilisé pour simplifier le CRUD avec laravel
 * nous allons créer deux routes dans la route resource qui accéder à l'index et le store controller puis
 * ajouter un middleware
 */
Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store']) //ici, la methode only active les routes index et store uniquement
    ->middleware('auth'); //le middleware permet à l'utilisateur d'accéder à la page index et store si et seulement si il est connecté

require __DIR__.'/auth.php';
