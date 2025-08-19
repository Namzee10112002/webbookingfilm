<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Movie;
use Illuminate\Http\Request;

class HomeUserController extends Controller
{
    public function index(){
        $movies = Movie::where('status_movie', 0)->get();
        $moviesComing = Movie::where('status_movie', 2)->get();
        $cities = City::all();
        return view('user.pages.home', compact('movies', 'cities','moviesComing'));
    }
}
