<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\user\HomeUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\user\UserBookingController;
use App\Http\Controllers\user\UserCompanyController;
use App\Http\Controllers\user\UserMovieController;
use App\Http\Controllers\user\UserPaymentController;
use App\Http\Controllers\user\UserProfileController;
use App\Http\Controllers\User\UserTicketController;

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

Route::get('/companies', [UserCompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/{company}', [UserCompanyController::class, 'show'])->name('companies.show');
Route::post('/companies/{company}/theaters', [UserCompanyController::class, 'getTheaters'])->name('companies.theaters');
Route::post('/theaters/{theater}/movies', [UserCompanyController::class, 'getMovies'])->name('theaters.movies');
Route::post('/theaters/{theaterId}/movies/{movieId}/shows', [UserCompanyController::class, 'getMovieShows'])->name('movies.shows');
Route::get('/ticket/lookup', [UserTicketController::class, 'index'])->name('ticket.lookup');
Route::post('/ticket/lookup', [UserTicketController::class, 'search'])->name('ticket.search');

 Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
 Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

  Route::get('/my-tickets', [UserTicketController::class, 'myTicket'])->name('user.tickets');


  Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');
    
    Route::get('users', [UserController::class,'index'])->name('users.index');
    Route::post('users/{user}/toggle-status', [UserController::class,'toggleStatus'])->name('users.toggle-status');

     Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::post('cities', [CityController::class, 'store'])->name('cities.store');
    Route::put('cities/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::post('cities/toggle/{id}', [CityController::class, 'toggleStatus'])->name('cities.toggle');
});