<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\MovieTheater;
use App\Models\TheaterCompany;
use App\Models\Movie;

class OrderController extends Controller
{
    // Hóa đơn theo hãng
    public function byCompany(Request $request, $companyId)
    {
        $query = Order::with(['user', 'details.seat.show.room.theater', 'details.seat.show.movie'])
            ->whereHas('details.seat.show.room.theater', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });

        // Tìm kiếm
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('id', $q)
                  ->orWhereHas('user', fn($u) => $u->where('name','like',"%$q%"))
                  ->orWhereHas('details.seat.show.movie', fn($m) => $m->where('name_movie','like',"%$q%"));
        }

        $orders = $query->paginate(10);
        return view('admin.pages.orders.index', compact('orders'));
    }

    // Hóa đơn theo rạp
    public function byTheater(Request $request, $theaterId)
    {
        $query = Order::with(['user', 'details.seat.show.room.theater', 'details.seat.show.movie'])
        ->whereHas('details.seat.show.room.theater', function ($q) use ($theaterId) {
                $q->where('theater_id', $theaterId);
            });

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('id', $q)
                  ->orWhereHas('user', fn($u) => $u->where('name','like',"%$q%"))
                  ->orWhereHas('details.seat.show.movie', fn($m) => $m->where('name_movie','like',"%$q%"));
        }

        $orders = $query->paginate(10);
        return view('admin.pages.orders.index', compact('orders'));
    }

    // Hóa đơn theo phim
    public function byMovie(Request $request, $movieId)
    {
        $query = Order::with(['user', 'details.seat.show.room.theater', 'details.seat.show.movie'])
            ->whereHas('details.seat.show', function ($q) use ($movieId) {
                $q->where('movie_id', $movieId);
            });

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('id', $q)
                  ->orWhereHas('user', fn($u) => $u->where('name','like',"%$q%"));
        }

        $orders = $query->paginate(10);
        return view('admin.pages.orders.index', compact('orders'));
    }

    // Chi tiết hóa đơn
    public function show($orderId)
    {
        $order = Order::with(['user', 'details.seat.show.room.theater.company', 'details.seat.show.movie', 'details.seat.show'])->findOrFail($orderId);
        return view('admin.pages.orders.show', compact('order'));
    }

    public function chooseCompany()
{
    $companies = TheaterCompany::all();
    return view('admin.pages.orders.choose-company', compact('companies'));
}

public function chooseTheater()
{
    $theaters = MovieTheater::with('company')->get();
    return view('admin.pages.orders.choose-theater', compact('theaters'));
}

public function chooseMovie()
{
    $movies = Movie::all();
    return view('admin.pages.orders.choose-movie', compact('movies'));
}
}

