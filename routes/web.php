<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
// all listings
Route::get('/', [ListingController::class, 'index']);
// create listing
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');
// store listing data
Route::post('/listing', [ListingController::class, 'store'])->middleware('auth');
// editing listing
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
// Update listing
Route::put('/listing/{listing}', [ListingController::class, 'update'])->middleware('auth');
// Delete listing
Route::delete('/listing/{listing}', [ListingController::class, 'destroy'])->middleware('auth');
// Manage user listings
Route::get('/listing/manage', [ListingController::class, 'manage'])->middleware('auth');
// single listing
Route::get('/listing/{listing}', [ListingController::class, 'show']);
// show Register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
// create new user
Route::post('/users', [UserController::class, 'store']);
// Log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
// Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
// Login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

