<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffresController;
use App\Http\Controllers\UtilisateurController;
/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [AuthController::class, 'register'])->name('register');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (!session()->has('user')) {
        return redirect()->route('login.form');
    }

    return view('dashboard');

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| Offres
|--------------------------------------------------------------------------
*/

Route::resource('offres', OffresController::class);


Route::resource('utilisateurs', UtilisateurController::class);

Route::put('/utilisateurs/{id}/activer',
    [UtilisateurController::class,'activer'])
    ->name('utilisateurs.activer');

Route::put('/utilisateurs/{id}/desactiver',
    [UtilisateurController::class,'desactiver'])
    ->name('utilisateurs.desactiver');
  