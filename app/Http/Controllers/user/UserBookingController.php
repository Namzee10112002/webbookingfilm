<?php

namespace App\Http\Controllers\user;

use App\Models\City;
use App\Models\Movie;
use App\Models\MovieTheater;
use App\Models\TheaterCompany;
use App\Models\MovieShow;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShowSeat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserBookingController
{
    // Bước 1: chọn thành phố
    public function selectCity($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $cities = City::all();
        return view('user.pages.select_city', compact('movie', 'cities'));
    }

    // Bước 2: hiển thị rạp chiếu trong city
    public function showTheaters(Request $request, $movieId, $cityId)
    {
        $movie = Movie::findOrFail($movieId);
        $city = City::findOrFail($cityId);
        $companies = TheaterCompany::all();

        $date = $request->input('date', Carbon::today()->toDateString());
        // Rạp trong city
        $theaters = MovieTheater::with('company')
            ->where('city_id', $cityId)
            ->get();

        foreach ($theaters as $theater) {
            $shows = MovieShow::where('movie_id', $movieId)
                ->whereHas('room', function ($q) use ($theater) {
                    $q->where('theater_id', $theater->id);
                })
                ->whereDate('time_start', $date)
                ->when($date == Carbon::today()->toDateString(), function ($q) {
                    $q->where('time_start', '>', Carbon::now());
                })
                ->with('room')
                ->get();


            foreach ($shows as $show) {
                $totalSeats   = $show->room->seat ?? 0;
                $bookedSeats  = $show->seats()->count();
                $show->available_seats = $totalSeats - $bookedSeats;
            }

            $theater->shows = $shows;
        }

        return view('user.pages.theaters', compact('movie', 'city', 'companies', 'theaters', 'date'));
    }

    public function chooseSeats($showId)
    {
        $show = MovieShow::with(['room.theater'])->findOrFail($showId);

        $totalSeats = $show->room->seat;
        $seatsPerRow = 20;

        // Tính số hàng
        $rows = ceil($totalSeats / $seatsPerRow);

        // Ghế đã đặt
        $bookedSeats = ShowSeat::where('show_id', $showId)->pluck('seat_number')->toArray();

        return view('user.pages.seats', compact('show', 'rows', 'seatsPerRow', 'bookedSeats', 'totalSeats'));
    }


    public function storeSeats(Request $request, $showId)
    {
        $request->validate([
            'seats' => 'required|string', // gửi chuỗi, ví dụ "122,123"
            'name_order' => 'required|string',
            'email_order' => 'required|email',
            'phone_order' => 'required|string',
            'payment_method' => 'required|in:0,1',
        ]);

        $show = MovieShow::with('room')->findOrFail($showId);

        // chuyển thành mảng ghế
        $seats = explode(',', $request->seats);

        if (count($seats) === 0) {
            return back()->withErrors(['seats' => 'Bạn phải chọn ít nhất 1 ghế']);
        }

        // check ghế đã đặt
        $booked = ShowSeat::where('show_id', $showId)
            ->whereIn('seat_number', $seats)
            ->pluck('seat_number')
            ->toArray();

        if (!empty($booked)) {
            return back()->withErrors(['seats' => 'Một số ghế đã có người đặt: ' . implode(', ', $booked)]);
        }

        $totalPrice = count($seats) * $show->price;


            // tạo order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'name_order' => $request->name_order,
                'email_order' => $request->email_order,
                'phone_order' => $request->phone_order,
                'total_order' => $totalPrice,
                'method_pay' => $request->payment_method,
                'status_order' => 0,
            ]);

            // lưu ghế + order detail
            foreach ($seats as $seat) {
                $showSeat = ShowSeat::create([
                    'show_id' => $showId,
                    'seat_number' => $seat
                ]);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'show_id' => $showId,
                    'seat_id' => $showSeat->id,
                ]);
            }

            DB::commit();

            if ($request->payment_method == 1) {
                $momoResponse = UserPaymentController::callMomoPayment($totalPrice);

                if (isset($momoResponse['payUrl'])) {
                    return redirect()->route('home')->with('momo_pay_url', $momoResponse['payUrl']);
                } else{
                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo liên kết thanh toán.');
                }
            }

            return redirect()->route('home')->with('success', 'Đặt vé thành công!');
    }
}
