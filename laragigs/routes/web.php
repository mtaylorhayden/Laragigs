<?php

use App\Models\listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use Symfony\Component\HttpFoundation\Request;

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


// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

////////////////////////////////////// listings //////////////////////////////////////


// show all listings
Route::get('/', [ListingController::class, 'index']);

// show create form
Route::get('listings/create', [ListingController::class, 'create'])->middleware('auth');

// create listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
;

// this needs to go to the bottom because anything after listing/ is a wildcard with that {listing}
// show single listing
Route::get('listings/{listing}', [ListingController::class, 'show']);


////////////////////////////////////// users //////////////////////////////////////


// show register/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create user
Route::post('/users', [UserController::class, 'store']);

// log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// log user in
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
