<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// LOGIN Y REGISTRO
Route::get('/', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

//TODO PÁGINAS PRINCIPALES (autenticadas) MENU
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return Inertia::render('principal/principal');
    })->name('home');

    Route::get('/place', function () {
        return Inertia::render('Place');
    })->name('place');

    Route::get('/transporte', function () {
        return Inertia::render('Transporte');
    })->name('transporte');

    Route::get('/mapa', function () {
        return Inertia::render('Mapa');
    })->name('mapa');


    // TODO RUTAS GENERALES

        Route::get('/location', function () {
        return Inertia::render('Location_info/Location_info');
    })->name('location');


    

    // PERFIL DE USUARIO
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
