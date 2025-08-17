<?php

use App\Http\Controllers\user\HomeUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\user\UserBookingController;
use App\Http\Controllers\user\UserMovieController;
use App\Http\Controllers\user\UserPaymentController;

Route::get('/',[HomeUserController::class,'index'])->name('home');


Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/movie/{id}', [UserMovieController::class, 'show'])->name('movie.show');
Route::post('/movie/{id}/comment', [UserMovieController::class, 'addComment'])->name('movie.comment');
Route::post('/movie/{id}/like', [UserMovieController::class, 'toggleLike'])->name('movie.like');
Route::post('/movie/{id}/rate', [UserMovieController::class, 'rate'])->name('movie.rate');
Route::get('/movie/{id}/book/{city_id}', [UserBookingController::class, 'showTheaters'])->name('movie.book.city');
Route::get('/booking/{show_id}/seats', [UserBookingController::class, 'chooseSeats'])->name('booking.seats');
Route::post('/booking/{show_id}/store', [UserBookingController::class, 'storeSeats'])->name('booking.storeSeats');
Route::get('/payment/momo/{orderId}', [UserPaymentController::class, 'momoRedirect'])->name('payment.momo');
Route::get('/payment/momo/return', [UserPaymentController::class, 'momoReturn'])->name('payment.momo.return');