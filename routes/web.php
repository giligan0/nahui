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

    Route::resource('/accommodation_types',\App\Http\Controllers\Accommodation_typesController::class);
    Route::resource('/accommodations',\App\Http\Controllers\AccommodationController::class);
    Route::resource('/amenity_categories',\App\Http\Controllers\Amenity_categoriesController::class);
    Route::resource('/amenities',\App\Http\Controllers\AmenitiesController::class);
    Route::resource('/abailability_slots',\App\Http\Controllers\Abailability_slotsController::class);
    Route::resource('/bookings',\App\Http\Controllers\BookingController::class);
    Route::resource('/place_categories',\App\Http\Controllers\Place_categoryController::class);
    Route::resource('/places',\App\Http\Controllers\PlaceController::class);
    Route::resource('/restaurant_categories',\App\Http\Controllers\Restaurant_categoryController::class);
    Route::resource('/dish_restaurants',\App\Http\Controllers\Dish_restaurantsController::class);
    Route::resource('/accommodations',\App\Http\Controllers\AccommodationController::class);

    Route::resource('/reviews',\App\Http\Controllers\ReviewController::class);



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
