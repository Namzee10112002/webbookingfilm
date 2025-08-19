<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MovieShow;

class ShowMonitorController extends Controller
{
    public function monitor(MovieShow $show) {
        $room = $show->room;
        $totalSeats = (int)$room->seat; // :contentReference[oaicite:13]{index=13}
        $bookedSeatNumbers = $show->seats()->where('status_seat',0)->pluck('seat_number')->toArray(); // :contentReference[oaicite:14]{index=14}

        $seatsPerRow = 20;
        $rows = (int)ceil($totalSeats / $seatsPerRow);

        return view('admin.pages.shows.monitor', [
            'show'=>$show,
            'room'=>$room,
            'totalSeats'=>$totalSeats,
            'bookedSeats'=>$bookedSeatNumbers,
            'rows'=>$rows,
            'seatsPerRow'=>$seatsPerRow
        ]);
    }
}

