<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieComment;
use App\Models\MovieLike;
use App\Models\MovieRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserMovieController extends Controller
{

public function show($id)
{
    $movie = Movie::findOrFail($id);
    $cities = City::all(); // thêm dòng này để load danh sách thành phố

    $userId = Auth::id();
    $userLiked = $userId ? MovieLike::where('user_id', $userId)->where('movie_id', $id)->exists() : false;
    $userRating = $userId ? optional(MovieRate::where('user_id', $userId)->where('movie_id', $id)->first())->user_rate : 0;

    $totalLikes = MovieLike::where('movie_id', $id)->count();
    $avgRating = MovieRate::where('movie_id', $id)->avg('user_rate') ?: 0;

    $comments = MovieComment::with('user')
        ->where('movie_id', $id)
        ->orderByDesc('date_comment')
        ->get();

    return view('user.pages.movie-detail', compact(
        'movie',
        'cities',
        'comments',
        'userLiked',
        'userRating',
        'totalLikes',
        'avgRating'
    ));
}


    public function addComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        MovieComment::create([
            'user_id' => Auth::id(),
            'movie_id' => $id,
            'content_comment' => $request->content,
        ]);

        return redirect()->route('movie.show', $id)->with('success', 'Bình luận đã được thêm');
    }

    public function toggleLike($id)
{
    $userId =  Auth::id();
    $like = MovieLike::where('user_id', $userId)->where('movie_id', $id)->first();

    if ($like) {
        $like->delete();
        $status = 'unliked';
    } else {
        MovieLike::create(['user_id' => $userId, 'movie_id' => $id]);
        $status = 'liked';
    }

    $totalLikes = MovieLike::where('movie_id', $id)->count();
    return response()->json(['status' => $status, 'totalLikes' => $totalLikes]);
}

public function rate(Request $request, $id)
{
    $request->validate([
        'rate' => 'required|integer|min:1|max:5'
    ]);

    $userId =  Auth::id();

    MovieRate::updateOrCreate(
        ['user_id' => $userId, 'movie_id' => $id],
        ['user_rate' => $request->rate]
    );

    $avgRating = MovieRate::where('movie_id', $id)->avg('user_rate');
    return response()->json(['avgRating' => round($avgRating, 1)]);
}
}
