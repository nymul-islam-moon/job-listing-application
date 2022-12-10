<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

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

    // All Listings
    Route::get('/', [ListingController::class, 'index']);

    // Show Create Form
    Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

    // Store Listing Data
    Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

    // Show Edit Form
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

    // Update Listing
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

    // Delete Listing
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

     // Manage Listings
     Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

    // Single Listing
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->middleware('auth');

    // Show Register/Create Form
    Route::get('/register', [UserController::class, 'create'])->middleware('guest');

    // Create New User
    Route::post('/users', [UserController::class, 'store'])->middleware('guest');

    // Log User Out
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

    // Show Login Form
    Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

    // Log in user
    Route::post('/users/authenticate', [UserController::class, 'authenticate']);


    // Route::post('/users', function () {
    //     return response('<h1>Hello World!</h1>', 400);
    // });

//     Route::get('/post/{id}', function ($id) {
//         // dd($id); // die and dump
//         // ddd($id); // die, dump and debug
//         return response('Post ' . $id);
//     })->where('id', '[0-9]');

//     Route::get('/search', function (Request $request) {
//         // dd($request);
//         return $request->name . ' ' . $request->city; // set the url as like search?name=name&city=city
//     });

// });
