<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    public $timestamps = false;

    protected $fillable = ['name_movie', 'description_movie', 'image_movie', 'date_release', 'categories', 'actors', 'director', 'duration', 'rate', 'likes', 'country', 'trailer', 'status_movie'];

    public function comments()
    {
        return $this->hasMany(MovieComment::class, 'movie_id');
    }

    public function likes()
    {
        return $this->hasMany(MovieLike::class, 'movie_id');
    }

    public function rates()
    {
        return $this->hasMany(MovieRate::class, 'movie_id');
    }

    public function shows()
    {
        return $this->hasMany(MovieShow::class, 'movie_id');
    }
}
