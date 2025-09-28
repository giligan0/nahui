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
    Route::resource('/amenity_categories',\App\Http\Controllers\Amenity_categoryController::class);
    Route::resource('/amenities',\App\Http\Controllers\AmenityController::class);
    Route::resource('/accommodation_amenities',\App\Http\Controllers\Accommodation_amenityController::class);
    Route::resource('/abailability_slots',\App\Http\Controllers\Abailability_slotsController::class);
    Route::resource('/bookings',\App\Http\Controllers\BookingController::class);
    Route::resource('/place_categories',\App\Http\Controllers\Place_categoryController::class);
    Route::resource('/places',\App\Http\Controllers\PlaceController::class);
    Route::resource('/restaurant_categories',\App\Http\Controllers\Restaurant_categoryController::class);
    Route::resource('/restaurants',\App\Http\Controllers\RestaurantController::class);
    Route::resource('/dishes',\App\Http\Controllers\DishController::class);
    Route::resource('/dish_restaurants',\App\Http\Controllers\Dish_restaurantsController::class);
    Route::resource('/event_categories',\App\Http\Controllers\Event_categoryController::class);
    Route::resource('/events',\App\Http\Controllers\EventController::class);
    Route::resource('/reviews',\App\Http\Controllers\ReviewController::class);
    Route::resource('/review_answers',\App\Http\Controllers\Review_answerController::class);
    Route::resource('/review_likes',\App\Http\Controllers\Review_likeController::class);




    
  Route::get('/createplace', function () {
    return Inertia::render('ViewProp/CreatePlace');
})->name('createplace');

    Route::get('/home', function () {
        return Inertia::render('ViewUser/principal/principal');
    })->name('home');

    Route::get('/place', function () {
        return Inertia::render('ViewUser/Place');
    })->name('place');

    Route::get('/transporte', function () {
        return Inertia::render('Transporte');
    })->name('transporte');

    Route::get('/mapa', function () {
        return Inertia::render('Mapa');
    })->name('mapa');
    



    // TODO RUTAS GENERALES

        Route::get('/location', function () {
        return Inertia::render('ViewUser/Location_info/Location_info');
    })->name('location');


    

    // PERFIL DE USUARIO
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
