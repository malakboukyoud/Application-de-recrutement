<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/dashboard', function () {

    return "Bienvenue dans le système ORMVASM";

});
