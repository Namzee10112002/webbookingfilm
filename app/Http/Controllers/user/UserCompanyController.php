<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TheaterCompany;
use App\Models\MovieTheater;
use App\Models\MovieShow;
use App\Models\Movie;
use App\Models\City;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserCompanyController extends Controller
{
    // danh sách hãng rạp
    public function index()
    {
        $companies = TheaterCompany::where('status_company', 0)->get();
        return view('user.pages.companies', compact('companies'));
    }

    // xem 1 hãng rạp
    public function show(TheaterCompany $company)
    {
        $cities = City::all();
        return view('user.pages.company-detail', compact('company', 'cities'));
    }

    // ajax lấy rạp theo hãng + thành phố
    public function getTheaters(Request $request, TheaterCompany $company)
    {
        $theaters = MovieTheater::where('company_id', $company->id)
            ->where('city_id', $request->city_id)
            ->where('city_id', $request->city_id)
            ->get();
        return response()->json($theaters);
    }

    // ajax lấy phim đang chiếu ở 1 rạp
    public function getMovies(MovieTheater $theater)
    {
        $movies = Movie::where('status_movie', 0)
            ->whereHas('shows.room.theater', function($q) use ($theater){
                $q->where('id', $theater->id);
            })
            ->distinct()
            ->get();
        return response()->json($movies);
    }

    // ajax lấy suất chiếu theo phim + ngày
    public function getMovieShows(Request $request, $theaterId, $movieId)
{
    $date = $request->date ?? now()->toDateString();

    $shows = MovieShow::with('room.theater')
        ->where('movie_id', $movieId)
        ->whereHas('room', function($q) use ($theaterId) {
            $q->where('theater_id', $theaterId);
        })
        ->whereDate('time_start', $date)
        ->orderBy('time_start')
        ->get();

    return response()->json($shows);
}
}
