<?php

use App\Http\Controllers\PlaceController;
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

Route::middleware('auth')->group(function () {
    Route::get('/my-hosting', function () {
        return Inertia::render('Places/Index');
    })->name('my-hosting'); // middleware opcional para propietarios
});

Route::middleware('auth')->group(function () {
    Route::get('/createpleace', function () {
        return Inertia::render('Places/Create');
    })->name('createpleace'); // middleware opcional para propietarios
});
//TODO PÁGINAS PRINCIPALES (autenticadas) MENU
Route::middleware('auth')->group(function () {

    Route::resource('/accommodation_types',\App\Http\Controllers\AccommodationTypeController::class);
    Route::resource('/accommodations',\App\Http\Controllers\AccommodationController::class);
    Route::resource('/amenity_categories',\App\Http\Controllers\AmenityCategoryController::class);
    Route::resource('/amenities',\App\Http\Controllers\AmenityController::class);
    Route::resource('/accommodation_amenities',\App\Http\Controllers\AccommodationAmenityController::class);
    Route::resource('/abailability_slots',\App\Http\Controllers\AvailabilitySlotController::class);
    Route::resource('/bookings',\App\Http\Controllers\BookingController::class);
    Route::resource('/place_categories',\App\Http\Controllers\PlaceCategoryController::class);
    Route::resource('/places',\App\Http\Controllers\PlaceController::class);
    Route::resource('/restaurant_categories',\App\Http\Controllers\RestaurantCategoryController::class);
    Route::resource('/restaurants',\App\Http\Controllers\RestaurantController::class);
    Route::resource('/dishes',\App\Http\Controllers\DishController::class);
    Route::resource('/dish_restaurants',\App\Http\Controllers\DishRestaurantController::class);
    Route::resource('/event_categories',\App\Http\Controllers\EventCategoryController::class);
    Route::resource('/events',\App\Http\Controllers\EventController::class);
    Route::resource('/reviews',\App\Http\Controllers\ReviewController::class);
    Route::resource('/review_answers',\App\Http\Controllers\ReviewAnswerController::class);
    Route::resource('/review_likes',\App\Http\Controllers\ReviewLikeController::class);



// Route::prefix('api')->group(function () {
//     Route::post('/places', [PlaceController::class, 'apiStore']);
//     Route::get('/places', [PlaceController::class, 'index']); // paginación
//     Route::get('/places/{place}', [PlaceController::class, 'show']);
//     Route::put('/places/{place}', [PlaceController::class, 'update']);
//     Route::delete('/places/{place}', [PlaceController::class, 'destroy']);
// });



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
        return Inertia::render('ViewUser/Mapa/Mapa');
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
