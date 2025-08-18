<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\admin\CompanyController;
use App\Http\Controllers\admin\CompanyTheaterController;
use App\Http\Controllers\admin\ShowMonitorController;
use App\Http\Controllers\admin\TheaterMovieController;
use App\Http\Controllers\admin\TheaterRoomController;
use App\Http\Controllers\admin\TheaterShowController;
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
Route::prefix('admin/companies')->name('admin.companies.')
->group(function () {
    // Hãng rạp
    Route::get('/', [CompanyController::class,'index'])->name('index');
    Route::post('/', [CompanyController::class,'store'])->name('store');
    Route::get('{company}/edit', [CompanyController::class,'edit'])->name('edit');
    Route::put('{company}', [CompanyController::class,'update'])->name('update');
    Route::patch('{company}/toggle', [CompanyController::class,'toggle'])->name('toggle');

    // B1: Popup chọn thành phố → danh sách rạp của Hãng tại TP đó
    Route::get('{company}/cities', [CompanyTheaterController::class,'chooseCity'])->name('cities');
    Route::get('{company}/cities/{city}', [CompanyTheaterController::class,'index'])->name('theaters');
    Route::post('{company}/cities/{city}', [CompanyTheaterController::class,'store'])->name('theaters.store');
    Route::get('{company}/cities/{city}/{theater}/edit', [CompanyTheaterController::class,'edit'])->name('theaters.edit');
    Route::put('{company}/cities/{city}/{theater}', [CompanyTheaterController::class,'update'])->name('theaters.update');
    Route::patch('{company}/cities/{city}/{theater}/toggle', [CompanyTheaterController::class,'toggle'])->name('theaters.toggle');

    // B2: Chi tiết Rạp → danh sách Phòng
    Route::get('theaters/{theater}/rooms', [TheaterRoomController::class,'index'])->name('rooms');
    Route::post('theaters/{theater}/rooms', [TheaterRoomController::class,'store'])->name('rooms.store');
    Route::get('theaters/{theater}/rooms/{room}/edit', [TheaterRoomController::class,'edit'])->name('rooms.edit');
    Route::put('theaters/{theater}/rooms/{room}', [TheaterRoomController::class,'update'])->name('rooms.update');
    Route::patch('theaters/{theater}/rooms/{room}/toggle', [TheaterRoomController::class,'toggle'])->name('rooms.toggle');

    // B3: Ở trang danh sách rạp (chi nhánh) có tab “Phim đang chiếu tại chi nhánh”
    Route::get('theaters/{theater}/movies', [TheaterMovieController::class,'index'])->name('theater.movies');
    // Thêm “phim đang chiếu” thực chất là tạo suất chiếu đầu tiên cho phim tại rạp này
    Route::post('theaters/{theater}/movies', [TheaterMovieController::class,'attachMovie'])->name('theater.movies.attach');

    // B4: Quản lý suất chiếu của 1 phim tại rạp
    Route::get('theaters/{theater}/movies/{movie}/shows', [TheaterShowController::class,'index'])->name('shows');
    Route::post('theaters/{theater}/movies/{movie}/shows', [TheaterShowController::class,'store'])->name('shows.store');
    Route::get('shows/{show}/edit', [TheaterShowController::class,'edit'])->name('shows.edit');
    Route::put('shows/{show}', [TheaterShowController::class,'update'])->name('shows.update');
    Route::patch('shows/{show}/toggle', [TheaterShowController::class,'toggle'])->name('shows.toggle');

    // B5: Chi tiết suất chiếu → bản đồ ghế (read-only)
    Route::get('shows/{show}/monitor', [ShowMonitorController::class,'monitor'])->name('shows.monitor');
});