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

//TODO PÁGINAS PRINCIPALES (autenticadas)
Route::middleware('auth')->group(function () {


    Route::resource('/accommodation_types',\App\Http\Controllers\AccommodationTypesController::class);
    Route::resource('/accommodations',\App\Http\Controllers\AccommodationController::class);
    Route::resource('/amenity_categories',\App\Http\Controllers\AmenityCategoryController::class);
    Route::resource('/amenities',\App\Http\Controllers\AmenityController::class);
    Route::resource('/accommodation_amenities',\App\Http\Controllers\AccommodationAmenityController::class);
    Route::resource('/abailability_slots',\App\Http\Controllers\AbailabilitySlotsController::class);
    Route::resource('/bookings',\App\Http\Controllers\BookingController::class);
    Route::resource('/place_categories',\App\Http\Controllers\PlaceCategoryController::class);
    Route::resource('/places',\App\Http\Controllers\PlaceController::class);
    Route::resource('/restaurant_categories',\App\Http\Controllers\RestaurantCategoryController::class);
    Route::resource('/restaurants',\App\Http\Controllers\RestaurantController::class);
    Route::resource('/dishes',\App\Http\Controllers\DishController::class);
    Route::resource('/dish_restaurants',\App\Http\Controllers\DishRestaurantsController::class);
    Route::resource('/event_categories',\App\Http\Controllers\EventCategoryController::class);
    Route::resource('/events',\App\Http\Controllers\EventController::class);
    Route::resource('/reviews',\App\Http\Controllers\ReviewController::class);
    Route::resource('/review_answers',\App\Http\Controllers\ReviewAnswerController::class);
    Route::resource('/review_likes',\App\Http\Controllers\ReviewLikeController::class);



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

    // PERFIL DE USUARIO
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
