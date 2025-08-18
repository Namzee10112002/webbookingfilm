<?php

// app/Http/Controllers/Admin/TheaterRoomController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{MovieTheater, TheaterRoom};
use Illuminate\Http\Request;

class TheaterRoomController extends Controller
{
    public function index(MovieTheater $theater) {
        $rooms = $theater->rooms()->orderBy('id','desc')->get();
        return view('admin.pages.rooms.index', compact('theater','rooms'));
    }

    public function store(Request $r, MovieTheater $theater) {
        $data = $r->validate([
            'name_room'   => 'required|max:255',
            'seat'        => 'required|integer|min:1',
            'status_room' => 'nullable|in:0,1'
        ]);
        $data['theater_id'] = $theater->id;
        $data['status_room'] = $data['status_room'] ?? 0;
        TheaterRoom::create($data);
        return back()->with('ok','Đã thêm phòng.');
    }

    public function edit($theaterId, $roomId)
    {
        $room = TheaterRoom::with('theater.city','theater.company')->findOrFail($roomId);
        $theaters = MovieTheater::whereHas('company', function ($q) use ($room) {
                $q->where('id', $room->theater->company_id);
            })->whereHas('city', function ($q) use ($room) {
                $q->where('id', $room->theater->city_id);
            })->get();

        return view('admin.pages.rooms.edit', compact('room', 'theaters'));
    }

    public function update(Request $request, $theaterId, $roomId)
    {
        $request->validate([
            'name_room' => 'required|string|max:255',
            'theater_id' => 'required|exists:movie_theaters,id',
            'seat' => 'required|integer|min:1',
        ]);

        $room = TheaterRoom::findOrFail($roomId);
        $room->update($request->only('name_room', 'theater_id', 'seat'));

        return redirect()->route('admin.companies.rooms', $theaterId)->with('success', 'Cập nhật phòng chiếu thành công!');
    }

    public function toggle(MovieTheater $theater, TheaterRoom $room) {
        $room->status_room = $room->status_room ? 0 : 1;
        $room->save();
        return back()->with('ok','Đã đổi trạng thái hiển thị.');
    }
}

