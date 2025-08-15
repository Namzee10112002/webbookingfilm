<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieLike extends Model
{
    protected $table = 'movie_likes';
    public $timestamps = false;

    protected $fillable = ['user_id', 'movie_id'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
