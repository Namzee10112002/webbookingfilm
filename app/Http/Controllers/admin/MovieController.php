<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieComment;

class MovieController extends Controller
{
    /**
     * Hiển thị danh sách phim (chia theo trạng thái).
     */
    public function index()
    {
        $nowShowing = Movie::where('status_movie', 0)->withCount(['likes','rates'])->get();
        $comingSoon = Movie::where('status_movie', 2)->withCount(['likes','rates'])->get();
        $hidden     = Movie::where('status_movie', 1)->withCount(['likes','rates'])->get();

        return view('admin.pages.movies.index', compact('nowShowing', 'comingSoon', 'hidden'));
    }

    /**
     * Form thêm phim mới.
     */
    public function create()
    {
        return view('admin.pages.movies.create');
    }

    /**
     * Lưu phim mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_movie'        => 'required|string|max:255',
            'description_movie' => 'nullable|string',
            'image_movie'       => 'nullable|string',
            'date_release'      => 'nullable|date',
            'categories'        => 'nullable|string',
            'country'           => 'nullable|string',
            'director'          => 'nullable|string',
            'actors'            => 'nullable|string',
            'duration'          => 'nullable|integer|min:1',
            'trailer'           => 'nullable|string',
            'status_movie'      => 'required|in:0,1,2',
        ]);

        Movie::create($request->all());

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim mới thành công!');
    }

    /**
     * Form sửa phim.
     */
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.pages.movies.edit', compact('movie'));
    }

    /**
     * Cập nhật phim.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_movie'        => 'required|string|max:255',
            'description_movie' => 'nullable|string',
            'image_movie'       => 'nullable|string',
            'date_release'      => 'nullable|date',
            'categories'        => 'nullable|string',
            'country'           => 'nullable|string',
            'director'          => 'nullable|string',
            'actors'            => 'nullable|string',
            'duration'          => 'nullable|integer|min:1',
            'trailer'           => 'nullable|string',
            'status_movie'      => 'required|in:0,1,2',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công!');
    }


    /**
     * Toggle trạng thái phim (ẩn/hiện).
     */
    public function toggle($id)
    {
        $movie = Movie::findOrFail($id);

        // 0: đang chiếu → 1: ẩn, 2: sắp chiếu giữ nguyên
        if ($movie->status_movie == 1) {
            $movie->status_movie = 0; // bật lại đang chiếu
        } else {
            $movie->status_movie = 1; // ẩn phim
        }

        $movie->save();

        return back()->with('success', 'Đã cập nhật trạng thái phim');
    }

    /**
     * Quản lý bình luận của phim.
     */
    public function comments($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $comments = MovieComment::where('movie_id', $movieId)->get();

        return view('admin.pages.movies.comments', compact('movie', 'comments'));
    }

    /**
     * Ẩn/hiện bình luận.
     */
    public function toggleComment($commentId)
    {
        $comment = MovieComment::findOrFail($commentId);
        $comment->status_comment = $comment->status_comment ? 0 : 1;
        $comment->save();

        return back()->with('success', 'Đã cập nhật trạng thái bình luận');
    }
}
