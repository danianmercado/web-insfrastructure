<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ShortLinkController::class, 'index'])->name('shortenLink.index');

// Route to handle form submission and store a new short link
Route::post('/generate-shorten-link', [ShortLinkController::class, 'store'])->name('shortenLink.store');

// Route to redirect to the original link based on the provided code
Route::get('/{code}', [ShortLinkController::class, 'shortenLink'])->name('shortenLink.redirect');
