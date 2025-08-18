<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    public function index()
    {
        return view('user.pages.ticket-lookup');
    }

public function search(Request $request)
{
    $request->validate([
        'order_id' => 'required|integer'
    ]);

    $order = Order::with(['details.seat.show.room.theater', 'details.seat.show.movie'])
        ->findOrFail($request->order_id);

    $seatsPerRow = 20;
    foreach ($order->details as $detail) {
        $seatNumber = $detail->seat->seat_number; // vd: 23
        $row = floor(($seatNumber - 1) / $seatsPerRow);
        $col = ($seatNumber - 1) % $seatsPerRow + 1;
        $detail->seat_label = chr(65 + $row) . $col; // gán A1, B3...
    }

    return view('user.pages.ticket-result', compact('order'));
}

 public function myTicket()
    {
        $userId = Auth::id();

        // lấy đơn hàng của user
        $orders = Order::with([
            'details.seat.show.room.theater',
            'details.seat.show.movie'
        ])
        ->where('user_id', $userId)
        ->orderBy('date_order', 'desc')
        ->get();

        // phân loại đơn hàng: sắp chiếu / đã chiếu
        $upcoming = [];
        $past = [];

        foreach ($orders as $order) {
            $hasFuture = false;
            foreach ($order->details as $detail) {
                $show = $detail->seat->show;
                if ($show->time_start > Carbon::now()) {
                    $hasFuture = true;
                    break;
                }
            }
            if ($hasFuture) {
                $upcoming[] = $order;
            } else {
                $past[] = $order;
            }
        }

        return view('user.pages.my-ticket', compact('upcoming', 'past'));
    }


}
