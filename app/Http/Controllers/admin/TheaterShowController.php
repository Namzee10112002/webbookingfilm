<?php

// app/Http/Controllers/Admin/TheaterShowController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Movie, MovieShow, MovieTheater};
use Illuminate\Http\Request;

class TheaterShowController extends Controller
{
    public function index(MovieTheater $theater, Movie $movie) {
        $roomIds = $theater->rooms()->pluck('id');
        $shows = MovieShow::with('room')
            ->where('movie_id',$movie->id)
            ->whereDate('time_start','>=',now())
            ->whereIn('room_id',$roomIds)
            ->orderBy('time_start','asc')->get();
        return view('admin.pages.shows.index', compact('theater','movie','shows'));
    }

    public function store(Request $r, MovieTheater $theater, Movie $movie) {
        $data = $r->validate([
            'room_id'    => 'required|exists:theater_rooms,id',
            'time_start' => 'required|date',
            'time_end'   => 'required|date|after:time_start',
            'price'      => 'required|numeric|min:0'
        ]);
        if (! $theater->rooms()->where('id',$data['room_id'])->exists()) {
            return back()->with('error','Phòng không thuộc rạp này.');
        }
        $show = MovieShow::create([
            'movie_id'=>$movie->id,
            'room_id'=>$data['room_id'],
            'time_start'=>$data['time_start'],
            'time_end'=>$data['time_end'],
            'price'=>$data['price'],
            'status_show'=>1
        ]);
        return back()->with('ok','Đã thêm suất chiếu.');
    }

    public function edit(MovieShow $show) {
        $theater = $show->room->theater;
        $rooms = $theater->rooms;
        return view('admin.pages.shows.edit', compact('show','theater','rooms'));
    }

    public function update(Request $r, MovieShow $show) {
        $data = $r->validate([
            'room_id'    => 'required|exists:theater_rooms,id',
            'time_start' => 'required|date',
            'time_end'   => 'required|date|after:time_start',
            'price'      => 'required|numeric|min:0',
            'status_show'=> 'nullable|in:0,1'
        ]);
        $show->update($data);
        return redirect()->route('admin.companies.shows', [$show->room->theater->id, $show->movie_id])
            ->with('ok','Đã cập nhật suất chiếu.');
    }

    public function toggle(MovieShow $show) {
        $show->status_show = $show->status_show ? 0 : 1;
        $show->save();
        return back()->with('ok','Đã đổi trạng thái hiển thị suất chiếu.');
    }
}

