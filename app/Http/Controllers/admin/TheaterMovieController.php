<?php

// app/Http/Controllers/Admin/TheaterMovieController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{City, Movie, MovieShow, MovieTheater, TheaterCompany, TheaterRoom};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TheaterMovieController extends Controller
{
    public function index(MovieTheater $theater) {
        $movieIds = MovieShow::whereIn('room_id', $theater->rooms()->pluck('id'))
            ->pluck('movie_id')->unique()->values();
        $movies = Movie::whereIn('id', $movieIds)->get();
        $rooms  = $theater->rooms()->where('status_room',0)->get(); 
        return view('admin.pages.theater_movies.index', compact('theater','movies','rooms'));
    }

    // Thêm "phim đang chiếu" = tạo suất chiếu đầu tiên
    public function attachMovie(Request $r, MovieTheater $theater) {
        $data = $r->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:theater_rooms,id',
            'time_start' => 'required|date',
            'time_end'   => 'required|date|after:time_start',
            'price'      => 'required|numeric|min:0'
        ]);
        // đảm bảo room thuộc rạp
        if (! $theater->rooms()->where('id',$data['room_id'])->exists()) {
            return back()->with('error','Phòng không thuộc rạp này.');
        }
        $show = MovieShow::create([
            'movie_id'=>$data['movie_id'],
            'room_id'=>$data['room_id'],
            'time_start'=>$data['time_start'],
            'time_end'=>$data['time_end'],
            'price'=>$data['price'],
            'status_show'=>1
        ]);
        // Khởi tạo show_seats trống theo tổng số ghế của phòng
        $room = TheaterRoom::find($data['room_id']);
        $seatsPayload = [];
        for ($i=1; $i <= (int)$room->seat; $i++) {
            $seatsPayload[] = ['show_id'=>$show->id,'seat_number'=>$i,'status_seat'=>0];
        }
        DB::table('show_seats')->insert($seatsPayload); // :contentReference[oaicite:12]{index=12}
        return back()->with('ok','Đã thêm phim đang chiếu (tạo 1 suất chiếu).');
    }

     public function edit($id)
    {
        $theater = MovieTheater::findOrFail($id);
        $cities = City::all();
        $companies = TheaterCompany::all();

        return view('admin.theaters.edit', compact('theater', 'cities', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_theater' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'company_id' => 'required|exists:theater_companies,id',
        ]);

        $theater = MovieTheater::findOrFail($id);
        $theater->update($request->only('name_theater', 'address', 'city_id', 'company_id'));

        return redirect()->route('admin.theaters.index')->with('success', 'Cập nhật rạp phim thành công!');
    }
}

